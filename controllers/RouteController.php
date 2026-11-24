<?php

class RouteController extends BaseController
{

    // colonnes par défaut pour les trajets.
    protected $default_columns = [
        ["label"=>"Départ","name"=>"start_at"],
        ["label"=>"Date","name"=>"start_date"],
        ["label"=>"Heure","name"=>"start_time"],
        ["label"=>"Destination","name"=>"end_at"],
        ["label"=>"Date","name"=>"end_date"],
        ["label"=>"Heure","name"=>"end_time"],
        ["label"=>"Places","name"=>"seats"],
    ];

    /**
     * list
     * Affiche la liste des trajets futurs
     * @return void
     */
    public function list(){
        $this->getUserAndDb();


        $table_columns = $this->default_columns;
        // si l'utilisateur est connecté on rajoute la colonne action
        if (!empty($this->currentUser)){
            $table_columns[]=["label"=>"","name"=>"actions"];
        }

        $routes=new Route($this->db)->getCurrents();
        $table_data=[];
        foreach($routes as $route){
            $seats=$route->getSeats();
            $row=[
                'id'=>$route->getId(),
                'start_at'=>$route->getStartAgency()->getName(),
                'start_date'=>$route->getStartDate(),
                'start_time'=>$route->getStartTime(),
                'end_at'=>$route->getEndAgency()->getName(),
                'end_date'=>$route->getEndDate(),
                'end_time'=>$route->getEndTime(),
                'seats'=>$seats['total']-$seats['taken'],
            ];
            if (!empty($this->currentUser)){ // si l'utilisateur est connecté on rajoutes des donnés additionnelles pour l'affichage des détails et les droits d'édition
                
                $row['details']['author']=$route->getOrganizer()->getFullName();
                $row['details']['phone']=$route->getOrganizer()->getPhone();
                $row['details']['email']=$route->getOrganizer()->getMail();
                $row['details']['seats']=$seats['total'];
                $row['editable']=$route->isEditableBy($this->currentUser);
            }
            $table_data[]=$row;
            
        }

        View::render('routes/list', [
            'currentUser'=>$this->currentUser??null,
            'title' => 'Touche pas au klaxon',
            'footer'=>['date'=>2026,'company'=>'CENEF','site'=>'MVC PHP'],
            "object"=>"routes",
            'table_columns'=>$table_columns,
            'table_data'=>$table_data
        ]);
    }

    /**
     * delete
     * Supprime un trajet et redirige vers la liste des trajets.
     * @param Number $id l'identifiant du trajet à supprimer
     * @return void
     */
    public function delete($id){
        $this->getUserAndDb();

        $route = new Route($this->db);
        $route->findById($id);

        if ($route->delete()){
            header('Location: ' . $_ENV['URL_ROOT']."?success=Le trajet a été supprimé avec succès.");
            exit;
        }else{
            header('Location: ' . $_ENV['URL_ROOT'].'?error=Le trajet n\'a pas pu être supprimé');
            exit;
        }
    }

    /**
     * creationForm
     * Affiche le formulaire de création de trajet.
     * @return void
     */

    public function creationForm(){

        $this->getUserAndDb();

        
        $route=[
            'start_at'=>$_GET['start_at']??"",
            'start_time'=>$_GET['start_time']??"",
            'end_at'=>$_GET['end_at']??"",
            'end_time'=>$_GET['end_time']??"",
            'seats_taken'=>$_GET['seats_taken']??"",
            'seats_total'=>$_GET['seats_total']??""
            ];

        $agencies=new Agency($this->db)->getList();
        $options=[];
        foreach($agencies as $agency){
            $option=[
                'value'=>$agency->getId(),
                'label'=>$agency->getName(),
            ];
            $options[]=$option;
        }

        View::render('routes/form', [
            'currentUser'=>$this->currentUser,
            'title' => 'Touche pas au klaxon',
            'footer'=>['date'=>2026,'company'=>'CENEF','site'=>'MVC PHP'],
            'action'=>'create',
            'object'=>'routes',
            'agency_options'=>$options,
            'route'=>$route
        ]);
    }

