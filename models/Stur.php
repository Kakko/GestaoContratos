<?php
class Stur extends Model {

    private $db_host;
    private $db_port;
    private $db_name;
    private $db_user;
    private $db_pass;

    public function conex_stur($empresa){

        $sql = $this->db->prepare("SELECT db_name, db_host, db_port, db_user, db_pass FROM cad_empresas WHERE id = :id");
        $sql->bindValue(":id", $empresa);
        $sql->execute();

        if($sql->rowCount() > 0){
            $dados_empresa = $sql->fetch(PDO::FETCH_ASSOC);

        }

        $this->db_host = $dados_empresa['db_host'];
        $this->db_port = $dados_empresa['db_port'];
        $this->db_name = $dados_empresa['db_name'];
        $this->db_user = $dados_empresa['db_user'];
        $this->db_pass = $dados_empresa['db_pass'];
    }



    public function getClientes($empresa){

        $sql = $this->db->prepare("SELECT db_name, db_host, db_port, db_user, db_pass FROM cad_empresas WHERE id = :id");
        $sql->bindValue(":id", $empresa);
        $sql->execute();

        if($sql->rowCount() > 0){
            $dados_empresa = $sql->fetch(PDO::FETCH_ASSOC);
        }

        $db_host = $dados_empresa['db_host'];
        $db_name = $dados_empresa['db_name'];
        $db_user = $dados_empresa['db_user'];
        $db_pass = $dados_empresa['db_pass'];

        $connect = new PDO("dblib:dbname=$db_name;host=$db_host", $db_user, $db_pass);

        $sql = $connect->prepare("SELECT CODCLI, NOMCLI FROM ECLIENTE order by NOMCLI asc");
        $sql->execute();

        $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        $resultado = '
            <form method="POST" id="form_faturas_clientes">
                <div class="row">
                    <div class="col-sm-2">
                        <label>Cód Stur:</label>
                        <input type="text" value="'.$empresa.'" id="company_id" hidden>
                        <input type="number" class="form-control form-control-sm" name="stur_cod" id="stur_cod" onkeyup="searchClient()" placeholder="0">
                    </div>
                    <div class="col-sm-7">
                        <label>Selecione o Cliente:</label>
                        <select class="form-control form-control-sm" id="clientes" name="clientes_fatura">
                            <option value="">Selecione...</option>';
                            foreach($array as $a){
                                $resultado .='
                                <option value="'.$a['CODCLI'].'">'.$a['CODCLI'].' - '.utf8_encode($a['NOMCLI']).'</option>';
                            }
                                $resultado .='
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="status">Status:</label>
                        <select class="form-control form-control-sm" name="status" id="status">
                            <option value="">Selecione</option>
                            <option>Todos</option>
                            <option>Aberto</option>
                            <option>Pago</option>
                        </select>   
                    </div>  
                </div>
                <br/>
                <div class="row">
                    <div class="col-sm"></div>
                    <div class="col-sm">
                        <div class="btn btn-success" onclick="listar_dados()" style="width: 100%; height: 40px; cursor: pointer">Pesquisar</div>
                    </div>
                    <div class="col-sm"></div>
                </div>
            </form>
        ';

        return $resultado;

    }

