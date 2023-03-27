<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestão de Contratos e Licitações</title>
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico">

    <!-- Jquery, Popper and Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

    <!-- Summernote -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    
    <!-- System CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/permission.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/warnings.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/notes.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    
</head>
<body class="darkMode">
    <div id="maskLoading">
        <img src="<?php echo BASE_URL; ?>assets/icons/logoMonkey.png"><br/>
        <h1>Por Favor <second style="color: #be3737">Aguarde...</second></h1>
    </div>
    <div id="contratos">
        <div class="topo" id="topo">
            <div class="brand">
                <h4>Gestão de Contratos e Licitações</h4>
            </div>
            <!-- <div class="nightButton">
                <img src="<?php BASE_URL; ?>assets/icons/dark-mode-l.png" id="light" onclick="setTheme()">
                <img src="<?php BASE_URL; ?>assets/icons/dark-mode_d.png" id="dark" onclick="setTheme()" hidden>
            </div> -->
            <div class="user_info">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Olá <?php echo $user_name; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>usuarios" style="color: black">Sua Conta</a>
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>admin" style="color: black">Administração</a>
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>login/logout" style="color: black">Sair</a>
                </div>
                <?php if($users->hasPermission('Alertas')): ?>
                    <div class="popup_area" id="popup_area">
                        <!-- <h3>Contratos à expirar nos próximos 5 dias</h3> -->
                        <?php if($exp_data !== 'Sem Dados'): ?>
                            <?php foreach($exp_data as $pop): ?>
                                <?php $user_array = explode(',', $pop['user_dismissed']); ?>
                                <?php if(!in_array($_SESSION['lgUser'], $user_array)): ?>
                                    <div class="popup">
                                        <div class="highlight"></div>
                                        <div class="popup_info">
                                            <h5>Contrato nº <?php echo $pop['n_contrato']; ?> expira em breve</h5>
                                        </div>
                                        <div class="popup_action" onclick="closePop(<?php echo $pop['id']; ?>)">
                                            <button class="btn"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="menu">
            <div class="menu_bg">
                <ul>
                    <div class="sections">
                        <li><a href="<?php echo BASE_URL; ?>">Início</a></li>
                        <li><a href="<?php echo BASE_URL; ?>licitacoes">Licitações</a></li>
                        <li><a href="<?php echo BASE_URL; ?>contratos">Contratos</a></li>
                        <li><a href="<?php echo BASE_URL; ?>documents">Documentos</a></li>
                        <li><a href="<?php echo BASE_URL; ?>agenda">Agenda</a></li>
                        <li><a href="<?php echo BASE_URL; ?>cadastros">Cadastros</a></li>
                        <li><a href="<?php echo BASE_URL; ?>analise">Análise</a></li>
                        <li id="li_rel" onclick="showReports()">Relatórios</li>
                    </div>
                    <div id="reports" style="height: 0px">
                        <li><a href="<?php echo BASE_URL; ?>relatorios/rel_licitacoes" style="margin-left: 20px; border-left: 1px solid coral; padding-left: 10px">Licitações</a></li>
                        <li><a href="<?php echo BASE_URL; ?>relatorios/rel_contratos" style="margin-left: 20px; border-left: 1px solid coral; padding-left: 10px">Contratos</a></li>
                        <li><a href="<?php echo BASE_URL; ?>relatorios/rel_faturas" style="margin-left: 20px; border-left: 1px solid coral; padding-left: 10px">Faturas</a></li>
                        <li><a href="<?php echo BASE_URL; ?>relatorios/rel_geral" style="margin-left: 20px; border-left: 1px solid coral; padding-left: 10px">Gerais</a></li>
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
    <script src="<?php echo BASE_URL; ?>assets/js/warnings.js"></script>
</body>
</html>
