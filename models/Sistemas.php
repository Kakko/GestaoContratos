<?php
class Sistemas extends Model {

    public function cad_sistemas($name, $data_cadastro, $user_id){
        $sql = $this->db->prepare("INSERT INTO cad_sistemas SET name = :name, data_cadastro = :data_cadastro, user_id = :user_id");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();
    }

    public function addSystemModal($system, $data_cadastro, $user_id){
        $array = array();

        $sql = $this->db->prepare("INSERT INTO cad_sistemas SET name = :name, data_cadastro = :data_cadastro, user_id = :user_id");
        $sql->bindValue(":name", $system);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();

        $sql = $this->db->prepare("SELECT * FROM cad_sistemas");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $result ='
        <label for="system">Sistema:</label>
        <div class="input-group">
            <select class="custom-select custom-select-sm" name="system" required>
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

    public function get_systems() {
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM cad_sistemas ORDER BY name ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function getSystem($id) {
        $array = array();
        
        $sql = $this->db->prepare("SELECT * FROM cad_sistemas WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
            return json_encode($array);
        } else {
            return 'erro ao exibir';
        }
    }

    public function upd_system($id, $name, $data_cadastro, $user_id){
        $sql = $this->db->prepare("UPDATE cad_sistemas SET name = :name, data_cadastro = :data_cadastro, user_id = :user_id WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":name", $name);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();
    }

    public function delete_system($id){
        $sql = $this->db->prepare("DELETE FROM cad_sistemas WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }
}