    /**
     * create
     * Crée un nouveau trajet selon le contenu du POST puis redirige vers la liste des trajets.
     * @return void
     */
    public function create(){
        $this->getUserAndDb();

        $newRoute=new Route($this->db);
        $newRoute->setStartAgency($_POST['start_at']);
        $newRoute->setStartDatetime($_POST['start_time']);
        $newRoute->setEndAgency($_POST['end_at']);
        $newRoute->setEndDatetime($_POST['end_time']);
        $newRoute->setSeats($_POST['seats_total']);
        $newRoute->setTakenSeats($_POST['seats_taken']);
        $newRoute->setOrganizer($this->currentUser->getId());
        
        if($newRoute->create()){
            header('Location: ' . $_ENV['URL_ROOT']."?success=Le trajet a été créé avec succès.");
            exit;
        }else{
            $get='start_at='.$_POST['start_at'].'&start_time='.$_POST['start_time'].'&end_at='.$_POST['end_at'].'&end_time='.$_POST['end_time'];
            $get.='&seats_total='.$_POST['seats_total'].'&seats_taken='.$_POST['seats_taken']."&error=La création du trajet a échoué.";
            header('Location: ' . $_ENV['URL_ROOT'].'/routes/create?'.$get);
            exit;
        }
    }

    /**
     * editionForm
     * Affiche le formulaire d'édition d'un trajet.
     * @param Number $id l'identifiant du trajet à modifier.
     * @return void
     */
    public function editionForm($id){
        
        $this->getUserAndDb();

        $route=new Route($this->db);
        $route->findById($id);

        $seats = $route->getSeats();
        
        $edited=[
            'id'=>$route->getId(),
            'start_at'=>$route->getStartAgency()->getId(),
            'start_time'=>date('Y-m-d\TH:i',strtotime($route->getStartDate().' '.$route->getStartTime())),
            'end_at'=>$route->getEndAgency()->getId(),
            'end_time'=>date('Y-m-d\TH:i',strtotime($route->getEndDate().' '.$route->getEndTime())),
            'seats_taken'=>$seats['taken'],
            'seats_total'=>$seats['total']
            ];

        $agencies=new Agency($this->db)->getList();
        $options=[];
        foreach($agencies as $agency){
            $option=[
                'value'=>$agency->getId(),
                'label'=>$agency->getName(),
            ];
            $options[]=$option;
        }

        View::render('routes/form', [
            'currentUser'=>$this->currentUser,
            'title' => 'Touche pas au klaxon',
            'footer'=>['date'=>2026,'company'=>'CENEF','site'=>'MVC PHP'],
            'action'=>'edit',
            'object'=>'routes',
            'agency_options'=>$options,
            'route'=>$edited
        ]);
    }

    /**
     * edit
     * Modifie un trajet selon le contenu du POST puis redirige vers la liste des trajets.
     * @param Number $id l'identifiant du trajet à modifier.
     * @return void
     */
    public function edit($id){

        echo '<pre>';

        $this->getUserAndDb();

        $route=new Route($this->db);
        $route->findById($id);

        
        $route->setStartAgency($_POST['start_at']);
        $route->setStartDatetime($_POST['start_time']);
        $route->setEndAgency($_POST['end_at']);
        $route->setEndDatetime($_POST['end_time']);
        $route->setSeats($_POST['seats_total']);
        $route->setTakenSeats($_POST['seats_taken']);

        if($route->update()){
            header('Location: ' . $_ENV['URL_ROOT']."?success=Le trajet a été modifié avec succès.");
            exit;
        }else{
            $get='start_at='.$_POST['start_at'].'&start_time='.$_POST['start_time'].'&end_at='.$_POST['end_at'].'&end_time='.$_POST['end_time'];
            $get.='&seats_total='.$_POST['seats_total'].'&seats_taken='.$_POST['seats_taken']."&error=La modification du trajet a échoué.";
            header('Location: ' . $_ENV['URL_ROOT'].'/route/'.$route->getId().'/create');
            exit;
        }

    }

}