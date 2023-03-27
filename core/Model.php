<?php
class Model {
	
	protected $db;
	protected $stur;

	public function __construct() {
		global $db;
		global $stur;
		$this->db = $db;
		$this->stur = $stur;
	}

	public function conexao_stur($db_name, $db_host, $db_user, $db_pass){

		try {
			$faturas = new PDO("dblib:dbname=$db_name;host=$db_host", $db_user, $db_pass);
		 } catch (PDOException $e) {
			 $faturas = "FALHOU... ".$e->getMessage();
			 
		 }
		
		return $faturas;
	}

}
?>