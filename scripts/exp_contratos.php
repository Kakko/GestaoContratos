<?php
//Abrir Conexão com o banco local
// $connect = new PDO("mysql:dbname=gestaocontratos;host=localhost", "root", "Monkey615243");
// $connect->exec("SET NAMES 'utf8'");
// $connect->exec('SET character_set_connection=utf8');
// $connect->exec('SET character_set_client=utf8');

//Banco Online
$connect = new PDO("mysql:dbname=gestaocontratos;host=67.205.175.48:5506", "gestaocontratos", "Gesta0_615243");
$connect->exec("SET NAMES 'utf8'");
$connect->exec('SET character_set_connection=utf8');
$connect->exec('SET character_set_client=utf8');

//Banco Ambiente de Teste
// $connect = new PDO("mysql:dbname=gestaocontratos;host=137.184.129.157", "admin", "Monkey_615243");
// $connect->exec("SET NAMES 'utf8'");
// $connect->exec('SET character_set_connection=utf8');
// $connect->exec('SET character_set_client=utf8');

$sql = $connect->prepare("SELECT * FROM cad_contratos WHERE CASE WHEN fim_aditivo IS NOT NULL THEN (fim_aditivo BETWEEN now() AND now() + interval 5 day)
ELSE fim_contrato BETWEEN now() AND  now() + interval 5 day END");
$sql->execute();

if($sql->rowCount() > 0) {
    $contracts = $sql->fetchAll(PDO::FETCH_ASSOC);

    foreach($contracts as $c){

        $sql = $connect->prepare("SELECT * FROM exp_contratos WHERE id_contrato = :id_contrato AND exp_date = :fim_contrato OR exp_date = :fim_aditivo");
        $sql->bindValue(":id_contrato", $c['id']);
        $sql->bindValue(":fim_contrato", $c['fim_contrato']);
        $sql->bindValue(":fim_aditivo", $c['fim_aditivo']);
        $sql->execute();

        if($sql->rowCount() === 0){

            $sql = $connect->prepare("INSERT INTO exp_contratos SET id_contrato = :id_contrato, n_contrato = :n_contrato, exp_date = :exp_date, data_cadastro = now()");
            $sql->bindValue(":id_contrato", $c['id']);
            $sql->bindValue(":n_contrato", $c['n_contrato']);
            if(!empty($c['fim_aditivo'])){
                $sql->bindValue(":exp_date", $c['fim_aditivo']);
            } else {
                $sql->bindValue(":exp_date", $c['fim_contrato']);
            }
   	    $sql->execute();
        }
        
    }
    
}
