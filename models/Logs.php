<?php
class Logs extends Model {

    public function registrarlogin($log, $user_ip, $data_cadastro, $user_id){
        $sql = $this->db->prepare("INSERT INTO logs SET log = :log, user_ip = :user_ip, data_cadastro = :data_cadastro, user_id = :user_id");
        $sql->bindValue(":log", $log);
        $sql->bindValue(":user_ip", $user_ip);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();

    }

    public function log_acesso($log, $user_ip, $data_cadastro, $user_id){
        
        if(empty($user_id)){
            $user_id = '0';
        }
	$data = json_encode([
		'GET' => $_GET,
		'POST' => $_POST
	]);
        $sql = $this->db->prepare("INSERT INTO logs SET log = :log, user_ip = :user_ip, data = :data, data_cadastro = :data_cadastro, user_id = :user_id");
        $sql->bindValue(":log", $log);
	$sql->bindValue(":data", $data);
        $sql->bindValue(":user_ip", $user_ip);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();
    }
}
