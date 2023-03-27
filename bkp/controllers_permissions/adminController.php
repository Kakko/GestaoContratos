<?php
class adminController extends Controller {

    public function index() {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        $permissions = new Permissions();
        $logs = new Logs();
        $warnings = new Warnings();

        if($users->isLogged() == false){
			header("Location: ".BASE_URL."login");
		}

        if(!empty($_POST['acao_warning']) && isset($_POST['acao_warning'])){
            if($_POST['acao_warning'] == 'upd_warnings'){
                $id = $_POST['id'];
    
                echo $warnings->updWarnings($id);
                exit;
            }
        }


        $log = 'Usuário acessou a área Administrativa';
        $data_cadastro = date("Y-m-d H:i:s");
        $user_id = $_SESSION['lgUser'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
        $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

        if(!empty($_POST['acao_usuario'])){
            if($_POST['acao_usuario'] == 'cadastrar'){
                $name = addslashes($_POST['name']);
                $email = addslashes($_POST['email']);
                $password = md5($_POST['password']);
                $endereco = addslashes($_POST['endereco']);
                $telefone = addslashes($_POST['telefone']);
                $obs = addslashes($_POST['obs']);
                $status = 'Ativo';
                $data_cadastro = date("Y-m-d H:i:s");

                $users->cad_user($name, $email, $password, $endereco, $telefone, $obs, $status, $data_cadastro);

                $log = 'Efetuou o cadastro do novo usuário -> '.$name;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

                header("Location: ".BASE_URL."admin");
            }

            if($_POST['acao_usuario'] == 'ver'){
                $id = $_POST['id'];
                echo $users->get_user($id);
                exit;
            }

            if($_POST['acao_usuario'] == 'edit'){
                $id = $_POST['id'];
                $name = addslashes($_POST['name']);
                $email = addslashes($_POST['email']);
                $password = addslashes($_POST['password']);
                $endereco = addslashes($_POST['endereco']);
                $telefone = addslashes($_POST['telefone']);
                $obs = addslashes($_POST['obs']);

                $users->edit_user($id, $name, $email, $password, $endereco, $telefone, $obs);

                $log = 'Editou o cadastro do usuário -> '.$name;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

                header("Location: ".BASE_URL."admin");
            }

            if($_POST['acao_usuario'] == 'inativar'){
                $id = $_POST['id'];

                $users->inativar_usuario($id);

                $log = 'Inativou o usuário -> '.$id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);
            }
        }

        if(!empty($_POST['acao_permission'])){
            if($_POST['acao_permission'] == 'cadastrar_grupo'){
                $name = addslashes($_POST['name']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                $permissions->cad_permission_group($name, $data_cadastro, $user_id);
                header("Location: ".BASE_URL."admin");
            }

            if($_POST['acao_permission'] == 'cad_permissoes'){
                $name = addslashes($_POST['name']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                $permissions->cad_permission($name, $data_cadastro, $user_id);
                header("Location: ".BASE_URL."admin");
            }
            if($_POST['acao_permission'] == 'gerenciar_grupos'){

                $name = addslashes($_POST['group_name']);
                $params = $_POST['permission_name'];

                $permissions->ger_group_permissions($name, $params);
                header("Location: ".BASE_URL."admin");
            }

            if($_POST['acao_permission'] == 'edit_perm_group'){

                $group_name = addslashes($_POST['group_name']);

                echo $permissions->list_groups($group_name);
                exit;
            }

            if($_POST['acao_permission'] == 'remove_perm'){
                
                $id = $_POST['id'];
                $group_name = $_POST['group_name'];
                $permissions->remove_perm($id, $group_name);
            }

            if($_POST['acao_permission'] == 'ver'){
                $id = $_POST['id'];

                echo $users->get_user($id);
                exit;
            }

            if($_POST['acao_permission'] == 'edit'){
                $id = $_POST['id'];
                $group = $_POST['group'];

                $users->set_perm_group($id, $group);
                exit;
            }

            if($_POST['acao_permission'] == 'setCompanies') {
                $companies = addslashes($_POST['companies']);
                $id = addslashes($_POST['id']);

                echo $users->setCompanies($companies, $id);
                exit;
            }

            if($_POST['acao_permission'] == 'fetch_registeredCompanies') {
                $id = addslashes($_POST['id']);

                echo $users->getRegisteredCompanies($id);
                exit;
            }

            if($_POST['acao_permission'] == 'removeCompanyPermission') {
                $id = addslashes($_POST['id']);
                $userID = addslashes($_POST['userID']);
                
                echo $users->removeCompanyPermission($id, $userID);
                exit;
            }
            //NEW PERMISSION AREA
            if($_POST['acao_permission'] == 'showPermissionParams') {
                $permissionGroup = addslashes($_POST['permissionGroup']);

                echo $permissions->showPermissionParams($permissionGroup);
                exit;
            }
            if($_POST['acao_permission'] == 'insert_params') {
                $params = addslashes($_POST['params']);
                $id = addslashes($_POST['id']);

                echo $permissions->insert_params($params, $id);
                exit;
            }
            if($_POST['acao_permission'] == 'showUserCompanies') {
                
                $user_id = addslashes($_POST['user']);

                echo $permissions->fetch_user_companies($user_id);
                exit;
            }
            if($_POST['acao_permission'] == 'set_company_permissions') {
                
                $id = addslashes($_POST['id']);
                $user_id = addslashes($_POST['user_id']);
                
                echo $permissions->set_company_permissions($id, $user_id);
                exit;
            }
            
            if($_POST['acao_permission'] == 'insert_company_params') {
                
                $company_id = addslashes($_POST['company_id']);
                $user_id = addslashes($_POST['user_id']);
                $params = addslashes($_POST['params']);
                
                echo $permissions->insert_company_params($company_id, $user_id, $params);
                exit;
            }    
            
            if($_POST['acao_permission'] == 'insert_system_params') {
                
                $user_id = addslashes($_POST['id']);
                $params = addslashes($_POST['params']);
                
                echo $permissions->insert_system_params($user_id, $params);
                exit;
            }       

            if($_POST['acao_permission'] == 'showUserSystemPermissions') {
                
                $user_id = addslashes($_POST['user_id']);
                
                echo $permissions->show_user_system_permissions($user_id);
                exit;
            }
        }

        $data['getCompanies'] = $users->getCompanies();
        $data['getPermission_groups'] = $permissions->getPermission_groups();
        $data['permissions_list'] = $permissions->getPermissionList();
        $data['get_users'] = $users->get_users();
        $data['get_active_users'] =  $users->get_active_users();
        $data['user_name'] = $users->getName();

        if(in_array('20', $permissions->verifySystemPermissions())) {
            $this->loadTemplate('admin', $data);
        } else {
            header("Location: ".BASE_URL);
        }
        
    }
    public function phpinfo(){
        $data = array();

        $this->loadView('phpinfo', $data);
    }

}