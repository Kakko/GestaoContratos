<?php
class contratosController extends Controller {

    public function index() {
        $data = array();
        $users = new Users();
        $utils = new Utils();
        $contratos = new Contratos();
        $empresas = new Empresas();
        $users->setLoggedUser();
        $stur = new Stur();
        $logs = new Logs();
        $licitacao = new Licitacoes();
        $warnings = new Warnings();
        $permissions = new Permissions();

        if($users->isLogged() == false){
			header("Location: ".BASE_URL."login");
		}

        $log = 'Acessou a área de Contratos';
        $data_cadastro = date("Y-m-d H:i:s");
        $user_id = $_SESSION['lgUser'];
        $user_ip = $_SERVER['REMOTE_ADDR'];

        $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

        if(!empty($_POST['acao_contratos'])){
            
            if($_POST['acao_contratos'] == 'cadastrar'){
                $cod_stur = addslashes($_POST['cod_stur']);
                $client_name = addslashes($_POST['nome_cliente_contrato']);
                $razao_social = addslashes($_POST['razao_social']);
                $cnpj = addslashes($_POST['cnpj']);
                $n_contrato = addslashes($_POST['n_contrato']);
                $emissor = addslashes($_POST['emissor']);
                $empresa = addslashes($_POST['empresa_id']);
                $cod = addslashes($_POST['cod2']);
                if(!empty($_POST['valor'])){
                    $valor = addslashes(str_replace('.', '', $_POST['valor']));
                    $valor = addslashes(str_replace(',', '.', $valor));
                } else {
                    $valor = 0.00;
                }
                $complemento = addslashes($_POST['complemento']);
                $faturamento = addslashes($_POST['faturamento']);
                $vencimento = addslashes($_POST['vencimento']);
                $reembolso = addslashes($_POST['reembolso']);
                $detalhes = addslashes($_POST['detalhes']);
                $situacao = addslashes($_POST['situacao']);
                $lei_kandir = addslashes($_POST['lei_kandir']);
                $inicio_contrato = addslashes($_POST['inicio_contrato']);
                $fim_contrato = addslashes($_POST['fim_contrato']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                echo $contratos->cad_novo_contrato($cod_stur, $client_name, $razao_social, $n_contrato, $emissor, $empresa, $cnpj, $cod, $valor, $complemento, $faturamento, $vencimento, $reembolso, $detalhes, $situacao, $lei_kandir, $inicio_contrato, $fim_contrato, $data_cadastro, $user_id);
                exit;
            }

            if($_POST['acao_contratos'] == 'searchCod'){
                $cod = addslashes($_POST['cod']);
                $empresa = addslashes($_POST['empresa']);

                echo $contratos->searchCod($cod, $empresa);
                exit;
            }

            if($_POST['acao_contratos'] == 'edit'){
                $id = $_POST['id'];
                echo $contratos->get_contrato($id);
                exit;
            }
            if($_POST['acao_contratos'] == 'updContrato'){
                
                $id = addslashes($_POST['id']);
                $cod = addslashes($_POST['cod']);
                $nome_cliente = addslashes($_POST['nome_cliente']);
                $razao_social = addslashes($_POST['razao_social']);
                $n_contrato = addslashes($_POST['n_contrato']);
                $emissor = addslashes($_POST['emissor']);
                $empresa = addslashes($_POST['empresa']);
                $cnpj = addslashes($_POST['cnpj']);
                $cod2 = addslashes($_POST['cod2']);
                $valor = addslashes(str_replace('.', '', $_POST['valor']));
                $valor = addslashes(str_replace(',', '.', $valor));
                $complemento = addslashes($_POST['complemento']);
                $faturamento = addslashes($_POST['faturamento']);
                $vencimento = addslashes($_POST['vencimento']);
                $reembolso = addslashes($_POST['reembolso']);
                $detalhes = addslashes($_POST['detalhes']);
                $situacao = addslashes($_POST['situacao']);
                $lei_kandir = addslashes($_POST['lei_kandir']);
                $inicio_contrato = addslashes($_POST['inicio_contrato']);
                $fim_contrato = addslashes($_POST['fim_contrato']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                $contratos->upd_contratos($id, $cod, $nome_cliente, $razao_social, $n_contrato, $emissor, $empresa, $cnpj, $cod2, $valor, $complemento, $faturamento, $vencimento, $reembolso, $detalhes, $situacao, $lei_kandir, $inicio_contrato, $fim_contrato, $data_cadastro, $user_id);

                // $stur->upd_inadimplente($id, $cod, $empresa);

                $log = 'Atualizou os dados do contrato de ID '.$id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];

                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

                header("Location: ".BASE_URL."contratos");
                exit;
            }

            if($_POST['acao_contratos'] == 'cad_historico'){

                
                $id = addslashes($_POST['id']);
                $titulo = addslashes($_POST['titulo']);

                if(!empty($_POST['check_aditivo'])){
                    $check_aditivo = addslashes($_POST['check_aditivo']);
                } else {
                    $check_aditivo = null;
                }

                if(!empty($_POST['data_contrato'])){
                    $data_contrato = addslashes($_POST['data_contrato']);
                } else {
                    $data_contrato = date("Y-m-d");
                }

                if(!empty($_POST['horario_contrato'])){
                    $horario_contrato = addslashes($_POST['horario_contrato']);
                } else {
                    $horario_contrato = date("H:i:s");
                }

                if(!empty($_POST['inicioAditivo'])){
                    $inicio_aditivo = addslashes($_POST['inicioAditivo']);
                } else {
                    $inicio_aditivo = null;
                }

                if(!empty($_POST['fimAditivo'])){
                    $fim_aditivo = addslashes($_POST['fimAditivo']);
                } else {
                    $fim_aditivo = null;
                }

                if(!empty($_POST['valueAditivo'])){
                    $valueAditivo = addslashes($_POST['valueAditivo']);
                    // $valueAditivo = str_replace('.','', $valueAditivo);
                    // $valueAditivo = str_replace(',','.', $valueAditivo);
                } else {
                    $valueAditivo = null;
                }

                $obs = addslashes($_POST['obs']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $contrato_id = $_POST['id'];

                $contratos->cad_historico_contrato($titulo, $data_contrato, $horario_contrato, $inicio_aditivo, $fim_aditivo, $valueAditivo, $obs, $data_cadastro, $user_id, $contrato_id, $check_aditivo);

                if(!empty($_FILES['upload_arquivo']['name'])){
                    $upload_arquivo = $_FILES['upload_arquivo'];

                    $contratos->upload_arquivo_hist($upload_arquivo, $contrato_id, $data_cadastro, $user_id);
                }

                $log = 'Cadastrou um Histórico no Contrato de ID '.$contrato_id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];

                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);
                header("Location: ".BASE_URL."contratos");
            }

            if($_POST['acao_contratos'] == 'ver') {
                $id = $_POST['id'];

                echo $contratos->verContrato($id);
                exit;
            }

            if($_POST['acao_contratos'] == 'filtrar'){

                $status = $_POST['status'];
                $inadimplencia = addslashes($_POST['inadimplencia']);
                if(!empty($_POST['cod_stur'])){
                    $cod_stur = addslashes($_POST['cod_stur']);
                } else {
                    $cod_stur = '';
                }
                if(!empty($_POST['empresa'])){
                    $empresa = $_POST['empresa'];
                } else {
                    $empresa = '';
                }

                if(!empty($_POST['expired'])){
                    $expired = $_POST['expired'];
                } else {
                    $expired = '';
                }
                $nome_cliente = $_POST['nome_cliente'];
                if(empty($_POST['cod_stur'])){
                    $cod_stur = '';
                } else {
                    $cod_stur = $_POST['cod_stur'];
                }
                $data_de = $_POST['data_de'];
                $data_ate = $_POST['data_ate'];

                echo $contratos->filtrar_contratos($status, $cod_stur, $inadimplencia, $empresa, $expired, $nome_cliente, $data_de, $data_ate);
                exit;

            }

            if($_POST['acao_contratos'] == 'excluir') {
                $id = $_POST['id'];
                
                $contratos->excluir_contrato($id);

                $log = 'Excluiu o Contrato de ID '.$id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];

                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);
            }

