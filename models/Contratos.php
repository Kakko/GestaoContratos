<?php
class Contratos extends Model {

    public function cad_novo_contrato($cod_stur, $client_name, $razao_social, $n_contrato, $emissor, $empresa, $cnpj, $cod, $valor, $complemento, $faturamento, $vencimento, $reembolso, $detalhes, $situacao, $lei_kandir, $inicio_contrato, $fim_contrato, $data_cadastro, $user_id){

        // $licitacao_id = $this->db->lastInsertId(); // Pega o último ID inserido
        $sql = $this->db->prepare("SELECT nome_cliente from cad_clientes WHERE id = :id");
        $sql->bindValue(":id", $client_name);
        $sql->execute();

        if($sql->rowCount() > 0){
            $client_name = $sql->fetch(PDO::FETCH_ASSOC);
        }
        $client_name = $client_name['nome_cliente'];

        $sql = $this->db->prepare("INSERT INTO cad_contratos SET cod = :cod_stur, nome_cliente = :nome_cliente, razao_social = :razao_social, n_contrato = :n_contrato, emissor = :emissor, empresa = :empresa, cnpj = :cnpj, cod2 = :cod, valor = :valor, complemento = :complemento, faturamento = :faturamento, vencimento = :vencimento, reembolso = :reembolso, detalhes = :detalhes, situacao = :situacao, lei_kandir = :lei_kandir, inicio_contrato = :inicio_contrato, fim_contrato = :fim_contrato, data_cadastro = :data_cadastro, user_id = :user_id");
        $sql->bindValue(":cod_stur", $cod_stur);
        $sql->bindValue(":nome_cliente", $client_name);
        $sql->bindValue(":razao_social", $razao_social);
        $sql->bindValue(":n_contrato", $n_contrato);
        $sql->bindValue(":emissor", $emissor);
        $sql->bindValue(":empresa", $empresa);
        $sql->bindValue(":cnpj", $cnpj);
        $sql->bindValue(":cod", $cod);
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":complemento", $complemento);
        $sql->bindValue(":faturamento", $faturamento);
        $sql->bindValue(":vencimento", $vencimento);
        $sql->bindValue(":reembolso", $reembolso);
        $sql->bindValue(":detalhes", $detalhes);
        $sql->bindValue(":situacao", $situacao);
        $sql->bindValue(":lei_kandir", $lei_kandir);
        $sql->bindValue(":inicio_contrato", $inicio_contrato);
        $sql->bindValue(":fim_contrato", $fim_contrato);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();

        return 'Contrato cadastrado!';

        //CONSULTA E ATUALIZAÇÃO DA INADIMPLENCIA

        // $sql = $this->stur->prepare("SELECT count(codclifor) AS qtd FROM ERECEBER WHERE docto like 'ft%' AND dtvencto < GETDATE() AND status = 'Aberto' AND codclifor = :cod_stur");
        // print_r($sql);
        // exit;
        // $sql->bindValue(":cod_stur", $cod_stur);
        // $sql->execute();

        // $stur = $sql->fetch(PDO::FETCH_ASSOC);


        // if($stur['qtd'] > 0){

        //     $sql3 = $this->db->prepare("UPDATE cad_contratos SET inadimplente = 'Sim' WHERE nome_cliente = :nome_cliente");
        //     $sql3->bindValue(":nome_cliente", $client_name);
        //     $sql3->execute();

        // } else {

        //     $sql4 = $this->db->prepare("UPDATE cad_contratos SET inadimplente = 'Não' WHERE nome_cliente = :nome_cliente");
        //     $sql4->bindValue(":nome_cliente", $client_name);
        //     $sql4->execute();

