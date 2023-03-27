<?php
class relatoriosController extends Controller {

    public function index() {
        $users = new Users();
        if($users->isLogged() == false){
			header("Location: ".BASE_URL."login");
		}
    }

    public function rel_licitacoes(){
        $data = array();
        $users = new Users();
        $pdf = new Pdf();
        $sistemas = new Sistemas();
        $orgaos = new Orgaos();
        $empresas = new Empresas();
        $users->setLoggedUser();
        $logs = new Logs();
        $warnings = new Warnings();

        $log = 'Acessou a área de Relatórios Licitações';
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

        if(!empty($_POST['tipo_relatorio'])){
            
            $data_de = $_POST['data_de'];
            $data_ate = $_POST['data_ate'];
            $status = $_POST['status'];
            $winner_company = $_POST['winner_company'];
            $sistema = $_POST['sistema'];
            $orgaos = $_POST['orgao'];
            
            if(!empty($_POST['agencia'])){
                $agencia = addslashes($_POST['agencia']);
            } else {
                $agencia = 'off';
            }

            if(!empty($_POST['group'])){
                $group = addslashes($_POST['group']);
            } else {
                $group = 'off';
            }
            $empresas = $_POST['empresas'];

            //Report Fields
            if(!empty($_POST['checkData'])){
                $checkData = $_POST['checkData'];
            } else {
                $checkData = '';
            }
            if(!empty($_POST['checkObj'])){
                $checkObj = $_POST['checkObj'];
            } else {
                $checkObj = '';
            }
            if(!empty($_POST['checkOrg'])){
                $checkOrg = $_POST['checkOrg'];
            } else {
                $checkOrg = '';
            }
            if(!empty($_POST['checkEdital'])){
                $checkEdital = $_POST['checkEdital'];
            } else {
                $checkEdital = '';
            }
            if(!empty($_POST['checkSys'])){
                $checkSystem = $_POST['checkSys'];
            } else {
                $checkSystem = '';
            }
            if(!empty($_POST['checkCom'])){
                $checkCompany = $_POST['checkCom'];
            } else {
                $checkCompany = '';
            }
            if(!empty($_POST['checkStat'])){
                $checkStatus = $_POST['checkStat'];
            } else {
                $checkStatus = '';
            }
            if(!empty($_POST['checkSinf'])){
                $checkStatInf = $_POST['checkSinf'];
            } else {
                $checkStatInf = '';
            }
            if(!empty($_POST['checkVal'])){
                $checkValue = $_POST['checkVal'];
            } else {
                $checkValue = '';
            }
            if(!empty($_POST['checkTit'])){
                $checkTitle = $_POST['checkTit'];
            } else {
                $checkTitle = '';
            }
            
            $data['cabecalho'] = $pdf->cabecalhoPdf();
            $data['relatorio'] = $pdf->rel_licitacoes($data_de, $data_ate, $status, $winner_company, $sistema, $orgaos, $agencia, $group, $empresas, $checkData, $checkObj, $checkOrg, $checkEdital, $checkSystem, $checkCompany, $checkStatus, $checkStatInf, $checkValue, $checkTitle);
            $data['rodape'] = $pdf->footerPdf();
            $pdf->gerarPdf('pdf', $data);
        }

        $data['winner_company'] = $empresas->winner_company();
        $data['get_empresas'] = $empresas->getCompanies();
        $data['get_orgaos'] = $orgaos->get_orgaos();
        $data['get_sistemas'] = $sistemas->get_systems();
        $data['user_name'] = $users->getName();

        if($users->hasPermission('Relatorio_licitacoes')){
            $this->loadTemplate('rel_licitacoes', $data);
        } else {
            header("Location: ".BASE_URL);
        }
    }