            if($_POST['acao_contratos'] == 'cod_stur'){
                $id = addslashes($_POST['nome']);
                
                echo $utils->cod_stur($id);
                exit;
            }

            if($_POST['acao_contratos'] == 'info'){
                $id = $_POST['id'];

                echo $stur->info_stur($id);
                exit;
            }

            if($_POST['acao_contratos'] == "licitacao_info"){
                $id = $_POST['id'];

                echo $contratos->infoBid($id);
                exit;
            }

            if($_POST['acao_contratos'] == 'excluirHist'){
                $id = addslashes($_POST['id']);

                echo $contratos->deleteHist($id);
                exit;

            }

            if($_POST['acao_contratos'] == 'delete_hist'){
                $id = addslashes($_POST['hist_id']);

                echo $contratos->delete_hist($id);
                exit;
            }
            //BLOCO DE NOTAS - CONTRATOS
            if($_POST['acao_contratos'] == 'notepad'){
                $id = addslashes($_POST['id']);

                echo $contratos->notepadContratos($id);
                exit;
            }

            if($_POST['acao_contratos'] == 'showNoteModal'){
                $id = $_POST['id'];

                echo $contratos->showNoteModal($id);
                exit;
            }

            if($_POST['acao_contratos'] == 'save_note'){
                $id = addslashes($_POST['id']);
                $title = addslashes($_POST['title']);
                $text = addslashes($_POST['text']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                echo $contratos->saveNewNote($id, $title, $text, $data_cadastro, $user_id);
                exit;
            }

            if($_POST['acao_contratos'] == 'deleteNote'){
                $id = addslashes($_POST['id']);
                $contrato_id = addslashes($_POST['contrato_id']);

                echo $contratos->deleteNote($id, $contrato_id);
                exit;
            }

            if($_POST['acao_contratos'] == 'searchClient'){
                $client = addslashes($_POST['client']);

                echo $contratos->searchClient($client);
                exit;
            }
        }
        if(!empty($_POST['acao_warning']) && isset($_POST['acao_warning'])){
            if($_POST['acao_warning'] == 'upd_warnings'){
                $id = $_POST['id'];
    
                echo $warnings->updWarnings($id);
                exit;
            }
        }

