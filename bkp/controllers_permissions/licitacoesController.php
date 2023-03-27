<?php
class licitacoesController extends Controller {

    public function index(){
        $data = array();
        $users = new Users();
        $utils = new Utils();
        $sistemas = new Sistemas();
        $orgaos = new Orgaos();
        $empresas = new Empresas();
        $licitacoes = new Licitacoes();
        $contratos = new Contratos();
        $produtos = new Produtos();
        $logs = new Logs();
        $warnings = new Warnings();
        $users->setLoggedUser();

        if($users->isLogged() == false){
			header("Location: ".BASE_URL."login");
		}

        $log = 'Acessou a área das Licitações';
        $data_cadastro = date("Y-m-d H:i:s");
        $user_id = $_SESSION['lgUser'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
        $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

        if(!empty($_POST['acao_warning']) && isset($_POST['acao_warning'])){
            if($_POST['acao_warning'] == 'upd_warnings'){
                $id = $_POST['id'];
    
                echo $warnings->updWarnings($id);
                exit;
            }
        }
        
        if(!empty($_POST['acao_licitacoes'])){
            if($_POST['acao_licitacoes'] == 'cadastrar' && !empty($_POST['system'])){
                $data = addslashes($_POST['data']);
                $hora = addslashes($_POST['hora']);
                $system = addslashes($_POST['system']);
                if(empty($_POST['value'])){
                    $value = 0.00;
                } else {
                    $value = str_replace('.', '', addslashes($_POST['value']));
                    $value = str_replace(',', '.', $value);
                }
                $complemento = addslashes($_POST['complemento']);
                $auction = addslashes($_POST['auction']);
                $complement = addslashes($_POST['complement']);
                $city = addslashes($_POST['city']);
                $uf = addslashes($_POST['uf']);
                $agency = addslashes($_POST['agency']);
                if(!empty($_POST['produtos'])){
                    $produtos = $_POST['produtos'];
                } else {
                    $produtos = '';
                }
                $company = addslashes($_POST['company']);
                $status = addslashes($_POST['status']);
                $status_info = addslashes($_POST['status_info']);
                $esclarecimentos = addslashes($_POST['esclarecimentos']);
                $ata = addslashes($_POST['ata']);
                $modalidades = addslashes($_POST['modalidades']);
                $object = addslashes($_POST['object']);
                $ag_cadast = addslashes($_POST['ag_cadast']);
                if(!empty($_POST['winner_company'])){
                    $company_winner = addslashes($_POST['winner_company']);
                } else {
                    $company_winner = '';
                }
                
                $obs = addslashes($_POST['obs']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                $licitacoes->cad_licitacao($data, $hora, $system, $value, $complemento, $auction, $complement, $city, $uf, $agency, $produtos, $company, $status, $status_info, $esclarecimentos, $ata, $modalidades, $object, $ag_cadast, $company_winner, $obs, $data_cadastro, $user_id);
                
                $log = 'Cadastrou uma Licitação';
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

                header("Location: ".BASE_URL."licitacoes");
            }

            if($_POST['acao_licitacoes'] == 'searchAgency'){
                $agency = addslashes($_POST['agency']);
                echo $orgaos->searchAgency($agency);
                exit;
            }
            if($_POST['acao_licitacoes'] == 'setAgency'){
                $id = addslashes($_POST['id']);
                echo $orgaos->setAgency($id);
                exit;
            }

            if($_POST['acao_licitacoes'] == 'addSistema_modal'){
                $system = addslashes($_POST['system']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                echo $sistemas->addSystemModal($system, $data_cadastro, $user_id);
                exit;
            }
            if($_POST['acao_licitacoes'] == 'addOrgao_modal'){
                $orgao = addslashes($_POST['orgao']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                echo $orgaos->addOrgaoModal($orgao, $data_cadastro, $user_id);
                exit;
            }

            if($_POST['acao_licitacoes'] == 'addStatusInfo'){
                if(!empty($_POST['status_info'])){
                    $status_info = addslashes($_POST['status_info']);
                    $data_cadastro = date("Y-m-d H:i:s");
                    $user_id = $_SESSION['lgUser'];

                    echo $licitacoes->addStatusInfo($status_info, $data_cadastro, $user_id);
                    exit;
                }
            }

            if($_POST['acao_licitacoes'] == 'ver') {
                $id = $_POST['id'];

                echo $licitacoes->get_bid($id);
                exit;
            }

            if($_POST['acao_licitacoes'] == 'ver_edit') {
                $id = $_POST['id'];
                
                echo $licitacoes->get_bid2($id);
                exit;
            }

            if($_POST['acao_licitacoes'] == 'atualizar') {
                $id = addslashes($_POST['id']);
                $data = addslashes($_POST['data']);
                $hora = addslashes($_POST['hora']);
                $system = addslashes($_POST['system']);
                if(strpos($_POST['value'], ',')){
                    $value = (str_replace('.',  '', $_POST['value']));
                    $value = addslashes(str_replace(',','.', $value));
                } else {
                    $value = addslashes($_POST['value']);
                }

                $complemento = addslashes($_POST['complemento']);
                $auction = addslashes($_POST['auction']);
                $complement = addslashes($_POST['complement']);
                $city = addslashes($_POST['city']);
                $uf = addslashes($_POST['uf']);
                $agency = addslashes($_POST['agency']);
                $object = addslashes($_POST['object']);
                $company = addslashes($_POST['company']);
                $cnpj = addslashes($_POST['cnpj']);
                $status = addslashes($_POST['status']);
                $status_info = addslashes($_POST['status_info']);
                $esclarecimentos = addslashes($_POST['esclarecimentos']);
                $ata = addslashes($_POST['ata']);
                $modalidades = addslashes($_POST['modalidades']);
                $object = addslashes($_POST['object']);
                $ag_cadast = addslashes($_POST['ag_cadast']);
                $company_winner = addslashes($_POST['winner_company']);
                $winner_perc = addslashes($_POST['winner_perc']);
                $obs = addslashes($_POST['obs']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                if(!empty($_POST['produtos'])){
                    $produtos = $_POST['produtos'];
                } else {
                    $produtos = '';
                }

                $licitacoes->upd_licitacao($id, $data, $hora, $system, $value, $complemento, $auction, $complement, $city, $uf, $agency, $produtos, $company, $status, $status_info, $esclarecimentos, $ata, $modalidades, $object, $ag_cadast, $company_winner, $obs, $data_cadastro, $user_id);


                if($_POST['status'] == 'Homologado'){

                    $contratos->cad_contrato($value, $company, $cnpj, $data_cadastro, $user_id, $id);
                }

                $log = 'Editou a licitação de ID '.$id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

                header("Location: ".BASE_URL."licitacoes");
                    
            }

            if($_POST['acao_licitacoes'] == 'winner'){
                $wcompany = addslashes($_POST['wcompany']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                echo $empresas->cadWinnerCompany($wcompany, $data_cadastro, $user_id);
                exit;
            }

            if($_POST['acao_licitacoes'] == 'cad_winnerCompany'){
                $winner_company = addslashes($_POST['winner_company']);
                if(empty($_POST['winner_value'])){
                    $winner_value = 0.0000;
                } else {
                    $winner_value = addslashes(str_replace('.', '', $_POST['winner_value']));
                    $winner_value = str_replace(',', '.', $winner_value);
                }
                $winner_perc = addslashes($_POST['winner_perc']);
                $licitacao_id = addslashes($_POST['licitacao_id']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];


                echo $empresas->setWinnerCompany($winner_company, $winner_value, $winner_perc, $licitacao_id, $data_cadastro, $user_id);
                exit;
            }

            if($_POST['acao_licitacoes'] == 'delete_winner'){
                $id = $_POST['id'];
                $licitacao_id = addslashes($_POST['licitacao_id']);

                echo $empresas->delete_winner($id, $licitacao_id);
                exit;
            }

            if($_POST['acao_licitacoes'] == 'excluir'){
                $id = $_POST['id'];
                $licitacoes->del_historico($id);
                $licitacoes->del_licitacao($id);

                $log = 'Excluiu a licitação de ID '.$id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

                exit;
            }
            if($_POST['acao_licitacoes'] == 'excluir_prod'){
                $id = $_POST['id'];
                $licitacoes->del_prod($id);

                $log = 'Deletou o produto de ID '.$id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

                exit;
            }

            if($_POST['acao_licitacoes'] == 'filtrar'){

                if(!empty($_POST['company'])){
                    $empresa = $_POST['company'];
                } else {
                    $empresa = '';
                }

                if(!empty($_POST['status'])){
                    $status = $_POST['status'];
                } else {
                    $status = '';
                }

                if(!empty($_POST['type'])) {
                    $tipo = $_POST['type'];
                } else {
                    $tipo = '';
                }

                if(!empty($_POST['system'])) {
                    $sistema = $_POST['system'];
                } else {
                    $sistema = '';
                }
                
                $data_de = $_POST['data_de'];
                $data_ate = $_POST['data_ate'];

                if(!empty($_POST['valor_de'])){
                    $valor_de = addslashes($_POST['valor_de']);
                } else {
                    $valor_de = '';
                }
                if(!empty($_POST['valor_ate'])){
                    $valor_ate = addslashes($_POST['valor_ate']);
                } else {
                    $valor_ate = '';
                }

                echo $licitacoes->filtrar_licitacoes($status, $tipo, $empresa, $sistema, $data_de, $data_ate, $valor_de, $valor_ate);
                exit;
            }

            if($_POST['acao_licitacoes'] == 'estado'){
                $estado = $_POST['estado'];

                echo $utils->get_cidades($estado);
                exit;
            }
            if($_POST['acao_licitacoes'] == 'get_cnpj'){
                $empresa = $_POST['empresa'];

                echo $utils->get_cnpj($empresa);
                exit;
            }

            //BLOCO DE NOTAS - LICITAÇÕES
            if($_POST['acao_licitacoes'] == 'notepad'){
                $id = addslashes($_POST['id']);

                echo $licitacoes->notepadContratos($id);
                exit;
            }

            if($_POST['acao_licitacoes'] == 'showNoteModal'){
                $id = $_POST['id'];

                echo $licitacoes->showNoteModal($id);
                exit;
            }

            if($_POST['acao_licitacoes'] == 'save_note'){
                $id = addslashes($_POST['id']);
                $title = addslashes($_POST['title']);
                $text = addslashes($_POST['text']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                echo $licitacoes->saveNewNote($id, $title, $text, $data_cadastro, $user_id);
                exit;
            }

            if($_POST['acao_licitacoes'] == 'deleteNote'){
                $id = addslashes($_POST['id']);
                $licitacao_id = addslashes($_POST['licitacao_id']);

                echo $licitacoes->deleteNote($id, $licitacao_id);
                exit;
            }

            if($_POST['acao_licitacoes'] == 'delete_hist'){
                $id = addslashes($_POST['hist_id']);

                echo $licitacoes->delete_hist($id);
                exit;
            }
        }

        

        if(!empty($_POST['acao_historico'])){
            if($_POST['acao_historico'] == 'cadastrar'){
                
                $titulo = addslashes($_POST['titulo']);
                if(!empty($_POST['data_licitacao'])){
                    $data_licitacao = addslashes($_POST['data_licitacao']);
                } else {
                    $data_licitacao = date("Y-m-d");
                }
                if(!empty($_POST['horario_licitacao'])){
                    $horario_licitacao = addslashes($_POST['horario_licitacao']);
                } else {
                    $horario_licitacao = date("H:i:s");
                }
                $obs = addslashes($_POST['obs']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $licitacao_id = $_POST['id'];

                $licitacoes->cad_historico($titulo, $data_licitacao, $horario_licitacao, $obs, $data_cadastro, $user_id, $licitacao_id);
                  
                if(!empty($_FILES['upload_arquivo']['name'])){  
                    $upload_arquivo = $_FILES['upload_arquivo'];
                    
                    $licitacoes->upload_arquivo_licitacao($upload_arquivo, $licitacao_id, $data_cadastro, $user_id);
                }

                $log = 'Cadastrou um histórico na licitação de ID '.$licitacao_id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

                header("Location: ".BASE_URL."licitacoes");
            }
        }

        if(!empty($_POST['acao_desconto'])){
            if($_POST['acao_desconto'] == 'edit_desconto'){
                $id = $_POST['id'];
                echo $licitacoes->get_desconto($id);
                exit;
            }

            if($_POST['acao_desconto'] == 'atualizar'){
                $prod_id = $_POST['prod_id'];
                $desconto = $_POST['desconto'];

                for($i=0; $i <count($prod_id); $i++){
                    $licitacoes->cad_desconto($prod_id[$i], $desconto[$i]);
                }
                header("Location: ".BASE_URL."licitacoes");
            }
        }
        $data['status_info'] = $licitacoes->fetchStatus_info();
        $data['winner_company'] = $empresas->winner_company();
        $data['internal'] = $licitacoes->getInternal();
        $data['get_produtos'] = $produtos->get_produtos();        
        $data['get_companies'] = $empresas->getCompanies();
        $data['get_orgaos'] = $orgaos->get_orgaos();
        $data['get_systems'] = $sistemas->get_systems();
        $data['get_estados'] = $utils->getEstados();
        $data['get_cidades'] = $utils->getCidades();
        $data['user_name'] = $users->getName();
        $data['get_bids_eletronico'] = $licitacoes->get_bids();
        $data['users'] = $users;


        if($users->hasPermission('Licitacoes_view')){
            $this->loadTemplate('licitacoes', $data);
        } else {
            header("Location: ".BASE_URL);
        }
    }

    public function licitacoes_andamento() {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        $licitacoes = new Licitacoes();
        $logs = new Logs();

        $log = 'Acessou a área de licitações em Andamento';
        $data_cadastro = date("Y-m-d H:i:s");
        $user_id = $_SESSION['lgUser'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
        $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

        if(!empty($_POST['acao_licitacoes'])){
            if($_POST['acao_licitacoes'] == 'ver') {
                $id = $_POST['id'];
                $licitacao['header'] = $licitacoes->get_bid($id);
                $licitacao['historico'] = $licitacoes->get_historico($id);
                echo json_encode($licitacao);
                exit;
            }
        }


        $data['ver_licitacoes_andamento'] = $licitacoes->ver_licitacoes_andamento();
        $data['user_name'] = $users->getName();
        $this->loadTemplate('licitacoes_andamento', $data);
    }

    public function licitacoes_canceladas() {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        $licitacoes = new Licitacoes();
        $logs = new Logs();

        $log = 'Acessou a área de licitações Canceladas';
        $data_cadastro = date("Y-m-d H:i:s");
        $user_id = $_SESSION['lgUser'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
        $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

        if(!empty($_POST['acao_licitacoes'])){
            if($_POST['acao_licitacoes'] == 'ver') {
                $id = $_POST['id'];
                $licitacao['header'] = $licitacoes->get_bid($id);
                $licitacao['historico'] = $licitacoes->get_historico($id);
                echo json_encode($licitacao);
                exit;
            }
        }


        $data['ver_licitacoes_canceladas'] = $licitacoes->ver_licitacoes_canceladas();
        $data['user_name'] = $users->getName();
        $this->loadTemplate('licitacoes_canceladas', $data);
    }

    public function licitacoes_concluidas() {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        $licitacoes = new Licitacoes();
        $logs = new Logs();

        $log = 'Acessou a área de licitações Concluidas';
        $data_cadastro = date("Y-m-d H:i:s");
        $user_id = $_SESSION['lgUser'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
        $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

        if(!empty($_POST['acao_licitacoes'])){
            if($_POST['acao_licitacoes'] == 'ver') {
                $id = $_POST['id'];
                $licitacao['header'] = $licitacoes->get_bid($id);
                $licitacao['historico'] = $licitacoes->get_historico($id);
                echo json_encode($licitacao);
                exit;
            }
        }


        $data['ver_licitacoes_concluidas'] = $licitacoes->ver_licitacoes_concluidas();
        $data['user_name'] = $users->getName();
        $this->loadTemplate('licitacoes_concluidas', $data);
    }
}