<?php
class Pdf extends Model {

    public function gerarPdf($view, $data) {

        require_once './vendor/autoload.php'; // Instanciando o mPDF

        $controller = new Controller();
        ob_start();
        $controller->loadView($view, $data);
        $html = ob_get_contents();
        ob_end_clean();
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L', 'margin_top' => 5, 'margin_left' => 1, 'margin_right' => 1, 'margim_bottom' => 5]);
        $mpdf->WriteHTML($html);
        $mpdf->Output('relatorio '.date('d/m/Y').'.pdf', 'I');

    }

    public function cabecalhoPdf(){
        ob_start();?>
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/pdf.css">
            <title>Relatório</title>
        </head>
        <body>
            <div class="corpo">
                <div class="cabecalho">
                    <div class="info">
                        <h1 style="text-align: center; border-bottom: 1px solid gray">Relatório Gestão Licitações / Contratos</h1>
                    </div>
                </div>
                <div class="conteúdo">
        <?php
        $cabecalho = ob_get_contents();
        ob_end_clean();
        return $cabecalho;
    }

    public function rel_licitacoes($data_de, $data_ate, $status, $winner_company, $sistema, $orgaos, $agencia, $group, $empresas, $checkData, $checkObj, $checkOrg, $checkEdital, $checkSystem, $checkCompany, $checkStatus, $checkStatInf, $checkValue, $checkTitle){

        $q2 = '(';
        $i = 0;
        if(!empty($empresas[0])){
            foreach($empresas as $e){
                $q2 .='
                cad_licitacao.company = :empresa'.$i;
                $i++;
                if($i < count($empresas)){
                    $q2 .= ' OR ';
                }   
            }
        }
        $q2 .=')';

        if(empty($data_de)) { $data_de = '2000-01-01'; }
        if(empty($data_ate)) { $data_ate = '5000-01-01'; }
        
        if(!empty($status)) { $status1 = 'AND cad_licitacao.status = :status';
        } else {
            $status1 = '';
        }
        //Alterar o Esclarecimentos para winner_company... fazer a junção das 2 tabelas por left join para ser feita a filtragem
        if(!empty($winner_company)) { $winner_company1 = 'AND cad_empresas_vencedoras.name = :winner_company';
        } else {
            $winner_company1 = '';
        }
        if(!empty($sistema)) { $sistema1 = 'AND cad_licitacao.system = :sistema';
        } else {
            $sistema1 = '';
        }
        if(!empty($orgaos)) { $orgaos1 = 'AND cad_licitacao.agency = :orgaos';
        } else {
            $orgaos1 = '';
        }
        if(!empty($empresas[0])) { $empresa1 = ' AND '.$q2;
        } else {
            $empresa1 = '';
        }


        $query = "SELECT hist_licitacoes.titulo AS hist_title, cad_empresas.name AS company_name, cad_empresas_vencedoras.value AS winner_value, cad_empresas_vencedoras.*, cad_licitacao.* FROM cad_licitacao 
                    LEFT JOIN cad_empresas_vencedoras ON(cad_licitacao.id = cad_empresas_vencedoras.licitacao_id) 
                    LEFT JOIN cad_empresas ON (cad_empresas.id = cad_licitacao.company)
                    LEFT JOIN hist_licitacoes ON (cad_licitacao.id = hist_licitacoes.licitacao_id)
                    WHERE cad_licitacao.data BETWEEN :data_de AND :data_ate $status1 $winner_company1 $sistema1 $orgaos1 $empresa1 ORDER BY cad_licitacao.data";


        $sql = $this->db->prepare($query);
        $sql->bindValue(":data_ate", $data_ate);
        $sql->bindValue(":data_de", $data_de);
        (!empty($status)) ? $sql->bindValue(":status", $status) : 0;
        (!empty($winner_company)) ? $sql->bindValue(":winner_company", $winner_company) : 0;
        (!empty($sistema)) ? $sql->bindValue(":sistema", $sistema) : 0;
        (!empty($orgaos)) ? $sql->bindValue(":orgaos", $orgaos) : 0;
        if(!empty($empresas[0])){
            $i = 0;
            foreach($empresas as $e){
                $sql->bindValue(":empresa".$i, $e);
                $i++;
            }
        }
        
        if($sql->execute()){
            $dados = $sql->fetchAll(PDO::FETCH_ASSOC);


            ob_start(); ?>
                <meta charset='utf-8'>
                <style>
                    td {
                        font-size: 10px;
                    }
                    th {
                        background-color: lightgray;
                        font-size: 12px;
                    }
                </style>

                <table>
                    <thead>
                        <tr>
                            <?php if(!empty($checkData)): ?>
                                <th>Data:</th>
                            <?php endif; ?>
                            <?php if(!empty($checkObj)): ?>
                                <th>Objeto</th>
                            <?php endif; ?>
                            <?php if(!empty($checkOrg)): ?>
                                <th>Órgão</th>
                            <?php endif; ?>
                            <?php if(!empty($checkEdital)): ?>
                                <th>Edital</th>
                            <?php endif; ?>
                            <?php if(!empty($checkSystem)): ?>
                                <th>Sistema</th>
                            <?php endif; ?>
                            <?php if(!empty($checkTitle)): ?>
                                <th>Título</th>
                            <?php endif; ?>
                            <?php if(!empty($checkCompany)): ?>
                                <th>Empresa</th>
                            <?php endif; ?>
                            <?php if(!empty($checkStatus)): ?>
                                <th>Status</th>
                            <?php endif; ?>
                            <?php if(!empty($checkStatInf)): ?>
                                <th>Status Info</th>
                            <?php endif; ?>
                            <?php if(!empty($checkValue)): ?>
                                <th>Valor</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($dados as $d): ?>
                            <?php if($d['system'] !== 'Licitação Genérica - Cadastro de Contrato'): ?>
                                <tr>
                                    <?php if(!empty($checkData)): ?>
                                        <td><?php echo date("d/m/Y", strtotime($d['data'])); ?> - <?php echo $d['hora']; ?></td>
                                    <?php endif; ?>
                                    <?php if(!empty($checkObj)): ?>
                                        <td><?php echo $d['object']; ?></td>
                                    <?php endif; ?>
                                    <?php if(!empty($checkOrg)): ?>
                                        <td><?php echo $d['agency']; ?></td>
                                    <?php endif; ?>
                                    <?php if(!empty($checkEdital)): ?>
                                        <td><?php echo $d['auction']; ?></td>
                                    <?php endif; ?>
                                    <?php if(!empty($checkSystem)): ?>
                                        <td><?php echo $d['cad_system']; ?></td>
                                    <?php endif; ?>
                                    <?php if(!empty($checkTitle)): ?>
                                        <td><?php echo $d['hist_title']; ?></td>
                                    <?php endif; ?>
                                    <?php if(!empty($checkCompany)): ?>    
                                        <td><?php echo $d['company_name']; ?></td>
                                    <?php endif; ?>
                                    <?php if(!empty($checkStatus)): ?>
                                        <?php if($d['status'] == 'Homologado'): ?>
                                            <td style="background-color: lightgreen"><?php echo $d['status']; ?></td>
                                        <?php elseif($d['status'] == 'Perdido'): ?>
                                            <td style="background-color: #FA8072"><?php echo $d['status']; ?></td>
                                        <?php elseif($d['status'] == 'Suspenso'): ?>
                                            <td style="background-color: #F0E68C"><?php echo $d['status']; ?></td>
                                        <?php elseif($d['status'] == 'Adiada'): ?>
                                            <td style="background-color: #e0dca4"><?php echo $d['status']; ?></td>
                                        <?php elseif($d['status'] == 'Não Participado'): ?>
                                            <td style="background-color: #aacfff"><?php echo $d['status']; ?></td>
                                        <?php else: ?>
                                            <td><?php echo $d['status']; ?></td>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if(!empty($checkStatInf)): ?>
                                        <td><?php echo $d['status_info']; ?></td>
                                    <?php endif; ?>
                                    <?php if(!empty($checkValue)): ?>
                                        <?php if($agencia === 'on'): ?>
                                            <td>R$ <?php echo number_format($d['value'],2,',','.'); ?></td>
                                        <?php endif; ?>
                                        <?php if($agencia === 'off' && $d['status'] == 'Homologado' && empty($d['winner_value']) && empty($d['perc'])): ?>
                                            <td>R$ <?php echo number_format($d['value'],2,',','.'); ?></td>
                                        <?php elseif($agencia == 'off' && $d['status'] == 'Homologado' && !empty($d['winner_value']) && empty($d['perc'])): ?>
                                            <td>R$ <?php echo number_format($d['winner_value'],4,',','.'); ?></td>
                                        <?php elseif($agencia == 'off' && $d['status'] == 'Homologado' && empty($d['winner_value']) && !empty($d['perc'])): ?>
                                            <td><?php echo $d['perc']; ?> %</td>
                                        <?php elseif($agencia == 'off'): ?>
                                            <td>R$ <?php echo number_format($d['value'],2,',','.'); ?></td>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </tr>
                            <?php endif; ?>
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

    public function rel_contratos($inicio_de, $inicio_ate, $fim_de, $fim_ate, $id_cliente, $empresas, $situacao, $lei_kandir, $inad, $state, $checkCode, $checkName, $checkContrato, $checkEmissor, $checkCNPJ, $checkValue, $checkCod2, $checkVencimento, $checkMail, $checkPhone, $checkSituacao, $checkKandir, $checkDetails, $checkAditivo, $checkSTURValue, $checkContStart, $checkContEnd, $checkProfitValue){

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
                        font-size: 12px;
                        border: 1px solid #aaa;
                    }
                </style>

                <table>
                    <thead>
                        <tr>
                            <?php if(!empty($checkCode)): ?>
                                <th>STUR</th>
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
                            <?php if(!empty($checkCod2)): ?>
                                <th>Código</th>
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
                            <?php if(!empty($checkCod2)): ?>
                                <td><?php echo $d['cod2']; ?></td>
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
                                <?php if(!empty($hist) && $hist['aditivo'] == 's'): ?>
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

    public function footerPdf(){
        ob_start();?>
            </div>
                <div style="width: 100%; text-align: center; margin-top: 10px; font-weight: bolder">WSA Administração</div>
            </div>
        </body>
        </html>
        <?php
        $footer = ob_get_contents();
        ob_end_clean();
        return $footer;
    }

}