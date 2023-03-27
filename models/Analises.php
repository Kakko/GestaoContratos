<?php
class Analises extends Model {

    public function info_stur($inicioContratode, $fimContratode, $inicioAditivode, $fimAditivode, $inicioContratoate, $fimContratoate, $inicioAditivoate, $fimAditivoate, $empresa){

        //BUSCAR DADOS DA EMPRESA PARA CONEXÃO AO STUR
        $sql = $this->db->prepare("SELECT db_name, db_host, db_port, db_user, db_pass FROM cad_empresas WHERE id = :empresa");
        $sql->bindValue(":empresa", $empresa);
        $sql->execute();

        if($sql->rowCount() > 0){
            $dados_empresa = $sql->fetch(PDO::FETCH_ASSOC);
        }
        $db_name = $dados_empresa['db_name'];
        $db_user = $dados_empresa['db_user'];
        $db_pass = $dados_empresa['db_pass'];
        $db_host = $dados_empresa['db_host'];
        //FINAL DA BUSCA DE DADOS PARA CONEXÃO AO STUR


        $info = array();
        $info_stur = array();
        $hasCompany = array();
        
        //VALORES DO BANCO DO SISTEMA DE GESTÃO DE CONTRATOS
        if(empty($inicioAditivode) && empty($inicioAditivoate) && empty($fimAditivode) && empty($fimAditivoate)){

            $sql = $this->db->prepare("SELECT * FROM cad_contratos WHERE inicio_contrato BETWEEN :inicioContratode AND :inicioContratoate AND fim_contrato BETWEEN :fimContratode AND :fimContratoate AND empresa = :empresa AND cod != ''");
            $sql->bindValue(":inicioContratode", $inicioContratode);
            $sql->bindValue(":inicioContratoate", $inicioContratoate);
            $sql->bindValue(":fimContratode", $fimContratode);
            $sql->bindValue(":fimContratoate", $fimContratoate);
            $sql->bindValue(":empresa", $empresa);
            $sql->execute();
    
            if($sql->rowCount() > 0){
                $info = $sql->fetchAll(PDO::FETCH_ASSOC);
            }

        } else if(empty($inicioContratode) && empty($inicioContratoate) && empty($fimContratode) && empty($fimContratoate)){
            $sql = $this->db->prepare("SELECT * FROM cad_contratos WHERE inicio_contrato BETWEEN :inicioAditivode AND :inicioAditivoate AND fim_contrato BETWEEN :fimAditivode AND :fimAditivoate AND empresa = :empresa AND cod != ''");
            $sql->bindValue(":inicioAditivode", $inicioAditivode);
            $sql->bindValue(":inicioAditivoate", $inicioAditivoate);
            $sql->bindValue(":fimAditivode", $fimAditivode);
            $sql->bindValue(":fimAditivoate", $fimAditivoate);
            $sql->bindValue(":empresa", $empresa);
            $sql->execute();
    
            if($sql->rowCount() > 0){
                $info = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } else if(empty($inicioContratode) && empty($inicioContratoate) && empty($fimContratode) && empty($fimContratoate) && empty($inicioAditivode) && empty($inicioAditivoate) && empty($fimAditivode) && empty($fimAditivoate)){
            $sql = $this->db->prepare("SELECT * FROM cad_contratos WHERE empresa = :empresa AND cod != ''");
            $sql->bindValue(":empresa", $empresa);
            $sql->execute();
    
            if($sql->rowCount() > 0){
                $info = $sql->fetchAll(PDO::FETCH_ASSOC);
            } 
        }


        //CÁLCULO DA DIFERENÇA DE MESES ENTRE DATAS
        $sql = $this->db->prepare("SELECT timestampdiff(MONTH, inicio_contrato, fim_contrato) AS diff_month FROM cad_contratos WHERE empresa = :empresa AND cod != ''");
        $sql->bindValue(":empresa", $empresa);
        $sql->execute();

        if($sql->rowCount() > 0){
            $diff = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        //CÁLCULO DA DIFERENÇA DE MESES DO INÍCIO DO CONTRATO PARA A DATA ATUAL
        $sql = $this->db->prepare("SELECT timestampdiff(MONTH, inicio_contrato, now()) AS diff_actual FROM cad_contratos WHERE empresa = :empresa AND cod != ''");
        $sql->bindValue(":empresa", $empresa);
        $sql->execute();

        if($sql->rowCount() > 0){
            $actual = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $retorno = '
            <table class="table table-striped table-hover table-sm" id="table_analise" style="font-size: 12px; width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th style="position: sticky; top: 0; color: black; background-color: lightblue">Nome Cliente</th>
                        <th style="position: sticky; top: 0; color: black; background-color: lightblue">STUR</th>
                        <th style="position: sticky; top: 0; color: black; background-color: lightblue">Valor Contrato</th>
                        <th style="position: sticky; top: 0; color: black; background-color: lightblue">Vigência Início</th>
                        <th style="position: sticky; top: 0; color: black; background-color: lightblue">Vigência Fim</th>
                        <th style="position: sticky; top: 0; color: black; background-color: lightblue">Tempo de Contrato</th>
                        <th style="position: sticky; top: 0; color: black; background-color: lightblue">Média / Mês</th>
                        <th style="position: sticky; top: 0; color: black; background-color: #f8f8c2">Primeira Compra</th>
                        <th style="position: sticky; top: 0; color: black; background-color: #f8f8c2">Última Compra</th>
                        <th style="position: sticky; top: 0; color: black; background-color: #f8f8c2">Total Vendas</th>
                        <th style="position: sticky; top: 0; color: black; background-color: #f8f8c2">Total Lucro</th>
                        <th style="position: sticky; top: 0; color: black; background-color: #f8f8c2">% Lucro</th>
                        <th style="position: sticky; top: 0; color: black; background-color: lightgreen">% Compra</th>
                        <th style="position: sticky; top: 0; color: black; background-color: lightgreen">Tempo de Contrato Restante (Mês)</th>
                        <th style="position: sticky; top: 0; color: black; background-color: lightgreen">Tempo de Contrato Restante (%)</th>
                        <th style="position: sticky; top: 0; color: black; background-color: lightgreen">Tot. Compra Média Ideal</th>
                        <th style="position: sticky; top: 0; color: black; background-color: lightgreen">% Compra Atrasada</th>
                        <th style="position: sticky; top: 0; color: black; background-color: gold">Receita Líquida</th>
                    </tr>
                </thead>
                <tbody>';

                for($i=0; $i < count($info); $i++){
                    
                    //VARIÁVEIS QUERY COM O STUR
                    $empresa = $info[$i]['empresa'];
                    $codcli = $info[$i]['cod'];
                    $inicioContrato = "'".$info[$i]['inicio_contrato']."'";
                    $fimContrato = "'".$info[$i]['fim_contrato']."'";
                    
                    $stur = $this->conexao_stur($db_name, $db_host, $db_user, $db_pass);
                    
                    $sql = $stur->prepare("SELECT MIN(CONVERT(char(10), ERESERVA.DTEMISSAO, 120)) AS DATAPRIMEIRACOMPRA,
                    MAX(CONVERT(char(10), ERESERVA.DTEMISSAO, 120)) AS DATAULTIMACOMPRA,
                    CAST(SUM(EMOVIM.VLRRECEBER) AS MONEY) AS TOTALVENDAS,
                    CAST(SUM(EMOVIM.VLRLIQUIDO) AS MONEY) AS TOTALLUCRO,
                    ROUND((SUM(EMOVIM.VLRLIQUIDO) / SUM(EMOVIM.VLRTARIFA) * 100), 2) AS PERCENTUALLUCRO
                    FROM EMOVIM
                    INNER JOIN ERESERVA ON (ERESERVA.RESERVA = EMOVIM.RESERVA AND ERESERVA.CODPROD = EMOVIM.CODPROD AND ERESERVA.CODFOR = EMOVIM.CODFOR AND ERESERVA.CODFOR2 = EMOVIM.CODFOR2)
                    WHERE ERESERVA.DTEMISSAO BETWEEN $inicioContrato AND $fimContrato AND ERESERVA.CODCLI = $codcli GROUP BY ERESERVA.CODCLI");

                    $sql->execute();

                    $info_stur = $sql->fetch(PDO::FETCH_ASSOC);
                    
                    //VARIÁVEIS PLANILHA - CONTRATOS
                    $nome_cliente = $info[$i]['nome_cliente'];
                    $cod_stur = $info[$i]['cod'];
                    $valor = $info[$i]['valor'];
                    $inicio_contrato = $info[$i]['inicio_contrato'];
                    $fim_contrato = $info[$i]['fim_contrato'];
                    $tempo_contrato = $diff[$i]['diff_month'];
                    
                    if($valor != 0.00 && $tempo_contrato != 0) {
                        $media_mes = $info[$i]['valor'] / $diff[$i]['diff_month'];
                    } else {
                        $media_mes = '0.00';
                    }

                    if(!empty($info_stur)) {
                        //VARIÁVEIS VINDAS DO STUR
                        $primeira_compra = $info_stur['DATAPRIMEIRACOMPRA'];
                        $ultima_compra = $info_stur['DATAULTIMACOMPRA'];
                        $total_vendas = $info_stur['TOTALVENDAS'];
                        $receita_liquida = $info_stur['TOTALLUCRO'];
                        $margem = $info_stur['PERCENTUALLUCRO'];
                    } else {
                        //VARIÁVEIS VINDAS DO STUR
                        $primeira_compra = ' - ';
                        $ultima_compra = ' - ';
                        $total_vendas = ' - ';
                        $receita_liquida = ' - ';
                        $margem = ' - ';
                    }

                    //VARIÁVEIS EXTRAS
                    $contrato_restante = $actual[$i]['diff_actual'];

                    $retorno .='
                        <tr>
                            <td>'.$nome_cliente.'</td>
                            <td>'.$cod_stur.'</td>
                            <td>R$ '.number_format($valor, 2, ',', '.').'</td>
                            <td>'.date("d/m/Y", strtotime($inicio_contrato)).'</td>
                            <td>'.date("d/m/Y", strtotime($fim_contrato)).'</td>
                            <td>'.$tempo_contrato.' meses</td>
                            <td>R$ '.number_format($media_mes, 2, ',', '.').'</td>

                            <td>'.date("d/m/Y", strtotime($primeira_compra)).'</td>   
                            <td>'.date("d/m/Y", strtotime($ultima_compra)).'</td>';
                            if(!empty($info_stur)) {
                                $retorno .='
                                <td>R$ '.number_format($total_vendas, 2, ',', '.').'</td>
                                <td>R$ '.number_format($receita_liquida, 2, ',', '.').'</td>
                                <td>'.number_format($margem, 2, ',', '.').' %</td>';
                            } else {
                                $retorno .='
                                <td>'.$total_vendas.'</td>
                                <td>'.$receita_liquida.'</td>
                                <td>'.$receita_liquida.'</td>';
                            }   

                            if($valor != 0.00 && !empty($info_stur)) {
                                $retorno .= '
                                <td>'.number_format(($total_vendas / $valor) * 100, 2, ',', '.').'%</td>';
                            } else {
                                $retorno .= '
                                <td>0.00</td>';
                            }
                                $retorno .= '

                            <td>'.$contrato_restante.' meses</td>';

                            if($tempo_contrato != 0 && $valor != 0 && !empty($info_stur)) {
                                $retorno .= '
                                <td>'.round(($contrato_restante / $tempo_contrato) * 100, 2).'%</td>';
                            } else {
                                $retorno .= '
                                <td>0.00</td>';
                            }

                            if($tempo_contrato != 0 && $valor != 0 && !empty($info_stur)) {
                                $retorno .= '
                                <td>R$ '.number_format($media_mes * $contrato_restante, 2,',','.').'</td>';
                            } else {
                                $retorno .= '
                                <td>0.00</td>';
                            }
                            if($tempo_contrato != 0 && $valor != 0 && !empty($info_stur)) {
                                $retorno .= '
                                <td>'.number_format(($total_vendas - ($media_mes * $contrato_restante)) / ($media_mes * $contrato_restante) * 100, 2, ',', '.').'%</td>';
                            } else {
                                $retorno .= '
                                <td>0.00</td>';
                            }
                            if(!empty($info_stur)) {
                                $retorno .='
                                <td>R$ '.number_format((($media_mes * $contrato_restante) * $margem) / 100, 2, ',', '.') .'</td>';    
                            } else {
                                $retorno .='
                                <td> -- </td>';
                            }
                }
                $retorno .='
                </tbody>
            </table>
        '; 
        
        return $retorno;
    }
}
