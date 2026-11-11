<?php

class RouteController extends BaseController
{    
    protected $default_columns = [
        ["label"=>"Départ","name"=>"start_at"],
        ["label"=>"Date","name"=>"start_date"],
        ["label"=>"Heure","name"=>"start_time"],
        ["label"=>"Destination","name"=>"end_at"],
        ["label"=>"Date","name"=>"end_date"],
        ["label"=>"Heure","name"=>"end_time"],
        ["label"=>"Places","name"=>"seats"],
    ];

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
            if (!empty($this->currentUser)){
                
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
            'table_columns'=>$table_columns,
            'table_data'=>$table_data
        ]);
    }

    public function details($id){

        $this->getUserAndDb();

        $selected=new Route($this->db);
        $selected->findById($id);

        $organizer = $selected->getOrganizer();

        $modal=[
            ["label"=>"Auteur","value"=> $organizer->getFullName()],
            ["label"=>"Téléphone","value"=>chunk_split($organizer->getPhone(), 2, " ")],
            ["label"=>"Email","value"=>$organizer->getMail()],
            ["label"=>"Nombre total de places","value"=>$selected->getSeats()['total']]
        ];



        $table_columns = $this->default_columns;
        if ($this->currentUser){
            $table_columns[]=["label"=>"","name"=>"actions"];
        }

        $routes=new Route($db)->getCurrents();
        $table_data=[];
        foreach($routes as $route){
            $seats=$route->getSeats();
            $row=[
                'id'=>$route->getId(),
                'start_at'=>$route->getStartAgency()->getName(),
                'start_date'=>$route->getEndDate(),
                'start_time'=>$route->getEndTime(),
                'end_at'=>$route->getEndAgency()->getName(),
                'end_date'=>$route->getEndDate(),
                'end_time'=>$route->getEndTime(),
                'seats'=>$seats['total']-$seats['taken'],
                'editable'=>$route->isEditableBy($currentUser)
            ];
            $table_data[]=$row;
            
        }

        View::render('routes/details', [
            'currentUser'=>$this->currentUser,
            'title' => 'Touche pas au klaxon',
            'footer'=>['date'=>2026,'company'=>'CENEF','site'=>'MVC PHP'],
            'table_columns'=>$table_columns,
            'table_data'=>$table_data,
            "modal"=>$modal,
            "open_modal"=>$id
        ]);
    }

    public function delete($id){
        $this->getUserAndDb();

        $route = new Route($this->db);
        $route->findById($id);

        if ($route->delete()){
            header('Location: ' . $_ENV['URL_ROOT']);
            exit;
        }else{
            header('Location: ' . $_ENV['URL_ROOT'].'?error=error');
            exit;
        }
    }

    public function creationForm(){

        $this->getUserAndDb();


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
            'agency_options'=>$options,
            'route'=>null
        ]);
    }

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
            header('Location: ' . $_ENV['URL_ROOT']);
            exit;
        }else{
            header('Location: ' . $_ENV['URL_ROOT'].'/route/create');
            exit;
        }
    }

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
            'agency_options'=>$options,
            'route'=>$edited
        ]);
    }

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
            header('Location: ' . $_ENV['URL_ROOT']);
            exit;
        }else{
            header('Location: ' . $_ENV['URL_ROOT'].'/route/'.$route->getId().'/create');
            exit;
        }

    }

}