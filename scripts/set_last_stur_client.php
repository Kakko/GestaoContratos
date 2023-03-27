<?php

//Abrir Conexão com o banco local - Produção
$connect = new PDO("mysql:dbname=gestaocontratos;host=localhost", "root", "Monkey615243");
$connect->exec("SET NAMES 'utf8'");
$connect->exec('SET character_set_connection=utf8');
$connect->exec('SET character_set_client=utf8');
$connect->exec('SET character_set_results=utf8');

//Abrir Conexão com o banco local - Desenvolvimento
// $connect = new PDO("mysql:dbname=gestaocontratos;host=67.205.175.48:5506", "gestaocontratos", "Gesta0_615243");
// $connect->exec("SET NAMES 'utf8'");
// $connect->exec('SET character_set_connection=utf8');
// $connect->exec('SET character_set_client=utf8');
// $connect->exec('SET character_set_results=utf8');


// INSERIR O ÚLTIMO CLIENTE CADASTRADO NO STUR NO BANCO DE DAODS LOCAL
$sql = $connect->prepare("SELECT * FROM cad_empresas WHERE db_name IS NOT NULL");
$sql->execute();

if($sql->rowCount() > 0) {
    $companies = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach($companies as $company){

        $dbname = $company['db_name'];
        $dbhost = $company['db_host'];
        $dbuser = $company['db_user'];
        $dbpass = $company['db_pass'];

        $stur = new PDO("dblib:dbname=".$dbname.";host=".$dbhost, $dbuser, $dbpass); //CONEXÃO COM O STUR

        $sql = $stur->prepare("SELECT TOP 1 * FROM ECLIENTE WHERE CODCLI != '99991' and CODCLI != '99980' ORDER BY CODCLI DESC"); // PEGAR O ÚLTIMO REGISTRO DE CLIENTE CADASTRADO
        $sql->execute();

        $sturClientData = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach($sturClientData as $stur){
            $sql = $connect->prepare("INSERT INTO stur_client_import SET codcli = :codcli, company_id = :company_id, reg_date = now()");
            $sql->bindValue(":codcli", $stur['CODCLI']);
            $sql->bindValue(":company_id", $company['id']);
            $sql->execute();
        }

    }
}