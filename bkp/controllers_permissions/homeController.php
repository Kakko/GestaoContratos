<?php
class homeController extends Controller {

    public function index() {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        $logs = new Logs();
        $warnings = new Warnings();
        $agenda = new Agenda();
        $docs = new Documents();
        $empresas = new Empresas();

        if($users->isLogged() == false){
			header("Location: ".BASE_URL."login");
        }

        //Usuário do Painel vai direto para a página específica
        if($users->hasPermission('Painel')){
            header("Location: ".BASE_URL."painel");
            exit;
        }

        //Fetch the Warnings
        $warnings->fetchLic();
        $warnings->fetchLicWeek();
        $warnings->fetchActualCont();
        $warnings->fetchWeekCont();
        $warnings->fetchMonthCont();
        $warnings->fetchDocs();
        $warnings->fetchDocType();
        $empresas->getCompanies();

        if(!empty($_POST['acao_warning']) && isset($_POST['acao_warning'])){
            if($_POST['acao_warning'] == 'exibirCont'){
                $id = $_POST['id'];
    
                echo $agenda->fetchContratos($id);
                exit;
            }
    
            if($_POST['acao_warning'] == 'exibirLic'){
                $id = $_POST['id'];
    
                echo $agenda->fetchLicitacao($id);
                exit;
            }
    
            if($_POST['acao_warning'] == 'exibirDoc'){
                $id = $_POST['id'];
    
                echo $docs->getDoc($id);
                exit;
            }

            if($_POST['acao_warning'] == 'upd_warnings'){
                $id = $_POST['id'];
    
                echo $warnings->updWarnings($id);
                exit;
            }
        }
        

        //Logs do Sistema
        $log = 'Acessou a área do Dashboard';
        $data_cadastro = date("Y-m-d H:i:s");
        $user_id = $_SESSION['lgUser'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
        $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

        $data['companies'] = $warnings->getCompanies();
        $data['docType'] = $warnings->fetchDocType();
        $data['licWarn'] = $warnings->fetchLic();
        $data['licWarnWeek'] = $warnings->fetchLicWeek();
        $data['contActualWarn'] = $warnings->fetchActualCont();
        $data['contWeekWarn'] = $warnings->fetchWeekCont();
        $data['contMonthWarn'] = $warnings->fetchMonthCont();
        $data['docsWarn'] = $warnings->fetchDocs();
        $data['user_name'] = $users->getName();
        $data['exp_data'] = $warnings->exp_contracts();

        $this->loadTemplate('home', $data);
    }
}