<?php

class Permissions extends Model {

    private $group;
    private $permissions;

    public function setGroup($id){
        $this->group = $id;
        $this->permissions = array();

        $sql = $this->db->prepare("SELECT params FROM permission_groups WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $row = $sql->fetch();

            if(empty($row['params'])){
                $row['params'] = '0';
            }

            $params = $row['params'];

            $sql = $this->db->prepare("SELECT name FROM permission_params WHERE id IN ($params)");
            $sql->execute();

            if($sql->rowCount() > 0){
                foreach($sql->fetchAll() as $item) {
                    $this->permissions[] = $item['name'];
                }
            }
        }
    }

    public function hasPermission($name) {
        if(in_array($name, $this->permissions)){
            return true;
        } else {
            return false;
        }
    }

    public function getPermissionList(){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM permission_params");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function cad_permission_group($name, $data_cadastro, $user_id){
        $params = '';
        $sql = $this->db->prepare("INSERT INTO permission_groups SET name = :name, params = :params, data_cadastro = :data_cadastro, user_id = :user_id");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":params", $params);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();

    }
    public function cad_permission($name, $data_cadastro, $user_id){
        $sql = $this->db->prepare("INSERT INTO permission_params SET name = :name, data_cadastro = :data_cadastro, user_id = :user_id");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();
    }

    public function getPermission_groups(){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM permission_groups");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function ger_group_permissions($name, $params){
        $permissions = implode(',', $params);
        $sql = $this->db->prepare("UPDATE permission_groups SET params = :params WHERE name = :name");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":params", $permissions);
        $sql->execute();
    }

    public function list_groups($group_name){
        $info = array();
        $group_info = '';

        $sql = $this->db->prepare("SELECT params FROM permission_groups WHERE name = :name");
        $sql->bindValue(":name", $group_name);
        $sql->execute();

        if($sql->rowCount() > 0){
            $row = $sql->fetch();

            if(empty($row['params'])){
                $row['params'] = '0';
            }

            $params = $row['params'];


            $sql = $this->db->prepare("SELECT * FROM permission_params WHERE id IN ($params)");
            $sql->execute();

            if($sql->rowCount() > 0){
                $param_names = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        }

        $group_info .='
            <form method="POST">
                <table class="table table-striped table-hover table-sm" id="table_licitacoes">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome da Permissão</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>';
                        foreach($param_names as $i){
                            $group_info .='
                                <tr>
                                    <td>'.$i['id'].'</td>
                                    <input name="acao_permission" value="remove_perm" hidden>
                                    <td id="perm_name">'.$i['name'].'</td>
                                    <td><button type="button" class="btn btn-outline-danger" onclick="remover_permissao('.$i['id'].')"><i class="fas fa-trash"></i></button></td>
                                </tr>';
                        }
                        $group_info .='
                        <tr></tr>
                    </tbody>
                </table>
            </form>
        ';

        return $group_info;
    }

    public function remove_perm($id, $group_name){
        $array = array();

        $sql = $this->db->prepare("SELECT params FROM permission_groups WHERE params LIKE :id AND name = :group_name");
        $sql->bindValue(":id", "%".$id."%");
        $sql->bindValue(":group_name", $group_name);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }
 
        $array = explode(',', $array['params']);
        
        $key = array_search($id, $array);
 
        unset($array[$key]);

        $dados = implode(',', $array);

        $sql = $this->db->prepare("UPDATE permission_groups SET params = :dados WHERE name = :name");
        $sql->bindValue(":dados", $dados);
        $sql->bindValue(":name", $group_name);
        $sql->execute();
    }

    public function showPermissionParams($permissionGroup){
        $data = '';

        $sql = $this->db->prepare("SELECT * FROM permission_groups WHERE id = :id");
        $sql->bindValue(":id", $permissionGroup);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $group = $sql->fetch(PDO::FETCH_ASSOC);
        }

        $params = explode(',', $group['params']);

        $sql = $this->db->prepare("SELECT * FROM permission_params");
        $sql->execute();

        if($sql->rowCount() > 0) {
            $paramData = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach($paramData as $pd){
                if(in_array($pd['id'], $params)){
                    $data .='
                    <div permID="'.$pd['id'].'" class="params_list selected" onclick="markItem(this)">'.$pd['name'].'</div>
                    ';
                } else {
                    $data .='
                    <div permID="'.$pd['id'].'" class="params_list" onclick="markItem(this)">'.$pd['name'].'</div>
                    ';
                }
            }
        }
        return $data;
    }

    public function insert_params($params, $id) {
        if(!empty($id)){
            $sql = $this->db->prepare("UPDATE permission_groups SET params = :params WHERE id = :id");
            $sql->bindValue(":params", $params);
            $sql->bindValue(":id", $id);
            if($sql->execute()) {
                return 'Permissões atualizadas com sucesso!';
            } else {
                return 'Erro ao atualizar permissões. Contate o Administrador';
            }
        } else {
            return 'Erro ao atualizar permissões. Contate o Administrador';
        }
    }

    // INÍCIO CONFIGURAÇÃO DE PERMISSÕES POR EMPRESA (VAI ANULAR TODAS AS OUTRAS PERMISSÕES NO FUTURO)

    public function fetch_user_companies($user_id) {
        $data = '';
        $sql = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $sql->bindValue(":id", $user_id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $user = $sql->fetch(PDO::FETCH_ASSOC);

            $companies = explode(',', $user['companies']);

            $data .='<div class="companySelectionArea">';

                foreach($companies as $company) {
                    
                    $sql = $this->db->prepare("SELECT * FROM cad_empresas WHERE id = :id ORDER BY name ASC");
                    $sql->bindValue(":id", $company);
                    $sql->execute();

                    if($sql->rowCount() > 0) {
                        $companiesData = $sql->fetchAll(PDO::FETCH_ASSOC);

                        foreach($companiesData as $companyData) {
                            $data .='
                                <div class="companiesItem" uid="'.$user_id.'" cid="'.$companyData['id'].'" onclick="showCompanyPermission(this)">'.$companyData['name'].'</div>
                            ';                        
                        }
                    }
                }

            $data .='</div>';
        } else {
            $data .=' - ';
        }

        return $data;
    }

    public function set_company_permissions($id, $user_id) {
        $data = '';
        $params = array();

        $sql = $this->db->prepare("SELECT * FROM permissions WHERE user = :user AND companies = :companies AND type = 'CMP'");
        $sql->bindValue(":user", $user_id);
        $sql->bindValue(":companies", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $user_permissions = $sql->fetch(PDO::FETCH_ASSOC);
            
            $params = explode(',', $user_permissions['permission_id']);
        }        

        $sql = $this->db->prepare("SELECT * FROM permission_params WHERE type = 'CMP' ORDER BY id ASC");
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $permissions = $sql->fetchAll(PDO::FETCH_ASSOC);

            $data .='
                <div class="setPermissionsArea">
            ';

            foreach($permissions as $permission) {
                if(in_array($permission['id'], $params)){
                    $data .='<button class="permButton perm_selected" permID="'.$permission['id'].'" onclick="markPermItem(this)">'.$permission['name'].'</button>';
                } else {
                    $data .='<button class="permButton" permID="'.$permission['id'].'" onclick="markPermItem(this)">'.$permission['name'].'</button>';
                }
            }
            $data .='</div>';
        }

        return $data;
    }

    public function insert_company_params($company_id, $user_id, $params) {
        $companies = explode(',', $company_id);

        foreach($companies as $company) {
            $sql = $this->db->prepare("SELECT * FROM permissions WHERE user = :user_id AND companies = :company_id");
            $sql->bindValue(":user_id", $user_id);
            $sql->bindValue(":company_id", $company);
            $sql->execute();
    
            if($sql->rowCount() > 0) {
                $sql = $this->db->prepare("UPDATE permissions SET permission_id = :permission_id WHERE user = :user_id AND companies = :company_id");
                $sql->bindValue(":permission_id", $params);
                $sql->bindValue(":user_id", $user_id);
                $sql->bindValue(":company_id", $company);
                $sql->execute();

            } else {
                $sql = $this->db->prepare("INSERT INTO permissions SET user = :user, companies = :company_id, permission_id = :permission_id, user_id = :user_id, type = 'CMP', reg_date = NOW()");
                $sql->bindValue(":user", $user_id);
                $sql->bindValue(":company_id", $company);
                $sql->bindValue(":permission_id", $params);
                $sql->bindValue(":user_id", $_SESSION['lgUser']);
                $sql->execute();
            }
        }
        return 'PERMISSÕES CRIADAS COM SUCESSO';
    }

    public function verifyPermissions($empresa) {
        $user_permissions = array();

        $empresas = explode('|', $empresa);
        
        foreach($empresas as $empresa) {
            $sql = $this->db->prepare("SELECT user, companies, permission_id FROM permissions WHERE user = :user AND companies = :companies");
            $sql->bindValue(":user", $_SESSION['lgUser']);
            $sql->bindValue(":companies", $empresa);
            $sql->execute();
    
            if($sql->rowCount() > 0) {
                $user_permissions[] = $sql->fetchAll(PDO::FETCH_ASSOC);    
            } 
        }
        
        return $user_permissions;
    }

    public function verifyAddPermission() {
        $permissions = '';

        $sql = $this->db->prepare("SELECT permission_id FROM permissions WHERE user = :user AND type = 'CMP'");
        $sql->bindValue(":user", $_SESSION['lgUser']);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $addPermissions = $sql->fetchAll(PDO::FETCH_ASSOC);

            for($i=0; $i < count($addPermissions); $i++) {
                $permissions = $permissions.','.$addPermissions[$i]['permission_id'];
            }
        }
        $permissions = substr($permissions, 1);

        return explode(',', $permissions);
    }

    public function show_user_system_permissions($user_id) {
        $data = '';
        $params = array();

        $sql = $this->db->prepare("SELECT * FROM permissions WHERE user = :user AND type = :type");
        $sql->bindValue(":user", $user_id);
        $sql->bindValue(":type", 'SYS');
        $sql->execute();

        if($sql->rowCount() > 0) {
            $user_permissions = $sql->fetch(PDO::FETCH_ASSOC);
            
            $params = explode(',', $user_permissions['permission_id']);
        }        

        $sql = $this->db->prepare("SELECT * FROM permission_params WHERE type = 'SYS' ORDER BY name ASC");
        $sql->execute();
        
        if($sql->rowCount() > 0) {
            $permissions = $sql->fetchAll(PDO::FETCH_ASSOC);

            $data .='
                <div class="setPermissionsArea">
            ';

            foreach($permissions as $permission) {
                if(in_array($permission['id'], $params)){
                    $data .='<button class="permButton perm_selected" permID="'.$permission['id'].'" onclick="markPermItem(this)">'.$permission['name'].'</button>';
                } else {
                    $data .='<button class="permButton" permID="'.$permission['id'].'" onclick="markPermItem(this)">'.$permission['name'].'</button>';
                }
            }
            $data .='</div>';
        }

        return $data;
    }

    public function insert_system_params($user_id, $params) {

        $sql = $this->db->prepare("SELECT * FROM permissions WHERE user = :user AND type = 'SYS'");
        $sql->bindValue(":user", $user_id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $this->db->prepare("UPDATE permissions SET permission_id = :params WHERE user = :user AND type = 'SYS'");
            $sql->bindValue(":params", $params);
            $sql->bindValue(":user", $user_id);
            if($sql->execute()) {
                return 'PERMISSÕES ATUALIZADAS COM SUCESSO';
            } else {
                return 'ERRO AO ATUALIZAR PERMISSÕES. FAVOR CONTACTAR O ADMINISTRADOR';
            }
        } else {
            $sql = $this->db->prepare("INSERT INTO permissions SET user = :user, companies = NULL, permission_id = :perms, type = 'SYS', user_id = :user_id, reg_date = NOW()");
            $sql->bindValue(":user", $user_id);
            $sql->bindValue(":perms", $params);
            $sql->bindValue(":user_id", $_SESSION['lgUser']);
            if($sql->execute()) {
                return 'PERMISSÕES INSERIDAS COM SUCESSO';
            } else {
                return 'ERRO AO INSERIR PERMISSÕES. FAVOR CONTACTAR O ADMINISTRADOR';
            }
        }
    }

    public function verifySystemPermissions() {
        $params = array();
        $param_name = '';

        $sql = $this->db->prepare("SELECT * FROM permissions WHERE user = :user AND type = 'SYS'");
        $sql->bindValue(":user", $_SESSION['lgUser']);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $user_perm = $sql->fetch(PDO::FETCH_ASSOC);

            $params = explode(',', $user_perm['permission_id']);
        }

        return $params;
    }

}