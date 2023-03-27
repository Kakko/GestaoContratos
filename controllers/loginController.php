<?php
class loginController extends Controller {
    
    public function index(){
        $data = array();
        $users = new Users;
        $logs = new Logs();

        $user_ip = $_SERVER['REMOTE_ADDR'];
        $data_cadastro = date("Y-m-d H:i:s");

        if(!empty($_POST['email']) && !empty($_POST['password'])){

            $email = addslashes($_POST['email']);
            $password = addslashes($_POST['password']);

            if($users->doLogin($email, $password)){
                $user_id = $_SESSION['lgUser'];
                $log = 'Usuário Efetuou Login';

                $logs->registrarlogin($log, $user_ip, $data_cadastro, $user_id);
                header("Location: ".BASE_URL);
                exit;
            } else {
                
                $user_id = '0';
                $data['error'] = "E-mail e/ou Senha Inválidos";
                $log = 'Tentativa invalida de login efetuada com o e-mail: '.$email.' e a senha: '.$password;
                $logs->registrarlogin($log, $user_ip, $data_cadastro, $user_id);
            }

            
        }

        $this->loadView('login', $data);
    }

    public function logout(){
        $users = new Users;
        $users->setLoggedUser();

        $users->logout();
        header("Location: ".BASE_URL);
        exit;
    }
}