<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestão de Contratos e Licitações</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login.css">
</head>
<body>
    <div class="loginArea">
        <div class="loginSection">
            <div class="title">
                <label class="loginTitle">Gestão de Contratos e Licitações</label>
            </div>
            <form method="POST">
                <div class="formArea">
                    <div class="inputArea">
                        <div class="logIcon">
                            <img src="./assets/icons/user_initial.png" id="initialUser">
                            <img src="./assets/icons/user.png" id="user" hidden>
                        </div>
                        <input type="email" class="inputForm" name="email" placeholder="Digite seu e-mail:" autocomplete="off" onfocus="changeUser()">
                    </div>
                    <div class="inputArea">
                        <div class="logIcon">
                            <img src="./assets/icons/password_initial.png" id="initialPass">
                            <img src="./assets/icons/password.png" hidden id="pass">
                        </div>
                        <input type="password" class="inputForm" name="password" placeholder="Digite sua Senha:" onfocus="changePass()">
                    </div>
                </div>
                <div class="buttonArea">
                    <input type="submit" class="loginButton" value="Entrar">
                    <!-- <span class="forgetPassword">Esqueceu sua senha?</span> -->
                </div>
            </form>
            <div class="disclaimer">
                <span>Desenvolvido por MonkeyBranch - Todos os Direitos Reservados - v.4.0.0</span>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/login.js"></script>
</body>
</html>
