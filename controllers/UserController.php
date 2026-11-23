<?php 
class UserController extends BaseController
{
    /**
     * list
     * Affiche la liste des utilisateurs.
     * @return void
     */
    public function list(){

        $this->getUserAndDb();

        $table_columns=[
            ['label'=>'Nom', 'name'=>'firstname'],
            ['label'=>'Prénom', 'name'=>'lastname'],
            ['label'=>'Téléphone', 'name'=>'phone'],
            ['label'=>'E-Mail', 'name'=>'email'],
            ['label'=>'Administrateur', 'name'=>'admin'],
        ];
        $table_data=[];
        $users=new User($this->db)->getList();
        foreach($users as $user){
            $row=[
                'firstname'=>$user->getFirstName(),
                'lastname'=>$user->getLastName(),
                'phone'=>chunk_split($user->getPhone(), 2, " "),
                'email'=>$user->getMail(),
                'admin'=>($user->isAdmin()?'Oui':'Non')
            ];
            $table_data[]=$row;
        }

        View::render('users/list', [
            'currentUser'=>$this->currentUser??null,
            'title' => 'Touche pas au klaxon',
            'footer'=>['date'=>2026,'company'=>'CENEF','site'=>'MVC PHP'],
            "object"=>"users",
            'table_columns'=>$table_columns,
            'table_data'=>$table_data,
        ]);
    }

    /**
     * loginPage
     * Affiche la page de connexion.
     * @return void
     */
    public function loginPage(){
        View::render('users/login', [
            'currentUser'=>null,
            'title' => 'Touche pas au klaxon',
            'footer'=>['date'=>2026,'company'=>'CENEF','site'=>'MVC PHP'],
        ]);
    }

    /**
     * login
     * Traite une tentative de connexion et redirige vers la page d'accueil en cas de connexion réussie.
     * @return void
     */
    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $db = Database::getDb();
        $user = new User($db);

        if ($user->authenticate($email, $password)) { // Si la connexion est réussie on enregistre son id dans la session.

            session_regenerate_id(true);

            $_SESSION['user'] = $user->getId();
            
            header('Location: ' . $_ENV['URL_ROOT']);
            exit;
        }

        // Sinon on redirige vers la page de connexion avec un message d'erreur
        header('Location: ' . $_ENV['URL_ROOT'] . '/login?error=invalid');
        exit;
    }

    /**
     * logout
     * déconnecte l'utilisateur s'il est connecté et renvoie vers la page d'accueil
     * @return void
     */

    public function logout(){
        unset($_SESSION['user']);
        header('Location: ' . $_ENV['URL_ROOT']);
        exit;
    }
}