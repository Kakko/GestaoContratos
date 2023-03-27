<?php
class Controller extends Model {

	protected $db;
	protected $stur;

	public function __construct() {
		global $config;
	}
	
	public function loadView($viewName, $viewData = array()) {
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}

	public function loadTemplate($viewName, $viewData = array()) {
		$users  = new Users();
		$warnings = new Warnings();
		
		$exp_data = $warnings->exp_contracts();
		$user_name = $users->getName();
        $user_permission = $users->getPermission();
		include 'views/template.php';
	}

	public function loadViewInTemplate($viewName, $viewData) {

		extract($viewData);
		include 'views/'.$viewName.'.php';
	}

	public function secure_string($secure) {
		if (gettype($secure) == 'array') {
			$new_secure = [];
			foreach($secure as $q => $val){
				$new_secure[$q] = addslashes($val);
				$new_secure[$q] = htmlentities($new_secure[$q]);
			}
			// for ($i=0; $i < count($secure); $i++) {
			// 	$secure[$i] = addslashes($secure[$i]);
			// 	$secure[$i] = htmlentities($secure[$i]);
			// }
		}else{
			$new_secure = addslashes($secure);
			$new_secure = htmlentities($new_secure);
		}
		return $new_secure;
	}
}