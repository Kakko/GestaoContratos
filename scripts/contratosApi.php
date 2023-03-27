<?php

    //Abrir Conexão com o banco local
    $connect = new PDO("mysql:dbname=gestaocontratos;host=67.205.175.48:5506", "gestaocontratos", "Gesta0_615243");
    $connect->exec("SET NAMES 'utf8'");
    $connect->exec('SET character_set_connection=utf8');
    $connect->exec('SET character_set_client=utf8');
    $connect->exec('SET character_set_results=utf8');

    $sql = $connect->prepare("SELECT name, db_host, db_name, db_user, db_pass FROM cad_empresas WHERE db_name != ''"); //Buscar os campos para conexão com o Banco do Stur - db_host / db_name / db_user / db_pass
    $sql->execute();

    $qtd = $sql->rowCount();

    $info = $sql->fetchAll(PDO::FETCH_ASSOC); //Retorna os dados solicitados de todas as empresas onde o db_name esteja preenchido
    echo '<pre>';
    foreach($info as $data) { //Conexão com o Stur para cada empresa
        $stur = new PDO("dblib:dbname=".$data['db_name'].";host=".$data['db_host'], $data['db_user'], $data['db_pass']); //Conexão com o banco do STUR

        $sql = $connect->prepare("SELECT cad_clientes.stur_cod FROM cad_contratos LEFT JOIN cad_clientes ON cad_contratos.nome_cliente = cad_clientes.nome_cliente WHERE cad_clientes.empresa = :empresa_name");
        $sql->bindValue(":empresa_name", $data['name']);
        $sql->execute();

        $result = $sql->fetchAll(PDO::FETCH_ASSOC); //Retorna os dados dos contratos cadastrados

        foreach($result as $sc){

            $sql = $stur->prepare("SELECT count(codclifor) AS qtd FROM ERECEBER WHERE docto like 'ft%' AND dtvencto < CONVERT(date, getdate()) AND status = 'Aberto' AND codclifor = :stur_cod");
            $sql->bindValue(":stur_cod", $sc['stur_cod']);
            $sql->execute();

            $dados_stur = $sql->fetch(PDO::FETCH_ASSOC);


            if($dados_stur['qtd'] > 0){
                print_r(' Inadimplente ');
                $sql = $connect->prepare("UPDATE cad_contratos SET inadimplente = 'Sim' WHERE cod = :stur_cod AND nome_cliente != ''");
                $sql->bindValue(":stur_cod", $sc['stur_cod']);
                $sql->execute();
                print_r($sc['stur_cod'].'<br/>');

            } else if($dados_stur['qtd'] == 0) {
                print_r(' Adimplente ');
                $sql = $connect->prepare("UPDATE cad_contratos SET inadimplente = 'Não' WHERE cod = :stur_cod AND nome_cliente != ''");
                $sql->bindValue(":stur_cod", $sc['stur_cod']);
                $sql->execute();
                print_r($sc['stur_cod'].'<br/>');
            }
        }
        print_r(' girei entre empresas ').'<hr/>';

    }
?>