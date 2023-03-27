<?php
class analiseController extends Controller {

    public function index() {
        $data = array();
        $empresas = new Empresas();
        $analise = new Analises();
        $warnings = new Warnings();
        $users = new Users();
        $users->setLoggedUser();
        $permissions = new Permissions();

        if(!empty($_POST['acao_warning']) && isset($_POST['acao_warning'])){
            if($_POST['acao_warning'] == 'upd_warnings'){
                $id = $_POST['id'];
    
                echo $warnings->updWarnings($id);
                exit;
            }
        }

        

        if(!empty($_POST['acao_analise']) && isset($_POST['acao_analise'])) {
            if($_POST['acao_analise'] == 'filtrar'){

                $inicioContratode = addslashes($_POST['inicioContratode']);
                $inicioContratoate = addslashes($_POST['inicioContratoate']);
                $fimContratode = addslashes($_POST['fimContratode']);
                $fimContratoate = addslashes($_POST['fimContratoate']);
                $inicioAditivode = addslashes($_POST['inicioAditivode']);
                $inicioAditivoate = addslashes($_POST['inicioAditivoate']);
                $fimAditivode = addslashes($_POST['fimAditivode']);
                $fimAditivoate = addslashes($_POST['fimAditivoate']);
                $empresa = addslashes($_POST['empresa']);
                
                echo $analise->info_stur($inicioContratode, $fimContratode, $inicioAditivode, $fimAditivode, $inicioContratoate, $fimContratoate, $inicioAditivoate, $fimAditivoate, $empresa);
                exit;
            }
        }

        $data['getCompanies'] = $empresas->getdbCompanies();

        if(in_array('19', $permissions->verifySystemPermissions())) {
            $this->loadTemplate('analise', $data);
        } else {
            header("Location: ".BASE_URL);
        }
    }

    public function analise_xls() {
    $data = array();

    if(!empty($_POST) && isset($_POST)){
        if($_POST['acao_analise'] == 'criar');
            $dados = addslashes($_POST['table']);
            $_SESSION['table'] = $dados;

    }
    

    $data['dado'] = $_SESSION['table'];

    
    $this->loadView('analise_xls', $data);
    }
}