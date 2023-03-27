<?php
class agendaController extends Controller {

    public function index() {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        $agenda = new Agenda();
        $logs = new Logs();
        $warnings = new Warnings();
        $docs = new Documents();

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
        //Exibição dados
        if(!empty($_POST['agenda_action']) && isset($_POST['agenda_action'])){
            if($_POST['agenda_action'] == 'exibir_licitacao') {
                $id = addslashes($_POST['id']);

                echo $agenda->fetchLicitacao($id);
                exit;
            }

            if($_POST['agenda_action'] == 'exibir_contratos'){
                $id = addslashes($_POST['id']);

                echo $agenda->fetchContratos($id);
                exit;
            }

            if($_POST['agenda_action'] == 'exibir_documentos'){
                $id = addslashes($_POST['id']);

                echo $docs->getDoc($id);
                exit;
            }
        }
        
        //Controle de Aviso
        // if(!empty($_POST['aviso']) && isset($_POST['aviso'])){
        //     if($_POST['aviso'] == 'followup_licitacoes'){
        //         echo $warnings->show_followup();
        //         exit;
        
        //     }

        //     if($_POST['aviso'] == 'aviso_licitacoes'){
        //         echo $warnings->get_warnings();
        //         exit;
        
        //     }

        //     if($_POST['aviso'] == 'fechar'){
        //         $user_id = $_SESSION['lgUser'];
        //         $id = addslashes($_POST['id']);
                
        //         echo $warnings->close_warning($user_id, $id);
        //         exit;
        //     }

        //     if($_POST['aviso'] == 'acompanhar'){
        //         $user_id = $_SESSION['lgUser'];
        //         $id = addslashes($_POST['id']);
                
        //         echo $warnings->close_followup($user_id, $id);
        //         exit;
        //     }

        //     if($_POST['aviso'] == 'encerrar'){
        //         $user_id = $_SESSION['lgUser'];
        //         $id = addslashes($_POST['id']);
                
        //         echo $warnings->dismiss_all($user_id, $id);
        //         exit;
        //     }
            
        //     //AVISO CONTRATOS
        //     if($_POST['aviso'] == 'aviso_contratos'){
        //         echo $warnings->warning_contratos();
        //         exit;
        //     }

        //     if($_POST['aviso'] == 'fechar_contract'){
        //         $user_id = $_SESSION['lgUser'];
        //         $id = addslashes($_POST['id']);
                
        //         echo $warnings->close_contract($user_id, $id);
        //         exit;
        //     }
        // }

        $log = 'Acessou a área de Agenda';
        $data_cadastro = date("Y-m-d H:i:s");
        $user_id = $_SESSION['lgUser'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
        $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

        $data['getAgendaDocuments'] = $agenda->getAgendaDocuments();
        $data['getAgendaLicitacao'] = $agenda->getAgendaLicitacao();
        $data['getAgendaContratos'] = $agenda->getAgendaContratos();
        $data['user_name'] = $users->getName();

        if($users->hasPermission('Agenda_view')){
            $this->loadTemplate('agenda', $data);
        } else {
            header("Location: ".BASE_URL);
        }
    }
}