    public function rel_contratos(){

        $data = array();
        $users = new Users();
        $pdf = new Pdf();
        $clientes = new Clientes();
        $empresas = new Empresas();
        $users->setLoggedUser();
        $logs = new Logs();
        $util = new Utils();
        $contratos = new Contratos();
        $warnings = new Warnings();

        $log = 'Acessou a área de Relatórios Contratos';
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

        if(!empty($_POST['tipo_contratos']) && $_POST['tipo_contratos'] == 'contratos'){
            $inicio_de = $_POST['inicio_de'];
            $inicio_ate = $_POST['inicio_ate'];
            $fim_de = $_POST['fim_de'];
            $fim_ate = $_POST['fim_ate'];
            $id_cliente = $_POST['id_cliente'];
            $empresa = $_POST['empresas'];
            $situacao = $_POST['situacao'];
            $lei_kandir = $_POST['lei_kandir'];
            $inad = $_POST['inadimplente'];
            $state = $_POST['state'];

            //Report Fields
            if(!empty($_POST['checkCode'])){
                $checkCode = $_POST['checkCode'];
            } else {
                $checkCode = '';
            }
            if(!empty($_POST['checkName'])){
                $checkName = $_POST['checkName'];
            } else {
                $checkName = '';
            }
            if(!empty($_POST['checkContrato'])){
                $checkContrato = $_POST['checkContrato'];
            } else {
                $checkContrato = '';
            }
            if(!empty($_POST['checkEmissor'])){
                $checkEmissor = $_POST['checkEmissor'];
            } else {
                $checkEmissor = '';
            }
            if(!empty($_POST['checkCNPJ'])){
                $checkCNPJ = $_POST['checkCNPJ'];
            } else {
                $checkCNPJ = '';
            }
            if(!empty($_POST['checkValue'])){
                $checkValue = $_POST['checkValue'];
            } else {
                $checkValue = '';
            }
            if(!empty($_POST['checkCod2'])){
                $checkCod2 = $_POST['checkCod2'];
            } else {
                $checkCod2 = '';
            }
            if(!empty($_POST['checkVencimento'])){
                $checkVencimento = $_POST['checkVencimento'];
            } else {
                $checkVencimento = '';
            }
            if(!empty($_POST['checkMail'])){
                $checkMail = $_POST['checkMail'];
            } else {
                $checkMail = '';
            }
            if(!empty($_POST['checkPhone'])){
                $checkPhone = $_POST['checkPhone'];
            } else {
                $checkPhone = '';
            }
            if(!empty($_POST['checkSituacao'])){
                $checkSituacao = $_POST['checkSituacao'];
            } else {
                $checkSituacao = '';
            }
            if(!empty($_POST['checkKandir'])){
                $checkKandir = $_POST['checkKandir'];
            } else {
                $checkKandir = '';
            }
            if(!empty($_POST['checkSTURValue'])){
                $checkSTURValue = $_POST['checkSTURValue'];
            } else {
                $checkSTURValue = '';
            }
            if(!empty($_POST['checkContStart'])){
                $checkContStart = $_POST['checkContStart'];
            } else {
                $checkContStart = '';
            }
            if(!empty($_POST['checkContEnd'])){
                $checkContEnd = $_POST['checkContEnd'];
            } else {
                $checkContEnd = '';
            }
            if(!empty($_POST['checkProfitValue'])){
                $checkProfitValue = $_POST['checkProfitValue'];
            } else {
                $checkProfitValue = '';
            }
            if(!empty($_POST['checkDetails'])){
                $checkDetails = $_POST['checkDetails'];
            } else {
                $checkDetails = '';
            }
            if(!empty($_POST['checkAditivo'])){
                $checkAditivo = $_POST['checkAditivo'];
            } else {
                $checkAditivo = '';
            }
            
            $data['cabecalho'] = $pdf->cabecalhoPdf();
            $data['relatorio'] = $pdf->rel_contratos($inicio_de, $inicio_ate, $fim_de, $fim_ate, $id_cliente, $empresa, $situacao, $lei_kandir, $inad, $state, $checkCode, $checkName, $checkContrato, $checkEmissor, $checkCNPJ, $checkValue, $checkCod2, $checkVencimento, $checkMail, $checkPhone, $checkSituacao, $checkKandir, $checkDetails, $checkAditivo, $checkSTURValue, $checkContStart, $checkContEnd, $checkProfitValue);
            $data['rodape'] = $pdf->footerPdf();
            $pdf->gerarPdf('pdf', $data);
        }

        $data['estados'] = $util->getEstados();
        $data['get_empresas'] = $empresas->getCompanies();
        $data['nome_cliente'] = $clientes->get_clientes();
        $data['user_name'] = $users->getName();
        if($users->hasPermission('Relatorio_contratos')){
            $this->loadTemplate('rel_contratos', $data);
        } else {
            header("Location: ".BASE_URL);
        }
    }

