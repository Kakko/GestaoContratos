<?php
class usuariosController extends Controller {

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
        $info_id = $_SESSION['lgUser'];
        $logs = new Logs();

        $log = 'Acessou a área do Usuário';
        $data_cadastro = date("Y-m-d H:i:s");
        $user_id = $_SESSION['lgUser'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
        $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

        if(isset($_POST['name']) && !empty($_POST['password'])){
            $name = addslashes($_POST['name']);
            $email = addslashes($_POST['email']);
            $password = md5($_POST['password']);
            $endereco = addslashes($_POST['endereco']);
            $telefone = addslashes($_POST['telefone']);
            $obs = addslashes($_POST['obs']);

            $users->edit_usuario($name, $email, $password, $endereco, $telefone, $obs, $info_id);

            $log = 'Editou Alguma informação do usuário '.$name;
            $data_cadastro = date("Y-m-d H:i:s");
            $user_id = $_SESSION['lgUser'];
            $user_ip = $_SERVER['REMOTE_ADDR'];
            
            $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);
            header("Location: ".BASE_URL);
        }

        $data['loggedUserInfo'] = $users->loggedUserInfo($info_id);
        $data['user_name'] = $users->getName();
        $this->loadTemplate('usuarios', $data);
    }
}