<style>
    * {
        margin: 0;
        padding: 0;
    }
    .container {
        width: 100%;
        height: 100vh;
        background-color: #EEE;
    }
    .monkeyIcon {
        width: 30%;
        height: 400px;
        margin-left: 35%;
        top: 200px;
        position: absolute;
    }
    .monkeyIcon img {
        margin-left: 30%;
    }
    .announcement {
        width: 100%;
        height: 150px;
        font-size: 40px;
        text-align: center;
        padding-top: 50px;
        font-family: 'Arial';
    }
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Contratos e Licitações</title>
</head>
<body>
    <div class="container">
        <div class="monkeyIcon">
            <img src="<?php echo BASE_URL; ?>assets/images/icons/logoMonkeyBranch.png">
            <div class="announcement"><marquee>Em Manutenção</marquee></div>
        </div>
    </div>
</body>
</html>
