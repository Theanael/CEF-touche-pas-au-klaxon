<?php

class AgencyController extends BaseController
{
    /**
     * list
     * Affiche la liste des agences
     * @return void
     */
    public function list(){
        $this->getUserAndDb();
        $table_columns=[
            ["label"=>"Nom","name"=>"name"],
            ["label"=>"","name"=>"actions"],
        ];

        $agencies=new Agency($this->db)->getList();
        $table_data=[];
        foreach($agencies as $agency){
            $table_data[]=[
                'id'=>$agency->getId(),
                'name'=>$agency->getName(),
                'editable'=>true
                ];
        }

            View::render('agencies/list', [
            'currentUser'=>$this->currentUser??null,
            'title' => 'Touche pas au klaxon',
            'footer'=>['date'=>2026,'company'=>'CENEF','site'=>'MVC PHP'],
            'object'=>'agencies',
            'table_columns'=>$table_columns,
            'table_data'=>$table_data,
            'detailed_view'=>false,
        ]);
    }

    /**
     * creationForm
     * Affiche le formulaire de création d'agence
     * @return void
     */
    public function creationForm(){
        $this->getUserAndDb();

        View::render('agencies/form', [
            'currentUser'=>$this->currentUser??null,
            'title' => 'Touche pas au klaxon',
            'footer'=>['date'=>2026,'company'=>'CENEF','site'=>'MVC PHP'],
            'object'=>'agencies',
            'action'=>'create'
        ]);
    }

    /**
     * create
     * Crée une nouvelle agence selon le contenu du POST et redirige vers la liste des agences
     * @return void
     */
    public function create(){
        $this->getUserAndDb();

        $agency = new Agency($this->db);
        $agency->setName($_POST['name']);

        if($agency->create()){
            header('Location: ' . $_ENV['URL_ROOT'].'/agencies');
            exit;
        }else{
            header('Location: ' . $_ENV['URL_ROOT'].'/agencies/create?error=1');
            exit;
        }
    }

    /**
     * editionForm
     * Affiche le formulaire d'édition d'agence.
     * @param Number $id identifiant de l'agence à modifier
     * @return void
     */

    public function editionForm($id){
        $this->getUserAndDb();
        
        $agency = new Agency($this->db);
        $agency->findById($id);
        
        View::render('agencies/form', [
            'currentUser'=>$this->currentUser??null,
            'title' => 'Touche pas au klaxon',
            'footer'=>['date'=>2026,'company'=>'CENEF','site'=>'MVC PHP'],
            'object'=>'agencies',
            'action'=>'edit',
            'agency'=>['id'=>$agency->getId(),'name'=>$agency->getName()]
        ]);
    }

    /**
     * edit
     * Modifie une agence selon le contenu du POST et redirige vers la liste des agences.
     * @param Number $id identifiant de l'agence à modifier
     * @return void
     */

    public function edit($id){

        $this->getUserAndDb();

        $agency = new Agency($this->db);
        $agency->findById($id);
        $agency->setName($_POST['name']);
        
        if($agency->update()){
            header('Location: ' . $_ENV['URL_ROOT'].'/agencies');
            exit;
        }else{
            header('Location: ' . $_ENV['URL_ROOT'].'/agencies/'.$id.'/edit?error=1');
            exit;
        }
    }   

    /**
     * delete
     * Supprime une agence et redirige vers la liste des agences.
     * @param mixed $id identifiant de l'agence à supprimer
     * @return void
     */

    public function delete($id){
        $this->getUserAndDb();
        $agency=new Agency($this->db);
        $agency->findById($id);
        

        if($agency->delete()){
            header('Location: ' . $_ENV['URL_ROOT'].'/agencies');
            exit;
        }else{
            header('Location: ' . $_ENV['URL_ROOT'].'/agencies?error=1');
            exit;
        }
        
    }
}