        // }
    }

    public function cad_contrato($value, $company, $cnpj, $data_cadastro, $user_id, $id){

        $verify = $this->db->prepare("SELECT * FROM cad_contratos WHERE licitacao_id = :licitacao_id");
        $verify->bindValue(":licitacao_id", $id);
        $verify->execute();

        if($verify->rowCount() == 0){

            $sql = $this->db->prepare("INSERT INTO cad_contratos SET valor = :valor, empresa = :empresa, cnpj = :cnpj, situacao = 'Novo', inicio_contrato = '1900-01-01', fim_contrato = '5000-01-01', data_cadastro = :data_cadastro, user_id = :user_id, licitacao_id = :licitacao_id");

            $sql->bindValue(":valor", $value);
            $sql->bindValue(":empresa", $company);
            $sql->bindValue(":cnpj", $cnpj);
            $sql->bindValue(":data_cadastro", $data_cadastro);
            $sql->bindValue(":user_id", $user_id);
            $sql->bindValue(":licitacao_id", $id);
            $sql->execute();
        }


    }

    public function getContratos(){
        $array = array();

        $sql = $this->db->prepare("SELECT cad_clientes.stur_cod, cad_contratos.* FROM cad_contratos LEFT JOIN cad_clientes ON cad_contratos.nome_cliente = cad_clientes.nome_cliente ORDER BY cad_contratos.nome_cliente ASC");
        $sql->execute();

        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getNomeCliente(){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM cad_clientes ORDER BY nome_cliente ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function get_contrato($id){
        $array = array();
        $data = '';

        $sql = $this->db->prepare("SELECT cad_empresas.name AS company_name, cad_clientes.id AS client_id, cad_contratos.* FROM cad_contratos
                                    LEFT JOIN cad_clientes ON (cad_clientes.stur_cod = cad_contratos.cod)
                                    LEFT JOIN cad_empresas ON (cad_empresas.id = cad_contratos.empresa)
                                    WHERE cad_contratos.id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }

        if($array['cod'] == 0) {
            $sql = $this->db->prepare("SELECT cad_empresas.name AS company_name, cad_clientes.id AS client_id, cad_contratos.* FROM cad_contratos
                        LEFT JOIN cad_clientes ON (cad_clientes.cnpj = cad_contratos.cnpj OR cad_clientes.razao_social = cad_contratos.razao_social)
                        LEFT JOIN cad_empresas ON (cad_empresas.id = cad_contratos.empresa)
                        WHERE cad_contratos.id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();

            if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
}
        }


        $contratos = new Contratos();
        $getNomeCliente = $contratos->getNomeCliente();


        $data .= '
        <div class="row">
            <div class="col-md-1">
                <label for="cod">Cód STUR:</label>
                <input type="text" name="acao_contratos" value="updContato" hidden>
                <input type="text" name="id" value="'.$array['id'].'" hidden>
                <input type="number" class="form-control form-control-sm" name="cod" id="cod" value="'.$array['cod'].'" onchange="searchEditCod()">
            </div>
            <div class="col-md-4">
                <label for="nome_cliente">Nome Cliente:</label>
                <select class="form-control form-control-sm" name="nome_cliente" onchange="cod_stur()" id="cliente_contrato">
                    <option>'.$array['nome_cliente'].'</option>';
                    foreach($getNomeCliente as $nome_cliente){
                        $data .='
                        <option>'.$nome_cliente['nome_cliente'].'</option>';
                    }
                        $data .='
                </select>
            </div>
            <div class="col-md-5">
                <label for="razao_social">Razão Social:</label>
                <input type="text" class="form-control form-control-sm" name="razao_social" id="razao_social" value="'.$array['razao_social'].'" readonly>
            </div>
            <div class="col-md-2">
                <label for="cnpj">CNPJ:</label>
                <input type="text" class="form-control form-control-sm" name="cnpj" id="cnpj" value="'.$array['cnpj'].'" readonly>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-2">
                <label for="n_contrato">Nº do Contrato:</label>
                <input type="text" class="form-control form-control-sm" name="n_contrato" value="'.$array['n_contrato'].'">
            </div>
            <div class="col-md-2">
                <label for="emissor">Emissor:</label>
                <input type="text" class="form-control form-control-sm" name="emissor" value="'.$array['emissor'].'">
            </div>
            <div class="col-md-3">
                <label for="empresa">Empresa:</label>
                <input type="text" class="form-control form-control-sm" name="empresa" id="empresa" value="'.$array['empresa'].'" hidden>
                <input type="text" class="form-control form-control-sm" name="empresa_show" id="empresa_show" value="'.$array['company_name'].'" readonly>
            </div>
            <div class="col-md-1">
                <label for="cod2">Cód:</label>
                <input type="text" class="form-control form-control-sm" name="cod2" value="'.$array['cod2'].'">
            </div>
            <div class="col-md-2">
                <label for="valor">Valor:</label>
                <input type="text" class="form-control form-control-sm valor" name="valor" value="'.number_format($array['valor'],2,',','.').'">
            </div>
            <div class="col-md-2">
                <label>Complemento:</label>
                <input type="text" class="form-control form-control-sm" name="complemento" value="'.$array['complemento'].'">
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-2">
                <label for="faturamento">Faturamento:</label>
                <input type="text" class="form-control form-control-sm" name="faturamento" value="'.$array['faturamento'].'">
            </div>
            <div class="col-md-2">
                <label for="vencimento">Vencimento:</label>
                <input type="text" class="form-control form-control-sm" name="vencimento" value="'.$array['vencimento'].'">
            </div>
            <div class="col-md-2">
                <label>Reembolso</label>
                <input type="text" class="form-control form-control-sm" name="reembolso" value="'.$array['reembolso'].'">
            </div>
            <div class="col-md-6">
                <label for="detalhes">Detalhes:</label>
                <input type="text" class="form-control form-control-sm" name="detalhes" value="'.$array['detalhes'].'">
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md">
                <label for="situacao">Situação:</label>
                <select class="form-control form-control-sm" name="situacao">
                    <option>'.$array['situacao'].'</option>
                    <option disabled>---------------</option>
                    <option>Ativo</option>
                    <option>Inativo</option>
                </select>
            </div>
            <div class="col-md">
                <label for="lei_kandir">Lei Kandir:</label>
                <select class="form-control form-control-sm" name="lei_kandir">
                    <option>'.$array['lei_kandir'].'</option>
                    <option disabled>------------------</option>
                    <option value="S">Sim</option>
                    <option value="N">Não</option>
                </select>
            </div>
            <div class="col-md">
                <label for="inicio">Início do Contrato:</label>
                <input type="date" class="form-control form-control-sm" name="inicio_contrato" value="'.$array['inicio_contrato'].'">
            </div>
            <div class="col-md">
                <label for="fim">Fim do Contrato:</label>
                <input type="date" class="form-control form-control-sm" name="fim_contrato" value="'.$array['fim_contrato'].'">
            </div>
        </div>
        ';

        return $data;
    }

    public function upd_contratos($id, $cod, $nome_cliente, $razao_social, $n_contrato, $emissor, $empresa, $cnpj, $cod2, $valor, $complemento, $faturamento, $vencimento, $reembolso, $detalhes, $situacao, $lei_kandir, $inicio_contrato, $fim_contrato, $data_cadastro, $user_id){
        
        // $sql = $this->db->prepare("SELECT nome_cliente from cad_clientes WHERE id = :id");
        // $sql->bindValue(":id", $nome_cliente);
        // $sql->execute();

        // if($sql->rowCount() > 0){
        //     $client_name = $sql->fetch(PDO::FETCH_ASSOC);
        // }
        // $nome_cliente = $client_name['nome_cliente'];

        $sql = $this->db->prepare("UPDATE cad_contratos SET cod = :cod, nome_cliente = :nome_cliente, razao_social = :razao_social, n_contrato = :n_contrato, emissor = :emissor, empresa = :empresa, cnpj = :cnpj, cod2 = :cod2, valor = :valor, complemento = :complemento, faturamento = :faturamento, vencimento = :vencimento, reembolso = :reembolso, detalhes = :detalhes, situacao = :situacao, lei_kandir = :lei_kandir, inicio_contrato = :inicio_contrato, fim_contrato = :fim_contrato, data_cadastro = :data_cadastro, user_id = :user_id WHERE id = :id");

        $sql->bindValue(":id", $id);
        $sql->bindValue(":cod", $cod);
        $sql->bindValue(":nome_cliente", $nome_cliente);
        $sql->bindValue(":razao_social", $razao_social);
        $sql->bindValue(":n_contrato", $n_contrato);
        $sql->bindValue(":emissor", $emissor);
        $sql->bindValue(":empresa", $empresa);
        $sql->bindValue(":cnpj", $cnpj);
        $sql->bindValue(":cod2", $cod2);
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":complemento", $complemento);
        $sql->bindValue(":faturamento", $faturamento);
        $sql->bindValue(":vencimento", $vencimento);
        $sql->bindValue(":reembolso", $reembolso);
        $sql->bindValue(":detalhes", $detalhes);
        $sql->bindValue(":situacao", $situacao);
        $sql->bindValue(":lei_kandir", $lei_kandir);
        $sql->bindValue(":inicio_contrato", $inicio_contrato);
        $sql->bindValue(":fim_contrato", $fim_contrato);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();
        
    }

    public function upd_contratos_agenda($id, $cod, $nome_cliente, $razao_social, $n_contrato, $emissor, $empresa, $cnpj, $cod2, $valor, $complemento, $faturamento, $vencimento, $reembolso, $detalhes, $situacao, $lei_kandir, $inicio_contrato, $fim_contrato){
        $sql = $this->db->prepare("UPDATE cad_contratos SET cod = :cod, nome_cliente = :nome_cliente, razao_social = :razao_social, n_contrato = :n_contrato, emissor = :emissor, empresa = :empresa, cnpj = :cnpj, cod2 = :cod2, valor = :valor, complemento = :complemento, faturamento = :faturamento, vencimento = :vencimento, reembolso = :reembolso, detalhes = :detalhes, situacao = :situacao, lei_kandir = :lei_kandir, inicio_contrato = :inicio_contrato, fim_contrato = :fim_contrato WHERE id = :id");

        $sql->bindValue(":id", $id);
        $sql->bindValue(":cod", $cod);
        $sql->bindValue(":nome_cliente", $nome_cliente);
        $sql->bindValue(":razao_social", $razao_social);
        $sql->bindValue(":n_contrato", $n_contrato);
        $sql->bindValue(":emissor", $emissor);
        $sql->bindValue(":empresa", $empresa);
        $sql->bindValue(":cnpj", $cnpj);
        $sql->bindValue(":cod2", $cod2);
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":complemento", $complemento);
        $sql->bindValue(":faturamento", $faturamento);
        $sql->bindValue(":vencimento", $vencimento);
        $sql->bindValue(":reembolso", $reembolso);
        $sql->bindValue(":detalhes", $detalhes);
        $sql->bindValue(":situacao", $situacao);
        $sql->bindValue(":lei_kandir", $lei_kandir);
        $sql->bindValue(":inicio_contrato", $inicio_contrato);
        $sql->bindValue(":fim_contrato", $fim_contrato);
        $sql->execute();
    }

    public function cad_historico_contrato($titulo, $data_contrato, $horario_contrato, $inicio_aditivo, $fim_aditivo, $valueAditivo, $obs, $data_cadastro, $user_id, $contrato_id, $check_aditivo){
        
        $sql = $this->db->prepare("INSERT INTO hist_contratos SET titulo = :titulo, data_contrato = :data_contrato, horario_contrato = :horario_contrato, obs = :obs, data_cadastro = :data_cadastro, user_id = :user_id, contrato_id = :contrato_id, valor_aditivo = :valor_aditivo, aditivo = :aditivo");
        $sql->bindValue(":titulo", $titulo);
        $sql->bindValue(":data_contrato", $data_contrato);
        $sql->bindValue(":horario_contrato", $horario_contrato);
        $sql->bindValue(":obs", $obs);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->bindValue(":contrato_id", $contrato_id);
        $sql->bindValue(":valor_aditivo", $valueAditivo);
        $sql->bindValue(":aditivo", $check_aditivo);
        $sql->execute();

        if(!empty($fim_aditivo) && !empty($inicio_aditivo)){
            $sql = $this->db->prepare("UPDATE cad_contratos SET inicio_aditivo = :inicio_aditivo, fim_aditivo = :fim_aditivo WHERE id = :contrato_id");
            $sql->bindValue(":inicio_aditivo", $inicio_aditivo);
            $sql->bindValue(":fim_aditivo", $fim_aditivo);
            $sql->bindValue(":contrato_id", $contrato_id);
            $sql->execute();
        }

        return 'ok';
    }

    public function verContrato($id){
        $array = array();
        $history = array();
        $contratos = '';
        $permissions = new Permissions();


        //FETCH CONTRATOS
        $sql = $this->db->prepare("SELECT cad_empresas.name AS company_name, cad_contratos.* FROM cad_contratos 
                                    LEFT JOIN cad_empresas ON (cad_empresas.id = cad_contratos.empresa)
                                    WHERE cad_contratos.id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }


        //FETCH HISTORY
        $sql = $this->db->prepare("SELECT users.name AS user, cad_arquivos.url AS url, hist_contratos.* FROM hist_contratos LEFT JOIN users ON (users.id = hist_contratos.user_id) LEFT JOIN cad_arquivos ON (hist_contratos.id = cad_arquivos.histContrato_id) WHERE contrato_id = :id");
        $sql->bindValue(":id", $array['id']);
        $sql->execute();

        if($sql->rowCount() > 0){
            $history = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $user_permissions = $permissions->verifyPermissions($array['empresa']);
        

        $contratos .='
        <div class="container-fluid" style="border: 1px solid lightgray; border-radius: 5px; box-shadow: 0 0 10px lightgray">
            <div class="row">
                <div class="col-md-1">
                    <label style="font-weight: bolder">Cod:</label><br/>
                    <input id="cod_stur" class="exib_dados" type="text" value="'.$array['cod'].'" readonly>
                </div>
                <div class="col-md">
                    <label style="font-weight: bolder">Nome Cliente:</label><br/>
                    <input id="nome_cliente" class="exib_dados" type="text" value="'.$array['nome_cliente'].'" readonly>
                </div>
                <div class="col-md-3">
                    <label style="font-weight: bolder">Razão Social:</label><br/>
                    <input id="razao_social_ver" class="exib_dados" type="text" value="'.$array['razao_social'].'" readonly>
                </div>
                <div class="col-md">
                    <label style="font-weight: bolder">Nº do Contrato:</label><br/>
                    <input id="n_contrato" class="exib_dados" type="text" value="'.$array['n_contrato'].'" readonly>
                </div>
                <div class="col-md">
                    <label style="font-weight: bolder">Emissor</label><br/>
                    <input id="emissor" class="exib_dados" type="text" value="'.$array['emissor'].'" readonly>
                </div>
                <div class="col-md">
                    <label style="font-weight: bolder">Empresa:</label><br/>
                    <input id="empresa" class="exib_dados" type="text" value="'.$array['company_name'].'" readonly>
                </div>
            </div>
            <br><br/>
            <div class="row">
                <div class="col-md-3">
                    <label style="font-weight: bolder">CNPJ:</label><br/>
                    <input id="cnpj_ver" class="exib_dados" type="text" value="'.$array['cnpj'].'" readonly>
                </div>
                <div class="col-md-2">
                    <label style="font-weight: bolder">Tipo de Cliente:</label><br/>
                    <input id="cod2" class="exib_dados" type="text" value="'.$array['cod2'].'" readonly>
                </div>
                <div class="col-md-2">
                    <label style="font-weight: bolder">Valor:</label><br/>
                    <input id="valor" class="exib_dados" type="text" value="R$ '.number_format($array['valor'], 2, ',', '.').'" readonly>
                </div>
                <div class="col-md-2">
                    <label style="font-weight: bolder">Quantitativo:</label>
                    <input type="text" class="exib_dados" id="complemento" value="'.$array['complemento'].'" readonly>
                </div>
                <div class="col-md-3">
                    <label style="font-weight: bolder">Faturamento:</label><br/>
                    <input id="faturamento" class="exib_dados" type="text" value="'.$array['faturamento'].'" readonly>
                </div>
            </div>
            <br><br/>
            <div class="row">
                <div class="col-md-3">
                    <label style="font-weight: bolder">Vencimento:</label><br/>
                    <input id="vencimento" class="exib_dados" type="text" value="'.$array['vencimento'].'" readonly>
                </div>
                <div class="col-md-2">
                    <label style="font-weight: bolder">Reembolso</label>
                    <input id="reembolso" type="text" class="exib_dados" name="reembolso" value="'.$array['reembolso'].'">
                </div>
                <div class="col-md-3">
                    <label style="font-weight: bolder">Detalhes:</label><br/>
                    <input id="detalhes" class="exib_dados" type="text" value="'.$array['detalhes'].'" readonly>
                </div>
                <div class="col-md-3">
                    <label style="font-weight: bolder">Situação:</label><br/>
                    <input id="situacao" class="exib_dados" type="text" value="'.$array['situacao'].'" readonly>
                </div>
                <div class="col-md-1">
                    <label style="font-weight: bolder">Lei Kandir:</label><br/>
                    <input id="lei_kandir" class="exib_dados" type="text" value="'.$array['lei_kandir'].'" readonly>
                </div>
            </div>
            <br><br/>
            <div class="row">
                <div class="col-md-6">
                    <label style="font-weight: bolder">Início do Contrato:</label><br/>
                    <input id="inicio_contrato" class="exib_dados" type="text" value="'.date("d/m/Y", strtotime($array['inicio_contrato'])).'" readonly>
                </div>
                <div class="col-md-6">
                    <label style="font-weight: bolder">Final do Contrato</label><br/>';
                    if(!empty($array['fim_aditivo'])){
                        $contratos .='
                            <input id="fim_contrato" class="exib_dados" type="text" value="'.date("d/m/Y", strtotime($array['fim_aditivo'])).'" readonly>
                        ';
                    } else {
                        $contratos .='
                            <input id="fim_contrato" class="exib_dados" type="text" value="'.date("d/m/Y", strtotime($array['fim_contrato'])).'" readonly>
                        ';
                    }
                    $contratos .='
                </div>
            </div>
            <br><br/>
            <div class="btn btn-info" onclick="licitacaoInfo('.$array['licitacao_id'].')">Informação da Licitação</div>
            <br/><br/><br/>
            <div class="row" style="border-bottom: 1px solid lightgray; border-top: 1px solid lightgray">
                <div class="col-md-12" style="border-right: 1px solid lightgray">
                    <label style="font-weight: bolder">Histórico:</label>
                    <div id="historico">
                        <table class="table table-striped table-hover table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Título</th>
                                    <th>Data</th>
                                    <th>Horário</th>
                                    <th>Observações</th>
                                    <th>Valor</th>
                                    <th>Usuário</th>
                                    <th>Download</th>
                                    <th>Excluir</th>
                                </tr>
                            </thead>
                            <tbody id="table-hist">';
                            foreach($history as $hist){
                                $contratos .='
                                <tr>
                                    <td>'.$hist['titulo'].'</td>
                                    <td>'.$hist['data_contrato'].'</td>
                                    <td>'.$hist['horario_contrato'].'</td>
                                    <td>'.$hist['obs'].'</td>
                                    <td>R$ '.number_format($hist['valor_aditivo'],2,',','.').'</td>
                                    <td>'.$hist['user'].'</td>';
                                    if(!empty($hist['url'])){
                                        $contratos .='
                                        <td><a href="./documentos/'.$hist['url'].'" target="_blank"><i class="fas fa-paperclip"></i></a></td>
                                        ';
                                    } else {
                                        $contratos .='
                                        <td><i class="fas fa-times btn-outline-secondary"></i></td>';
                                    }
                                    $user_perm = explode(',', $user_permissions[0][0]['permission_id']);
                                    if(in_array('1', $user_perm)) {
                                        $contratos .='
                                        <td><button type="button" class="btn btn-outline-danger" onclick="delete_hist('.$hist['id'].')" style="text-align: center"><i class="fas fa-trash"></i></button></td>';
                                    } else {
                                        $contratos .='
                                        <td><button type="button" class="btn btn-outline-secondary" style="text-align: center" disabled><i class="fas fa-trash"></i></button></td>';
                                    };
                                    $contratos .='
                                </tr>
                                ';
                            }
                                $contratos .='
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br/>
        </div>
        ';

        return $contratos;
    }

    public function get_historico($id){
        $array = array();

        $sql = $this->db->prepare("SELECT hist_contratos.obs AS hist_obs, hist_contratos.id AS hist_id, hist_contratos.*, users.*, cad_arquivos.*
        FROM hist_contratos
        LEFT JOIN users ON users.id =  hist_contratos.user_id
        LEFT JOIN cad_arquivos ON cad_arquivos.histContrato_id = hist_contratos.id
        WHERE hist_contratos.contrato_id = :id ORDER BY hist_contratos.id ASC");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);

            return $array;
        } else {
            return 'Erro ao buscar dados';
        }
    }

    public function get_cod_stur(){
        $array = array();

        $sql = $this->db->prepare("SELECT cod FROM cad_contratos");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function upload_arquivo_hist($upload_arquivo, $contrato_id, $data_cadastro, $user_id){
        $licitacao_id = '';

        $sql = $this->db->prepare("SELECT id FROM hist_contratos WHERE contrato_id = $contrato_id ORDER BY id DESC limit 1");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
            $last_id = implode('', $array);
        }

        $ext = strtolower(substr($_FILES['upload_arquivo']['name'],-4)); //Pegando extensão do arquivo
        $new_name = md5(time(). rand(0,999)) . $ext; //Definindo um novo nome para o arquivo
        $dir = './documentos/'; //Diretório para uploads


        move_uploaded_file($_FILES['upload_arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

            $sql = $this->db->prepare("INSERT INTO cad_arquivos SET url = :url, histContrato_id = :hist_id, histLicitacao_id = :histLicitacao_id, data_cadastro = :data_cadastro, user_id = :user_id");
            $sql->bindValue(":url", $new_name);
            $sql->bindValue(":hist_id", $last_id);
            $sql->bindValue(":histLicitacao_id", $licitacao_id);
            $sql->bindValue(":data_cadastro", $data_cadastro);
            $sql->bindValue(":user_id", $user_id);
            $sql->execute();

    }

    public function filtrar_contratos($status, $cod_stur, $inadimplencia, $empresa, $expired, $nome_cliente, $data_de, $data_ate) {


        $users = new Users();
        $permissions = new Permissions();
        $user_permissions = $permissions->verifyPermissions($empresa);

        $user_companies = '';
        $user_perm = '';
        
        // foreach($user_permissions as $up) {
            
        //     $user_companies .= $up[0]['companies'].',';
        //     $user_perm .= $up[0]['permission_id'].',';
        // } 


        // $user_companies = substr($user_companies, 0, -1);
        // $user_perm = substr($user_perm, 0, -1);

        // $user_companies = explode(',', $user_companies); //CRIANDO O ARRAY COM AS EMPRESAS NO QUAL O USUÁRIO TEM PERMISSÃO DE ACESSAR
        // $user_perm = explode(',', $user_perm); //CRIANDO O ARRAY COM AS PERMISSÕES QUE TEM O USUÁRIO NAS EMPRESAS SELECIONADAS

        if(!empty($empresa)){
            $empresa = explode("|", $empresa);
            // $empresa = str_replace("\r\n", "", $empresa);
        }

        if(!empty($expired)){
            $expired = explode("|", $expired);
            // $expired = str_replace("\r\n", "", $expired);
        }
        
        if(!empty($status)){
            $status = explode(",", $status);
        }

        if(!empty($inadimplencia)){
            $inadimplencia = explode(",", $inadimplencia);
        }

        if(!empty($nome_cliente)){
            $nome_cliente = explode("|", $nome_cliente);
        }


        //Filtro para múltiplas entradas - Empresas
        $q2 = '(';
        $i = 0;
        if(!empty($empresa)){
            foreach($empresa as $e){
                $q2 .='
                cad_empresas.id = :empresa'.$i;
                $i++;
                if($i < count($empresa)){
                    $q2 .= ' OR ';
                }
            }
        }
        $q2 .=')';

        //Filtro para múltiplas entradas - Inadimplência
        $q3 = '(';
        $i = 0;
        if(!empty($inadimplencia)){
            foreach($inadimplencia as $e){
                $q3 .='
                cad_contratos.inadimplente = :inadimplencia'.$i;
                $i++;
                if($i < count($inadimplencia)){
                    $q3 .= ' OR ';
                }
            }
        }
        $q3 .=')';

        //Filtro para múltiplas entradas - Status
        $q4 = '(';
        $i = 0;
        if(!empty($status)){
            foreach($status as $e){
                $q4 .='
                cad_contratos.situacao = :situacao'.$i;
                $i++;
                if($i < count($status)){
                    $q4 .= ' OR ';
                }
            }
        }
        $q4 .=')';

        //Filtro para múltiplas entradas - Nome Cliente
        $q5 = '(';
        $i = 0;
        if(!empty($nome_cliente)){
            foreach($nome_cliente as $e){
                $q5 .='
                cad_contratos.nome_cliente = :nome_cliente'.$i;
                $i++;
                if($i < count($nome_cliente)){
                    $q5 .= ' OR ';
                }
            }
        }
        $q5 .=')';
        
        //Filtro para múltiplas entradas - Contratos Vencidos
        $q6 = '(';
        $i = 0;
        if(!empty($expired)){
            foreach($expired as $e){
                $q6 .='
                cad_empresas.id = :expired'.$i.' AND CASE WHEN cad_contratos.fim_aditivo IS NOT NULL 
                THEN EXTRACT(MONTH FROM fim_aditivo) = EXTRACT(MONTH FROM NOW()) AND EXTRACT(YEAR FROM fim_aditivo) = EXTRACT(YEAR FROM NOW())
                ELSE extract(month from fim_contrato) = extract(month from now()) AND extract(year from fim_contrato) = extract(year from now()) END';
                $i++;
                if($i < count($expired)){
                    $q6 .= ' OR ';
                }
            }
        }
        $q6 .=')';


        if(empty($data_de)) { $data_de = '1800-01-01'; }
        if(empty($data_ate)) { $data_ate = '5000-01-01'; }

        if(!empty($empresa)) { $empresa1 = ' AND '.$q2;
        } else {
            $empresa1 = '';
        }

        if(!empty($inadimplencia)) { $inadimplencia1 = ' AND '.$q3;
        } else {
            $inadimplencia1 = '';
        }

        if(!empty($status)) { $status1 = ' AND '.$q4;
        } else {
            $status1 = '';
        }

        if(!empty($nome_cliente)) { $nome_cliente1 = ' AND '.$q5;
        } else {
            $nome_cliente1 = '';
        }

        if(!empty($expired)) { $expired1 = ' AND '.$q6;
        } else {
            $expired1 = '';
        }

        if(!empty($cod_stur)) { $cod_stur1 = ' AND cad_contratos.cod = :cod';
        } else {
            $cod_stur1 = '';
        }
        
        $query = "SELECT cad_empresas.name AS company_name, cad_contratos.* 
                    FROM cad_contratos 
                    LEFT JOIN cad_empresas ON (cad_empresas.id = cad_contratos.empresa)
                    WHERE CASE WHEN cad_contratos.fim_aditivo IS NOT NULL THEN (cad_contratos.inicio_aditivo BETWEEN :data_de AND :data_ate AND cad_contratos.fim_aditivo BETWEEN :data_de AND :data_ate) 
                    ELSE cad_contratos.inicio_contrato BETWEEN :data_de AND :data_ate AND cad_contratos.fim_contrato BETWEEN :data_de AND :data_ate END $status1 $empresa1 $inadimplencia1 $nome_cliente1 $cod_stur1 $expired1 
                    ORDER BY cad_contratos.cod ASC";

        $sql = $this->db->prepare($query);
        $sql->bindValue(":data_de", $data_de);
        $sql->bindValue(":data_ate", $data_ate);


        if(!empty($empresa)){
            $i = 0;
            foreach($empresa as $e){
                
                $sql->bindValue(":empresa".$i, $e);
                $i++;
            }
        }

        if(!empty($inadimplencia)){
            $i = 0;
            foreach($inadimplencia as $e){
                $sql->bindValue(":inadimplencia".$i, $e);
                $i++;
            }
        }
        
        if(!empty($status)){
            $i = 0;
            foreach($status as $e){
                $sql->bindValue(":situacao".$i, $e);
                $i++;
            }
        }

        if(!empty($nome_cliente)){
            $i = 0;
            foreach($nome_cliente as $e){
                $sql->bindValue(":nome_cliente".$i, $e);
                $i++;
            }
        }

        if(!empty($expired)){
            $i = 0;
            foreach($expired as $e){
                $sql->bindValue(":expired".$i, $e);
                $i++;
            }
        }

        // (!empty($nome_cliente)) ? $sql->bindValue(":nome_cliente", $nome_cliente) : 0;
        (!empty($cod_stur)) ? $sql->bindValue(":cod", $cod_stur) : 0;
        // (!empty($inadimplencia)) ? $sql->bindValue(":inadimplencia", $inadimplencia) : 0;
        // (!empty($emissor)) ? $sql->bindValue(":emissor", $emissor) : 0;

        if($sql->execute()){
            // $sql->debugDumpParams();
            // exit;
            
            $listar_contratos = $sql->fetchAll(PDO::FETCH_ASSOC);

            $resultado = '
            <table class="table table-striped table-hover table-sm" id="table_contratos">
                <thead class="thead-dark">
                    <tr>
                        <th style="width: 10px"></th>
                        <th>Cod Stur</th>
                        <th>Nome do Cliente</th>
                        <th>Emissor</th>
                        <th>Valor:</th>
                        <th>Nº do Contrato</th>
                        <th>Empresa</th>
                        <th>Término do Contrato</th>
                        <th style="width: 18%">Ações</th>
                    </tr>
                </thead>';
                    $adtValue = 0;
                    foreach($listar_contratos as $c){
                        //REALIZAR A SOMA DOS VALORES DOS ADITIVOS CADASTRADOS
                        $sql = $this->db->prepare("SELECT * FROM hist_contratos WHERE contrato_id = :id AND valor_aditivo IS NOT NULL");
                        $sql->bindValue(":id", $c['id']);
                        $sql->execute();

                        if($sql->rowCount() > 0){
                            $value = $sql->fetchAll(PDO::FETCH_ASSOC);
                            
                            foreach($value as $v){
                                $adtValue = $adtValue + $v['valor_aditivo'];
                            }
                            
                        } else {
                            $adtValue = 0;
                        }
                        $resultado .='
                        <tbody style="font-size: 12px">';
                            if(!empty($expired)){
                                $resultado .='<tr style="border-bottom: 2px solid red;">';
                            } else {
                                $resultado .='<tr>';    
                            }
                                if(empty($c['nome_cliente'])){
                                    $resultado .='
                                    <td style="background-color: #FFDA33;"></td>';
                                }
                                if($c['inadimplente'] == 'Sim'){
                                    $resultado .='
                                    <td style="background-color: #FF3333;"></td>';
                                }
                                if($c['inadimplente'] == 'Não'){
                                    $resultado .='
                                    <td style="background-color: #0C8400;"></td>';
                                }
                                if($c['inadimplente'] == '-'){
                                    $resultado .='
                                    <td style="background-color: lightgray;"></td>';
                                }
                                if($c['inadimplente'] == '' && !empty($c['nome_cliente'])){
                                    $resultado .='
                                    <td style="background-color: lightgray;"></td>';
                                }
                                $resultado .='
                                <td>'.$c['cod'].'</td>
                                <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap" title="'.$c['nome_cliente'].'">'.$c['nome_cliente'].'</td>
                                <td>'.$c['emissor'].'</td>';
                                    if($adtValue !== 0){
                                        $resultado .='
                                        <td style="color: green">R$ '.number_format(($c['valor'] + $adtValue),2,',','.').'</td>';
                                    } else {
                                        $resultado .='
                                        <td>R$ '.number_format(($c['valor'] + $adtValue),2,',','.').'</td>';
                                    }
                                $resultado .='
                                <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap" title="'.$c['n_contrato'].'">'.$c['n_contrato'].'</td>
                                <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap" title="'.$c['company_name'].'">'.$c['company_name'].'</td>';
                                if(!empty($c['fim_aditivo'])){
                                    $resultado .='
                                        <td style="text-align: center">'.date("d/m/Y", strtotime($c['fim_aditivo'])).'</td>';
                                } else if($c['fim_contrato'] !== '5000-01-01'){
                                    $resultado .='
                                    <td style="text-align: center">'.date("d/m/Y", strtotime($c['fim_contrato'])).'</td>';
                                } else {
                                    $resultado .='
                                    <td>-</td>';
                                }
                                
                                $resultado .='
                                <td style="width: 15%">';

                                for($i=0; $i<count($user_permissions); $i++) {
                                    if($user_permissions[$i][0]['companies'] == $c['empresa']) {
                                        $user_perm = explode(',', $user_permissions[$i][0]['permission_id']);
                                        if(in_array('3', $user_perm)) {
                                            $resultado .='<button class="btn btn-outline-info btn-sm" onclick="ver_contrato('.$c['id'].')"><i class="fas fa-eye"></i></button>';
                                        } else {
                                            $resultado .='<button class="btn btn-outline-secondary btn-sm" disabled><i class="fas fa-eye"></i></button>';
                                        }
                                        if(in_array('1', $user_perm)) {
                                            $resultado .='<button class="btn btn-outline-primary btn-sm" onclick="cad_historico('.$c['id'].')"><i class="fas fa-history"></i></button>';
                                        } else {
                                            $resultado .='<button class="btn btn-outline-secondary btn-sm" disabled><i class="fas fa-history"></i></button>';
                                        }
                                        $resultado .='<button class="btn btn-outline-success btn-sm" onclick="ver_info('.$c['id'].')"><i class="fas fa-info-circle"></i></button>';
                                        if(in_array('2', $user_perm)) {
                                            $resultado .='<button class="btn btn-outline-warning btn-sm" onclick="editar_contrato('.$c['id'].')"><i class="fas fa-pen"></i></button>';
                                        } else {
                                            $resultado .='<button class="btn btn-outline-secondary btn-sm" disabled><i class="fas fa-pen"></i></button>';
                                        }
                                        $resultado .='<button class="btn btn-outline-note btn-sm" onclick="addNote('.$c['id'].')"><i class="far fa-sticky-note"></i></button>';
                                        if(in_array('4', $user_perm)) {
                                            $resultado .='<button class="btn btn-outline-danger btn-sm" onclick="excluir_contrato('.$c['id'].')"><i class="fas fa-trash"></i></button>';
                                        } else {
                                            $resultado .='<button class="btn btn-outline-secondary btn-sm" disabled><i class="fas fa-trash"></i></button>';
                                        }
                                    }
                                }
                                $resultado .='
                            </td>';
                                $resultado .='
                            </tr>
                        </tbody>
                        ';
                    }
                $resultado .='
            </table>
            ';

            return $resultado;
        } else {
            return 'Erro ao Listar';
        }

    }

    public function returnContrato($id){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM cad_contratos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function excluir_contrato($id){

        $sql = $this->db->prepare("DELETE FROM cad_contratos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        $sql = $this->db->prepare("DELETE FROM hist_contratos WHERE contrato_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function n_contratos_novos(){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM cad_contratos WHERE situacao = 'Novo'");
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->rowCount();
            return $array;
        } else {
            return '0';
        }
    }

    public function deleteHist($id){

        $sql = $this->db->prepare("DELETE FROM hist_contratos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        $sql = $this->db->prepare("DELETE FROM cad_arquivos WHERE histContrato_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function newContractCount() {
        $array = array();
        $sql = $this->db->prepare("SELECT count(*) AS qtd FROM cad_contratos WHERE situacao = 'novo'");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }

        $array = implode($array);

        return $array;
    }
    public function newContractWarning() {
        $array = array();
        $sql = $this->db->prepare("SELECT * FROM cad_contratos WHERE situacao = 'novo'");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function notepadContratos($id){
        $data = array();
        $notes = '';
        $sql = $this->db->prepare("SELECT * FROM notepad_contratos WHERE contrato_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $notes .='
            <button type="button" class="btn btn-info" onclick="addNewNote('.$id.')">Nova Nota</button><br/><hr/>
        ';
        foreach($data as $info){
            $notes .='
                <div class="notes">
                    <input type="text" name="contrato_id" value="'.$id.'" hidden>
                    <div class="title">'.$info['title'].'</div>
                    <div class="text">'.$info['text'].'</div>
                    <div class="date">'.date("d/m/Y H:i:s", strtotime($info['data_cadastro'])).'</div>
                    <img src="'.BASE_URL.'assets/images/icons/trashbin.png" onclick="deleteNote('.$info['id'].')" class="noteDelete">
                </div>
            ';
        }

        return $notes;
    }

    public function showNoteModal($id){
        $form = '
            <label>Título:</label>
            <input type="text" name="contrato_id" value="'.$id.'" hidden>
            <input type="text" class="form-control form-control-sm" name="noteTitle">
            <hr/>
            <label>Nota:</label>
            <textarea class="form-control form-control-sm" name="noteText" id="noteText"></textarea>
        ';

        return $form;
    }

    public function saveNewNote($id, $title, $text, $data_cadastro, $user_id){
        $sql = $this->db->prepare("INSERT INTO notepad_contratos SET title = :title, text = :text, contrato_id = :id, data_cadastro = :data_cadastro, user_id = :user_id");
        $sql->bindValue(":title", $title);
        $sql->bindValue(":text", $text);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();

        $notes = '';
        $sql = $this->db->prepare("SELECT * FROM notepad_contratos WHERE contrato_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $notes .='
            <button type="button" class="btn btn-info" onclick="addNewNote('.$id.')">Nova Nota</button><br/><hr/>
        ';
        foreach($data as $info){
            $notes .='
            <div class="notes">
                <input type="text" name="contrato_id" value="'.$id.'" hidden>
                <div class="title">'.$info['title'].'</div>
                <div class="text">'.$info['text'].'</div>
                <div class="date">'.date("d/m/Y H:i:s", strtotime($info['data_cadastro'])).'</div>
                <img src="'.BASE_URL.'assets/images/icons/trashbin.png" onclick="deleteNote('.$info['id'].')" class="noteDelete">
            </div>
            ';
        }

        return $notes;
    }

    public function deleteNote($id, $contrato_id) {
        $data = array();
        $sql = $this->db->prepare("DELETE FROM notepad_contratos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        $notes = '';
        $sql = $this->db->prepare("SELECT * FROM notepad_contratos WHERE contrato_id = :id");
        $sql->bindValue(":id", $contrato_id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $notes .='
            <button type="button" class="btn btn-info" onclick="addNewNote('.$contrato_id.')">Nova Nota</button><br/><hr/>
        ';
        foreach($data as $info){
            $notes .='
            <div class="notes">
                <input type="text" name="contrato_id" value="'.$contrato_id.'" hidden>
                <div class="title">'.$info['title'].'</div>
                <div class="text">'.$info['text'].'</div>
                <div class="date">'.date("d/m/Y H:i:s", strtotime($info['data_cadastro'])).'</div>
                <img src="'.BASE_URL.'assets/images/icons/trashbin.png" onclick="deleteNote('.$info['id'].')" class="noteDelete">
            </div>
            ';
        }

        return $notes;
    }

    public function infoBid($id){
        $historico = array();
        $dados = '';
        $sql = $this->db->prepare("SELECT * FROM cad_licitacao WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $info = $sql->fetch(PDO::FETCH_ASSOC);

            $sql = $this->db->prepare("SELECT cad_arquivos.url AS url, hist_licitacoes.obs AS hist_obs, users.name AS userName, hist_licitacoes.* FROM hist_licitacoes
                                    LEFT JOIN cad_arquivos ON (hist_licitacoes.id = cad_arquivos.histLicitacao_id)
                                    LEFT JOIN users ON (hist_licitacoes.user_id = users.id)
                                    WHERE licitacao_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $historico = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $dados .='
        <div class="row">
            <div class="col-sm">
                <label>Data:</label>
                <input type="text" class="exib_dados" value="'.$info['data'].'" readonly>
            </div>
            <div class="col-sm">
                <label>Hora:</label>
                <input type="text" class="exib_dados" value="'.$info['hora'].'" readonly>
            </div>
            <div class="col-sm">
                <label>Sistema:</label>
                <input type="text" class="exib_dados" value="'.$info['cad_system'].'" readonly>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-sm">
                <label>Valor:</label>
                <input type="text" class="exib_dados" value="'.$info['value'].'" readonly>
            </div>
            <div class="col-sm">
                <label>Pregão:</label>
                <input type="text" class="exib_dados" value="'.$info['auction'].'" readonly>
            </div>
            <div class="col-sm">
                <label>Complemento:</label>
                <input type="text" class="exib_dados" value="'.$info['complement'].'" readonly>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-sm">
                <label>Órgão:</label>
                <input type="text" class="exib_dados" value="'.$info['agency'].'" readonly>
            </div>
            <div class="col-sm">
                <label>Status:</label>
                <input type="text" class="exib_dados" value="'.$info['status'].'" readonly>
            </div>
            <div class="col-sm">
                <label>Modalidade:</label>
                <input type="text" class="exib_dados" value="'.$info['modalidades'].'" readonly>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-sm">
                <label>Observações:</label>
                <input type="text" class="exib_dados" value="'.$info['obs'].'">
            </div>
        </div>
        <br/><br/>
        <table class="table table-striped table-hover table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>Título</th>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Observações</th>
                    <th>Usuário</th>
                    <th>Downloads</th>
                </tr>
            </thead>
            <tbody>';
                foreach($historico as $hist){
                    if(!empty($hist['licitacao_id'])){
                        $dados .='
                        <tr>
                            <td>'.$hist['titulo'].'</td>
                            <td>'.$hist['data_licitacao'].'</td>
                            <td>'.$hist['horario_licitacao'].'</td>
                            <td>'.$hist['hist_obs'].'</td>
                            <td>'.$hist['userName'].'</td>';
                            if($hist['url'] !== null){
                                $dados .='
                                <td style="text-align: center"><a href="./documentos/'.$hist['url'].'" target="_blank"><i class="fas fa-paperclip"></i></a></td>';
                            } else {
                                $dados .='
                                <td style="text-align: center"><i class="fas fa-times btn-outline-secondary"></i></td>';
                            }
                            $dados .='
                        </tr>';
                    }
                }
            $dados .='
            </tbody>
        </table>
        ';

        return $dados;

        } else {
            echo 'Sem Dados para Exibir';
        }
    }

    public function delete_hist($id){ //$id = ID do histórico
        $users = new Users();
        
        $data = array();
        $historico = '';
        //FETCH THE LICITACAO ID
        $sql = $this->db->prepare("SELECT * FROM hist_contratos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $contrato_id = $sql->fetch(PDO::FETCH_ASSOC);
            $contrato_id = $contrato_id['contrato_id'];
        }

        //EXECUTE THE HISTORY EXCLUSION
        $sql = $this->db->prepare("DELETE FROM hist_contratos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        //EXECUTE THE ADITIVO DATA EXCLUSION
        // $sql = $this->db->prepare("UPDATE cad_contratos SET inicio_aditivo = NULL, fim_aditivo = NULL WHERE id = :id");
        // $sql->bindValue(":id", $contrato_id);
        // $sql->execute();

        //FETCH THE HISTORY AGAIN
        $sql = $this->db->prepare("SELECT users.name AS user, cad_arquivos.url AS url, hist_contratos.* FROM hist_contratos LEFT JOIN users ON (users.id = hist_contratos.user_id) LEFT JOIN cad_arquivos ON (hist_contratos.contrato_id = cad_arquivos.histContrato_id) WHERE contrato_id = :contrato_id");
        $sql->bindValue(":contrato_id", $contrato_id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $history = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach($history as $hist){
                $historico .='
                    <tr>
                        <td>'.$hist['titulo'].'</td>
                        <td>'.$hist['data_contrato'].'</td>
                        <td>'.$hist['horario_contrato'].'</td>
                        <td>'.$hist['obs'].'</td>
                        <td>'.$hist['user'].'</td>';
                        if(!empty($hist['url'])){
                            $historico .='
                            <td><a href="./documentos/'.$hist['url'].'" target="_blank"><i class="fas fa-paperclip"></i></a></td>
                            ';
                        } else {
                            $historico .='
                            <td><i class="fas fa-times btn-outline-secondary"></i></td>';
                        }
                        if($users->hasPermission('Excluir_Historicos')){
                            $historico .='
                            <td><button type="button" class="btn btn-outline-danger" onclick="delete_hist('.$hist['id'].')" style="text-align: center"><i class="fas fa-trash"></i></button></td>';
                        };
                    $historico .='
                    </tr>
                ';
            }
        }

        return $historico;
    }

    public function xlsContratos($inicio_de, $inicio_ate, $fim_de, $fim_ate, $id_cliente, $empresas, $situacao, $lei_kandir, $inad, $state, $checkCode, $checkName, $checkContrato, $checkEmissor, $checkCNPJ, $checkValue, $checkVencimento, $checkMail, $checkPhone, $checkSituacao, $checkKandir, $checkDetails, $checkAditivo, $checkSTURValue, $checkContStart, $checkContEnd, $checkProfitValue){

        $hist = '';
        if(empty($inicio_de)) { $inicio_de = '2000-01-01'; }
        if(empty($inicio_ate)) { $inicio_ate = '5000-01-01'; }
        if(empty($fim_de)) { $fim_de = '2000-01-01'; }
        if(empty($fim_ate)) { $fim_ate = '5000-01-01'; }

        if(!empty($id_cliente)) { $id_cliente1 = 'AND cad_clientes.id = :id_cliente';
        } else {
            $id_cliente1 = '';
        }
        if(!empty($situacao)) { $situacao1 = 'AND cad_contratos.situacao = :situacao';
        } else {
            $situacao1 = '';
        }
        if(!empty($empresas)) { $empresa1 = 'AND cad_contratos.empresa = :empresa';
        } else {
            $empresa1 = '';
        }
        if(!empty($lei_kandir)) { $lei_kandir1 = 'AND cad_contratos.lei_kandir = :lei_kandir';
        } else {
            $lei_kandir1 = '';
        }
        if(!empty($inad)) { $inad1 = 'AND cad_contratos.inadimplente = :inadimplente';
        } else {
            $inad1 = '';
        }
        if(!empty($state)) { $state1 = 'AND cad_clientes.state = :state';
        } else {
            $state1 = '';
        }


        $query = "SELECT CAST(cad_contratos.cod AS SIGNED) AS cod2, cad_clientes.state AS client_state, cad_clientes.phone AS client_phone, cad_clientes.email AS client_email,cad_contratos.* FROM cad_contratos
        LEFT JOIN cad_clientes ON (cad_clientes.nome_cliente = cad_contratos.nome_cliente AND cad_clientes.stur_cod = cad_contratos.cod AND cad_clientes.empresa = cad_contratos.empresa AND cad_clientes.cnpj = cad_contratos.cnpj)
        WHERE (CASE WHEN cad_contratos.fim_aditivo is not null
        THEN (cad_contratos.inicio_aditivo BETWEEN :inicio_de AND :inicio_ate) AND (cad_contratos.fim_aditivo BETWEEN :fim_de AND :fim_ate)
        ELSE (cad_contratos.inicio_contrato BETWEEN :inicio_de AND :inicio_ate) AND (cad_contratos.fim_contrato BETWEEN :fim_de AND :fim_ate) END)
        $id_cliente1 $inad1 $situacao1 $empresa1 $lei_kandir1 $state1
        ORDER BY cod2 ASC";


        $sql = $this->db->prepare($query);
        $sql->bindValue(":inicio_de", $inicio_de);
        $sql->bindValue(":inicio_ate", $inicio_ate);
        $sql->bindValue(":fim_de", $fim_de);
        $sql->bindValue(":fim_ate", $fim_ate);
        (!empty($id_cliente)) ? $sql->bindValue(":id_cliente", $id_cliente) : 0;
        (!empty($situacao)) ? $sql->bindValue(":situacao", $situacao) : 0;
        (!empty($empresas)) ? $sql->bindValue(":empresa", $empresas) : 0;
        (!empty($lei_kandir)) ? $sql->bindValue(":lei_kandir", $lei_kandir) : 0;
        (!empty($inad)) ? $sql->bindValue(":inadimplente", $inad) : 0;
        (!empty($state)) ? $sql->bindValue(":state", $state) : 0;

        if($sql->execute()){
            $dados = $sql->fetchAll(PDO::FETCH_ASSOC);
            

            ob_start();?>
            <!DOCTYPE html>
            <html lang="pt-BR">
            <head>
                <meta charset='utf-8'>
            </head>
            <body>
                <style>
                    td {
                        font-size: 10px;
                        border: 1px solid #aaa;
                        text-align: left;
                    }
                </style>
                <style>
                    th {
                        background-color: #aaa;
                        font-size: 16px;
                        border: 1px solid #aaa;
                    }
                </style>

                <table>
                    <thead>
                        <tr>
                            <?php if(!empty($checkCode)): ?>
                                <th>Cod</th>
                            <?php endif; ?>
                            <?php if(!empty($checkName)): ?>
                                <th>Nome do Cliente</th>
                            <?php endif; ?>
                            <?php if(!empty($checkContrato)): ?>
                                <th>Nº Contrato</th>
                            <?php endif; ?>
                            <?php if(!empty($checkEmissor)): ?>
                                <th>Emissor</th>
                            <?php endif; ?>
                            <?php if(!empty($checkCNPJ)): ?>
                                <th>CNPJ</th>
                            <?php endif; ?>
                            <?php if(!empty($checkValue)): ?>
                                <th>Valor Atual</th>
                            <?php endif; ?>
                            <?php if(!empty($checkVencimento)): ?>
                                <th>Vencimento</th>
                            <?php endif; ?>
                            <?php if(!empty($checkMail)): ?>
                                <th>E-mail</th>
                            <?php endif; ?>
                            <?php if(!empty($checkPhone)): ?>
                                <th>Telefone</th>
                            <?php endif; ?>
                            <?php if(!empty($checkSituacao)): ?>
                                <th>Situação</th>
                            <?php endif; ?>
                            <?php if(!empty($checkKandir)): ?>
                                <th>Lei Kandir</th>
                            <?php endif; ?>
                            <?php if(!empty($checkDetails)): ?>
                                <th>Detalhes</th>
                            <?php endif; ?>
                            <?php if(!empty($checkAditivo)): ?>
                                <th>Aditivo</th>
                            <?php endif; ?>
                            <?php if(!empty($checkContStart)): ?>
                                <th>Início do Contrato</th>
                            <?php endif; ?>
                            <?php if(!empty($checkContEnd)): ?>
                                <th>Fim do Contrato</th>
                            <?php endif; ?>
                            <?php if(!empty($checkSTURValue)): ?>
                                <th>Valor do Stur:</th>
                            <?php endif; ?>
                            <?php if(!empty($checkProfitValue)): ?>
                                <th>Lucro do Stur:</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($dados as $d): ?>
                            <tr>
                            <?php if(!empty($checkCode)): ?>
                                <td><?php echo $d['cod']; ?></td>
                            <?php endif; ?>
                            <?php if(!empty($checkName)): ?>
                                <td><?php echo $d['nome_cliente']; ?></td>
                            <?php endif; ?>
                            <?php if(!empty($checkContrato)): ?>
                                <td><?php echo $d['n_contrato']; ?></td>
                            <?php endif; ?>
                            <?php if(!empty($checkEmissor)): ?>
                                <td><?php echo $d['emissor']; ?></td>
                            <?php endif; ?>
                            <?php if(!empty($checkCNPJ)): ?>
                                <td><?php echo $d['cnpj']; ?></td>
                            <?php endif; ?>
                            <?php if(!empty($checkValue)): ?>
                                <?php 
                                    $sql = $this->db->prepare("SELECT SUM(valor_aditivo) AS vlr_cont_adt,
                                    hist_contratos.* 
                                    FROM hist_contratos 
                                    WHERE contrato_id = :id AND aditivo = 's' 
                                    AND valor_aditivo IS NOT NULL
                                    GROUP BY contrato_id");
                                    $sql->bindValue(":id", $d['id']);
                                    $sql->execute();
                                    if($sql->rowCount() > 0) {
                                        $adtData = $sql->fetch(PDO::FETCH_ASSOC);
                                        $vlr_cont_adt = $adtData['vlr_cont_adt'];
                                    } else {
                                        $vlr_cont_adt = 0;
                                    }
                                ?>
                                <td>R$ <?php echo number_format(($d['valor'] + $vlr_cont_adt),2,',','.'); ?></td>
                                <!-- <td>R$ <?php echo number_format($d['valor'],2,',','.'); ?></td> -->
                            <?php endif; ?>
                            <?php if(!empty($checkVencimento)): ?>
                                <td><?php echo $d['vencimento']; ?></td>
                            <?php endif; ?>
                            <?php if(!empty($checkMail)): ?>
                                <td><?php echo $d['client_email']; ?></td>
                            <?php endif; ?>
                            <?php if(!empty($checkPhone)): ?>
                                <td><?php echo $d['client_phone']; ?></td>
                            <?php endif; ?>
                            <?php if(!empty($checkSituacao)): ?>
                                <td><?php echo $d['situacao']; ?></td>
                            <?php endif; ?>
                            <?php if(!empty($checkKandir)): ?>
                                <td><?php echo $d['lei_kandir']; ?></td>
                            <?php endif; ?>
                            <?php if(!empty($checkDetails)): ?>
                                <td><?php echo $d['detalhes']; ?></td>
                            <?php endif; ?>
                            <?php if(!empty($checkAditivo)): ?>
                                <?php 
                                    $sql = $this->db->prepare("SELECT * FROM hist_contratos WHERE contrato_id = :id AND aditivo = 's' ORDER BY id DESC LIMIT 1");
                                    $sql->bindValue(":id", $d['id']);
                                    $sql->execute();

                                    if($sql->rowCount() > 0) {
                                        $hist = $sql->fetch(PDO::FETCH_ASSOC);
                                    }
                                ?>
                                <?php if($hist['aditivo'] == 's'): ?>
                                    <td><?php echo $hist['obs']; ?></td>
                                <?php else: ?>
                                    <td> - </td>
                                <?php endif; ?>
                            
                            <?php endif; ?>
                            <?php if(!empty($checkContStart)): ?>
                                <td><?php echo date("d/m/Y", strtotime($d['inicio_contrato'])); ?></td>
                            <?php endif; ?>
                            <?php if(!empty($checkContEnd)): ?>
                                <?php if(!empty($d['fim_aditivo'])): ?>
                                    <td><?php echo date("d/m/Y", strtotime($d['fim_aditivo'])); ?></td>
                                <?php else: ?>
                                    <td><?php echo date("d/m/Y", strtotime($d['fim_contrato'])); ?></td>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if(!empty($checkSTURValue)): ?>
                                <!-- FETCH STUR DATA -->
                                <?php 
                                    $codcli = $d['cod'];
                                    $inicioContrato = "'".$d['inicio_contrato']."'";
                                    $fimContrato = "'".$d['fim_contrato']."'";

                                    $sql = $this->db->prepare("SELECT * FROM cad_empresas WHERE id = :id");
                                    $sql->bindValue(":id", $d['empresa']);
                                    $sql->execute();
                            
                                    if($sql->rowCount() > 0) {
                                        $info = $sql->fetch(PDO::FETCH_ASSOC);
                                        
                                        $this->db_host = $info['db_host'];
                                        $this->db_name = $info['db_name'];
                                        $this->db_user = $info['db_user'];
                                        $this->db_pass = $info['db_pass'];

                                        $stur = new PDO("dblib:dbname=".$this->db_name.";host=".$this->db_host, $this->db_user, $this->db_pass); //Conexão com o banco do STUR

                                        $sql = $stur->prepare("SELECT MIN(CONVERT(char(10), ERESERVA.DTEMISSAO, 120)) AS DATAPRIMEIRACOMPRA,
                                                                MAX(CONVERT(char(10), ERESERVA.DTEMISSAO, 120)) AS DATAULTIMACOMPRA,
                                                                COUNT(EMOVIM.RESERVA) AS QUANTIDADETKT,
                                                                CAST(SUM(EMOVIM.VLRRECEBER) AS MONEY) AS TOTALVENDAS,
                                                                CAST(SUM(EMOVIM.VLRLIQUIDO) AS MONEY) AS TOTALLUCRO,
                                                                ROUND((SUM(EMOVIM.VLRLIQUIDO) / SUM(EMOVIM.VLRTARIFA) * 100), 2) AS PERCENTUALLUCRO
                                                                FROM EMOVIM
                                                                INNER JOIN ERESERVA ON (ERESERVA.RESERVA = EMOVIM.RESERVA AND ERESERVA.CODPROD = EMOVIM.CODPROD AND ERESERVA.CODFOR = EMOVIM.CODFOR AND ERESERVA.CODFOR2 = EMOVIM.CODFOR2)
                                                                WHERE ERESERVA.DTEMISSAO BETWEEN $inicioContrato AND $fimContrato AND ERESERVA.CODCLI = $codcli GROUP BY ERESERVA.CODCLI");
                                        $sql->execute();

                                        $sturData = $sql->fetch(PDO::FETCH_ASSOC);
                                    }    
                                ?>
                                <?php if(!empty($sturData['TOTALVENDAS'])): ?>
                                    <?php if($sturData['TOTALVENDAS'] > 0): ?>
                                        <td style="color: green">R$ <?php echo number_format($sturData['TOTALVENDAS'],2,',','.'); ?></td>
                                    <?php else: ?>
                                        <td style="color: red">R$ <?php echo number_format($sturData['TOTALVENDAS'],2,',','.'); ?></td>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if(!empty($sturData['TOTALLUCRO'])): ?>
                                    <?php if($sturData['TOTALLUCRO'] > 0): ?>
                                        <td style="color: green">R$ <?php echo number_format($sturData['TOTALLUCRO'],2,',','.'); ?> (<?php echo number_format($sturData['PERCENTUALLUCRO']); ?> %)</td>
                                    <?php else: ?>
                                        <td style="color: red">R$ <?php echo number_format($sturData['TOTALLUCRO'],2,',','.'); ?> (<?php echo number_format($sturData['PERCENTUALLUCRO']); ?> %)</td>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <!-- <td><?php echo $d['detalhes']; ?></td> -->
                            
                            <!-- <?php if($d['inadimplente'] == 'Sim'): ?>
                                <td style="background-color: #FA8072"><?php echo $d['inadimplente']; ?></td>
                            <?php elseif($d['inadimplente'] == 'Não'): ?>
                                <td style="background-color: lightgreen"><?php echo $d['inadimplente']; ?></td>
                            <?php endif; ?> -->
                            
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <!-- </body> -->
            <?php
            $relatorio = ob_get_contents();
            ob_end_clean();
        }

    return $relatorio;
    }

    public function searchCod($cod, $empresa) {
        $data = '';
        $sql = $this->db->prepare("SELECT id, nome_cliente, razao_social, cnpj, empresa FROM cad_clientes WHERE stur_cod = :cod AND empresa = :empresa");
        $sql->bindValue(":cod", $cod);
        $sql->bindValue(":empresa", $empresa);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);
        }

        return json_encode($data);
    }

    public function searchClient($client){
        $data = '';
        $sql = $this->db->prepare("SELECT * FROM cad_clientes WHERE nome_cliente LIKE '%$client%'");
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $client_name = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach($client_name as $client){
                if(!empty($client['nome_cliente'])){
                    $data .='<div class="clientItem" onclick="selectClientName(this)">'.$client['nome_cliente'].'</div>';
                } 
            } 
        } else {
            $data .='Sem Registro';
        }
        
        

        return $data;
    }
}