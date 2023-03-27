<?php
class Orgaos extends Model {

    public function cad_orgao($name, $data_cadastro, $user_id){

        $sql = $this->db->prepare("SELECT * FROM cad_orgaos WHERE name = :name");
        $sql->bindValue(":name", $name);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }
        if($name !== $array['name']){
            $sql = $this->db->prepare("INSERT INTO cad_orgaos SET name = :name, data_cadastro = :data_cadastro, user_id = :user_id");
            $sql->bindValue(":name", $name);
            $sql->bindValue(":data_cadastro", $data_cadastro);
            $sql->bindValue(":user_id", $user_id);
            $sql->execute();
        } else {
            return 'Sem Resultados';
        }

    }

    public function addOrgaoModal($orgao, $data_cadastro, $user_id){
        $array = array();

        $sql = $this->db->prepare("INSERT INTO cad_orgaos SET name = :name, data_cadastro = :data_cadastro, user_id = :user_id");
        $sql->bindValue(":name", $orgao);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();

        $sql = $this->db->prepare("SELECT * FROM cad_orgaos");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $result ='
            <label for="orgaos">Órgão:</label>
            <div class="input-group">
                <select class="custom-select custom-select-sm" name="agency" required>
                    <option value="">Selecione...</option>';
                    foreach($array as $s){
                        $result .='
                            <option>'.$s['name'].'</option>';
                        }
                        $result .='
                </select>
                <div class="input-group-append">
                    <button class="btn btn-outline-success btn-sm" type="button" onclick="addSystem()" id="closeModal"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            ';
        return $result;
    }

    public function get_orgaos(){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM cad_orgaos ORDER BY name ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function getOrgao($id){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM cad_orgaos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
            return json_encode($array);
        } else {
            return 'Erro ao exibir';
        }
    }

    public function upd_orgao($id, $name, $data_cadastro, $user_id){
        $sql = $this->db->prepare("UPDATE cad_orgaos SET name = :name, data_cadastro = :data_cadastro, user_id = :user_id WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":name", $name);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();
    }

    public function delete_orgao($id){

        $sql = $this->db->prepare("DELETE FROM cad_orgaos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function searchAgency($agency){
        $data = '';
        $sql = $this->db->prepare("SELECT * FROM cad_orgaos WHERE name LIKE :agency ORDER BY name");
        $sql->bindValue(":agency", '%'.$agency.'%');
        $sql->execute();

        if($sql->rowCount() > 0){
            $result = $sql->fetchAll(PDO::FETCH_ASSOC);

            $data .='';
            foreach($result as $res){
                $data .='
                    <div class="agencyResult" onclick="selectAgency('.$res['id'].')">'.$res['name'].'</div>
                ';
            }
        }

        return $data;
    }

    public function setAgency($id){
        $sql = $this->db->prepare("SELECT name from cad_orgaos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);
        }

        return $data['name'];
    }
}