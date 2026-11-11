<?php

class AgencyController extends BaseController
{
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
            'table_data'=>$table_data
        ]);
    }

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

    public function creationForm(){
        $this->getUserAndDb();

        View::render('agencies/form', [
            'currentUser'=>$this->currentUser??null,
            'title' => 'Touche pas au klaxon',
            'footer'=>['date'=>2026,'company'=>'CENEF','site'=>'MVC PHP'],
            'object'=>$this->object,
            'action'=>'create'
        ]);
    }

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
}