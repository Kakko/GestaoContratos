<?php
class notFoundController extends Controller {

    public function __construct(){
        parent:: __construct();

        $users = new Users();
        if($users->isLogged() == false){
            header("Location: ".BASE_URL."login");
        }
    }

    public function index() {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();


        $data['user_name'] = $users->getName();
        $this->loadTemplate('404', $data);
    }

}