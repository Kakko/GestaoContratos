<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestão de Contratos e Licitações</title>
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/permission.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/warnings.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/notes.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

    <script src="<?php echo BASE_URL; ?>assets/js/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- SUMERNOTE -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
</head>
<body>
    <div id="contratos">
        <div class="topo" id="topo">
            <div class="brand">
                <h4>Gestão de Contratos e Licitações</h4>
            </div>
            <div class="user_info">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Olá <?php echo $user_name; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>usuarios" style="color: black">Sua Conta</a>
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>admin" style="color: black">Administração</a>
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>login/logout" style="color: black">Sair</a>
                </div>
            </div>
        </div>
        <div class="menu">
            <div class="menu_bg">
                <ul>
                    <div class="sections">
                        <li><a href="<?php echo BASE_URL; ?>">Início</a></li>
                        <?php if($users->hasPermission('Licitacoes_view')): ?>
                            <li><a href="<?php echo BASE_URL; ?>licitacoes">Licitações</a></li>
                        <?php else: ?>
                            <li style="color: gray; cursor:default">Licitações</li>
                        <?php endif; ?>

                        <?php if($users->hasPermission('Contratos_view')): ?>
                            <li><a href="<?php echo BASE_URL; ?>contratos">Contratos</a></li>
                        <?php else: ?>
                            <li style="color: gray; cursor:default">Contratos</li>
                        <?php endif; ?>

                        <?php if($users->hasPermission('Documentos_view')): ?>
                            <li><a href="<?php echo BASE_URL; ?>documents">Documentos</a></li>
                        <?php else: ?>
                            <li style="color: gray; cursor:default">Documentos</li>
                        <?php endif; ?>

                        <?php if($users->hasPermission('Agenda_view')): ?>
                            <li><a href="<?php echo BASE_URL; ?>agenda">Agenda</a></li>
                        <?php else: ?>
                            <li style="color: gray; cursor:default">Agenda</li>
                        <?php endif; ?>

                        <?php if($users->hasPermission('Cadastros_view')): ?>
                            <li><a href="<?php echo BASE_URL; ?>cadastros">Cadastros</a></li>
                        <?php else: ?>
                            <li style="color: gray; cursor:default">Cadastros</li>
                        <?php endif; ?>

                        <?php if($users->hasPermission('Analise_view')): ?>
                            <li><a href="<?php echo BASE_URL; ?>analise">Análise</a></li>
                        <?php else: ?>
                            <li style="color: gray; cursor:default">Análise</li>
                        <?php endif; ?>
                        <li id="li_rel" onclick="showReports()">Relatórios</li>
                    </div>
                    <div id="reports" style="height: 0px">
                        <?php if($users->hasPermission('Relatorio_licitacoes')): ?>
                            <li><a href="<?php echo BASE_URL; ?>relatorios/rel_licitacoes" style="margin-left: 20px; border-left: 1px solid coral; padding-left: 10px">Licitações</a></li>
                        <?php else: ?>
                            <li><a style="margin-left: 20px; border-left: 1px solid coral; padding-left: 10px; color: gray; cursor: default">Licitações</a></li>
                        <?php endif; ?>

                        <?php if($users->hasPermission('Relatorio_contratos')): ?>
                            <li><a href="<?php echo BASE_URL; ?>relatorios/rel_contratos" style="margin-left: 20px; border-left: 1px solid coral; padding-left: 10px">Contratos</a></li>
                        <?php else: ?>
                            <li><a style="margin-left: 20px; border-left: 1px solid coral; padding-left: 10px; color: gray; cursor: default">Contratos</a></li>
                        <?php endif; ?>

                        <?php if($users->hasPermission('Relatorio_faturas')): ?>
                            <li><a href="<?php echo BASE_URL; ?>relatorios/rel_faturas" style="margin-left: 20px; border-left: 1px solid coral; padding-left: 10px">Faturas</a></li>
                        <?php else: ?>
                            <li><a style="margin-left: 20px; border-left: 1px solid coral; padding-left: 10px; color: gray; cursor: default">Faturas</a></li>
                        <?php endif; ?>

                        <?php if($users->hasPermission('Relatorio_geral')): ?>
                            <li><a href="<?php echo BASE_URL; ?>relatorios/rel_geral" style="margin-left: 20px; border-left: 1px solid coral; padding-left: 10px">Gerais</a></li>
                        <?php else: ?>
                            <li><a style="margin-left: 20px; border-left: 1px solid coral; padding-left: 10px; color: gray; cursor: default">Gerais</a></li>
                        <?php endif; ?>
                    </div>
                        
                </ul>
            </div>
        </div>
    </div>
    <div class="view_area">
        <?php
            $this->loadViewInTemplate($viewName, $viewData);
        ?>
    </div>
    <script src="<?php echo BASE_URL; ?>assets/js/filters.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/template.js"></script>
    <!-- <script src="<?php echo BASE_URL; ?>assets/js/contratos.js"></script> -->
</body>
</html>