        $data['newCount'] = $contratos->newContractCount();
        $data['newContract'] = $contratos->newContractWarning();
        // $data['get_emissor'] = $contratos->get_emissor();
        $data['get_cod_stur'] = $contratos->get_cod_stur();
        $data['getNomeCliente'] = $contratos->getNomeCliente();
        $data['get_companies'] = $empresas->getCompanies();
        $data['getContratos'] = $contratos->getContratos();
        $data['user_name'] = $users->getName();
        $data['users'] = $users;
        // $data['user_permissions'] = $permissions->verifyPermissions($empresa);

        if(in_array('13', $permissions->verifySystemPermissions())) {
            $this->loadTemplate('contratos', $data);
        } else {
            header("Location: ".BASE_URL);
        }
    }

    public function ver_contrato(){
        $data= array();
        $users = new Users();
        $users->setLoggedUser();
        $contratos = new Contratos();

        $id = $_GET['id'];
        $contratos->returnContrato($id);


        if(!empty($_POST['nome_cliente']) && !empty($_POST['n_contrato'])){
            $cod = addslashes($_POST['cod']);
            $nome_cliente = addslashes($_POST['nome_cliente']);
            $razao_social = addslashes($_POST['razao_social']);
            $n_contrato = addslashes($_POST['n_contrato']);
            $emissor = addslashes($_POST['emissor']);
            $empresa = addslashes($_POST['empresa']);
            $cnpj = addslashes($_POST['cnpj']);
            $cod2 = addslashes($_POST['cod2']);
            $valor = addslashes($_POST['valor']);
            $complemento = addslashes($_POST['complemento']);
            $faturamento = addslashes($_POST['faturamento']);
            $vencimento = addslashes($_POST['vencimento']);
            $reembolso = addslashes($_POST['reembolso']);
            $detalhes = addslashes($_POST['detalhes']);
            $situacao = addslashes($_POST['situacao']);
            $lei_kandir = addslashes($_POST['lei_kandir']);
            $inicio_contrato = addslashes($_POST['inicio_contrato']);
            $fim_contrato = addslashes($_POST['fim_contrato']);
            $data_cadastro = date("Y-m-d H:i:s");
            $user_id = $_SESSION['lgUser'];

            $contratos->upd_contratos_agenda($id, $cod, $nome_cliente, $razao_social, $n_contrato, $emissor, $empresa, $cnpj, $cod2, $valor, $complemento, $faturamento, $vencimento, $reembolso, $detalhes, $situacao, $lei_kandir, $inicio_contrato, $fim_contrato);
            header("Location: ".BASE_URL."agenda");
        }





        $data['getNomeCliente'] = $contratos->getNomeCliente();
        $data['returnContrato'] = $contratos->returnContrato($id);
        $data['user_name'] = $users->getName();

        $this->loadTemplate('ver_contrato', $data);
    }
}