    public function rel_faturas(){
        $data = array();
        $users = new Users();
        $stur = new Stur();
        $empresas = new Empresas();
        $users->setLoggedUser();
        $logs = new Logs();
        $warnings = new Warnings();

        $log = 'Acessou a área de Relatórios Faturas';
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

        if(!empty($_POST['acao_faturas'])){
            if($_POST['acao_faturas'] == 'filtrar'){

                $empresa = $_POST['empresa'];
   
                echo $stur->getClientes($empresa);
                exit;
            }
        }
        if(!empty($_POST['acao_faturas'])){
            if($_POST['acao_faturas'] == 'dados_clientes'){
                
                $clientes = $_POST['clientes'];
                $empresa = $_POST['empresa'];
                $status = $_POST['status'];

   
                echo $stur->getDadosClientes($clientes, $empresa, $status);
                exit;
            }

            if($_POST['acao_faturas'] == 'searchCodClient'){

                $company = $_POST['company'];
                $stur_cod = $_POST['stur_cod'];

                echo $stur->getClientSturCod($company, $stur_cod);
                exit;
            }
        }


        $data['getCompanies'] = $empresas->getdbCompanies();
        $data['user_name'] = $users->getName();
        if($users->hasPermission('Relatorio_faturas')){
            $this->loadTemplate('rel_faturas', $data);
        } else {
            header("Location: ".BASE_URL);
        }
    }

    public function rel_geral() {
        $data = array();
        $users = new Users();
        $users->setLoggedUser();
        $empresas = new Empresas();
        $stur = new Stur();
        $xls = new Xls();
        $warnings = new Warnings();

        if(!empty($_POST['acao_warning']) && isset($_POST['acao_warning'])){
            if($_POST['acao_warning'] == 'upd_warnings'){
                $id = $_POST['id'];
    
                echo $warnings->updWarnings($id);
                exit;
            }
        }

        if(!empty($_POST['acao_relatorio'])) {
            if($_POST['acao_relatorio'] == 'empresa') {

                $empresa = addslashes($_POST['empresa']);

                echo $stur->rel_clientes($empresa);
                exit;
            }

            if($_POST['acao_relatorio'] == 'info_clientes') {

                $empresa = addslashes($_POST['empresa']);
                if($_POST['codtipo'][0] != 'pira') {
                    $codtipo = $_POST['codtipo'];    
                } else {
                    $codtipo = '';
                }
                
                $situacao = addslashes($_POST['situacao']);

                echo $stur->rel_status($empresa, $codtipo, $situacao);
                exit;
            }
            if($_POST['acao_relatorio'] == 'gerar_xls') {


                $this->loadView('rel_clientes_xls', $data);
                exit;
            }
        }

        $data['getCompanies'] = $empresas->getdbCompanies();
        $data['user_name'] = $users->getName();

        if($users->hasPermission('Relatorio_geral')){
            $this->loadTemplate('rel_geral', $data);
        } else {
            header("Location: ".BASE_URL);
        }
    }

    public function xls(){
        $data = array();
        $stur = new Stur();

            $clientes = $_POST['clientes_fatura'];
            $empresa = $_POST['empresa'];
            $status = $_POST['status'];



        $data['stur'] = $stur;
        $data['empresa'] = $empresa;
        $data['clientes'] = $clientes;
        $data['getDadosClientes'] = $stur->getDadosClientes($clientes, $empresa, $status, $xls = 's');

        $this->loadView('xls', $data);   
    }

