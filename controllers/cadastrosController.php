<?php
class cadastrosController extends Controller {

    public function index(){
        $data = array();
        $users = new Users();
        $utils = new Utils();
        $empresas = new Empresas();
        $sistemas = new Sistemas();
        $orgaos = new Orgaos();
        $produtos = new Produtos();
        $clientes = new Clientes();
        $users->setLoggedUser();
        $utils->getCompanyNumber();
        $logs = new Logs();
        $warnings = new Warnings();
        $stur = new Stur();
        $permissions = new Permissions();

        $log = 'Acessou a área de Cadastros';
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

        if(!empty($_POST['acao_company'])){
            if($_POST['acao_company'] == 'cadastrar'){
                $name = addslashes($_POST['name']);
                $email = addslashes($_POST['email']);
                $cnpj = addslashes($_POST['cnpj']);
                $address1 = addslashes($_POST['address1']);
                $address2 = addslashes($_POST['address2']);
                $city = addslashes($_POST['city']);
                $uf = addslashes($_POST['uf']);
                $phone1 = addslashes($_POST['phone1']);
                $phone2 = addslashes($_POST['phone2']);
                $contact_name = addslashes($_POST['contact_name']);
                $tipo = addslashes($_POST['tipo']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                $empresas->cad_empresa($name, $email, $cnpj, $address1, $address2, $city, $uf, $phone1, $phone2, $contact_name, $tipo, $data_cadastro, $user_id);

                $log = 'Cadastrou a Empresa de nome: '.$name;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

                header("Location: ".BASE_URL."cadastros");
            }

        }
        if(!empty($_POST['acao_system'])){
            if($_POST['acao_system'] == 'cadastrar'){
                $name = addslashes($_POST['name']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                $sistemas->cad_sistemas($name, $data_cadastro, $user_id);

                $log = 'Cadastrou o sistema de nome: '.$name;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);
                header("Location: ".BASE_URL."cadastros");
            }
        }
        if(!empty($_POST['acao_agencies'])){
            if($_POST['acao_agencies'] == 'cadastrar'){
                $name = addslashes($_POST['name']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                $orgaos->cad_orgao($name, $data_cadastro, $user_id);

                $log = 'Cadastrou o órgão de nome: '.$name;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);
                header("Location: ".BASE_URL."cadastros");
            }
        }

        if(!empty($_POST['acao_produtos'])){
            if($_POST['acao_produtos'] == 'cadastrar'){
                $name = addslashes($_POST['name']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                $produtos->cad_produtos($name, $data_cadastro, $user_id);

                $log = 'Cadastrou o produto de nome: '.$name;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

                header("Location: ".BASE_URL."cadastros");
            }
        }

        if(!empty($_POST['acao_clientes'])){
            if($_POST['acao_clientes'] == 'cadastrar'){
                $stur_cod = addslashes($_POST['stur_cod']);
                $nome_cliente = addslashes($_POST['nome_cliente']);
                $razao_social = addslashes($_POST['razao_social']);
                $cnpj = addslashes($_POST['cnpj']);
                $address = addslashes($_POST['address']);
                $neighbour = addslashes($_POST['neighbour']);
                $cep = addslashes($_POST['cep']);
                $phone = addslashes($_POST['phone']);
                $state = addslashes($_POST['state']);
                $city = addslashes($_POST['city']);
                $email = addslashes($_POST['email']);
                $empresa = addslashes($_POST['empresa']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                $clientes->cad_cliente($stur_cod, $nome_cliente, $razao_social, $cnpj, $address, $neighbour, $cep, $phone, $state, $city, $email, $empresa, $data_cadastro, $user_id);

                $log = 'Cadastrou o Cliente de nome: '.$name;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);
                header("Location: ".BASE_URL."cadastros");
            }

            if($_POST['acao_clientes'] == 'fetch_cities'){
                $estado = addslashes($_POST['state']);

                echo $clientes->get_cidades($estado);
                exit;
            }   
        }

        $data['getCompanies'] = $empresas->getCompanies();
        $data['estados'] = $utils->getEstados();
        $data['cidades'] = $utils->getCidades();
        $data['company_number'] = $utils->getCompanyNumber();
        $data['system_number'] = $utils->getSystemNumber();
        $data['sector_number'] = $utils->getAgenciesNumber();
        $data['produtos_number'] = $utils->getProdutosNumber();
        $data['clients_number'] = $utils->getClientsNumber();
        $data['user_name'] = $users->getName();
        $data['imported_client_number'] = $stur->imported_client_number();
        
        if(in_array('18', $permissions->verifySystemPermissions())) {
            $this->loadTemplate('cadastros', $data);
        } else {
            header("Location: ".BASE_URL);
        }
    }

    public function ver_empresas(){
        $data = array();
        $users = new Users();
        $empresas = new Empresas();
        $utils = new Utils();
        $users->setLoggedUser();
        $logs = new Logs();

        $log = 'Acessou a área Ver Empresas';
        $data_cadastro = date("Y-m-d H:i:s");
        $user_id = $_SESSION['lgUser'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
        $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

        if(!empty($_POST['acao_company'])){
            if($_POST['acao_company'] == 'editar'){
                $id = addslashes($_POST['id']);
                echo $empresas->getCompany($id);
                exit;
            }
            if($_POST['acao_company'] == 'atualizar'){
                $id = addslashes($_POST['id']);
                $name = addslashes($_POST['name']);
                $email = addslashes($_POST['email']);
                $cnpj = addslashes($_POST['cnpj']);
                $address1 = addslashes($_POST['address1']);
                $address2 = addslashes($_POST['address2']);
                $city = addslashes($_POST['city']);
                $uf = addslashes($_POST['uf']);
                $phone1 = addslashes($_POST['phone1']);
                $phone2 = addslashes($_POST['phone2']);
                $contact_name = addslashes($_POST['contact_name']);
                $tipo = addslashes($_POST['tipo']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];

                $empresas->upd_empresa($id, $name, $email, $cnpj, $address1, $address2, $city, $uf, $phone1, $phone2, $contact_name, $tipo, $data_cadastro, $user_id);

                $log = 'Atualizou a Empresa de ID: '.$id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);
                header("Location: ".BASE_URL."cadastros/ver_empresas");
            }
            if($_POST['acao_company'] == 'excluir'){
                $id = $_POST['id'];
                $empresas->delete_empresa($id);

                $log = 'Excluiu a Empresa de ID: '.$id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

                exit;
            }
        }
        $data['estados'] = $utils->getEstados();
        $data['cidades'] = $utils->getCidades();
        $data['get_companies'] = $empresas->getCompanies();
        $data['user_name'] = $users->getName();
        $this->loadTemplate('ver_empresas', $data);
    }

    public function ver_sistemas(){
        $data = array();
        $users = new Users();
        $sistemas = new Sistemas();
        $empresas = new Empresas();
        $utils = new Utils();
        $users->setLoggedUser();
        $logs = new Logs();

        $log = 'Acessou a área Ver Empresas';
        $data_cadastro = date("Y-m-d H:i:s");
        $user_id = $_SESSION['lgUser'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
        $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

        if(!empty($_POST['acao_system'])){
            if($_POST['acao_system'] == 'editar'){
                $id = addslashes($_POST['id']);
                echo $sistemas->getSystem($id);
                exit;
            }
            if($_POST['acao_system'] == 'atualizar'){
                $id = $_POST['id'];
                $name = addslashes($_POST['name']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $sistemas->upd_system($id, $name, $data_cadastro, $user_id);

                $log = 'Atualizou o Sistema de ID: '.$id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);
                header("Location: ".BASE_URL."cadastros/ver_sistemas");
            }
            if($_POST['acao_system'] == 'excluir'){
                $id = $_POST['id'];
                $sistemas->delete_system($id);

                $log = 'Excluiu o Sistema de ID: '.$id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

                exit;
            }
        }

        $data['get_systems'] = $sistemas->get_systems();
        $data['get_companies'] = $empresas->getCompanies();
        $data['user_name'] = $users->getName();
        $this->loadTemplate('ver_sistemas', $data);
    }

    public function ver_orgaos(){
        $data = array();
        $users = new Users();
        $orgaos = new Orgaos();
        $empresas = new Empresas();
        $utils = new Utils();
        $users->setLoggedUser();
        $logs = new Logs();

        $log = 'Acessou a área de ver órgãos';
        $data_cadastro = date("Y-m-d H:i:s");
        $user_id = $_SESSION['lgUser'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
        $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

        if(!empty($_POST['acao_agencies'])){
            if($_POST['acao_agencies'] == 'editar'){
                $id = addslashes($_POST['id']);
                echo $orgaos->getOrgao($id);
                exit;
            }
            if($_POST['acao_agencies'] == 'atualizar'){
                $id = $_POST['id'];
                $name = addslashes($_POST['name']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $orgaos->upd_orgao($id, $name, $data_cadastro, $user_id);

                $log = 'Atualizou o Órgão de ID: '.$id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);
                header("Location: ".BASE_URL."cadastros/ver_orgaos");
            }
            if($_POST['acao_agencies'] == 'excluir'){
                $id = $_POST['id'];
                $orgaos->delete_orgao($id);

                $log = 'Excluiu o Órgão de ID: '.$id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);
                exit;
            }
        }

        $data['get_orgaos'] = $orgaos->get_orgaos();
        $data['get_companies'] = $empresas->getCompanies();
        $data['user_name'] = $users->getName();
        $this->loadTemplate('ver_orgaos', $data);
    }

    public function ver_produtos(){
        $data = array();
        $users = new Users();
        $orgaos = new Orgaos();
        $empresas = new Empresas();
        $produtos = new Produtos();
        $utils = new Utils();
        $users->setLoggedUser();
        $logs = new Logs();

        $log = 'Acessou a área de ver produtos';
        $data_cadastro = date("Y-m-d H:i:s");
        $user_id = $_SESSION['lgUser'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
        $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

        if(!empty($_POST['acao_produtos'])){
            if($_POST['acao_produtos'] == 'editar'){
                $id = addslashes($_POST['id']);
                echo $produtos->getProdutos($id);
                exit;
            }
            if($_POST['acao_produtos'] == 'atualizar'){
                $id = $_POST['id'];
                $name = addslashes($_POST['name']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $produtos->upd_produtos($id, $name, $data_cadastro, $user_id);

                $log = 'Atualizou o Produto de ID: '.$id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);
                header("Location: ".BASE_URL."cadastros/ver_produtos");
            }
            if($_POST['acao_produtos'] == 'excluir'){
                $id = $_POST['id'];
                $produtos->delete_produtos($id);

                $log = 'Excluiu o Produto de ID: '.$id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);
                exit;
            }
        }   

        $data['get_produtos'] = $produtos->get_produtos();
        $data['get_companies'] = $empresas->getCompanies();
        $data['user_name'] = $users->getName();
        $this->loadTemplate('ver_produtos', $data);
    }

    public function ver_clientes(){
        $data = array();
        $users = new Users();
        $clientes = new Clientes;
        $utils = new Utils();
        $users->setLoggedUser();
        $logs = new Logs();
        $empresas = new Empresas();

        $id = '';
        $log = 'Acessou a área de ver clientes';
        $data_cadastro = date("Y-m-d H:i:s");
        $user_id = $_SESSION['lgUser'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
        $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);

        if(!empty($_POST['acao_clientes'])){
            if($_POST['acao_clientes'] == 'editar'){
                $id = addslashes($_POST['id']);
                echo $clientes->getClientes($id);
                exit;
            }
            if($_POST['acao_clientes'] == 'atualizar'){
                $id = $_POST['id'];
                $stur_cod = addslashes($_POST['stur_cod']);
                $nome_cliente = addslashes($_POST['nome_cliente']);
                $razao_social = addslashes($_POST['razao_social']);
                $cnpj = addslashes($_POST['cnpj']);
                $address = addslashes($_POST['address']);
                $neighbour = addslashes($_POST['neighbour']);
                $cep = addslashes($_POST['cep']);
                $phone = addslashes($_POST['phone']);
                $state = addslashes($_POST['state']);
                $city = addslashes($_POST['city']);
                $email = addslashes($_POST['email']);
                $empresa = addslashes($_POST['empresa']);
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $clientes->upd_clientes($id, $stur_cod, $nome_cliente, $razao_social, $cnpj, $address, $neighbour, $cep, $phone, $state, $city, $email, $empresa, $data_cadastro, $user_id);

                $log = 'Atualizou o Cliente de ID: '.$id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);
                header("Location: ".BASE_URL."cadastros/ver_clientes");
            }
            if($_POST['acao_clientes'] == 'excluir'){
                $id = $_POST['id'];
                $clientes->delete_clientes($id);

                $log = 'Excluiu o Cliente de ID: '.$id;
                $data_cadastro = date("Y-m-d H:i:s");
                $user_id = $_SESSION['lgUser'];
                $user_ip = $_SERVER['REMOTE_ADDR'];
                
                $logs->log_acesso($log, $user_ip, $data_cadastro, $user_id);
                exit;
            }

            if($_POST['acao_clientes'] == 'fetch_cities'){
                $estado = addslashes($_POST['state']);

                echo $clientes->get_cidades($estado);
                exit;
            }   
        }   
        $data['estados'] = $utils->getEstados();
        $data['getCompanies'] = $empresas->getCompanies();
        $data['get_clientes'] = $clientes->get_clientes();
        $data['getClientes'] = $clientes->getClientes($id);
        $data['user_name'] = $users->getName();
        $this->loadTemplate('ver_clientes', $data);
    }

    public function ver_stur_clientes() {
        $data = array();
        $stur = new Stur();

        if(!empty($_POST['acao_import']) && isset($_POST['acao_import'])){
            if($_POST['acao_import'] == 'verify'){
                $id = addslashes($_POST['id']);
                $company_id = addslashes($_POST['company_id']);

                echo $stur->verifyImport($id, $company_id);
                exit;
            }
            if($_POST['acao_import'] == 'insert'){
                $cod_stur = addslashes($_POST['cod_stur']);
                $name = addslashes($_POST['name']);
                $razao_social = addslashes($_POST['razao_social']);
                $cpf_cnpj = addslashes($_POST['cpf_cnpj']);
                $endereco = addslashes($_POST['endereco']);
                $bairro = addslashes($_POST['bairro']);
                $cep = addslashes($_POST['cep']);
                $phone = addslashes($_POST['phone']);
                $email = addslashes($_POST['email']);
                $cidade_id = addslashes($_POST['cidade']);
                $estado_id = addslashes($_POST['estado']);
                $empresa_id = addslashes($_POST['empresa_id']);

                echo $stur->insertSturClient($cod_stur, $name, $razao_social, $cpf_cnpj, $endereco, $bairro, $cep, $phone, $email, $cidade_id, $estado_id, $empresa_id);
                exit;
            }
            if($_POST['acao_import'] == 'remove'){
                $id = addslashes($_POST['id']);
                $company_id = addslashes($_POST['company_id']);

                echo $stur->removeImport($id, $company_id);
                exit;
            }
        }

        $data['import_client_stur'] = $stur->import_client_stur();
        $this->loadTemplate('ver_stur_clientes', $data);
    }


    public function php_info(){
        $data = array();
        
        $this->loadView('php_info', $data);
    }

}