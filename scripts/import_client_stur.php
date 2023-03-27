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

    $sql = $connect->prepare("SELECT * FROM stur_client_import");
    $sql->execute();

    if($sql->rowCount() > 0) {
        $sturClients = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach($sturClients as $client){
            $sql = $sql = $connect->prepare("SELECT * FROM cad_empresas WHERE id = :id");
            $sql->bindValue(":id", $client['company_id']);
            $sql->execute();

            if($sql->rowCount() > 0) {
                $companyData = $sql->fetch(PDO::FETCH_ASSOC);

                $dbname = $companyData['db_name'];
                $dbhost = $companyData['db_host'];
                $dbuser = $companyData['db_user'];
                $dbpass = $companyData['db_pass'];
        
                $stur = new PDO("dblib:dbname=".$dbname.";host=".$dbhost, $dbuser, $dbpass); //CONEXÃO COM O STUR
        
                $sql = $stur->prepare("SELECT ECIDADE.DESCRCID AS CIDADE, ECIDADE.SIGLAESTADO AS UF, * FROM ECLIENTE 
                                        LEFT JOIN ECIDADE ON (ECIDADE.SIGLACID = ECLIENTE.SIGLACID)
                                        WHERE CODCLI > :codcli AND CODCLI != '99991' and CODCLI != '99980'");
                $sql->bindValue(":codcli", $client['codcli']);
                $sql->execute();

                $data = $sql->fetchAll(PDO::FETCH_ASSOC);

                if(!empty($data)){
                  
                  
                } 
            }
        }
    }
    



