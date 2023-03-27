<?php
class Warnings extends Model {

    private $alerts;

    public function fetchLic(){
        $licWarn = '';
        $sql = $this->db->prepare("SELECT * FROM cad_licitacao WHERE data = CURDATE() ORDER BY hora ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $licWarn = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $licWarn;
    }

    public function fetchLicWeek(){
        $licWarnWeek = '';
        $sql = $this->db->prepare("SELECT * FROM cad_licitacao WHERE data BETWEEN DATE_ADD(CURDATE(), INTERVAL 1 DAY) AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) ORDER BY data ASC, hora ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $licWarnWeek = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $licWarnWeek;
    }

    public function fetchActualCont(){
        
        $contActualWarn = array();
        // $sql = $this->db->prepare("SELECT * FROM cad_contratos WHERE fim_contrato = CURDATE()");
        $sql = $this->db->prepare("SELECT * FROM cad_contratos WHERE situacao != 'Inativo' AND CASE WHEN fim_aditivo IS NOT NULL THEN fim_aditivo = CURDATE()
        ELSE fim_contrato = CURDATE() END");
        $sql->execute();

        if($sql->rowCount() > 0){
            $contActualWarn = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $contActualWarn;
    }

    public function fetchWeekCont(){
        $contWeekWarn = [];
        $sql = $this->db->prepare("SELECT DATEDIFF(cad_contratos.fim_contrato, CURDATE()) AS diffDays, cad_contratos.* 
                                    FROM cad_contratos 
                                    WHERE situacao != 'Inativo' 
                                    AND CASE WHEN fim_aditivo IS NOT NULL THEN fim_aditivo BETWEEN DATE_ADD(CURDATE(), INTERVAL 1 DAY) AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) 
                                    ELSE fim_contrato BETWEEN DATE_ADD(CURDATE(), INTERVAL 1 DAY) AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
                                    END");
        $sql->execute();

        if($sql->rowCount() > 0){
            $contWeekWarn = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $contWeekWarn;
    }

    public function fetchMonthCont(){
        $contFurWarn = '';
        $sql = $this->db->prepare("SELECT DATEDIFF(cad_contratos.fim_contrato, CURDATE()) AS diffDays, cad_contratos.* FROM cad_contratos 
        WHERE situacao != 'Inativo' AND CASE WHEN fim_aditivo IS NOT NULL THEN fim_aditivo BETWEEN DATE_ADD(CURDATE(), INTERVAL 8 DAY) AND DATE_ADD(CURDATE(), INTERVAL 30 DAY) 
        ELSE fim_contrato BETWEEN DATE_ADD(CURDATE(), INTERVAL 8 DAY) AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
        END");
        $sql->execute();

        if($sql->rowCount() > 0){
            $contMonthWarn = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $contMonthWarn;
    }

    public function fetchDocType(){
        $docType = '';
        $sql = $this->db->prepare("SELECT (SELECT companies FROM users WHERE id = :user_id) AS company_permission, cad_empresas.name AS company_name, cad_documents.* FROM cad_documents 
                                    LEFT JOIN cad_empresas ON (cad_empresas.id = cad_documents.company)
                                    WHERE expiration_date BETWEEN DATE_ADD(CURDATE(), INTERVAL -7 DAY) AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) GROUP BY company");
        $sql->bindValue(":user_id", $_SESSION['lgUser']);
        $sql->execute();

        if($sql->rowCount() > 0){
            $docType = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $docType;
    }
    
    public function fetchDocs(){
        $docsWarn = '';
        $sql = $this->db->prepare("SELECT DATEDIFF(cad_documents.expiration_date, CURDATE()) AS venc_dias, cad_documents.* FROM cad_documents WHERE expiration_date BETWEEN DATE_ADD(CURDATE(), INTERVAL -7 DAY) AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)");
        $sql->execute();

        if($sql->rowCount() > 0){
            $docsWarn = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $docsWarn;
    }

    public function getCompanies(){
        $array = array();
        $user_id = $_SESSION['lgUser'];
        $sql = $this->db->prepare("SELECT (SELECT companies FROM users WHERE id = :user_id) AS company_permission, cad_empresas.* FROM cad_empresas 
                                    INNER JOIN cad_contratos ON(cad_empresas.id = cad_contratos.empresa)
                                    WHERE cad_contratos.fim_contrato = CURDATE()
                                    OR cad_contratos.fim_contrato BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
                                    OR cad_contratos.fim_contrato BETWEEN DATE_ADD(CURDATE(), INTERVAL 8 DAY) AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
                                    GROUP BY cad_contratos.empresa
                                    ORDER BY name ASC;");
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function exp_contracts(){
        $user_id = '';

        $sql = $this->db->prepare("SELECT * FROM exp_contratos WHERE exp_date >= now()");
        $sql->execute();

        if($sql->rowCount() > 0) {
           return $this->alerts = $sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return 'Sem Dados';
        }
    }

    public function updWarnings($id) {
        $data = '';
        $sql = $this->db->prepare("SELECT * FROM exp_contratos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $user_id = $sql->fetch(PDO::FETCH_ASSOC);
        }
       
        $user_id = $_SESSION['lgUser'].','.$user_id['user_dismissed'];

        $sql = $this->db->prepare("UPDATE exp_contratos SET user_dismissed = :user_dismissed WHERE id = :id");
        $sql->bindValue(":user_dismissed", $user_id);
        $sql->bindValue("id", $id);
        if($sql->execute()) {
            $sql = $this->db->prepare("SELECT * FROM exp_contratos WHERE exp_date >= now()");
            $sql->execute();
            
            if($sql->rowCount() > 0) {
                $warnings = $sql->fetchAll(PDO::FETCH_ASSOC);

                foreach($warnings as $pop){
                    $user_array = explode(',', $pop['user_dismissed']);
                    if(!in_array($_SESSION['lgUser'], $user_array)){
                        $data .='
                        <div class="popup">
                            <div class="highlight"></div>
                            <div class="popup_info">
                                <h5>'.$pop['n_contrato'].' expira em 5 dias</h5>
                            </div>
                            <div class="popup_action" onclick="closePop('.$pop['id'].')">
                                <button class="btn"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        ';
                    }
                }

                return $data;
            } else {
                return 'Sem Dados';
            }
            
        }
    }
}
