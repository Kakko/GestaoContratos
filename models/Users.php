<?php
class Users extends Model{

    private $userInfo;
    private $permissions;
    private $companyPermissions;

    public function isLogged(){

        if(isset($_SESSION['lgUser']) && !empty($_SESSION['lgUser'])){
            return true;
        } else {
            return false;
        }
    }

    public function active(){
        $status = array();

        $id = $_SESSION['lgUser'];

        $sql = $this->db->prepare("SELECT status FROM users WHERE id = $id");
        $sql->execute();

        $status = $sql->fetch(PDO::FETCH_ASSOC);

        if($status['status'] == 'Ativo'){
            return true;
        } else {
            return false;
        }
    }

    public function cad_user($name, $email, $password, $endereco, $telefone, $obs, $status, $data_cadastro){

        $sql = $this->db->prepare("INSERT INTO users SET name = :name, email = :email, password = :password, endereco = :endereco, telefone = :telefone, obs = :obs, status = :status, data_cadastro = :data_cadastro");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":password", $password);
        $sql->bindValue(":endereco", $endereco);
        $sql->bindValue(":telefone", $telefone);
        $sql->bindValue(":obs", $obs);
        $sql->bindValue(":status", $status);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->execute();
    }

    public function edit_user($id, $name, $email, $password, $endereco, $telefone, $obs){

        if(!empty($password)){
            $sql = $this->db->prepare("UPDATE users SET name = :name, email = :email, password = :password, endereco = :endereco, telefone = :telefone, obs = :obs WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->bindValue(":name", $name);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":password", md5($password));
            $sql->bindValue(":endereco", $endereco);
            $sql->bindValue(":telefone", $telefone);
            $sql->bindValue(":obs", $obs);
            $sql->execute();
        } else {
            $sql = $this->db->prepare("UPDATE users SET name = :name, email = :email, endereco = :endereco, telefone = :telefone, obs = :obs WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->bindValue(":name", $name);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":endereco", $endereco);
            $sql->bindValue(":telefone", $telefone);
            $sql->bindValue(":obs", $obs);
            $sql->execute();
        }

    }

    public function inativar_usuario($id){
        $array = array();

        $sql = $this->db->prepare("SELECT status FROM users WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }

        if($array['status'] == 'Ativo'){
            $sql = $this->db->prepare("UPDATE users SET status = 'Inativo' WHERE id = :id");
        } elseif($array['status'] == 'Inativo') {
            $sql = $this->db->prepare("UPDATE users SET status = 'Ativo' WHERE id = :id");
        }
        $sql->bindValue(":id", $id);
        $sql->execute();

    }



    public function get_users(){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM users ORDER BY status, name ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function get_active_users(){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM users WHERE status = 'Ativo' ORDER BY name ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function get_user($id){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }
        return json_encode($array);
    }

    public function doLogin($email, $password){
        
        $sql = $this->db->prepare("SELECT * FROM users WHERE email = :email AND password = :password AND status = 'Ativo'");
        $sql->bindValue(":email", $email);
        $sql->bindValue(":password", md5($password));
        $sql->execute();

        if($sql->rowCount() > 0){
            $row = $sql->fetch();
            $_SESSION['lgUser'] = $row['id'];
            return true;
        } else {
            return false;
        }
    }

    public function setLoggedUser(){
        if(isset($_SESSION['lgUser']) && !empty($_SESSION['lgUser'])){
            $id = $_SESSION['lgUser'];

            $sql = $this->db->prepare("SELECT * FROM users WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();

            if($sql->rowCount() > 0){
                $this->userInfo = $sql->fetch();
                $this->permissions = new Permissions();
                $this->permissions->setGroup($this->userInfo['group']);
            }
        }
    }

    public function getName(){
        $this->setLoggedUser();
        if(isset($this->userInfo['name'])){
            return $this->userInfo['name'];
        } else {
            return 'Não tem Nome';
        }
    }
    
    public function getPermission(){
        $this->setLoggedUser();
        if(isset($this->userInfo['group'])){
            return $this->userInfo['group'];
        } else {
            return 'Sem Permissão Definida';
        }
    }
    
    public function logout(){
        session_unset();
    }

    public function hasPermission($name){
        $this->setLoggedUser();
        return $this->permissions->hasPermission($name);
    }

    public function loggedUserInfo($info_id){
        $array = array();
        $sql = $this->db->prepare("SELECT * FROM users WHERE id = :info_id");
        $sql->bindValue(":info_id", $info_id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function edit_usuario($name, $email, $password, $endereco, $telefone, $obs, $info_id){
        $sql = $this->db->prepare("UPDATE users SET name = :name, email = :email, password = :password, endereco = :endereco, telefone = :telefone, obs = :obs WHERE id = :info_id");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":password", $password);
        $sql->bindValue(":endereco", $endereco);
        $sql->bindValue(":telefone", $telefone);
        $sql->bindValue(":obs", $obs);
        $sql->bindValue(":info_id", $info_id);
        $sql->execute();
    }

    public function set_perm_group($id, $group){
        $sql = $this->db->prepare("UPDATE users SET users.group = :group WHERE id = :id");
        $sql->bindValue(":group", $group);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function getCompanies() {
        $sql = $this->db->prepare("SELECT * FROM cad_empresas ORDER BY name ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $getCompanies = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $getCompanies;
    }

    public function setCompanies($companies, $id){

        //CREATE A COMPANY ARRAY
        if(!empty($companies)){
            $companies = explode(",", $companies);
        }
        //VERIFICAR SE O ID DA EMPRESA JÁ CONSTA NO BANCO
        foreach($companies as $c){
            //FETCH USER'S COMPANY PERMISSION
            $sql = $this->db->prepare("SELECT * FROM users WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();

            if($sql->rowCount() > 0){
                $row = $sql->fetch(PDO::FETCH_ASSOC);

                if(empty($row['companies'])){
                    $row['companies'] = '0';
                }
                $compPermissions = $row['companies'];
            }

            $permArray = explode(',', $compPermissions); // Permissões já no banco

            if(!in_array($c, $permArray)){
                $sql = $this->db->prepare("UPDATE users SET companies = :companies WHERE id = :id");
                $sql->bindValue(":companies", $compPermissions.','.$c);
                $sql->bindValue(":id", $id);
                $sql->execute();
            }
        }

        return $this->getRegisteredCompanies($id);
    }

    public function getRegisteredCompanies($id){
        $data = '';
        $sql = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }

        $companies = explode(',', $array['companies']);
        
        foreach($companies as $comp){
            $sql = $this->db->prepare("SELECT * FROM cad_empresas WHERE id = :id");
            $sql->bindValue(":id", $comp);
            $sql->execute();

            if($sql->rowCount() > 0){
                $info = $sql->fetch(PDO::FETCH_ASSOC);
                $data .= '
                <div class="companyButton">
                    <div class="companyInfo">
                        '.$info['name'].'
                    </div>
                    <div class="removeCompany" onclick="removeCompanyPermission('.$info['id'].')">
                        x
                    </div>
                </div>
            ';
            }
            
        }

        return $data;
    }

    public function setCompaniesPermission($id){
         //FETCH USER'S COMPANY PERMISSION
         $sql = $this->db->prepare("SELECT * FROM users WHERE id = :id");
         $sql->bindValue(":id", $id);
         $sql->execute();
 
         if($sql->rowCount() > 0){
             $row = $sql->fetch(PDO::FETCH_ASSOC);
 
             if(empty($row['companies'])){
                 $row['companies'] = '0';
             }
             $compPermissions = $row['companies'];
         }
         //FETCH COMPANIES NAME FROM ARRAY    
         $sql = $this->db->prepare("SELECT name FROM cad_empresas WHERE id IN ($compPermissions)");
         $sql->execute();
     
         if($sql->rowCount() > 0){
             foreach($sql->fetchAll(PDO::FETCH_ASSOC) as $item){
                 $this->companyPermissions = $item['name'];
             }
         }
    }

    public function removeCompanyPermission($id, $userID) {
        $sql = $this->db->prepare("SELECT companies FROM users WHERE id = :userID");
        $sql->bindValue(":userID", $userID);
        $sql->execute();

        if($sql->rowCount() > 0){
            $info = $sql->fetch(PDO::FETCH_ASSOC);
        }
        $companies = explode(',', $info['companies']);
        $key = array_search($id, $companies);

        if($key!==false){
            unset($companies[$key]);
        }

        $companies = implode(',', $companies); 

        $sql = $this->db->prepare("UPDATE users SET companies = :companies WHERE id = :userID");
        $sql->bindValue(":companies", $companies);
        $sql->bindValue(":userID", $userID);
        $sql->execute();

        return $this->getRegisteredCompanies($userID);   
    }
}
