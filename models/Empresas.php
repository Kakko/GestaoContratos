<?php
class Empresas extends Model {

    public function cad_empresa($name, $email, $cnpj, $address1, $address2, $city, $uf, $phone1, $phone2, $contact_name, $tipo, $data_cadastro, $user_id){

        $sql = $this->db->prepare("SELECT * FROM cad_empresas WHERE name = :name");
        $sql->bindValue(":name", $name);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }
        
        if($name !== $array['name']){
            $sql = $this->db->prepare("INSERT INTO cad_empresas SET name = :name, email = :email, cnpj = :cnpj, address1 = :address1, address2 = :address2, city = :city, uf = :uf, phone1 = :phone1, phone2 = :phone2, contact_name = :contact_name, tipo = :tipo, data_cadastro = :data_cadastro, user_id = :user_id");
            $sql->bindValue(":name", $name);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":cnpj", $cnpj);
            $sql->bindValue(":address1", $address1);
            $sql->bindValue(":address2", $address2);
            $sql->bindValue(":city", $city);
            $sql->bindValue(":uf", $uf);
            $sql->bindValue(":phone1", $phone1);
            $sql->bindValue(":phone2", $phone2);
            $sql->bindValue(":contact_name", $contact_name);
            $sql->bindValue(":tipo", $tipo);
            $sql->bindValue(":data_cadastro", $data_cadastro);
            $sql->bindValue(":user_id", $user_id);
            $sql->execute();
        } else {
            return 'Empresa já cadastrada';
        }

    }

    public function getCompanies(){
        $array = array();

        $sql = $this->db->prepare("SELECT (SELECT companies FROM users WHERE users.id = :userID) AS company_permission,  cad_empresas.* FROM cad_empresas ORDER BY name ASC");
        $sql->bindValue(":userID", $_SESSION['lgUser']);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function getdbCompanies(){
        $array = array();

        $sql = $this->db->prepare("SELECT(SELECT companies FROM users WHERE users.id = :userID) AS company_permission, cad_empresas.* FROM cad_empresas WHERE db_host != ''");
        $sql->bindValue(":userID", $_SESSION['lgUser']);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function getCompany($id){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM cad_empresas WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
            return json_encode($array);
        } else {
            return 'Erro ao Exibir';
        }
    }
    public function upd_empresa($id, $name, $email, $cnpj, $address1, $address2, $city, $uf, $phone1, $phone2, $contact_name, $tipo, $data_cadastro, $user_id){
        $sql = $this->db->prepare("UPDATE cad_empresas SET name = :name, email = :email, cnpj = :cnpj, address1 = :address1, address2 = :address2, city = :city, uf = :uf, phone1 = :phone1, phone2 = :phone2, contact_name = :contact_name, tipo = :tipo, data_cadastro = :data_cadastro, user_id = :user_id WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":name", $name);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":cnpj", $cnpj);
        $sql->bindValue(":address1", $address1);
        $sql->bindValue(":address2", $address2);
        $sql->bindValue(":city", $city);
        $sql->bindValue(":uf", $uf);
        $sql->bindValue(":phone1", $phone1);
        $sql->bindValue(":phone2", $phone2);
        $sql->bindValue(":contact_name", $contact_name);
        $sql->bindValue(":tipo", $tipo);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();
    }

    public function delete_empresa($id){
        $sql = $this->db->prepare("DELETE FROM cad_empresas WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function winner_company(){
        $array = array();
        $sql = $this->db->prepare("SELECT * FROM cad_wcompany ORDER BY name ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function cadWinnerCompany($wcompany, $data_cadastro, $user_id){
        $sql = $this->db->prepare("INSERT INTO cad_wcompany SET name = :name, data_cadastro = :data_cadastro, user_id = :user_id");
        $sql->bindValue(":name", $wcompany);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();

        $sql = $this->db->prepare("SELECT * FROM cad_wcompany");
        $sql->execute();

        if($sql->rowCount() > 0){
            $company = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $dados = '
        <div class="input-group">
            <select class="custom-select custom-select-sm" name="winner_company" required>
                <option value="">Selecione...</option>';
                foreach($company as $data){
                    $dados .='
                    <option>'.$data['name'].'</option>';
                }
                    $dados .='
            </select>
            <div class="input-group-append">
                <button class="btn btn-success btn-sm" type="button" onclick="addWinnerCompany()"><i class="fas fa-plus"></i></button>
            </div>
        </div>
        ';

        return $dados;
    }

    public function setWinnerCompany($winner_company, $winner_value, $winner_perc, $licitacao_id, $data_cadastro, $user_id){
        $sql = $this->db->prepare("INSERT INTO cad_empresas_vencedoras SET name = :name, value = :value, perc = :winner_perc, licitacao_id = :licitacao_id, data_cadastro = :data_cadastro, user_id = :user_id");
        $sql->bindValue(":name", $winner_company);
        $sql->bindValue(":value", $winner_value);
        $sql->bindValue(":winner_perc", $winner_perc);
        $sql->bindValue(":licitacao_id", $licitacao_id);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();

        $sql = $this->db->prepare("SELECT * FROM cad_empresas_vencedoras WHERE licitacao_id = :licitacao_id");
        $sql->bindValue(":licitacao_id", $licitacao_id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $dados = '';
        foreach($array as $data){
            $dados .='
            <tr>
                <th style="font-weight: normal">'.$data['name'].'</th>
                <th style="font-weight: normal">'.$data['value'].'</th>
                <th style="font-weight: normal">'.$data['perc'].'</th>
                <th hidden><input type="text" name="licitacao_id" value="'.$data['licitacao_id'].'"></th>
                <td><button type="button" class="btn btn-outline-danger" onclick="delete_winner('.$data['id'].')" style="text-align: center"><i class="fas fa-trash"></i></button></td>
            </tr>
            ';
        }
        return $dados;

    }

    public function delete_winner($id, $licitacao_id){
        $array = array();
        $sql = $this->db->prepare("DELETE FROM cad_empresas_vencedoras WHERE id = :id");
        $sql->bindValue("id", $id);
        $sql->execute();

        $sql = $this->db->prepare("SELECT * FROM cad_empresas_vencedoras WHERE licitacao_id = :licitacao_id");
        $sql->bindValue(":licitacao_id", $licitacao_id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $dados = '';
        foreach($array as $data){
            $dados .='';
            if(!empty($data['name'])){
                $dados .='
                <tr>
                    <th style="font-weight: normal">'.$data['name'].'</th>
                    <th style="font-weight: normal">'.$data['value'].'</th>
                    <th style="font-weight: normal">'.$data['perc'].'</th>
                    <th hidden><input type="text" name="licitacao_id" value="'.$data['licitacao_id'].'"></th>
                    <td><button type="button" class="btn btn-outline-danger" onclick="delete_winner('.$data['id'].')" style="text-align: center"><i class="fas fa-trash"></i></button></td>
                </tr>';
            } else {
                $dados .='
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                ';
            }
            $dados .='';
        }
        return $dados;
    }



}