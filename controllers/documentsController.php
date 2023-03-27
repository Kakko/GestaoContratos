<?php
class documentsController extends Controller {

    public function index(){
        $data = array();
        $documents = new Documents();
        $empresas = new Empresas();
        $util = new Utils();
        $users = new Users();
        $users->setLoggedUser();
        $logs = new Logs();
        $warnings = new Warnings();
        $permissions = new Permissions();

        if($users->isLogged() == false){
			header("Location: ".BASE_URL."login");
        }
        
        $log = 'Acessou a área dos documentos';
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

        if(!empty($_POST['doc_action']) && isset($_POST['doc_action'])){

            //CADASTRAR NOVO DOCUMENTO
            if($_POST['doc_action'] == 'cadNewDoc'){


                $company = addslashes($_POST['company']);
                $category = addslashes($_POST['categories']);
                $doctype = addslashes($_POST['docType']);
                $address = addslashes($_POST['address']);
                $issue_date = addslashes($_POST['issue_date']);

                if(!empty($_POST['expiration_day'])){
                    $expiration_day = addslashes($_POST['expiration_day']);
                    $expiration_date = date('Y-m-d', strtotime($issue_date.'+ '.$expiration_day.' days')); // ADICIONANDO O DIA DE VENCIMENTO À DATA DE EMISSÃO PARA CALCULAR A DATA DE VENCIMENTO
                } else {
                    $expiration_date = addslashes($_POST['expiration_date']);
                    $expiration_day = 0;
                    // $expiration_day = date_diff(new datetime($issue_date), new datetime($expiration_date)); // CALCULANDO O DIA DE VALIDADE ENTRE AS 2 DATAS INSERIDAS NO SISTEMA
                    // $expiration_day = $expiration_day->format('%d'); // FORMATANDO O RESULTADO DO DATE_DIFF PARA EXIBIR SOMENTE UMA STRING COM O VALOR.
                }                
                if(empty($_POST['value'])){
                    $value = 0.00;
                } else {
                    $value = str_replace('.', '', addslashes($_POST['value']));
                    $value = str_replace(',', '.', $value);
                }
                $state = addslashes($_POST['state']);
                $city = addslashes($_POST['city']);
                $n_copy = addslashes($_POST['n_copy']);
                $description = addslashes($_POST['description']);

                if(!empty($_FILES['doc_file']['name'][0])){
                    $doc_file = $_FILES['doc_file'];
                } else {
                    $doc_file = '';
                }

                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                $documents->addNewDoc($company, $category, $doctype, $address, $issue_date, $expiration_date, $expiration_day, $value, $state, $city, $n_copy, $description, $doc_file, $data_cadastro, $user_id);
                header("Location: ".BASE_URL."documents");
            }

            //EXIBIR DOCUMENTO CADASTRADO
            if($_POST['doc_action'] == 'seeDoc'){
                $id = addslashes($_POST['id']);
                
                echo $documents->getDoc($id);
                exit;
            }

            //EDITAR DOCUMENTO CADASTRADO
            if($_POST['doc_action'] == 'edit_doc'){
                $id = addslashes($_POST['id']);

                echo $documents->editDocs($id);
                exit;
            }

            //ATUALIZAR DOCUMENTO CADASTRADO {
            if($_POST['doc_action'] == 'att_doc'){
                $id = addslashes($_POST['id']);
                $company = addslashes($_POST['company']);
                $category = addslashes($_POST['category']);
                $doctype = addslashes($_POST['edit_doctype']);
                $address = addslashes($_POST['address']);
                $issue_date = addslashes($_POST['issue_date']);
                if(empty($_POST['expiration_day'])){
                    $expiration_day = 0;
                } else {
                    $expiration_day = addslashes($_POST['expiration_day']);
                }
                $expiration_date = addslashes($_POST['expiration_date']);
            
                if(empty($_POST['value'])){
                    $value = 0.00;
                } else {
                    $value = str_replace('.', '', addslashes($_POST['value']));
                    $value = str_replace(',', '.', $value);
                }

                $state = addslashes($_POST['state']);
                $city = addslashes($_POST['city']);
                $n_copy = addslashes($_POST['n_copy']);
                $description = addslashes($_POST['description']);

                if(!empty($_FILES['doc_file']['name'][0])){
                    $doc_file = $_FILES['doc_file'];
                } else {
                    $doc_file = '';
                }
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                $documents->attDoc($id, $company, $category, $doctype, $address, $issue_date, $expiration_date, $expiration_day, $value, $state, $city, $n_copy, $description, $doc_file, $data_cadastro, $user_id);
                header("Location: ".BASE_URL."documents");
            }

            //EXCLUIR DOCUMENTO CADASTRADO
            if($_POST['doc_action'] == 'delete_doc'){
                $id = addslashes($_POST['id']);

                echo $documents->deleteDoc($id);
                exit;
            }

            //EXCLUIR ARQUIVO ENVIADO
            if($_POST['doc_action'] == 'delete_file'){
                $id = addslashes($_POST['id']);
                echo $documents->deleteFile($id);
                exit;
            }

            //CADASTRAR NOVA CATEGORIA
            if($_POST['doc_action'] == 'addCategory'){
                $name = addslashes($_POST['name']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                echo $documents->addCategory($name, $data_cadastro, $user_id);
                exit;
            }

            //CADASTRAR NOVO TIPO DE DOCUMENTO
            if($_POST['doc_action'] == 'addDocType'){
                $name = addslashes($_POST['name']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                echo $documents->addDocType($name, $data_cadastro, $user_id);
                exit;
            }

            //EXIBIR AS CIDADES DE ACORDO COM O ESTADO SELECIONADO
            if($_POST['doc_action'] == 'show_cities'){
                $estado = addslashes($_POST['state']);
                
                echo $util->get_cidades($estado);
                exit;
            }

            //ADD NÚMERO DE CÓPIAS
            if($_POST['doc_action'] == 'addCopy'){
                $id = addslashes($_POST['id']);

                echo $documents->addCopy($id);
                exit;
            }

            //REMOVE NÚMERO DE CÓPIAS
            if($_POST['doc_action'] == 'removeCopy'){
                $id = addslashes($_POST['id']);

                echo $documents->removeCopy($id);
                exit;
            }

            //FILTROS
            if($_POST['doc_action'] == 'filter'){
                $company = $_POST['company'];

                echo $documents->filter($company);
                exit;
            }
        }
        
        // $data['cities'] = $util->getCidades();
        $data['states'] = $util->getEstados();
        $data['getCategories'] = $documents->getCategories();
        $data['getDocType'] = $documents->getDocType();
        $data['getCompanies'] = $empresas->getCompanies();
        $data['data'] = $documents->getDocuments();
        $data['users'] = $users;
        
        if(in_array('15', $permissions->verifySystemPermissions())) {
            $this->loadTemplate('documents', $data);
        } else {
            header("Location: ".BASE_URL);
        }
    }
}