    public function getClientSturCod($company, $stur_cod){
        $data = '';
        $sql = $this->db->prepare("SELECT db_name, db_host, db_port, db_user, db_pass FROM cad_empresas WHERE id = :id");
        $sql->bindValue(":id", $company);
        $sql->execute();

        if($sql->rowCount() > 0){
            $dados_empresa = $sql->fetch(PDO::FETCH_ASSOC);
        }

        $db_host = $dados_empresa['db_host'];
        $db_name = $dados_empresa['db_name'];
        $db_user = $dados_empresa['db_user'];
        $db_pass = $dados_empresa['db_pass'];

        $connect = new PDO("dblib:dbname=$db_name;host=$db_host", $db_user, $db_pass);

        $sql = $connect->prepare("SELECT CODCLI, NOMCLI FROM ECLIENTE WHERE CODCLI LIKE '$stur_cod%' ORDER BY CODCLI asc");
        // $sql->bindValue(":codcli", $stur_cod);
        $sql->execute();

        $clients = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach($clients as $client){
            $data .='<option value="'.$client['CODCLI'].'">'.$client['CODCLI'].' - '.utf8_encode($client['NOMCLI']).'</option>';
        }

        return $data;
    }

    
    public function getDadosClientes($clientes, $empresa, $status, $xls = 'n'){

        $this->conex_stur($empresa);
        $dados_cliente = array();
        $faturas = $this->conexao_stur($this->db_name, $this->db_host, $this->db_user, $this->db_pass);

        if($status == 'Todos'){
            $status1 = '';
        } else if($status == 'Aberto'){
            $status1 = 'AND ERECEBER.DTBAIXA IS NULL';
        } else if($status == 'Pago') {
            $status1 = 'AND ERECEBER.DTBAIXA IS NOT NULL';
        }

        $sql = $faturas->prepare("SELECT TOP 10 ERECEBER.CODCLIFOR AS CODCLIFOR, ERECEBER.NOMCLIFOR AS NOMCLIFOR, ERECEBER.FATURA, ERECEBER.DTEMISSAO, ERECEBER.DTVENCTO, ERECEBER.VALOR, ERECEBER.DTBAIXA, max(ERESERVA.CODCCUSTOCLI) AS CODCUSTO, EPRODUTO.DESCRPROD FROM ERECEBER 
        inner JOIN ERESERVA ON (ERECEBER.FATURA = ERESERVA.NUMFAT)
        inner JOIN EPRODUTO ON (EPRODUTO.CODPROD = ERESERVA.CODPROD)
        WHERE ERECEBER.CODCLIFOR = :clientes $status1 GROUP BY ERECEBER.FATURA, ERECEBER.DTEMISSAO, ERECEBER.DTVENCTO, ERECEBER.VALOR, ERECEBER.DTBAIXA, EPRODUTO.DESCRPROD, ERECEBER.CODCLIFOR, ERECEBER.NOMCLIFOR
        ORDER BY ERECEBER.FATURA");

        $sql->bindValue(":clientes", $clientes);
        $sql->execute();

        $dados_cliente = $sql->fetchAll(PDO::FETCH_ASSOC);
        if($xls == 'n'){
            $resultado = '
            <br/>
            <div style="height: 300px; overflow: auto">
                <table class="table table-striped table-hover table-sm" id="table_dados_cliente">
                    <thead class="thead-dark">
                        <tr>
                            <th style="position: sticky; top: 0">Cód. Stur</th>
                            <th style="position: sticky; top: 0">Nome Cliente</th>
                            <th style="position: sticky; top: 0">Fatura</th>
                            <th style="position: sticky; top: 0">Emissão</th>
                            <th style="position: sticky; top: 0">Vencimento</th>
                            <th style="position: sticky; top: 0">Valor</th>
                            <th style="position: sticky; top: 0">Baixa</th>
                            <th style="position: sticky; top: 0">Evento</th>
                            <th style="position: sticky; top: 0">Serviço</th>
                        </tr>
                    </thead>
                    <tbody>';
                        foreach($dados_cliente as $d){
                            $resultado .='
                            <tr>
                                <td>'.$d['CODCLIFOR'].'</td>
                                <td>'.utf8_encode($d['NOMCLIFOR']).'</td>
                                <td>'.$d['FATURA'].'</td>
                                <td>'.date("d/m/Y", strtotime($d['DTEMISSAO'])).'</td>
                                <td>'.date("d/m/Y", strtotime($d['DTVENCTO'])).'</td>
                                <td>R$ '.number_format($d['VALOR'],2,',','.').'</td>';
                                    if($status == 'Aberto'){
                                        $resultado .='
                                        <td>Em Aberto</td>';
                                    } else if($status == 'Pago') {
                                        $resultado .='
                                        <td>'.date("d/m/Y", strtotime($d['DTBAIXA'])).'</td>';
                                    } else {
                                        $resultado .='
                                        <td>';
                                            if(date("d/m/Y", strtotime($d['DTBAIXA'])) == '31/12/1969'){
                                                $resultado .='
                                                Em Aberto';
                                            } else {
                                                $resultado .='
                                                '.date("d/m/Y", strtotime($d['DTBAIXA'])).'';
                                            }
                                            $resultado .='
                                        </td>';
                                    }
                                    $resultado .='
                                <td>'.utf8_encode($d['CODCUSTO']).'</td>
                                <td>'.utf8_encode($d['DESCRPROD']).'</td>
                            </tr>
                            ';
                        }
                            $resultado .='
                    </tbody>
                </table>
            </div>
            <div style="margin-top:10px">
                <button type="submit" class="btn btn-success" style="float:right">Gerar XLS</button>
            </div>
            ';
        } else {
            ob_start(); ?>
                <meta charset='utf-8'>
                <table style="border: 1px solid black; ">
                    <tr>
                        <th style="background-color: #000; color: #fff">Cod Stur</th>
                        <th style="background-color: #000; color: #fff">Nome Cliente</th>
                        <th style="background-color: #000; color: #fff">Fatura</th>
                        <th style="background-color: #000; color: #fff">Emissão</th>
                        <th style="background-color: #000; color: #fff">Vencimento</th>
                        <th style="background-color: #000; color: #fff">Valor</th>
                        <th style="background-color: #000; color: #fff">Baixa</th>
                        <th style="background-color: #000; color: #fff">Evento</th>
                        <th style="background-color: #000; color: #fff">Serviço</th>
                    </tr>
                    <?php foreach($dados_cliente as $d): ?>
                        <tr>
                            <td style="border: 1px solid black"><?php echo $d['CODCLIFOR']; ?></td>
                            <td style="border: 1px solid black"><?php echo utf8_encode($d['NOMCLIFOR']); ?></td>
                            <td style="border: 1px solid black"><?php echo $d['FATURA']; ?></td>
                            <td style="border: 1px solid black"><?php echo date("d/m/Y", strtotime($d['DTEMISSAO'])); ?></td>
                            <td style="border: 1px solid black"><?php echo date("d/m/Y", strtotime($d['DTVENCTO'])); ?></td>
                            <td style="border: 1px solid black">R$ <?php echo number_format($d['VALOR'],2,',','.'); ?></td>
                            <?php if(empty($d['DTBAIXA'])): ?>
                                <td style="border: 1px solid black">Em Aberto</td>
                            <?php elseif(!empty($d['DTBAIXA'])): ?>
                                <td style="border: 1px solid black"><?php echo date("d/m/Y", strtotime($d['DTBAIXA'])); ?></td>
                            <?php endif; ?>
                            <td style="border: 1px solid black"><?php echo utf8_encode($d['CODCUSTO']); ?></td>
                            <td style="border: 1px solid black"><?php echo utf8_encode($d['DESCRPROD']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                        <tr>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:yellow"></td>
                            <td style="background-color:yellow; font-weight: bolder">VALOR TOTAL</td>
                            <td style="background-color:yellow; font-weight: bolder; text-align: center">=SOMA(F2:F1048576)</td>
                        </tr>
                </table>
                <?php
                    $resultado = ob_get_contents();
                    ob_end_clean();
        }
    return $resultado;
        
    }

    public function upd_inadimplente($id, $cod, $empresa){

        $verify = $this->db->prepare("SELECT * FROM cad_empresas WHERE name = :empresa");
        $verify->bindValue(":empresa", $empresa);
        $verify->execute();

        if($verify->rowCount() > 0){
            $dado = $verify->fetch(PDO::FETCH_ASSOC);
        }


        if($dado['db_name'] !== null) {
            $this->conex_stur($empresa);
  
            $faturas = $this->conexao_stur($this->db_name, $this->db_host, $this->db_user, $this->db_pass);

            $sql = $faturas->prepare("SELECT count(codclifor) AS qtd FROM ERECEBER WHERE docto like 'ft%' AND dtvencto < GETDATE() AND status = 'Aberto' AND codclifor = :cod");
            $sql->bindValue(":cod", $cod);
            $sql->execute();

            $info = $sql->fetch(PDO::FETCH_ASSOC);

            $info2 = implode(',', $info);

            if($info2 == '0'){
                $sql2 = $this->db->prepare("UPDATE cad_contratos SET inadimplente = 'Não' WHERE id = :id AND nome_cliente != '' AND nome_cliente != null");
                $sql2->bindValue(":id", $id);
                $sql2->execute();
            } else {
                $sql2 = $this->db->prepare("UPDATE cad_contratos SET inadimplente = 'Sim' WHERE id = :id AND nome_cliente != '' AND nome_cliente != null");
                $sql2->bindValue(":id", $id);
                $sql2->execute();
            }
        }
    }

    public function info_stur($id){

        $info = array();
        $info_stur = array();
        $hasCompany = array();
 
        $sql = $this->db->prepare("SELECT * FROM cad_contratos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $info = $sql->fetch(PDO::FETCH_ASSOC);
        }

        $empresa = $info['empresa'];
        $codcli = $info['cod'];
        $inicioContrato = "'".$info['inicio_contrato']."'";
        $fimContrato = "'".$info['fim_contrato']."'";

        $sql = $this->db->prepare("SELECT * FROM cad_empresas WHERE id = :id");
        $sql->bindValue(":id", $empresa);
        $sql->execute();

        $hasCompany = $sql->fetch(PDO::FETCH_ASSOC);


        if(!empty($hasCompany['db_name'])){
            
            $this->conex_stur($empresa);

            $faturas = $this->conexao_stur($this->db_name, $this->db_host, $this->db_user, $this->db_pass);

            $sql = $faturas->prepare("SELECT MIN(CONVERT(char(10), ERESERVA.DTEMISSAO, 120)) AS DATAPRIMEIRACOMPRA,
                                        MAX(CONVERT(char(10), ERESERVA.DTEMISSAO, 120)) AS DATAULTIMACOMPRA,
                                        COUNT(EMOVIM.RESERVA) AS QUANTIDADETKT,
                                        CAST(SUM(EMOVIM.VLRRECEBER) AS MONEY) AS TOTALVENDAS,
                                        CAST(SUM(EMOVIM.VLRLIQUIDO) AS MONEY) AS TOTALLUCRO,
                                        ROUND((SUM(EMOVIM.VLRLIQUIDO) / SUM(EMOVIM.VLRTARIFA) * 100), 2) AS PERCENTUALLUCRO
                                        FROM EMOVIM
                                        INNER JOIN ERESERVA ON (ERESERVA.RESERVA = EMOVIM.RESERVA AND ERESERVA.CODPROD = EMOVIM.CODPROD AND ERESERVA.CODFOR = EMOVIM.CODFOR AND ERESERVA.CODFOR2 = EMOVIM.CODFOR2)
                                        WHERE ERESERVA.DTEMISSAO BETWEEN $inicioContrato AND $fimContrato AND ERESERVA.CODCLI = $codcli GROUP BY ERESERVA.CODCLI");

            $sql->execute();

            $info_stur = $sql->fetchAll(PDO::FETCH_ASSOC);

            $retorno = '
                <table class="table table-striped table-hover table-sm" id="table_dados_cliente">
                    <thead class="thead-dark">
                        <tr>
                            <th style="position: sticky; top: 0">Primeira Compra</th>
                            <th style="position: sticky; top: 0">Última Compra</th>
                            <th style="position: sticky; top: 0">Tickets</th>
                            <th style="position: sticky; top: 0">Total Vendas</th>
                            <th style="position: sticky; top: 0">Total Lucro</th>
                            <th style="position: sticky; top: 0">% Lucro</th>
                        </tr>
                    </thead>
                    <tbody>';
                        foreach($info_stur as $info){
                            $retorno .='
                            <tr>
                                <td>'.date("d/m/Y", strtotime($info['DATAPRIMEIRACOMPRA'])).'</td>   
                                <td>'.date("d/m/Y", strtotime($info['DATAULTIMACOMPRA'])).'</td>   
                                <td>'.$info['QUANTIDADETKT'].'</td>
                                <td>R$ '.number_format($info['TOTALVENDAS'], 2,',','.').'</td>';
                                if($info['TOTALLUCRO'] > 0){
                                    $retorno .='
                                    <td style="color: green">R$ '.number_format($info['TOTALLUCRO'], 2,',','.').'</td>';   
                                } else {
                                    $retorno .='
                                    <td style="color: red">R$ '.number_format($info['TOTALLUCRO'], 2,',','.').'</td>';
                                }
                                if($info['PERCENTUALLUCRO'] > 0){
                                    $retorno .='
                                    <td style="color: green">'.number_format($info['PERCENTUALLUCRO'], 2,',','.').'</td>';   
                                } else {
                                    $retorno .='
                                    <td style="color: red">'.number_format($info['PERCENTUALLUCRO'], 2,',','.').'</td>';
                                }
                                    $retorno .='
                            </tr>';
                        }
                        $retorno .='
                    </tbody>
                </table>
            ';            
        } else {

            $retorno = '
                <table class="table table-striped table-hover table-sm" id="table_dados_cliente">
                    <thead class="thead-dark">
                        <tr>
                            <th style="position: sticky; top: 0">Primeira Compra</th>
                            <th style="position: sticky; top: 0">Última Compra</th>
                            <th style="position: sticky; top: 0">Tickets</th>
                            <th style="position: sticky; top: 0">Total Vendas</th>
                            <th style="position: sticky; top: 0">Total Lucro</th>
                            <th style="position: sticky; top: 0">% Lucro</th>
                        </tr>
                    </thead>
                </table>
                <h3>Não existem Dados para Exibição</h3>
            ';       
        }

        return $retorno;

    }
    public function report(){
        $info = array();
        $info_stur = array();
        $hasCompany = array();

        $sql = $this->db->prepare("SELECT * FROM cad_contratos");
        $sql->execute();

        if($sql->rowCount() > 0) {
            $info = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $info;
    }

    public function rel_clientes($empresa) {
        $data = array();

        $this->conex_stur($empresa);
        $stur = $this->conexao_stur($this->db_name, $this->db_host, $this->db_user, $this->db_pass);

        $sql = $stur->prepare("SELECT * FROM ETIPOCLI");
        $sql->execute();

        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
   
        $dados = '
            <div class="row">
                <div class="col-sm-5">
                    <label>CODTIPO:</label>
                    <select class="form-control form-control-sm" name="codtipo" multiple style="height: 100px">
                    <option value="pira">TODOS</option>
                    <option disabled>--------------------------------</option>';
                        foreach($data as $info){
                            $dados .='
                            <option value="'.utf8_encode($info['CODTIPO']).'">'.utf8_encode($info['CODTIPO']).' - '.utf8_encode($info['DESCRTIPO']).'</option>
                            ';  
                        };
                        $dados .='
                    </select>
                </div>
                <div class="col-sm-4">
                    <label>SITUAÇÃO:</label>
                    <select class="form-control form-control-sm" name="situacao" style="margin-top: 30px">
                        <option value="T">Ativo</option>
                        <option value="I">Inativo</option>
                    </select>
                </div>
                <input type="text" name="xls" value="n" hidden />
                <div class="col-sm-3">
                    <button type="button" class="btn btn-info" style="width: 100%; margin-top: 55px" onclick="gerar_relatorio()">Pesquisar</button>
                </div>
            </div>
        ';
        return $dados;        
    }

    public function rel_status($empresa, $codtipo, $situacao) {
        $data = array();

        $q2 = '(';
        $i = 0;
        if(!empty($codtipo)){
            foreach($codtipo as $e){
                $q2 .='
                ECLIENTE.CODTIPO = :codtipo'.$i;
                $i++;
                if($i < count($codtipo)){
                    $q2 .= ' OR ';
                }   
            }
        } 
        $q2 .=')';

        if(!empty($codtipo)) { $codtipo1 = 'AND '.$q2;
        } else {
            $codtipo1 = '';
        }

        $this->conex_stur($empresa);
        $stur = $this->conexao_stur($this->db_name, $this->db_host, $this->db_user, $this->db_pass);

        $sql = $stur->prepare("SELECT CODCLI, NOMCLI, CGCCPF, ECLIENTE.CODTIPO, SITUACAO, DESCRTIPO FROM ECLIENTE LEFT JOIN ETIPOCLI ON (ECLIENTE.CODTIPO = ETIPOCLI.CODTIPO) WHERE situacao = :situacao $codtipo1");
        $sql->bindValue(":situacao", $situacao);

        if(!empty($codtipo)){
            $i = 0;
            foreach($codtipo as $s){
                $sql->bindValue(":codtipo".$i, $s);
                $i++;
            }
        }

        $sql->execute();

        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        $tabela ='
        <div style="max-height: 300px; overflow: auto">
            <table class="table table-striped table-hover table-sm" id="table_dados_cliente">
                <thead class="thead-dark">
                    <tr>
                        <th style="position: sticky; top: 0">Código</th>
                        <th style="position: sticky; top: 0">Nome do Cliente</th>
                        <th style="position: sticky; top: 0">CNPJ / CPF</th>
                        <th style="position: sticky; top: 0">Tipo</th>
                        <th style="position: sticky; top: 0">Situação</th>
                    </tr>
                </thead>
                <tbody>';
                    foreach($data as $dado) {
                        $tabela .='
                            <tr>
                                <td>'.$dado['CODCLI'].'</td>
                                <td>'.utf8_encode($dado['NOMCLI']).'</td>
                                <td>'.$dado['CGCCPF'].'</td>
                                <td>'.utf8_encode($dado['DESCRTIPO']).'</td>
                                <td>';
                                    if($dado['SITUACAO'] == 'T'){
                                        $tabela .='
                                        Ativo';
                                    } else {
                                        $tabela .='
                                        Inativo';
                                    }
                                    $tabela .=
                                '</td>
                            </tr>
                        ';
                    };
                    $tabela .='
                </tbody>
            </table>
        </div>
        <div style="margin-top: 10px">';
            if(!empty($codtipo)){
                $tabela .='
                    <input type="text" name="codtipo" value="'.implode(',', $codtipo).'" hidden/>    
                ';
            } else {

                $tabela .='
                <input type="text" name="codtipo" value="'.$codtipo.'" hidden/>
                ';
            } 
                $tabela .='
            <input type="text" name="situacao" value="'.$situacao.'" hidden/>
            <input type="submit" class="btn btn-success float-right" value="Gerar XLS" />
        </div>
        ';

        return $tabela;
    }
    
    public function rel_status_xls($empresa, $codtipo, $situacao) {
        $data = array();

        $q2 = '(';
        $i = 0;
        if(!empty($codtipo)){
            foreach($codtipo as $e){
                $q2 .='
                ECLIENTE.CODTIPO = :codtipo'.$i;
                $i++;
                if($i < count($codtipo)){
                    $q2 .= ' OR ';
                }   
            }
        }
        $q2 .=')';

        if(!empty($codtipo)) { $codtipo1 = 'AND '.$q2;
        } else {
            $codtipo1 = '';
        }

        $this->conex_stur($empresa);
        $stur = $this->conexao_stur($this->db_name, $this->db_host, $this->db_user, $this->db_pass);

        $sql = $stur->prepare("SELECT CODCLI, NOMCLI, CGCCPF, ECLIENTE.CODTIPO, SITUACAO, DESCRTIPO FROM ECLIENTE LEFT JOIN ETIPOCLI ON (ECLIENTE.CODTIPO = ETIPOCLI.CODTIPO) WHERE situacao = :situacao $codtipo1");
        $sql->bindValue(":situacao", $situacao);

        if(!empty($codtipo)){
            $i = 0;
            foreach($codtipo as $s){
                $sql->bindValue(":codtipo".$i, $s);
                $i++;
            }
        }

        $sql->execute();

        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        ob_start(); ?>
        <table>
            <thead>
                <tr>
                    <th style="border: 1px solid black; background-color: #aaa">Código</th>
                    <th style="border: 1px solid black; background-color: #aaa">Nome do Cliente</th>
                    <th style="border: 1px solid black; background-color: #aaa">CNPJ / CPF</th>
                    <th style="border: 1px solid black; background-color: #aaa">Tipo</th>
                    <th style="border: 1px solid black; background-color: #aaa">Situação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $dado): ?>
                    <tr>
                        <td style="border: 1px solid black"><?php echo $dado['CODCLI']; ?></td>
                        <td style="border: 1px solid black"><?php echo utf8_encode($dado['NOMCLI']); ?></td>
                        <td style="border: 1px solid black"><?php echo $dado['CGCCPF']; ?></td>
                        <td style="border: 1px solid black"><?php echo utf8_encode($dado['DESCRTIPO']); ?></td>
                        <td style="border: 1px solid black"><?php if($dado['SITUACAO'] == 'T'){
                                echo 'Ativo';
                            } else {
                                echo 'Inativo';
                            }; ?> 
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
        $tabela = ob_get_contents();
        ob_end_clean();
        
        return $tabela;
    }

    public function imported_client_number()  {
        $sql = $this->db->prepare("SELECT COUNT(*) AS count FROM stur_client_import");
        $sql->execute();

        if($sql->rowCount() > 0) {
            $count = $sql->fetch(PDO::FETCH_ASSOC);

            return $count['count'];
        } else {
            return '0';
        }
    }

    public function import_client_stur() {
        $data = '';

        $sql = $this->db->prepare("SELECT * FROM cad_empresas WHERE db_name IS NOT NULL");
        $sql->execute();

        if($sql->rowCount() > 0) {
            $companies = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach($companies as $company){

                
                $dbname = $company['db_name'];
                $dbhost = $company['db_host'];
                $dbuser = $company['db_user'];
                $dbpass = $company['db_pass'];

                $stur = new PDO("dblib:dbname=".$dbname.";host=".$dbhost, $dbuser, $dbpass); //CONEXÃO COM O STUR

                $sql = $this->db->prepare("SELECT * FROM stur_client_import WHERE company_id = :company_id ORDER BY id DESC LIMIT 1"); //BUSCA O ÚLTIMO CLIENTE IMPORTADO ANTERIORMENTE EM CADA EMPRESA
                $sql->bindValue(":company_id", $company['id']);
                $sql->execute();

                if($sql->rowCount() > 0){
                    $hasImported = $sql->fetch(PDO::FETCH_ASSOC);

                    $sql = $stur->prepare("SELECT * FROM ECLIENTE WHERE CODCLI > :codcli AND CODCLI != '99991' AND CODCLI != '99980' ORDER BY CODCLI"); // PEGAR O ÚLTIMO REGISTRO DE CLIENTE CADASTRADO
                    $sql->bindValue(":codcli", $hasImported['codcli']);
                    $sql->execute();

                    $sturClientData = $sql->fetchAll(PDO::FETCH_ASSOC);

                    foreach($sturClientData as $stur){
                        $sql = $this->db->prepare("INSERT INTO stur_client_import SET codcli = :codcli, company_id = :company_id, reg_date = now()");
                        $sql->bindValue(":codcli", $stur['CODCLI']);
                        $sql->bindValue(":company_id", $company['id']);
                        $sql->execute();
                    }
                } else {

                    $sql = $stur->prepare("SELECT TOP 1 * FROM ECLIENTE WHERE CODCLI != '99991' AND CODCLI != '99980' ORDER BY CODCLI DESC"); // PEGAR O ÚLTIMO REGISTRO DE CLIENTE CADASTRADO
                    $sql->execute();

                    $sturClientData = $sql->fetchAll(PDO::FETCH_ASSOC);

                    foreach($sturClientData as $stur){
                        $sql = $this->db->prepare("INSERT INTO stur_client_import SET codcli = :codcli, company_id = :company_id, reg_date = now()");
                        $sql->bindValue(":codcli", $stur['CODCLI']);
                        $sql->bindValue(":company_id", $company['id']);
                        $sql->execute();
                    }
                }
            }
        }
        
        $sql = $this->db->prepare("SELECT * FROM stur_client_import WHERE inserted IS NULL");
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sturClients = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            $data .='
                <table>
                    <tr>
                        <th style="width: 5%">Cód STUR:</th>
                        <th style="width: 15%">Nome:</th>
                        <th style="width: 15%">Razão Social:</th>
                        <th>Endereço:</th>
                        <th>Cidade:</th>
                        <th>E-mail:</th>
                        <th>Empresa:</th>
                        <th>Ações:</th>
                    </tr>
            ';

            foreach($sturClients as $client){
                
                $sql = $this->db->prepare("SELECT * FROM cad_empresas WHERE id = :id");
                $sql->bindValue(":id", $client['company_id']);
                $sql->execute();

                if($sql->rowCount() > 0) {
                    $companyData = $sql->fetch(PDO::FETCH_ASSOC);

                    $dbname = $companyData['db_name'];
                    $dbhost = $companyData['db_host'];
                    $dbuser = $companyData['db_user'];
                    $dbpass = $companyData['db_pass'];
            
                    $stur = new PDO("dblib:dbname=".$dbname.";host=".$dbhost, $dbuser, $dbpass); //CONEXÃO COM O STUR
            
                    $sql = $stur->prepare("SELECT ECIDADE.DESCRCID AS CIDADE, ECIDADE.SIGLAESTADO AS UF, * FROM ECLIENTE 
                                            LEFT JOIN ECIDADE ON (ECIDADE.SIGLACID = ECLIENTE.SIGLACID)
                                            WHERE CODCLI = :codcli AND CODCLI != '99991' and CODCLI != '99980'");
                    $sql->bindValue(":codcli", $client['codcli']);
                    $sql->execute();

                    $sturdata = $sql->fetchAll(PDO::FETCH_ASSOC);
                    if(!empty($sturdata)){
                        foreach($sturdata as $stur){

                            $data .='
                                <tr>
                                    <td>'.utf8_encode($stur['CODCLI']).'</td>
                                    <td>'.utf8_encode($stur['NOMCLI']).'</td>
                                    <td>'.utf8_encode($stur['RAZAOSOC']).'</td>
                                    <td>'.utf8_encode($stur['ENDERECO']).'</td>
                                    <td>'.utf8_encode($stur['CIDADE']).'</td>
                                    <td>'.$stur['EMAIL'].'</td>
                                    <td>'.$companyData['name'].'</td>
                                    <td id="company_id_'.$stur['CODCLI'].'" hidden>'.$companyData['id'].'</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" onclick="edit_import('.$stur['CODCLI'].')"><i class="fas fa-pen"></i></button>
                                        <button class="btn btn-sm btn-danger" onclick="remove_import('.$stur['CODCLI'].')"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            ';
                        }
                    } 
                }
            }
            $data .='</table>';
        }
        return $data;
    }

    public function verifyImport($id, $company_id) {

        $data = '';
        
        $sql = $this->db->prepare("SELECT * FROM stur_client_import WHERE inserted IS NULL AND codcli = :codcli AND company_id = :company_id");
        $sql->bindValue(":codcli", $id);
        $sql->bindValue(":company_id", $company_id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sturClients = $sql->fetch(PDO::FETCH_ASSOC);

            $sql = $sql = $this->db->prepare("SELECT * FROM cad_empresas WHERE id = :id");
                $sql->bindValue(":id", $sturClients['company_id']);
                $sql->execute();

                if($sql->rowCount() > 0) {
                    $companyData = $sql->fetch(PDO::FETCH_ASSOC);

                    $dbname = $companyData['db_name'];
                    $dbhost = $companyData['db_host'];
                    $dbuser = $companyData['db_user'];
                    $dbpass = $companyData['db_pass'];
            
                    $stur = new PDO("dblib:dbname=".$dbname.";host=".$dbhost, $dbuser, $dbpass); //CONEXÃO COM O STUR
            
                    $sql = $stur->prepare("SELECT ECIDADE.DESCRCID AS CIDADE, ECIDADE.SIGLAESTADO AS UF, * FROM ECLIENTE 
                                            LEFT JOIN ECIDADE ON (ECIDADE.SIGLACID = ECLIENTE.SIGLACID)
                                            WHERE CODCLI >= :codcli AND CODCLI != '99991' and CODCLI != '99980'");
                    $sql->bindValue(":codcli", $sturClients['codcli']);
                    $sql->execute();

                    $sturdata = $sql->fetch(PDO::FETCH_ASSOC);

                    //COMPARAÇÃO CIDADES
                    $sql = $this->db->prepare("SELECT cidades.id AS cidade_id, cidades.* FROM cidades 
                                                LEFT JOIN estados ON (cidades.estado_id = estados.id)
                                                WHERE cidade = :cidade");
                    $sql->bindValue(":cidade", utf8_encode($sturdata['CIDADE']));
                    $sql->execute();

                    if($sql->rowCount() > 0) {
                        $cidade = $sql->fetch(PDO::FETCH_ASSOC);
                    } else {
                        $cidade['cidade'] = '';
                    }

                    //COMPARAÇÃO ESTADOS
                    $sql = $this->db->prepare("SELECT * FROM estados WHERE uf = :uf");
                    $sql->bindValue(":uf", $sturdata['UF']);
                    $sql->execute();

                    if($sql->rowCount() > 0) {
                        $estado = $sql->fetch(PDO::FETCH_ASSOC);
                        
                    }

                    //COMBO CIDADES - GERAL
                    $sql = $this->db->prepare("SELECT * FROM cidades ORDER BY cidade");
                    $sql->execute();

                    if($sql->rowCount() > 0) {
                        $cidades = $sql->fetchAll(PDO::FETCH_ASSOC);
                    }

                    //COMBO ESTADOS - GERAL
                    $sql = $this->db->prepare("SELECT * FROM estados ORDER BY estado");
                    $sql->execute();

                    if($sql->rowCount() > 0) {
                        $estados = $sql->fetchAll(PDO::FETCH_ASSOC);
                    }
                    // print_r(mb_strtolower(utf8_encode($sturdata['CIDADE'])).' ------- '.mb_strtolower($cidade['cidade']));
                    // exit;
                    $data .='
                        <form method="post" id="stur_form">
                            <div style="display: flex; width: 100%; justify-content: space-between; flex-wrap: wrap">
                                <div style="width: 30%; height: 80px; padding-left: 10px; ">
                                    <label style="font-weight: bold">Cód. Stur</label><br/>
                                    <input id="cod_stur" type="text" style="width: 90%; height: 30px; border: 1px solid #CCC; border-radius: 5px; padding-left: 10px" value="'.$sturdata['CODCLI'].'">
                                </div>
                                <div style="width: 30%; height: 80px; padding-left: 10px;">
                                    <label style="font-weight: bold">Nome Cliente:</label><br/>
                                    <input id="name" type="text" style="width: 90%; height: 30px; border: 1px solid #CCC; border-radius: 5px; padding-left: 10px" value="'.utf8_encode($sturdata['NOMCLI']).'">
                                </div>
                                <div style="width: 30%; height: 80px; padding-left: 10px;">
                                    <label style="font-weight: bold">Razão Social</label><br/>
                                    <input id="razao_social" type="text" style="width: 90%; height: 30px; border: 1px solid #CCC; border-radius: 5px; padding-left: 10px" value="'.utf8_encode($sturdata['RAZAOSOC']).'">
                                </div>
                                <div style="width: 30%; height: 80px; padding-left: 10px;">
                                    <label style="font-weight: bold">CPF / CNPJ</label><br/>
                                    <input id="cpf_cnpj" type="text" style="width: 90%; height: 30px; border: 1px solid #CCC; border-radius: 5px; padding-left: 10px" value="'.$sturdata['CGCCPF'].'">
                                </div>
                                <div style="width: 30%; height: 80px; padding-left: 10px;">
                                    <label style="font-weight: bold">Endereço</label><br/>
                                    <input id="endereco" type="text" style="width: 90%; height: 30px; border: 1px solid #CCC; border-radius: 5px; padding-left: 10px" value="'.utf8_encode($sturdata['ENDERECO']).'">
                                </div>
                                <div style="width: 30%; height: 80px; padding-left: 10px;">
                                    <label style="font-weight: bold">Bairro</label><br/>
                                    <input id="bairro" type="text" style="width: 90%; height: 30px; border: 1px solid #CCC; border-radius: 5px; padding-left: 10px" value="'.utf8_encode($sturdata['BAIRRO']).'">
                                </div>
                                <div style="width: 30%; height: 80px; padding-left: 10px;">
                                    <label style="font-weight: bold">CEP</label><br/>
                                    <input id="cep" type="text" style="width: 90%; height: 30px; border: 1px solid #CCC; border-radius: 5px; padding-left: 10px" value="'.$sturdata['CEP'].'">
                                </div>
                                <div style="width: 30%; height: 80px; padding-left: 10px;">
                                    <label style="font-weight: bold">Telefone</label><br/>
                                    <input id="phone" type="text" style="width: 90%; height: 30px; border: 1px solid #CCC; border-radius: 5px; padding-left: 10px" value="'.$sturdata['FONES'].'">
                                </div>
                                <div style="width: 30%; height: 80px; padding-left: 10px;">
                                    <label style="font-weight: bold">Email</label><br/>
                                    <input id="email" type="text" style="width: 90%; height: 30px; border: 1px solid #CCC; border-radius: 5px; padding-left: 10px" value="'.$sturdata['EMAIL'].'">
                                </div>
                                <div style="width: 30%; height: 80px; padding-left: 10px;">
                                    <label style="font-weight: bold">Cidade</label><br/>
                                    <select id="cidade" style="width: 90%; height: 30px; border: 1px solid #CCC; border-radius: 5px; padding-left: 10px">';
                                    if(mb_strtolower(utf8_encode($sturdata['CIDADE'])) == mb_strtolower($cidade['cidade'])){
                                        $data .='<option value="'.$cidade['cidade_id'].'">'.utf8_encode($sturdata['CIDADE']).'</option>';
                                    } else {
                                        $data .='<option>Selecione a cidade correta</option>';
                                    }
                                        $data .='
                                        <option disabled> --------------- </option>';
                                        foreach($cidades as $cidade) {
                                            $data.='<option value="'.$cidade['id'].'">'.$cidade['cidade'].'</option>';
                                        };
                                        $data .='
                                    </select>
                                </div>
                                <div style="width: 30%; height: 80px; padding-left: 10px;">
                                    <label style="font-weight: bold">Estado</label><br/>
                                    <select id="estado" style="width: 90%; height: 30px; border: 1px solid #CCC; border-radius: 5px; padding-left: 10px">

                                        <option value="'.$estado['id'].'">'.$sturdata['UF'].'</option>
                                        <option disabled> --------------- </option>';
                                        foreach($estados as $estado) {
                                            $data.='<option value="'.$estado['id'].'">'.$estado['estado'].' / '.$estado['uf'].'</option>';
                                        };
                                        $data .='
                                    </select>
                                </div>
                                <div style="width: 30%; height: 80px; padding-left: 10px;">
                                    <label style="font-weight: bold">Empresa</label><br/>
                                    <input id="empresa_id" type="text" style="width: 90%; height: 30px; border: 1px solid #CCC; border-radius: 5px; padding-left: 10px" value="'.$companyData['id'].'" hidden>
                                    <input type="text" style="width: 90%; height: 30px; border: 1px solid #CCC; border-radius: 5px; padding-left: 10px" value="'.$companyData['name'].'" readonly>
                                </div>
                            </div>
                        </form>
                    ';
                }

        }
        return $data;
    }

    public function insertSturClient($cod_stur, $name, $razao_social, $cpf_cnpj, $endereco, $bairro, $cep, $phone, $email, $cidade_id, $estado_id, $empresa_id) {
        
        $sql = $this->db->prepare("SELECT * FROM cad_clientes WHERE stur_cod = :stur_cod AND empresa = :empresa");
        $sql->bindValue(":stur_cod", $cod_stur);
        $sql->bindValue(":empresa", $empresa_id);
        $sql->execute();

        if($sql->rowCount() == 0) {
            $sql = $this->db->prepare("INSERT INTO cad_clientes SET stur_cod = :stur_cod, nome_cliente = :nome_cliente, razao_social = :razao_social, cnpj = :cnpj, address = :address, neighbour = :neighbour, state = :state, city = :city, cep = :cep, phone = :phone, email = :email, empresa = :empresa, from_stur = 'S', data_cadastro = now(), user_id = :user_id");

            $sql->bindValue(":stur_cod", $cod_stur);
            $sql->bindValue(":nome_cliente", $name);
            $sql->bindValue(":razao_social", $razao_social);
            $sql->bindValue(":cnpj", $cpf_cnpj);
            $sql->bindValue(":address", $endereco);
            $sql->bindValue(":neighbour", $bairro);
            $sql->bindValue(":state", $estado_id);
            $sql->bindValue(":city", $cidade_id);
            $sql->bindValue(":cep", $cep);
            $sql->bindValue(":phone", $phone);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":empresa", $empresa_id);
            $sql->bindValue(":user_id", $_SESSION['lgUser']);

            if($sql->execute()){
                $sql = $this->db->prepare("UPDATE stur_client_import SET inserted = 'S', user_id = :user_id WHERE codcli = :codcli AND company_id = :company_id");
                $sql->bindValue(":codcli", $cod_stur);
                $sql->bindValue(":company_id", $empresa_id);
                $sql->bindValue(":user_id", $_SESSION['lgUser']);
                $sql->execute();
            }

            return 'Cliente importado com sucesso para a base do sistema';

        } else {

            $sql = $this->db->prepare("UPDATE stur_client_import SET inserted = 'N', user_id = :user_id WHERE codcli = :codcli AND company_id = :company_id");
            $sql->bindValue(":codcli", $cod_stur);
            $sql->bindValue(":company_id", $empresa_id);
            $sql->bindValue(":user_id", $_SESSION['lgUser']);
            $sql->execute();

            return 'Cliente não cadastrado. Já existente na base do sistema';
        }
    }

    public function removeImport($id, $company_id) {
        $sql = $this->db->prepare("UPDATE stur_client_import SET inserted = 'N', user_id = :user_id WHERE codcli = :codcli AND company_id = :company_id");
        $sql->bindValue(":user_id", $_SESSION['lgUser']);
        $sql->bindValue(":codcli", $id);
        $sql->bindValue(":company_id", $company_id);
        $sql->execute();
    }
    

    
}