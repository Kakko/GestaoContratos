<?php

    //Abrir Conexão com o banco local - Produção
    // $connect = new PDO("mysql:dbname=gestaocontratos;host=localhost", "root", "root1234");
    // $connect->exec("SET NAMES 'utf8'");
    // $connect->exec('SET character_set_connection=utf8');
    // $connect->exec('SET character_set_client=utf8');
    // $connect->exec('SET character_set_results=utf8');

    //Abrir Conexão com o banco local - Desenvolvimento
    $connect = new PDO("mysql:dbname=gestaocontratos;host=67.205.175.48:5506", "gestaocontratos", "Gesta0_615243");
    $connect->exec("SET NAMES 'utf8'");
    $connect->exec('SET character_set_connection=utf8');
    $connect->exec('SET character_set_client=utf8');
    $connect->exec('SET character_set_results=utf8');


    $data = '';
    $data_atual = date("Y-m-d");

    //BUSCAR LICITAÇÕES PARA AVISOS
    $sql = $connect->prepare("SELECT * FROM cad_licitacao WHERE data = :data_atual");
    $sql->bindValue(":data_atual", $data_atual);
    $sql->execute();

    if($sql->rowCount() > 0){
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach($data as $info){
            if($info['hora'] > date("H:i")){
                $sql = $connect->prepare("SELECT * FROM warnings WHERE licitacao_id = :licitacao_id");
                $sql->bindValue(":licitacao_id", $info['id']);
                $sql->execute();
                
                if($sql->rowCount() == 0 ){
                    $sql = $connect->prepare("INSERT INTO warnings SET data = :data, horario = :horario, visualizado = :visualizado, encerrado = :encerrado, acompanhar = :acompanhar, data_cadastro = :data_cadastro, licitacao_id = :licitacao_id");
                    $sql->bindValue(":data", $info['data']);
                    $sql->bindValue(":horario", $info['hora']);
                    $sql->bindValue(":visualizado", '0');
                    $sql->bindValue(":encerrado", '0');
                    $sql->bindValue(":acompanhar", '0');
                    $sql->bindValue(":data_cadastro", date("Y-m-d H:i:s"));
                    $sql->bindValue(":licitacao_id", $info['id']);
                    $sql->execute();
                }

            } else if($info['hora'] == date("H:i")) {
                
            }
        }
        print_r('Licitações carregadas ');
    } else {
        print_r('Sem Licitações Hoje');
    }

    //BUSCAR CONTRATOS PARA AVISOS
    $data_contratos = date('Y-m-d', strtotime("+7 days", strtotime($data_atual)));

    $sql = $connect->prepare("SELECT * FROM cad_contratos WHERE fim_contrato = :fim_contrato");
    $sql->bindValue(":fim_contrato", $data_contratos);
    $sql->execute();


    if($sql->rowCount() > 0){
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach($data as $info){
            $sql = $connect->prepare("SELECT * FROM warnings WHERE contratos_id = :contratos_id");
            $sql->bindValue(":contratos_id", $info['id']);
            $sql->execute();
            
            if($sql->rowCount() == 0 ){
                $sql = $connect->prepare("INSERT INTO warnings SET data = :data, visualizado = :visualizado, encerrado = :encerrado, acompanhar = :acompanhar, data_cadastro = :data_cadastro, contratos_id = :contratos_id");
                $sql->bindValue(":data", $info['fim_contrato']);
                $sql->bindValue(":visualizado", '0');
                $sql->bindValue(":encerrado", '0');
                $sql->bindValue(":acompanhar", '0');
                $sql->bindValue(":data_cadastro", date("Y-m-d H:i:s"));
                $sql->bindValue(":contratos_id", $info['id']);
                $sql->execute();
            }
        }
        print_r('Contratos carregados ');
    } else {
        print_r('Sem Contratos Hoje');
    }


?>