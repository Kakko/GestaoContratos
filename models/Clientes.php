<?php
class Clientes extends Model {

    public function cad_cliente($stur_cod, $nome_cliente, $razao_social, $cnpj, $address, $neighbour, $cep, $phone, $state, $city, $email, $empresa, $data_cadastro, $user_id){

        if(empty($stur_cod)){
            $stur_cod = '0';
        }
        
        $sql = $this->db->prepare("INSERT INTO cad_clientes SET stur_cod = :stur_cod, nome_cliente = :nome_cliente, razao_social = :razao_social, cnpj = :cnpj, address = :address, neighbour = :neighbour, cep = :cep, phone = :phone, state = :state, city = :city, email = :email, empresa = :empresa, data_cadastro = :data_cadastro, user_id = :user_id");
        $sql->bindValue(":stur_cod", $stur_cod);
        $sql->bindValue(":nome_cliente", $nome_cliente);
        $sql->bindValue(":razao_social", $razao_social);
        $sql->bindValue(":cnpj", $cnpj);
        $sql->bindValue(":address", $address);
        $sql->bindValue(":neighbour", $neighbour);
        $sql->bindValue(":cep", $cep);
        $sql->bindValue(":phone", $phone);
        $sql->bindValue(":state", $state);
        $sql->bindValue(":city", $city);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":empresa", $empresa);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();
    }

    public function get_clientes(){
        $array = array();

        $sql = $this->db->prepare("SELECT cad_empresas.name AS company_name, cad_clientes.* FROM cad_clientes LEFT JOIN cad_empresas ON (cad_empresas.id = cad_clientes.empresa) ORDER BY nome_cliente ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function getClientes($id){
        $array = array();

        $sql = $this->db->prepare("SELECT cidades.cidade AS city_name, cad_clientes.* FROM cad_clientes LEFT JOIN cidades ON (cidades.id = cad_clientes.city) WHERE cad_clientes.id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
            return json_encode($array);
        } else {
            return 'Erro ao exibir';
        }
    }

    public function upd_clientes($id, $stur_cod, $nome_cliente, $razao_social, $cnpj, $address, $neighbour, $cep, $phone, $state, $city, $email, $empresa, $data_cadastro, $user_id){
        $sql = $this->db->prepare("SELECT * FROM cad_empresas WHERE name = :empresa");
        $sql->bindValue(":empresa", $empresa);
        $sql->execute();

        if($sql->rowCount() > 0){
            $dado = $sql->fetch(PDO::FETCH_ASSOC);

            $sql = $this->db->prepare("UPDATE cad_clientes SET stur_cod = :stur_cod, nome_cliente = :nome_cliente, razao_social = :razao_social, cnpj = :cnpj, address = :address, neighbour = :neighbour, cep = :cep, phone = :phone, state = :state, city = :city, email = :email, empresa = :empresa, data_cadastro = :data_cadastro, user_id = :user_id WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->bindValue(":stur_cod", $stur_cod);
            $sql->bindValue(":nome_cliente", $nome_cliente);
            $sql->bindValue(":razao_social", $razao_social);
            $sql->bindValue(":cnpj", $cnpj);
            $sql->bindValue(":address", $address);
            $sql->bindValue(":neighbour", $neighbour);
            $sql->bindValue(":cep", $cep);
            $sql->bindValue(":phone", $phone);
            $sql->bindValue(":state", $state);
            $sql->bindValue(":city", $city);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":empresa", $dado['id']);
            $sql->bindValue(":data_cadastro", $data_cadastro);
            $sql->bindValue(":user_id", $user_id);
            $sql->execute();
        }
    }

    public function delete_clientes($id){

        $sql = $this->db->prepare("DELETE FROM cad_clientes WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function get_cidades($estado){
        $array = array();
        $lista = '';

        $sql = $this->db->prepare("SELECT * FROM cidades WHERE estado_id = :estado ORDER BY cidade ASC");
        $sql->bindValue(":estado", $estado);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);

        }
            $lista .='
            <label for="city">Cidade:</label>
            <select class="form-control form-control-sm" name="city">
                <option value="">Selecionar...</option>';
                foreach($array as $c){
                    $lista.='
                    <option value="'.$c['id'].'">'.$c['cidade'].'</option>';
                }
                    $lista .='
            </select>
            ';

            return $lista;
    }
}