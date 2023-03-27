<?php
class Utils extends Model {

    public function getCompanyNumber(){
        $sql = $this->db->prepare("SELECT * FROM cad_empresas");
        $sql->execute();

        if($sql->rowCount() > 0){
            $company_number = $sql->rowCount();
            return $company_number; 
        } else {
            return '0';
        }
    }

    public function getSystemNumber(){
        $sql = $this->db->prepare("SELECT * FROM cad_sistemas");
        $sql->execute();

        if($sql->rowCount() > 0){
            $system_number = $sql->rowCount();
            return $system_number; 
        } else {
            return '0';
        }
    }

    public function getAgenciesNumber(){
        $sql = $this->db->prepare("SELECT * FROM cad_orgaos");
        $sql->execute();

        if($sql->rowCount() > 0){
            $sector_number = $sql->rowCount();
            return $sector_number; 
        } else {
            return '0';
        }
    }

    public function getProdutosNumber(){
        $sql = $this->db->prepare("SELECT * FROM cad_produtos");
        $sql->execute();

        if($sql->rowCount() > 0){
            $produtos_number = $sql->rowCount();
            return $produtos_number; 
        } else {
            return '0';
        }
    }

    public function getClientsNumber(){
        $sql = $this->db->prepare("SELECT * FROM cad_clientes");
        $sql->execute();

        if($sql->rowCount() > 0){
            $clients_number = $sql->rowCount();
            return $clients_number; 
        } else {
            return '0';
        }
    }

    public function getCidades(){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM cidades ORDER BY cidade ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function getEstados(){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM estados ORDER BY estado ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function get_cidades($estado){
        $array = array();
        $lista = '';

        $sql = $this->db->prepare("SELECT * FROM cidades WHERE estado = :estado ORDER BY cidade ASC");
        $sql->bindValue(":estado", $estado);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);

            $lista .='
            <label for="city">Cidade:</label>
            <select class="form-control form-control-sm" name="city">
                <option value="">Selecionar...</option>';
                foreach($array as $c){
                    $lista.='
                    <option value="'.$c['cidade'].'">'.$c['cidade'].'</option>';
                }
                     $lista .='
            </select>
            ';
        } else {
            $lista .='
            <label for="city">Cidade:</label>
            <select class="form-control form-control-sm" name="city">
                <option value="">ERRO AO BUSCAR DADOS DO BANCO</option>
            </select>
            ';
        }
        
        return $lista;

    }

    public function cod_stur($id){
        $array = array();

        $sql = $this->db->prepare("SELECT id FROM cad_clientes WHERE nome_cliente = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $client_info = $sql->fetch(PDO::FETCH_ASSOC);
            $id = $client_info['id'];
        }
        
        $sql = $this->db->prepare("SELECT cad_empresas.name AS company_name, cad_empresas.id AS empresa_id, cad_clientes.stur_cod, cad_clientes.razao_social, cad_clientes.cnpj, cad_clientes.empresa 
                                    FROM cad_clientes
                                    LEFT JOIN cad_empresas ON (cad_empresas.id = cad_clientes.empresa) 
                                    WHERE cad_clientes.id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }
        return json_encode($array);
    }

    public function get_cnpj($empresa){
        $array = array();

        $sql = $this->db->prepare("SELECT cnpj FROM cad_empresas WHERE name = :empresa");
        $sql->bindValue(":empresa", $empresa);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }
        return json_encode($array);
    }



}