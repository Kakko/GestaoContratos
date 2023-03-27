<?php
class Documents extends Model {



    public function getDocuments() {
        $data = array();

        $sql = $this->db->prepare("SELECT (SELECT companies FROM users WHERE id = :userID) as company_permission, DATEDIFF(cad_documents.expiration_date, NOW()) AS diff, cad_empresas.name AS company_name, cad_documents.* FROM cad_documents 
        LEFT JOIN cad_empresas ON (cad_documents.company = cad_empresas.id)
        ORDER BY issue_date");
        $sql->bindValue(":userID", $_SESSION['lgUser']);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $data;
    }

    //ADD NEW DOCUMENT
    public function addNewDoc($company, $category, $doctype, $address, $issue_date, $expiration_date, $expiration_day, $value, $state, $city, $n_copy, $description, $doc_file, $data_cadastro, $user_id){
        $sql = $this->db->prepare("INSERT INTO cad_documents SET company = :company, category = :category, doctype = :doctype, address = :address, issue_date = :issue_date, expiration_date = :expiration_date, expiration_day = :expiration_day, value = :value, state = :state, city = :city, n_copy = :n_copy, description = :description, data_cadastro = :data_cadastro, user_id = :user_id");
  
        $sql->bindValue(":company", $company);
        $sql->bindValue(":category", $category);
        $sql->bindValue(":doctype", $doctype);
        $sql->bindValue(":address", $address);
        $sql->bindValue(":issue_date", $issue_date);
        if(empty($expiration_date)){ 
            $expiration_date = NULL;
        }
        $sql->bindValue(":expiration_date", $expiration_date);
        $sql->bindValue(":expiration_day", $expiration_day);
        $sql->bindValue(":value", $value);
        $sql->bindValue(":state", $state);
        $sql->bindValue(":city", $city);
        $sql->bindValue(":n_copy", $n_copy);
        $sql->bindValue(":description", $description);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();

        $document_id = $this->db->lastInsertId();

        if(!empty($doc_file)){
            if(count($doc_file['tmp_name']) > 0){
                for($i=0;$i<count($doc_file['tmp_name']);$i++){
                    $doc_name = $doc_file['name'][$i];
                    $ext = strtolower(substr($_FILES['doc_file']['name'][$i],-4)); //Pegando extensão do arquivo
                    $new_name = md5(time(). rand(0,999)) . $ext; //Definindo um novo nome para o arquivo
                    $dir = './documentos/'; //Diretório para uploads

                    move_uploaded_file($doc_file['tmp_name'][$i], $dir.$new_name);

                    $sql = $this->db->prepare("INSERT INTO doc_arquivos SET name = :doc_name, url = :url, document_id = :document_id, data_cadastro = :data_cadastro, user_id = :user_id");
                    $sql->bindValue(":doc_name", $doc_name);
                    $sql->bindValue(":url", $new_name);
                    $sql->bindValue(":document_id", $document_id);
                    $sql->bindValue(":data_cadastro", $data_cadastro);
                    $sql->bindValue(":user_id", $user_id);
                    $sql->execute();
                }
            }
        } 
    }

    // ADD A COPY
    public function addCopy($id){
        $sql = $this->db->prepare("SELECT * FROM cad_documents WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);
        }
        
        $n_copy = $data['n_copy'] + 1;

        $sql = $this->db->prepare("UPDATE cad_documents SET n_copy = :n_copy WHERE id = :id");
        $sql->bindValue(":n_copy", $n_copy);
        $sql->bindValue(":id", $id);
        $sql->execute();

        $sql = $this->db->prepare("SELECT n_copy FROM cad_documents WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $new = $sql->fetch(PDO::FETCH_ASSOC);
        }

        $result ='
        <button class="btn btn-outline-success btn-sm" id="button_plus" onclick="addCopy('.$data['id'].')"><i class="fas fa-plus"></i></button>
            '.$new['n_copy'].'
        <button class="btn btn-outline-danger btn-sm" id="button_minus" onclick="removeCopy('.$data['id'].')"><i class="fas fa-minus"></i></button>
        ';

        return $result;
    }

    // REMOVE A COPY
    public function removeCopy($id){
        $sql = $this->db->prepare("SELECT * FROM cad_documents WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);
        }
        
        $n_copy = $data['n_copy'] - 1;

        $sql = $this->db->prepare("UPDATE cad_documents SET n_copy = :n_copy WHERE id = :id");
        $sql->bindValue(":n_copy", $n_copy);
        $sql->bindValue(":id", $id);
        $sql->execute();

        $sql = $this->db->prepare("SELECT n_copy FROM cad_documents WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $new = $sql->fetch(PDO::FETCH_ASSOC);
        }

        $result ='
        <button class="btn btn-outline-success btn-sm" id="button_plus" onclick="addCopy('.$data['id'].')"><i class="fas fa-plus"></i></button>
            '.$new['n_copy'].'
        <button class="btn btn-outline-danger btn-sm" id="button_minus" onclick="removeCopy('.$data['id'].')"><i class="fas fa-minus"></i></button>
        ';

        return $result;
    }

    //FETCH A DOCUMENT BASED ON ID
    public function getDoc($id){
        $users = new Users();
        $view = '';
        $sql = $this->db->prepare("SELECT cad_empresas.name AS company_name, cad_documents.* FROM cad_documents 
                                    LEFT JOIN cad_empresas ON (cad_documents.company = cad_empresas.id)
                                    WHERE cad_documents.id = :id ORDER BY issue_date");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $doc = $sql->fetch(PDO::FETCH_ASSOC);
        }

        $sql = $this->db->prepare("SELECT * FROM doc_arquivos WHERE document_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $files = $sql->fetch(PDO::FETCH_ASSOC);
        }

        $sql = $this->db->prepare("SELECT * FROM doc_arquivos WHERE document_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $files = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $view = '
        <div class="row">
            <div class="col-sm">
                <label>Empresa:</label>
                <input type="text" class="exib_dados" value="'.$doc['company_name'].'">
            </div>
            <div class="col-sm">
                <label>Categoria</label>
                <input type="text" class="exib_dados" value="'.$doc['category'].'">
            </div>
            <div class="col-sm">
                <label>Tipo Documento</label>
                <input type="text" class="exib_dados" value="'.$doc['doctype'].'">
            </div>
            <div class="col-sm">
                <label>Endereço</label>
                <input type="text" class="exib_dados" value="'.$doc['address'].'">
            </div>
        </div>
        <br/><hr/>
        <div class="row">
            <div class="col-sm">
                <label>Data de Emissão</label>
                <input type="text" class="exib_dados" value="'.date("d/m/Y", strtotime($doc['issue_date'])).'">
            </div>
            <div class="col-sm">
                <label>Data de Validade</label>';
                if(!empty($doc['expiration_date'])){
                    $view .='
                    <input type="text" class="exib_dados" value="'.date("d/m/Y", strtotime($doc['expiration_date'])).'">';
                } else {
                    $view .='
                    <input type="text" class="exib_dados" value="Sem Validade">';
                }
                $view .='
            </div>';
            if($doc['expiration_day'] !== '0'){
                $view .='
                <div class="col-sm">
                    <label>Validade - Dias</label>
                    <input type="text" name="expiration_day" class="exib_dados" value="'.$doc['expiration_day'].'">
                </div>
                ';
            }
            $view .='
            <div class="col-sm">
                <label>Valor</label>
                <input type="text" class="exib_dados" value="R$ '.number_format($doc['value'],2,',','.').'">
            </div>
            <div class="col-sm">
                <label>Estado</label>
                <input type="text" class="exib_dados" value="'.$doc['state'].'">
            </div>
            <div class="col-sm" id="docCity">
                <label>Cidade</label>
                <input type="text" class="exib_dados" value="'.$doc['city'].'">
            </div>
            <div class="col-sm">
                <label>Qtd Cópias</label>
                <input type="text" class="exib_dados" value="'.$doc['n_copy'].'">
            </div>
        </div>
        <br/><hr/>
        <div class="row">
            <div class="col-sm">
                <label>Descrição</label>
                <input type="text" class="exib_dados" value="'.$doc['description'].'">
            </div>
        </div>
        <br/><hr/>
        <div class="row">
            <div class="col-sm">
                <label>Arquivos Enviados</label>
                <table class="table table-striped table-hover table-sm" id="table_licitacoes" style="font-size: 12px">
                    <thead class="thead-light">
                        <tr>
                            <th>Nome do Arquivo</th>
                            <th>Data de Cadastro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                <tbody style="font-size: 12px">';
                    if(!empty($files)){
                        foreach($files as $file){
                            $view .='
                                <tr>
                                    <td>'.$file['name'].'</td>
                                    <td>'.$file['data_cadastro'].'</td>
                                    <td>
                                        <a href="'.BASE_URL.'documentos/'.$file['url'].'" target="_blank"><button type="button" class="btn btn-outline-info btn-sm"><i class="fas fa-paperclip"></i></button></a>';
                                        if($users->hasPermission('Cadastrar_documentos')){
                                            $view .='
                                            <button class="btn btn-outline-danger btn-sm" onclick="deleteFile('.$file['id'].', this)"><i class="fas fa-trash"></i></button>
                                            ';
                                        } else {
                                            $view .='
                                            <button class="btn btn-outline-secondary btn-sm" disabled><i class="fas fa-trash"></i></button>
                                            ';
                                        }
                                        $view .='
                                        
                                    </td>
                                </tr>
                            ';
                        }
                    }
                    $view .='
                </tbody>
            </table>
            </div>  
        </div>
        ';

        return $view;
    }

    public function editDocs($id){
        $edit = '';

        $sql = $this->db->prepare("SELECT cad_empresas.name AS company_name, cad_documents.* FROM cad_documents 
                                    LEFT JOIN cad_empresas ON (cad_empresas.id = cad_documents.company)
                                    WHERE cad_documents.id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $doc = $sql->fetch(PDO::FETCH_ASSOC);
        }

        $sql = $this->db->prepare("SELECT * FROM cad_empresas ORDER BY name ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $companies = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $sql = $this->db->prepare("SELECT * FROM doc_categoria ORDER BY name ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $category = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $sql = $this->db->prepare("SELECT * FROM doc_tipo ORDER BY name ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $doctype = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $sql = $this->db->prepare("SELECT * FROM estados ORDER BY estado");
        $sql->execute();

        if($sql->rowCount() > 0){
            $states = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $edit .= '
        <input type="text" value="att_doc" name="doc_action" hidden>
        <input type="text" value="'.$doc['id'].'" name="id" hidden>
        <div class="row">
            <div class="col-sm">
                <label>Empresa:</label>
                <select class="form-control form-control-sm" name="company" required>
                    <option value="'.$doc['company'].'">'.$doc['company_name'].'</option>
                    <option disabled></option>';
                        foreach($companies as $company){
                            $edit .='
                                <option value="'.$company['id'].'">'.$company['name'].'</option>
                            ';
                        }
                    $edit .='
                </select>
            </div>
            <div class="col-sm" id="editCategories">
                <label>Categoria</label>
                <div class="input-group">
                    <select class="custom-select custom-select-sm" name="category">
                        <option>'.$doc['category'].'</option>';
                        foreach($category as $cat){
                            $edit .='
                                <option>'.$cat['name'].'</option>
                            ';
                        }
                        $edit .='
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-success btn-sm" type="button" onclick="editCategory()"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-sm" id="editDocType">
                <label>Tipo Documento</label>
                <div class="input-group">
                    <select class="custom-select custom-select-sm" name="edit_doctype">
                        <option>'.$doc['doctype'].'</option>';
                        foreach($doctype as $type){
                            $edit .='
                                <option>'.$type['name'].'</option>
                            ';
                        }
                        $edit .='
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-success btn-sm" type="button" onclick="editDocType()"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <label>Endereço</label>
                <input type="text" name="address" class="form-control form-control-sm" value="'.$doc['address'].'">
            </div>
        </div>
        <br/><hr/>
        <div class="row">
            <div class="col-sm">
                <label>Data de Emissão</label>
                <input type="date" name="issue_date" class="form-control form-control-sm" value="'.$doc['issue_date'].'">
            </div>
            <div class="col-sm">
                <label>Validade - Data</label>
                <input type="date" name="expiration_date" class="form-control form-control-sm" value="'.$doc['expiration_date'].'">
            </div>
            <div class="col-sm">
                <label>Validade - Dias</label>
                <input type="text" name="expiration_day" class="form-control form-control-sm" value="'.$doc['expiration_day'].'">
            </div>
            <div class="col-sm">
                <label>Valor</label>
                <input type="text" name="value" class="form-control form-control-sm" value="'.$doc['value'].'">
            </div>
            <div class="col-sm">
                <label>Estado</label>
                <select class="form-control form-control-sm" name="state" onchange="showCities()" required>
                    <option>'.$doc['state'].'</option>';
                    foreach($states as $state){
                        $edit .='
                            <option>'.$state['estado'].'</option>';
                    }
                    $edit .='                   
                </select>
            </div>
            <div class="col-sm" id="docCity">
                <label>Cidade</label>
                <select class="form-control form-control-sm" name="city" required readonly>
                    <option>'.$doc['city'].'</option>
                </select>
            </div>
            <div class="col-sm">
                <label>Qtd Cópias</label>
                <input type="text" name="n_copy" class="form-control form-control-sm" value="'.$doc['n_copy'].'">
            </div>
        </div>
        <br/><hr/>
        <div class="row">
            <div class="col-sm">
                <label>Descrição</label>
                <input type="text" name="description" class="form-control form-control-sm" value="'.$doc['description'].'">
            </div>
        </div>
        <br/><hr/>
            <div class="row">
                <div class="col-sm-3">
                    <label>Anexar Arquivos</label>
                    <input type="file" name="doc_file[]" multiple>
                </div>
            </div>
        <br/><hr/>
        <div class="row">
            <div class="col-sm">
                <label>Arquivos Enviados</label>
                <table class="table table-striped table-hover table-sm" id="table_licitacoes" style="font-size: 12px">
                    <thead class="thead-light">
                        <tr>
                            <th>Nome do Arquivo</th>
                            <th>Data de Cadastro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                <tbody style="font-size: 12px">';
                    if(!empty($files)){
                        foreach($files as $file){
                            $edit .='
                                <tr>
                                    <td>'.$file['name'].'</td>
                                    <td>'.$file['data_cadastro'].'</td>
                                    <td>
                                        <a href="'.BASE_URL.'documentos/'.$file['url'].'" target="_blank"><button type="button" class="btn btn-outline-info btn-sm"><i class="fas fa-paperclip"></i></button></a>
                                        <button class="btn btn-outline-danger btn-sm" onclick="deleteFile('.$file['id'].', this)"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            ';
                        }
                    }
                    $edit .='
                </tbody>
            </table>
            </div>  
        </div>
        ';

        return $edit;
    }

    public function attDoc($id, $company, $category, $doctype, $address, $issue_date, $expiration_date, $expiration_day, $value, $state, $city, $n_copy, $description, $doc_file, $data_cadastro, $user_id){
        
        $sql = $this->db->prepare("UPDATE cad_documents SET company = :company, category = :category, doctype = :doctype, address = :address, issue_date = :issue_date, expiration_date = :expiration_date, expiration_day = :expiration_day, value = :value, state = :state, city = :city, n_copy = :n_copy, description = :description WHERE id = :id");
  
        $sql->bindValue(":id", $id);
        $sql->bindValue(":company", $company);
        $sql->bindValue(":category", $category);
        $sql->bindValue(":doctype", $doctype);
        $sql->bindValue(":address", $address);
        $sql->bindValue(":issue_date", $issue_date);
        if(empty($expiration_date)){ 
            $expiration_date = NULL;
        }
        $sql->bindValue(":expiration_date", $expiration_date);
        $sql->bindValue(":expiration_day", $expiration_day);
        $sql->bindValue(":value", $value);
        $sql->bindValue(":state", $state);
        $sql->bindValue(":city", $city);
        $sql->bindValue(":n_copy", $n_copy);
        $sql->bindValue(":description", $description);
        $sql->execute();

        if(!empty($doc_file)){
            if(count($doc_file['tmp_name']) > 0){
                for($i=0;$i<count($doc_file['tmp_name']);$i++){
                    $doc_name = $doc_file['name'][$i];
                    $ext = strtolower(substr($_FILES['doc_file']['name'][$i],-4)); //Pegando extensão do arquivo
                    $new_name = md5(time(). rand(0,999)) . $ext; //Definindo um novo nome para o arquivo
                    $dir = './documentos/'; //Diretório para uploads

                    move_uploaded_file($doc_file['tmp_name'][$i], $dir.$new_name);

                    $sql = $this->db->prepare("INSERT INTO doc_arquivos SET name = :doc_name, url = :url, document_id = :document_id, data_cadastro = :data_cadastro, user_id = :user_id");
                    $sql->bindValue(":doc_name", $doc_name);
                    $sql->bindValue(":url", $new_name);
                    $sql->bindValue(":document_id", $id);
                    $sql->bindValue(":data_cadastro", $data_cadastro);
                    $sql->bindValue(":user_id", $user_id);
                    $sql->execute();
                }
            }
        } 
    }

    public function deleteDoc($id) {
        $sql = $this->db->prepare("DELETE FROM cad_documents WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        $sql = $this->db->prepare("SELECT * FROM doc_arquivos WHERE document_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $filename = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        
        foreach($filename as $file){
            unlink('./documentos/'.$file['url']);
        }

        $sql = $this->db->prepare("DELETE FROM doc_arquivos WHERE document_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();


    }

    public function deleteFile($id) {
        $sql = $this->db->prepare("SELECT * FROM doc_arquivos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $filename = $sql->fetch(PDO::FETCH_ASSOC);
        }

        $filename = $filename['url'];
        print_r($filename);

        unlink('./documentos/'.$filename);

        $sql = $this->db->prepare("DELETE FROM doc_arquivos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

    }

    //ADD NEW CATEGORY
    public function addCategory($name, $data_cadastro, $user_id){
        $array = array();
        $data = '';

        if(empty($name)){
            $sql = $this->db->prepare("SELECT * FROM doc_categoria ORDER BY name ASC");
                $sql->execute();

                if($sql->rowCount() > 0){
                    $array = $sql->fetchAll(PDO::FETCH_ASSOC);
                }

            $data .= '
                <label>Categoria</label>
                <div class="input-group">
                    <select class="custom-select custom-select-sm" name="categories" required>
                        <option value="">Selecione...</option>';
                        foreach($array as $cat){
                            $data .= '
                                <option>'.$cat['name'].'</option>
                            ';
                        }
                        $data .='
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-success btn-sm" type="button" onclick="addCategory()"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            ';
        } else {
            $array = array();
            $data = '';
            $sql = $this->db->prepare("SELECT * FROM doc_categoria WHERE name = :name");
            $sql->bindValue(":name", $name);
            $sql->execute();

            if($sql->rowCount() == 0){
                $sql = $this->db->prepare("INSERT INTO doc_categoria SET name = :name, data_cadastro = :data_cadastro, user_id = :user_id");
                $sql->bindValue(":name", $name);
                $sql->bindValue(":data_cadastro", $data_cadastro);
                $sql->bindValue(":user_id", $user_id);
                $sql->execute();

                $sql = $this->db->prepare("SELECT * FROM doc_categoria ORDER BY name ASC");
                $sql->execute();

                if($sql->rowCount() > 0){
                    $array = $sql->fetchAll(PDO::FETCH_ASSOC);
                }

                $data .= '
                    <label>Categoria</label>
                    <div class="input-group">
                        <select class="custom-select custom-select-sm" name="categories" required>
                            <option value="">Selecione...</option>';
                            foreach($array as $cat){
                                $data .= '
                                    <option>'.$cat['name'].'</option>
                                ';
                            }
                            $data .='
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-outline-success btn-sm" type="button" onclick="addCategory()"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                ';

            } else {
                $sql = $this->db->prepare("SELECT * FROM doc_categoria ORDER BY name ASC");
                $sql->execute();

                if($sql->rowCount() > 0) {
                    $array = $sql->fetchAll(PDO::FETCH_ASSOC);
                }

                $data .= '
                    <label>Categoria</label>
                    <div class="input-group">
                        <select class="custom-select custom-select-sm" name="categories" required>
                            <option value="">CATEGORIA JÁ CADASTRADA!</option>';
                            foreach($array as $cat){
                                $data .= '
                                    <option>'.$cat['name'].'</option>
                                ';
                            }
                            $data .='
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-outline-success btn-sm" type="button" onclick="addCategory()"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                ';
            }
        }
        
        return $data;
    }

    //FETCH ALL THE CATEGORIES
    public function getCategories() {
        $array = array();
        $sql = $this->db->prepare("SELECT * FROM doc_categoria ORDER BY name ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    //ADD NEW DOCUMENT TYPE
    public function addDocType($name, $data_cadastro, $user_id) {
        $data = '';
        $array = array();

        $sql = $this->db->prepare("INSERT INTO doc_tipo set name = :name, data_cadastro = :data_cadastro, user_id = :user_id");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();

        $sql = $this->db->prepare("SELECT * FROM doc_tipo ORDER BY name ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $data .= '
            <label>Tipo Documento</label>
            <div class="input-group">
                <select class="custom-select custom-select-sm" name="docType" required>
                    <option value="">Selecione...</option>';
                    foreach($array as $doc){
                        $data .= '
                            <option>'.$doc['name'].'</option>
                        ';
                    }
                    $data .='
                </select>
                <div class="input-group-append">
                    <button class="btn btn-outline-success btn-sm" type="button" onclick="addDocType()"><i class="fas fa-plus"></i></button>
                </div>
            </div>
        ';

        return $data;
    }

    //FETCH ALL DOCUMENT TYPES
    public function getDocType(){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM doc_tipo ORDER BY name ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    //FILTERS
    public function filter($company){

        $users = new Users();

        $permissions = new Permissions();
        $user_permissions = $permissions->verifyPermissions($company);

        $user_perm = '';

        if(!empty($company)){
            $company = explode("|", $company);
            // $company = str_replace("\n", "", $company);
        }

        $q2 = '(';
        $i = 0;
        if(!empty($company)){
            foreach($company as $e){
                $q2 .='
                cad_empresas.id = :empresa'.$i;
                $i++;
                if($i < count($company)){
                    $q2 .= ' OR ';
                }   
            }
        }
        $q2 .=')';

        if(!empty($company)) { $company1 = $q2;
        } else {
            $company1 = '';
        }

        $sql = $this->db->prepare("SELECT DATEDIFF(cad_documents.expiration_date, NOW()) AS diff, cad_empresas.name AS company_name, cad_documents.* FROM cad_documents 
        LEFT JOIN cad_empresas ON (cad_empresas.id = cad_documents.company)
        WHERE $company1");
        
        if(!empty($company)){
            $i = 0;
            foreach($company as $companies){
                $sql->bindValue(":empresa".$i, $companies);
                $i++;
            }
        };

        if($sql->execute()){
            // print_r($sql->debugDumpParams());
            // exit;
            $docs = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $sql = $this->db->prepare("SELECT * FROM doc_categoria ORDER BY name");
        $sql->execute();

        if($sql->rowCount() > 0){
            $category = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $result ='';
        foreach($category as $cat){
            $result .='
            <table class="table table-striped table-hover table-sm" id="table_licitacoes" style="font-size: 12px">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 350px; background-color: lightgray">'.$cat['name'].'</th>
                        <th style="width: 400px; background-color: lightgray">Empresa</th>
                        <th style="width: 200px; background-color: lightgray">Data de Emissão</th>
                        <th style="width: 200px; background-color: lightgray">Data de Vencimento</th>
                        <th style="width: 350px; background-color: lightgray">Descrição</th>
                        <th style="width: 200px; background-color: lightgray">Valor</th>
                        <th style="width: 150px; background-color: lightgray; text-align: center">Nº Cópias</th>
                        <th style="width: 350px; background-color: lightgray; text-align: center">Ação</th>
                    </tr>
                </thead>
                <tbody style="font-size: 12px">';
                    foreach($docs as $doc){
                        if($cat['name'] == $doc['category']){
                            if($doc['expiration_date'] <= date("Y-m-d") && !empty($doc['expiration_date'])){
                                $result .='
                                    <tr style="background-color: #e0a4a4">
                                ';
                            } elseif($doc['diff'] >= 1 && $doc['diff'] <= 7){
                                $result .='
                                    <tr style="background-color: #e0dca4">
                                ';
                            } elseif($doc['expiration_date'] > date("Y-m-d")){
                                $result .='
                                    <tr>
                                ';
                            }
                            $result .='
                            <td>'.$doc['doctype'].'</td>
                            <td>'.$doc['company_name'].'</td>
                            <td>'.date("d/m/Y", strtotime($doc['issue_date'])).'</td>
                            <td>';
                                if(!empty($doc['expiration_date'])){
                                    $result .='
                                        '.date("d/m/Y", strtotime($doc['expiration_date'])).'
                                    ';
                                } else {
                                    $result .=' - ';
                                }
                                $result .='
                            </td>
                            <td>'.$doc['description'].'</td>
                            <td>R$ '.number_format($doc['value'],2,',','.').'</td>';
                            $result .='

                            <td id="n_copy-'.$doc['id'].'" style="text-align: center">';
                            for($i=0; $i<count($user_permissions); $i++) {
                                if($user_permissions[$i][0]['companies'] == $doc['company']) {
                                    $user_perm = explode(',', $user_permissions[$i][0]['permission_id']);
                                    //CADASTRAR
                                    if(in_array('9', $user_perm)) {
                                        $result .='
                                        <button class="btn btn-outline-success btn-sm" id="button_plus" onclick="addCopy('.$doc['id'].')"><i class="fas fa-plus"></i></button>
                                            '.$doc['n_copy'].'
                                        <button class="btn btn-outline-danger btn-sm" id="button_minus" onclick="removeCopy('.$doc['id'].')"><i class="fas fa-minus"></i></button>
                                        ';
                                    } else {
                                        $result .='
                                            '.$doc['n_copy'].'
                                        ';
                                    }
                                    $result .='
                                    </td>
                                    <td style="text-align: center">';
                                        //VISUALIZAR
                                    if(in_array('11', $user_perm)) {
                                        $result .='
                                        <button class="btn btn-outline-info btn-sm" onclick="seeDoc('.$doc['id'].')"><i class="fas fa-eye"></i></button>';
                                    } else {
                                        $result .='
                                        <button class="btn btn-outline-secondary btn-sm" disabled><i class="fas fa-eye"></i></button>';
                                    }
                                        //EDITAR
                                    if(in_array('10', $user_perm)) {
                                        $result .='
                                        <button class="btn btn-outline-warning btn-sm" onclick="editDoc('.$doc['id'].')"><i class="fas fa-pen"></i></button>';
                                    } else {
                                        $result .='
                                        <button class="btn btn-outline-secondary btn-sm" disabled><i class="fas fa-pen"></i></button>';
                                    }
                                    //EXCLUIR
                                    if(in_array('12', $user_perm)) {
                                        $result .='<button class="btn btn-outline-danger btn-sm" onclick="delDoc('.$doc['id'].')"><i class="fas fa-trash"></i></button>';
                                    } else {
                                        $result .=' <button class="btn btn-outline-secondary btn-sm" disabled><i class="fas fa-trash"></i></button>';
                                    }
                                }
                            }
                                $result .='
                            </td>
                        </tr>';
                        }
                    }
                    $result .='
                </tbody>
            </table>';
        }

        return $result;
                

    }

        

}