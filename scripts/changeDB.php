<?php 
    //Abrir Conexão com o banco local - Produção
    $connect = new PDO("mysql:dbname=gestaocontratos;host=67.205.175.48:5506", "gestaocontratos", "Gesta0_615243");
    $connect->exec("SET NAMES 'utf8'");
    $connect->exec('SET character_set_connection=utf8');
    $connect->exec('SET character_set_client=utf8');
    $connect->exec('SET character_set_results=utf8');

    //Change BD - Licitações
    $sql = $connect->prepare("SELECT cad_licitacao.*, cad_empresas.id AS empresa_id, cad_empresas.name AS company_name FROM cad_licitacao
    INNER JOIN cad_empresas ON (cad_empresas.name = cad_licitacao.company)");
    $sql->execute();

    $info = $sql->fetchAll();

    foreach($info as $i) {
        $sql = $connect->prepare("UPDATE cad_licitacao SET cad_licitacao.company = :empresa_id WHERE cad_licitacao.company = :cad_company");
        $sql->bindValue(":empresa_id", $i['empresa_id']);
        $sql->bindValue(":cad_company", $i['company_name']);
        $sql->execute();
    }

    //Change BD - Contratos
    $sql = $connect->prepare("SELECT cad_contratos.*, cad_empresas.id AS empresa_id, cad_empresas.name AS company_name FROM cad_contratos
    INNER JOIN cad_empresas ON (cad_empresas.name = cad_contratos.empresa)");
    $sql->execute();

    $info = $sql->fetchAll();

    foreach($info as $i) {
        $sql = $connect->prepare("UPDATE cad_contratos SET cad_contratos.empresa = :empresa_id WHERE cad_contratos.empresa = :cad_company");
        $sql->bindValue(":empresa_id", $i['empresa_id']);
        $sql->bindValue(":cad_company", $i['company_name']);
        $sql->execute();
    }

    // //Change BD - Clientes
    $sql = $connect->prepare("SELECT cad_clientes.*, cad_empresas.id AS empresa_id, cad_empresas.name AS company_name FROM cad_clientes
    INNER JOIN cad_empresas ON (cad_empresas.name = cad_clientes.empresa)");
    $sql->execute();

    $info = $sql->fetchAll();

    foreach($info as $i) {
        $sql = $connect->prepare("UPDATE cad_clientes SET cad_clientes.empresa = :empresa_id WHERE cad_clientes.empresa = :cad_company");
        $sql->bindValue(":empresa_id", $i['empresa_id']);
        $sql->bindValue(":cad_company", $i['company_name']);
        $sql->execute();
    }

    //Change BD - Documents
    $sql = $connect->prepare("SELECT cad_documents.*, cad_empresas.id AS empresa_id, cad_empresas.name AS company_name FROM cad_documents
    INNER JOIN cad_empresas ON (cad_empresas.name = cad_documents.company)");
    $sql->execute();

    $info = $sql->fetchAll();

    foreach($info as $i) {
        print_r('Alterando');
        $sql = $connect->prepare("UPDATE cad_documents SET cad_documents.company = :empresa_id WHERE cad_documents.company = :cad_company");
        $sql->bindValue(":empresa_id", $i['empresa_id']);
        $sql->bindValue(":cad_company", $i['company_name']);
        $sql->execute();
    }
    
