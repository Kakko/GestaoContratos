<?php
    header("refresh: 600;");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - Gestão de Cadastros e Licitações</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/painel.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css">
    <!-- Scripts -->
    <script src="<?php echo BASE_URL; ?>assets/js/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="topPainel">
        <div class="title">Painel - Gestão de Contratos e Licitações</div>
    </div>
    <div class="showArea">
        <table class="table table-striped table-hover table-sm table-fixed">
            <thead class="thead-dark">
                <tr>
                    <th style="padding-left: 10px">Data</th>
                    <th>Hora</th>
                    <th>Sistema</th>
                    <th>Valor</th>
                    <th>Edital</th>
                    <th>Id.</th>
                    <th>Órgão</th>
                    <th>Empresa</th>
                    <th>Observação</th>
                </tr>
            </thead>
            <tbody style="font-size: 12px">
                <?php if(!empty($info)): ?>
                    <?php foreach($info as $lic): ?>
                        <?php if($lic['status'] == 'Homologado'): ?>
                            <tr style="background-color: #a6e0a4">
                        <?php elseif($lic['status'] == 'Anulado'): ?>
                            <tr style="background-color: #e0a4a4">
                        <?php elseif($lic['status'] == 'Perdido'): ?>
                            <tr style="background-color: #e0a4a4">
                        <?php elseif($lic['status'] == 'Não Participado'): ?>
                            <tr style="background-color: #aacfff">
                        <?php elseif($lic['status'] == 'Suspenso'): ?>
                            <tr style="background-color: #e0dca4">
                        <?php elseif($lic['status'] == 'Em Andamento'): ?>
                            <tr style="background-color: #ffcff5">
                        <?php elseif($lic['status'] == 'Recurso'): ?>
                            <tr style="background-color: #852871; color: #FFF">
                        <?php elseif($lic['status'] == 'Cadastrado'): ?>
                            <tr style="background-color: #22608a; color: #FFF">
                        <?php elseif($lic['status'] == 'Mandado de Segurança'): ?>
                            <tr style="background: linear-gradient(45deg, #FFC900, #FF0000, #FFC900); color: #fff">
                        <?php endif; ?>
                            <td style="width: 5%; padding-left: 10px"><?php echo date("d/m/Y", strtotime($lic['data'])); ?></td>
                            <td style="width: 5%"><?php echo $lic['hora']; ?></td>
                            <td style="max-width: 80px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap" title="<?php echo $lic['cad_system']; ?>"><?php echo $lic['cad_system']; ?></td>
                            <td style="width: 10%">R$ <?php echo number_format($lic['value'],2,',', '.'); ?></td>
                            <td style="max-width: 40px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap" title="<?php echo $lic['auction']; ?>"><?php echo $lic['auction']; ?></td>
                            <td style="max-width: 40px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap" title="<?php echo $lic['complement']; ?>"><?php echo $lic['complement']; ?></td>
                            <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap" title="<?php echo $lic['agency']; ?>"><?php echo $lic['agency']; ?></td>
                            <td style="max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap" title="<?php echo $lic['company_name']; ?>"><?php echo $lic['company_name']; ?></td>
                            <td style="max-width: 370px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap" title="<?php echo $lic['obs']; ?>"><?php echo $lic['obs']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>