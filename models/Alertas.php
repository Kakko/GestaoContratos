<?php
 
class Alertas extends Model {

    public function returnAlerta(){
        $sql = $this->db->prepare("SELECT horario_licitacao.id AS horario_id, horario_licitacao.*, cad_licitacao.* FROM horario_licitacao LEFT JOIN cad_licitacao ON(horario_licitacao.licitacao_id = cad_licitacao.id) WHERE horario_licitacao.data = CURDATE() AND (visualizado = 'N' AND adiado = 'N' AND acompanhar = 'N')");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);

            $aviso ='';
            foreach($array as $info){
                $aviso .='
                <div id="aviso_licitacao">
                    Início da Licitação nº - '.$info['auction'].' às '.$info['horario'].'<button onclick="ok_licitacao('.$info['horario_id'].')">Fechar</button><button onclick="adiar_licitacao('.$info['horario_id'].')">Adiar</button><br/>
                </div>';
            }
            $aviso .='
        ';
        return $aviso;

        } else {
            $aviso = '';
            return $aviso;
        }
    }   

    public function okAlerta($id){
        $sql = $this->db->prepare("UPDATE horario_licitacao SET visualizado = 'S' WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        $sql = $this->db->prepare("SELECT horario_licitacao.id AS horario_id, horario_licitacao.*, cad_licitacao.* FROM horario_licitacao LEFT JOIN cad_licitacao ON(horario_licitacao.licitacao_id = cad_licitacao.id) WHERE horario_licitacao.data = CURDATE() AND (visualizado = 'N' AND adiado = 'N' AND acompanhar = 'N')");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);

            $aviso ='';
            foreach($array as $info){
                $aviso .='
                <div id="aviso_licitacao">
                    Início da Licitação nº - '.$info['auction'].' às '.$info['horario'].'<button onclick="ok_licitacao('.$info['horario_id'].')">Fechar</button><button onclick="adiar_licitacao('.$info['horario_id'].')">Adiar</button><br/>
                </div>';
                
            }
            $aviso .='
        ';
        
        return $aviso;

        } else {
            $aviso = '';

            return $aviso;
        }
    }

    public function adiarAlerta($id){
        $sql = $this->db->prepare("UPDATE horario_licitacao SET adiado = 'S' WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        $sql = $this->db->prepare("SELECT horario_licitacao.id AS horario_id, horario_licitacao.*, cad_licitacao.* FROM horario_licitacao LEFT JOIN cad_licitacao ON(horario_licitacao.licitacao_id = cad_licitacao.id) WHERE horario_licitacao.data = CURDATE() AND (visualizado = 'N' AND adiado = 'N' AND acompanhar = 'N')");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);

            $aviso ='';
            foreach($array as $info){
                $aviso .='
                <div id="aviso_licitacao">
                    Início da Licitação nº - '.$info['auction'].' às '.$info['horario'].'<button onclick="ok_licitacao('.$info['horario_id'].')">Fechar</button><button onclick="adiar_licitacao('.$info['horario_id'].')">Adiar</button><br/>
                </div>';
            }
            $aviso .='
        ';
        
        return $aviso;

        } else {
            $aviso = '';

            return $aviso;
        }
    }

    public function licitacoes_adiadas() {
        $sql = $this->db->prepare("SELECT horario_licitacao.id AS horario_id, horario_licitacao.*, cad_licitacao.* FROM horario_licitacao LEFT JOIN cad_licitacao ON(horario_licitacao.licitacao_id = cad_licitacao.id) WHERE horario_licitacao.data = CURDATE() AND (adiado = 'S' AND visualizado = 'N' AND acompanhar = 'N') AND TIMEDIFF(CURTIME(), horario) < '-00:30:00'");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);

            $aviso ='';
            foreach($array as $info){
                $aviso .='
                <div id="adiados_licitacao">
                    Início da Licitação nº - '.$info['auction'].' às '.$info['horario'].'<button onclick="fechar_adiados('.$info['horario_id'].')">Fechar</button><button onclick="acompanhar_adiados('.$info['horario_id'].')">Seguir</button><br/>
                </div> ';
            }
            $aviso .='
        ';
        
            return $aviso;  
        }
    }

    public function fechar_adiados($id) {
        $sql = $this->db->prepare("UPDATE horario_licitacao SET visualizado = 'S' WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        $sql = $this->db->prepare("SELECT horario_licitacao.id AS horario_id, horario_licitacao.*, cad_licitacao.* FROM horario_licitacao LEFT JOIN cad_licitacao ON(horario_licitacao.licitacao_id = cad_licitacao.id) WHERE horario_licitacao.data = CURDATE() AND (adiado = 'S' AND visualizado = 'N' AND acompanhar = 'N')");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            $aviso ='';
            foreach($array as $info){
                $aviso .='
                <div id="adiados_licitacao">
                    Início da Licitação nº - '.$info['auction'].' às '.$info['horario'].'<button onclick="fechar_adiados('.$info['horario_id'].')">Fechar</button><button onclick="acompanhar_adiados('.$info['horario_id'].')">Seguir</button><br/>
                </div> ';
            }
            $aviso .='
        ';
        
            return $aviso;  
        }
    }

    public function acompanhar_adiado($id){
        $sql = $this->db->prepare("UPDATE horario_licitacao SET acompanhar = 'S' WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        $sql = $this->db->prepare("SELECT horario_licitacao.id AS horario_id, horario_licitacao.*, cad_licitacao.* FROM horario_licitacao LEFT JOIN cad_licitacao ON(horario_licitacao.licitacao_id = cad_licitacao.id) WHERE horario_licitacao.data = CURDATE() AND (adiado = 'S' AND visualizado = 'N' AND acompanhar = 'N')");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            $aviso ='';
            foreach($array as $info){
                $aviso .='
                <div id="adiados_licitacao">
                    Início da Licitação nº - '.$info['auction'].' às '.$info['horario'].'<button onclick="fechar_adiados('.$info['horario_id'].')">Fechar</button><button onclick="acompanhar_adiados('.$info['horario_id'].')">Seguir</button><br/>
                </div> ';
            }
            $aviso .='
        ';
        
            return $aviso;  
        }
    }

    public function inicio_licitacao(){
        $sql = $this->db->prepare("SELECT horario_licitacao.id AS horario_id, horario_licitacao.*, cad_licitacao.* FROM horario_licitacao LEFT JOIN cad_licitacao ON(horario_licitacao.licitacao_id = cad_licitacao.id) WHERE horario_licitacao.data = CURDATE() AND (adiado = 'S' AND visualizado = 'N' AND acompanhar = 'S') AND TIMEDIFF(CURTIME(), horario) < '-00:10:00'");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            $aviso ='';
            foreach($array as $info){
                $aviso .='
                <div id="inicio_licitacao">
                    A Licitação de nº - '.$info['auction'].' está prestes a iniciar às '.$info['horario'].'<button onclick="fechar_adiados('.$info['horario_id'].')">OK</button><br/>
                </div> ';
            }
            $aviso .='
        ';
        
            return $aviso;  
        }
    }
}