    public function xlsContratos(){
        $data = array();
        $contratos = new Contratos();

        if(!empty($_POST['tipo_contratos']) && $_POST['tipo_contratos'] == 'contratos_xls'){;
            $inicio_de = $_POST['inicio_de'];
            $inicio_ate = $_POST['inicio_ate'];
            $fim_de = $_POST['fim_de'];
            $fim_ate = $_POST['fim_ate'];
            $id_cliente = $_POST['id_cliente'];
            $empresas = $_POST['empresas'];
            $situacao = $_POST['situacao'];
            $lei_kandir = $_POST['lei_kandir'];
            $inad = $_POST['inadimplente'];
            $state = $_POST['state'];
            

            //Report Fields
            if(!empty($_POST['checkCode'])){
                $checkCode = $_POST['checkCode'];
            } else {
                $checkCode = '';
            }
            if(!empty($_POST['checkName'])){
                $checkName = $_POST['checkName'];
            } else {
                $checkName = '';
            }
            if(!empty($_POST['checkContrato'])){
                $checkContrato = $_POST['checkContrato'];
            } else {
                $checkContrato = '';
            }
            if(!empty($_POST['checkEmissor'])){
                $checkEmissor = $_POST['checkEmissor'];
            } else {
                $checkEmissor = '';
            }
            if(!empty($_POST['checkCNPJ'])){
                $checkCNPJ = $_POST['checkCNPJ'];
            } else {
                $checkCNPJ = '';
            }
            if(!empty($_POST['checkValue'])){
                $checkValue = $_POST['checkValue'];
            } else {
                $checkValue = '';
            }
            if(!empty($_POST['checkVencimento'])){
                $checkVencimento = $_POST['checkVencimento'];
            } else {
                $checkVencimento = '';
            }
            if(!empty($_POST['checkMail'])){
                $checkMail = $_POST['checkMail'];
            } else {
                $checkMail = '';
            }
            if(!empty($_POST['checkPhone'])){
                $checkPhone = $_POST['checkPhone'];
            } else {
                $checkPhone = '';
            }
            if(!empty($_POST['checkSituacao'])){
                $checkSituacao = $_POST['checkSituacao'];
            } else {
                $checkSituacao = '';
            }
            if(!empty($_POST['checkKandir'])){
                $checkKandir = $_POST['checkKandir'];
            } else {
                $checkKandir = '';
            }
            if(!empty($_POST['checkDetails'])){
                $checkDetails = $_POST['checkDetails'];
            } else {
                $checkDetails = '';
            }
            if(!empty($_POST['checkAditivo'])){
                $checkAditivo = $_POST['checkAditivo'];
            } else {
                $checkAditivo = '';
            }
            if(!empty($_POST['checkSTURValue'])){
                $checkSTURValue = $_POST['checkSTURValue'];
            } else {
                $checkSTURValue = '';
            }
            if(!empty($_POST['checkContStart'])){
                $checkContStart = $_POST['checkContStart'];
            } else {
                $checkContStart = '';
            }
            if(!empty($_POST['checkContEnd'])){
                $checkContEnd = $_POST['checkContEnd'];
            } else {
                $checkContEnd = '';
            }
            if(!empty($_POST['checkProfitValue'])){
                $checkProfitValue = $_POST['checkProfitValue'];
            } else {
                $checkProfitValue = '';
            }

            $data['relatorio'] = $contratos->xlsContratos($inicio_de, $inicio_ate, $fim_de, $fim_ate, $id_cliente, $empresas, $situacao, $lei_kandir, $inad, $state, $checkCode, $checkName, $checkContrato, $checkEmissor, $checkCNPJ, $checkValue, $checkVencimento, $checkMail, $checkPhone, $checkSituacao, $checkKandir, $checkDetails, $checkAditivo, $checkSTURValue, $checkContStart, $checkContEnd, $checkProfitValue);
            
            $this->loadView('xlsContratos', $data); 
        }          
    }

    public function rel_clientes_xls(){
        $data = array();
        $xls = new Xls();
        $stur = new Stur();

        $empresa = addslashes($_POST['empresa']);

        if(!empty($_POST['codtipo'])){
            $codtipo = addslashes($_POST['codtipo']);
            $codtipo = explode(',', $codtipo);
        } else {
            $codtipo = addslashes($_POST['codtipo']);
        }
        
        $situacao = addslashes($_POST['situacao']);

        $data['rel_status'] = $stur->rel_status_xls($empresa, $codtipo, $situacao);
        $this->loadView('rel_clientes_xls', $data);   
    }
}