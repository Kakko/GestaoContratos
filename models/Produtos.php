<?php
class Produtos extends Model {

    public function cad_produtos($name, $data_cadastro, $user_id){

        $sql = $this->db->prepare("INSERT INTO cad_produtos SET name = :name, data_cadastro = :data_cadastro, user_id = :user_id");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();
    }

    public function get_produtos() {
        $array = array();
    
        $sql = $this->db->prepare("SELECT * FROM cad_produtos ORDER BY name ASC");
        $sql->execute();
    
        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }
    
    public function getProdutos($id) {
        $array = array();
        
        $sql = $this->db->prepare("SELECT * FROM cad_produtos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    
        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
            return json_encode($array);
        } else {
            return 'erro ao exibir';
        }
    }
    
    public function upd_Produtos($id, $name, $data_cadastro, $user_id){
        $sql = $this->db->prepare("UPDATE cad_produtos SET name = :name, data_cadastro = :data_cadastro, user_id = :user_id WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":name", $name);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();
    }
    
    public function delete_produtos($id){
        $sql = $this->db->prepare("DELETE FROM cad_produtos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }
}

