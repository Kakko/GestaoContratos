<?php
class Licitacoes extends Model {
    
    public function cad_licitacao($data, $hora, $system, $value, $complemento, $auction, $complement, $city, $uf, $agency, $produtos, $company, $status, $status_info, $esclarecimentos, $ata, $modalidades, $object, $ag_cadast, $company_winner, $obs, $data_cadastro, $user_id) {


        $sql = $this->db->prepare("INSERT INTO cad_licitacao SET data = :data, hora = :hora, cad_system = :system, value = :value, complemento = :complemento, auction = :auction, complement = :complement, city = :city, uf = :uf, agency = :agency, company = :company, status = :status, status_info = :status_info, esclarecimentos = :esclarecimentos, ata = :ata, modalidades = :modalidades, object = :object, ag_cadast = :ag_cadast, company_winner = :company_winner, obs = :obs, data_cadastro = :data_cadastro, user_id = :user_id");

        $sql->bindValue(":data", $data);
        $sql->bindValue(":hora", $hora);
        $sql->bindValue(":system", $system);
        $sql->bindValue(":value", $value);
        $sql->bindValue(":complemento", $complemento);
        $sql->bindValue(":auction", $auction);
        $sql->bindValue(":complement", $complement);
        $sql->bindValue(":city", $city);
        $sql->bindValue(":uf", $uf);
        $sql->bindValue(":agency", $agency);
        $sql->bindValue(":object", $object);
        $sql->bindValue(":company", $company);
        $sql->bindValue(":status", $status);
        $sql->bindValue(":status_info", $status_info);
        $sql->bindValue(":esclarecimentos", $esclarecimentos);
        $sql->bindValue(":ata", $ata);
        $sql->bindValue(":modalidades", $modalidades);
        $sql->bindValue(":ag_cadast", $ag_cadast);
        $sql->bindValue(":company_winner", $company_winner);
        $sql->bindValue(":obs", $obs);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        
        $sql->execute();

        $licitacao_id = $this->db->lastInsertId(); // Pega o último ID inserido

        if($status === 'Homologado'){
            if($company !== 5 || $company !== 24){
                $sql = $this->db->prepare("SELECT licitacao_id FROM cad_contratos WHERE licitacao_id = :id");
                $sql->bindValue(":id", $licitacao_id);
                $sql->execute();

                if($sql->rowCount() == 0){
                    $sql = $this->db->prepare("INSERT INTO cad_contratos SET valor = :valor, empresa = :empresa, situacao = 'Novo', inicio_contrato = '1983-12-07', fim_contrato = '2030-01-01', data_cadastro = now(), user_id = :user_id, licitacao_id = :licitacao_id");
                    $sql->bindValue(":valor", $value);
                    $sql->bindValue(":empresa", $company);
                    $sql->bindValue(":user_id", $_SESSION['lgUser']);
                    $sql->bindValue(":licitacao_id", $licitacao_id);
                    $sql->execute();
                }
            }
        }

        // for($i=0; $i < count($produtos); $i++){
        //     $sql3 = $this->db->prepare("INSERT INTO prod_licitacao SET name = :name, data_cadastro = :data_cadastro, licitacao_id = :licitacao_id, user_id = :user_id");
        //     $sql3->bindValue(":name", $produtos[$i]);
        //     $sql3->bindValue(":licitacao_id", $licitacao_id);
        //     $sql3->bindValue(":data_cadastro", $data_cadastro);
        //     $sql3->bindValue(":user_id", $user_id);
        //     $sql3->execute();
        // }
        if($produtos !== ''){
            for($i=0; $i < count($produtos); $i++){
                if(!empty($produtos[$i])){
                    $sql3 = $this->db->prepare("INSERT prod_licitacao SET name = :name, licitacao_id = :licitacao_id, user_id = :user_id, data_cadastro = now()");
                    $sql3->bindValue(":name", $produtos[$i]);
                    $sql3->bindValue(":licitacao_id", $licitacao_id);
                    $sql3->bindValue(":user_id", $_SESSION['lgUser']);
                    $sql3->execute();
                }
            }
        }
        exit;
    }
    
    public function get_bids(){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM cad_licitacao ORDER BY data DESC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function get_bid($id){
        $lic = array();
        $produtos = array();
        $licitacao = '';
        $winner = '';
        $historico = '';
        $users = new Users();
        $permissions = new Permissions();

        $sql = $this->db->prepare("SELECT cad_empresas.name AS company_name, cad_licitacao.* 
                                    FROM cad_licitacao 
                                    LEFT JOIN cad_empresas ON (cad_empresas.id = cad_licitacao.company)
                                    WHERE cad_licitacao.id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $lic = $sql->fetch(PDO::FETCH_ASSOC);
        }
        
        $user_permissions = $permissions->verifyPermissions($lic['company']);

        //Fetch the produtcs
        $produtos = array();
        $sql = $this->db->prepare("SELECT * FROM prod_licitacao WHERE licitacao_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $produtos = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        //Fetch the Winner Company
        $sql = $this->db->prepare("SELECT * FROM cad_empresas_vencedoras WHERE licitacao_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $winner = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        //Fetch the History
        $sql = $this->db->prepare("SELECT users.name AS user, cad_arquivos.url AS url, hist_licitacoes.* FROM hist_licitacoes LEFT JOIN users ON (users.id = hist_licitacoes.user_id) LEFT JOIN cad_arquivos ON (hist_licitacoes.id = cad_arquivos.histLicitacao_id) WHERE licitacao_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $history = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $licitacao .='
        <div class="container-fluid" style="border: 1px solid lightgray; border-radius: 5px; box-shadow: 0 0 10px lightgray">
            <div class="row">
                <div class="col-sm">
                    <label style="font-weight: bolder">Data:</label><br/>
                    <input type="text" class="exib_dados" id="data" value="'.date("d/m/Y", strtotime($lic['data'])).'" readonly>
                </div>
                <div class="col-sm">
                    <label style="font-weight: bolder">Hora:</label>
                    <input type="text" class="exib_dados" id="hora" value="'.$lic['hora'].'" readonly>
                </div>
                <div class="col-sm">
                    <label style="font-weight: bolder">Sistema:</label>
                    <input type="text" class="exib_dados" id="system" value="'.$lic['cad_system'].'" readonly>
                </div>
                <div class="col-sm">
                    <label style="font-weight: bolder">Valor:</label>
                    <input type="text" class="exib_dados" id="value" value="R$ '.number_format($lic['value'],2,',', '.').'" readonly>
                </div>
                <div class="col-sm">
                    <label style="font-weight: bolder">Complemento:</label>
                    <input type="text" class="exib_dados" id="complemento" value="'.$lic['complemento'].'" readonly>
                </div>
                <div class="col-sm">
                    <label style="font-weight: bolder">Nº do Pregão:</label>
                    <input type="text" class="exib_dados" id="auction" value="'.$lic['auction'].'" readonly>
                </div>
                <div class="col-sm">
                    <label style="font-weight: bolder">Identificador</label>
                    <input type="text" class="exib_dados" id="complement" value="'.$lic['complement'].'" readonly>
                </div>
                <div class="col-sm">
                    <label style="font-weight: bolder">Cidade:</label>
                    <input type="text" class="exib_dados" id="city" value="'.$lic['city'].'" readonly>
                </div>
                <div class="col-sm">
                    <label style="font-weight: bolder">UF:</label>
                    <input type="text" class="exib_dados" id="uf" value="'.$lic['uf'].'" readonly>
                </div>
            </div>
            <br><hr/>
            <div class="row">
                <div class="col-sm-2">
                    <label style="font-weight: bolder">Órgão:</label>
                    <input type="text" class="exib_dados" id="agency" value="'.$lic['agency'].'" readonly>
                </div>
                <div class="col-sm-2">
                    <label style="font-weight: bolder">Empresa:</label>
                    <input type="text" class="exib_dados" id="company" value="'.$lic['company_name'].'" readonly>
                </div>
                <div class="col-sm-2">
                    <label style="font-weight: bolder">Status:</label>
                    <input type="text" class="exib_dados" id="status" value="'.$lic['status'].'" readonly>
                </div>
                <div class="col-sm-2">
                    <label style="font-weight: bolder">Status Info:</label>
                    <input type="text" class="exib_dados" id="status" value="'.$lic['status_info'].'" readonly>
                </div>
                <div class="col-sm-2">
                    <label style="font-weight: bolder">Esclarecimentos:</label>
                    <input type="text" class="exib_dados" id="esclarecimentos" value="'.$lic['esclarecimentos'].'" readonly>
                </div>
                <div class="col-sm-2">
                    <label style="font-weight: bolder">Ata:</label>
                    <input type="text" class="exib_dados" id="ata" value="'.$lic['ata'].'" readonly>
                </div>
            </div>
            <br><hr/>
            <div class="row">
                <div class="col-sm-2">
                    <label style="font-weight: bolder">Modalidades:</label>
                    <input type="text" class="exib_dados" id="modalidades" value="'.$lic['modalidades'].'" readonly>
                </div>
                <div class="col-sm-4">
                    <label style="font-weight: bolder">Objetos:</label>
                    <input type="text" class="exib_dados" id="object" value="'.$lic['object'].'" readonly>
                </div>
                <div class="col-sm-2">
                    <label style="font-weight: bolder">Agenciamento</label>
                    <input type="text" class="exib_dados" id="ag_cadast" value="'.$lic['ag_cadast'].'" readonly>
                </div>
                <div class="col-sm-4" style="max-height: 200px; overflow: auto">
                    <label style="font-weight: bolder">Produtos Cadastrados:</label>
                    <table class="table table-striped table-sm exib_dados" readonly>
                        <thead class="thead-dark">
                            <tr>
                                <th>Nome</th>
                                <th>Desconto</th>
                            </tr>
                        </thead>
                        <tbody id="table_prod">';
                            foreach($produtos as $prod){
                                $licitacao .='
                                <tr>
                                    <td>'.$prod['name'].'</td>
                                    <td>'.$prod['desconto'].'</td>
                                </tr>
                                ';
                            }
                            $licitacao .='
                        </tbody>
                    </table>    
                </div>
            </div>
            <br><hr/>
            <div class="row">
                <div class="col-sm-8">
                    <label style="font-weight: bolder">Observações:</label>
                    <textarea type="text" class="exib_dados" id="obs" style="resize: none" readonly>'.$lic['obs'].'</textarea>
                </div>
                <div class="col-sm-4">
                    <label style="font-weight: bolder">Empresa Vencedora:</label>
                        <table class="table table-striped table-sm exib_dados" readonly>
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nome:</th>
                                    <th>Valor:</th>
                                    <th>Porcentagem:</th>
                                </tr>
                            </thead>
                            <tbody id="table_win">';
                            if(!empty($winner)){
                                foreach($winner as $win){
                                    $licitacao .='
                                        <tr>
                                            <td>'.$win['name'].'</td>
                                            <td>'.$win['value'].'</td>
                                            <td>'.$win['perc'].'</td>
                                        </tr>
                                    ';
                                }
                            } else {
                                $licitacao .='
                                    <tr>
                                        <td> - </td>
                                        <td> - </td>
                                        <td> - </td>
                                    </tr>
                                ';
                            }
                                $licitacao .='
                            </tbody>
                        </table>
                </div>
            </div>
            <br><br/>
            <div class="row" style="border-bottom: 1px solid lightgray; border-top: 1px solid lightgray">
                <div class="col-sm-12" style="border-right: 1px solid lightgray">
                    <label style="font-weight: bolder">Histórico:</label>
                    <div id="historico">
                        <table class="table table-striped table-hover table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Título</th>
                                    <th>Data</th>
                                    <th>Horário</th>
                                    <th>Observações</th>
                                    <th>Usuário</th>
                                    <th>Download</th>
                                    <th>Excluir</th>
                                </tr>
                            </thead>
                            <tbody id="table-hist">';
                                if(!empty($history)){
                                    foreach($history as $hist){
                                        $licitacao .='
                                            <tr>
                                                <td>'.$hist['titulo'].'</td>
                                                <td>'.$hist['data_licitacao'].'</td>
                                                <td>'.$hist['horario_licitacao'].'</td>
                                                <td>'.$hist['obs'].'</td>
                                                <td>'.$hist['user'].'</td>';
                                                if(!empty($hist['url'])){
                                                    $licitacao .='
                                                    <td><a href="./documentos/'.$hist['url'].'" target="_blank"><i class="fas fa-paperclip"></i></a></td>    
                                                    ';
                                                } else {
                                                    $licitacao .='
                                                    <td><i class="fas fa-times btn-outline-secondary"></i></td>';
                                                }
                                                $user_perm = explode(',', $user_permissions[0][0]['permission_id']);
                                                if(in_array('1', $user_perm)) {
                                                    $licitacao .='
                                                    <td><button type="button" class="btn btn-outline-danger" onclick="delete_hist('.$hist['id'].')" style="text-align: center"><i class="fas fa-trash"></i></button></td>';
                                                } else {
                                                    $licitacao .='
                                                    <td><button type="button" class="btn btn-outline-secondary" style="text-align: center" disabled><i class="fas fa-trash"></i></button></td>';
                                                };
                                                $licitacao .='
                                            </tr>
                                                ';
                                    }
                                }
                                $licitacao .='
                            </tbody>
                        </table>                
                    </div>
                </div>
            </div>
            <br/>
        </div>
        ';

        return $licitacao;
    }

    //EDIÇÃO DAS LICITAÇÕES
    public function get_bid2($id){
        $array = array();
        $licitacao = '';

        //Fetch the Licitação Data
        $sql = $this->db->prepare("SELECT cad_empresas.name AS company_name, cad_empresas.id AS company_id, cad_licitacao.* 
                                    FROM cad_licitacao 
                                    LEFT JOIN cad_empresas ON (cad_empresas.id = cad_licitacao.company)
                                    WHERE cad_licitacao.id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $lic = $sql->fetch(PDO::FETCH_ASSOC);
        }
        //Fetch the Systems
        $sistema= new Sistemas();

        //Fetch the States
        $states = new Utils();

        //Fetch the Agencies
        $agency = new Orgaos();

        //Fetch the Products
        $product = new Produtos();

        //Fetch Companies
        $companies = new Empresas();

        //Fetch the Produtcs (Licitação)
        $licProd = new Licitacoes();

        //Fetch the Winner Company
        $licWin = new Licitacoes();

        //Fetch the Status Info
        $statusInfo = new Licitacoes();



        $licitacao .='
        <div class="row">
            <div class="col-sm">
                <label for="name">Data:</label>
                <input type="text" name="id" value="'.$lic['id'].'" hidden>
                <input type="text" name="acao_licitacoes" value="atualizar" hidden>
                <input type="date" class="form-control form-control-sm" name="data" value="'.$lic['data'].'" required>
            </div>
            <div class="col-sm-1">
                <label for="hora">Horario:</label>
                <input type="time" class="form-control form-control-sm" name="hora" value="'.$lic['hora'].'" required>
            </div>
            <div class="col-sm" id="system_cad">
                <label for="system">Sistema:</label>
                <div class="input-group">
                    <select class="custom-select custom-select-sm" name="system" required>
                        <option>'.$lic['cad_system'].'</option>
                        <option value="" disabled>---------------------</option>';
                        foreach($sistema->get_systems() as $sys){
                            $licitacao .='
                            <option>'.$sys['name'].'</option>
                            ';
                        }
                        $licitacao .='
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-success btn-sm" type="button" onclick="addSystem()"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <label for="value">Valor:</label>
                <input type="text" class="form-control form-control-sm valor" name="value" value="'.number_format($lic['value'], 2, ',', '.').'" >
            </div>
            <div class="col-sm">
                <label for="complemento">Complemento:</label>
                <input type="text" class="form-control form-control-sm" name="complemento" value="'.$lic['complemento'].'">
            </div>
            <div class="col-sm">
                <label for="auction">Nº Edital:</label>
                <input type="text" class="form-control form-control-sm" name="auction" value="'.$lic['auction'].'" required>
            </div>
            <div class="col-sm-1">
                <label for="-">Identificador</label>
                <input type="text" class="form-control form-control-sm" name="complement"  value="'.$lic['complement'].'">
            </div>
        </div>
        <hr/>
        <div class="row">
        <div class="col-sm">
                <label for="uf">Estado:</label>
                <select class="form-control form-control-sm" name="uf" onchange="listar_cidades()">
                    <option>'.$lic['uf'].'</option>
                    <option value="" disabled>-----------------------</option>';
                    foreach($states->getEstados() as $states){
                        $licitacao .='
                        <option>'.$states['estado'].'</option>';
                    }
                    $licitacao .='
                </select>
            </div>
            <div class="col-sm" id="cidade">
                <label for="city">Cidade:</label>
                <input type="text" class="form-control form-control-sm" name="city"  value="'.$lic['city'].'" readonly>
            </div>
            <div class="col-sm" id="orgao">
                <label for="agencies">Órgão:</label>
                <div class="input-group">
                    <select class="custom-select custom-select-sm" name="agency" required>
                    <option>'.$lic['agency'].'</option>
                    <option value="" disabled> -------------------- </option>';
                    foreach($agency->get_orgaos() as $ag){
                        $licitacao .='<option>'.$ag['name'].'</option>';
                    }
                        $licitacao .='
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-success btn-sm" type="button" onclick="addOrgao()"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <label for="produtos">Produtos:</label>
                <select class="form-control form-control-sm" name="produtos[]" multiple>
                <option value="" style="font-weight: bolder; text-decoration: underline">Nenhum Produto</option>';
                    foreach($product->get_produtos() as $prod){
                        $licitacao .='
                            <option>'.$prod['name'].'</option>
                        ';
                    }
                    $licitacao .='
                </select>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-sm-2">
                <label for="companies">Empresas:</label>
                <select class="form-control form-control-sm" name="company" onchange="get_cnpj()">
                    <option value="'.$lic['company_id'].'">'.$lic['company_name'].'</option>';
                    foreach($companies->getCompanies() as $company){
                        $licitacao .='
                            <option value="'.$company['id'].'">'.$company['name'].'</option>
                        ';
                    }
                    $licitacao .='
                </select>
            </div>
            <input type="text" name="cnpj" id="company_cnpj" hidden>
            <div class="col-sm-2">
                <label for="status">Status:</label>
                <select class="form-control form-control-sm" name="status"  required>
                    <option>'.$lic['status'].'</option>
                    <option value=""disabled> --------------- </option>
                    <option>Pré Cadastro</option>
                    <option>Cadastrado</option>
                    <option>Em Andamento</option>
                    <option>Homologado</option>
                    <option>Suspenso</option>
                    <option>Anulado</option>
                    <option>Perdido</option>
                    <option>Adiada</option>
                    <option>Não Participado</option>
                    <option>Recurso</option>
                    <option>Fracassado</option>
                    <option>Revogado</option>
                    <option>Deserto</option>
                    <option>Mandado de Segurança</option>
                </select>
            </div>
            <div class="col-sm-2" id="statusInfo">
                <label for="status_info">Motivo do Status</label>
                <div class="input-group">
                    <select class="custom-select custom-select-sm" name="status_info" required>
                        <option>'.$lic['status_info'].'</option>
                        <option disabled> ------------- </option>';
                        foreach($statusInfo->fetchStatus_info() as $info){
                            $licitacao .='
                                <option>'.$info['name'].'</option>
                            ';
                        }
                        $licitacao .='
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-success btn-sm" type="button" onclick="addStatusInfo()"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <label for="esclarecimentos">Esclarecimentos:</label>
                <select class="form-control form-control-sm" name="esclarecimentos">
                    <option>'.$lic['esclarecimentos'].'</option>
                    <option value="" disabled> ----------------- </option>
                    <option>Enviado</option>
                    <option>Não Enviado</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="ata">Ata:</label>
                <select class="form-control form-control-sm" name="ata">
                    <option>'.$lic['ata'].'</option>
                    <option value="" disabled> ----------------- </option>
                    <option>Sim</option>
                    <option>Não</option>
                </select>
            </div>
            <div class="col-sm-2">
                <label for="modalidades">Modalidades:</label>
                <select class="form-control form-control-sm" name="modalidades">
                    <option>'.$lic['modalidades'].'</option>
                    <option value="" disabled> ------------------</option>
                    <option>Carta Convite</option>
                    <option>Concorrência</option>
                    <option>Tomada de Preço</option>
                    <option>Pregão Presencial</option>
                    <option>Pregão Eletrônico</option>
                    <option>Cotação Eletrônica</option>
                    <option>RDC</option>
                    <option>Internacional</option>
                </select>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-sm-4">
                <label for="object">Objeto:</label>
                <textarea class="form-control form-control-sm" name="object" style="height: 50px; resize: none">'.$lic['object'].'</textarea>
            </div>
            <div class="col-sm-3">
                <label for="ag_cadast">Agenciamento</label>
                <textarea class="form-control form-control-sm" name="ag_cadast" style="height: 50px; resize: none">'.$lic['ag_cadast'].'</textarea>
            </div>

            <div class="col-sm-2" style="background-color: lightgray">
                <label>Empresa Vencedora:</label>
                <div id="wcompany_select">
                    <div class="input-group">
                        <select class="custom-select custom-select-sm" name="winner_company" id="winner_company" disabled>
                            <option value="">Selecione...</option>
                            <option value="" disabled> ------------ </option>';
                            foreach($companies->winner_company() as $win){
                                $licitacao .='
                                    <option>'.$win['name'].'</option>
                                ';
                            }
                            $licitacao .='
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-secondary btn-sm" type="button" onclick="addWinnerCompany()" id="addWinnerCompany2" disabled><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-1" style="background-color: lightgray">
                <label>Valor:</label>
                <input type="text" class="form-control form-control-sm valor4" name="winner_value" disabled id="winner_value">
            </div>
            <div class="col-sm-1" style="background-color: lightgray">
                <label>Porcentagem:</label>
                <input type="number" class="form-control form-control-sm" name="winner_perc" disabled id="winner_perc">
            </div>
            <div class="col-sm-1" style="background-color: lightgray">
                <button type="button" class="btn btn-info" onclick="cadWinnerCompany()" style="width: 100%; margin-top: 25px" id="addcadWinnerCompany" disabled>Adicionar</button>
            </div>
        </div>
        <hr/>
        <div class="row" style="border-bottom: 1px solid lightgray; border-top: 1px solid lightgray">
            <div class="col-sm-5">
                <label style="font-weight: bolder">Produtos:</label>
                <div id="historico">
                    <table class="table table-striped table-hover table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th style="text-align: center">Nome:</th>
                                <th>Ação:</th>
                            </tr>
                        </thead>
                        <tbody id="table-prod">';
                        if(!empty($licProd->get_produtos($id))){
                            foreach($licProd->get_produtos($id) as $prod){
                                $licitacao .='
                                <tr>
                                    <td>'.$prod['name'].'</td>
                                    <td><button class="btn btn-outline-danger" onclick="excluir_prod('.$prod['id'].')" style="text-align: center"><i class="fas fa-trash"></i></button></td>
                                </tr>
                                ';
                            } 
                        } else {
                            $licitacao .='
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                            ';
                        }
                            $licitacao .='
                        
                        </tbody>
                    </table>                
                </div>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-5">
                <label style="font-weight: bolder">Empresas Vencedoras:</label>
                <div id="historico">
                    <table class="table table-striped table-hover table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nome:</th>
                                <th>Valor:</th>
                                <th>Porcentagem:</th>
                                <th>Ação:</th>
                            </tr>
                        </thead>
                        <tbody id="table-winner">';
                            if(!empty($licWin->get_winner($id))){
                                foreach($licWin->get_winner($id) as $win){
                                    $licitacao .='
                                        <tr>
                                            <td>'.$win['name'].'</td>';
                                            if(!empty($win['value'])){
                                                $licitacao .='<td>R$ '.$win['value'].'</td>';
                                            } else {
                                                $licitacao .='<td> - </td>';
                                            }
                                            if(!empty($win['perc'])){
                                                $licitacao .='<td>'.$win['perc'].'</td>';
                                            } else {
                                                $licitacao .='<td> - </td>';
                                            }
                                            $licitacao .='
                                            <td><button type="button" class="btn btn-outline-danger" onclick="delete_winner('.$win['id'].')" style="text-align: center"><i class="fas fa-trash"></i></button></td>
                                        </tr>
                                    ';
                                }
                            } else {
                                $licitacao .='
                                <tr>
                                    <td> - </td>
                                    <td> - </td>
                                    <td> - </td>
                                    <td> - </td>
                                </tr>
                                ';
                            }
                            $licitacao .='
                        </tbody>
                    </table>                
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-sm-12">
                <label for="obs">Observações</label>
                <textarea name="obs" class="form-control form-control-sm" style="height: 100px; resize: none">'.$lic['obs'].'</textarea>
            </div>
        </div>
        ';

        return $licitacao;
    }

    public function get_prod($id){
        $sql = $this->db->prepare("SELECT * FROM prod_licitacao WHERE licitacao_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($array);
    }

    public function del_prod($id){
        $sql = $this->db->prepare("DELETE FROM prod_licitacao WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function getInternal(){
        $sql = $this->db->prepare("SELECT * FROM cad_empresas");
        $sql->execute();

        if($sql->rowCount() > 0){
            $internal = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $internal;
    }

    public function upd_licitacao($id, $data, $hora, $system, $value, $complemento, $auction, $complement, $city, $uf, $agency, $produtos, $company, $status, $status_info, $esclarecimentos, $ata, $modalidades, $object, $ag_cadast, $company_winner, $obs){

        $sql = $this->db->prepare("UPDATE cad_licitacao SET data = :data, hora = :hora, cad_system = :system, value = :value, complemento = :complemento, auction = :auction, complement = :complement, city = :city, uf = :uf, agency = :agency, object = :object, company = :company, status = :status, status_info = :status_info, esclarecimentos = :esclarecimentos, ata = :ata, modalidades = :modalidades, ag_cadast = :ag_cadast, company_winner = :company_winner, obs = :obs WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":data", $data);
        $sql->bindValue(":hora", $hora);
        $sql->bindValue(":system", $system);
        $sql->bindValue(":value", $value);
        $sql->bindValue(":complemento", $complemento);
        $sql->bindValue(":auction", $auction);
        $sql->bindValue(":complement", $complement);
        $sql->bindValue(":city", $city);
        $sql->bindValue(":uf", $uf);
        $sql->bindValue(":agency", $agency);
        $sql->bindValue(":object", $object);
        $sql->bindValue(":company", $company);
        $sql->bindValue(":status", $status);
        $sql->bindValue(":status_info", $status_info);
        $sql->bindValue(":esclarecimentos", $esclarecimentos);
        $sql->bindValue(":ata", $ata);
        $sql->bindValue(":modalidades", $modalidades);
        $sql->bindValue(":ag_cadast", $ag_cadast);
        $sql->bindValue(":company_winner", $company_winner);
        $sql->bindValue(":obs", $obs);
        $sql->execute();

        // print_r($sql->debugDumpParams());
        // exit;

        if($status === 'Homologado'){
            if($company !== 5 OR $company !== 24){
                $sql = $this->db->prepare("SELECT licitacao_id FROM cad_contratos WHERE licitacao_id = :id");
                $sql->bindValue(":id", $id);
                $sql->execute();

                if($sql->rowCount() == 0){
                    $sql = $this->db->prepare("INSERT INTO cad_contratos SET valor = :valor, empresa = :empresa, situacao = 'Novo', inicio_contrato = '1983-12-07', fim_contrato = '2030-01-01', data_cadastro = now(), user_id = :user_id, licitacao_id = :licitacao_id");
                    $sql->bindValue(":valor", $value);
                    $sql->bindValue(":empresa", $company);
                    $sql->bindValue(":user_id", $_SESSION['lgUser']);
                    $sql->bindValue(":licitacao_id", $id);
                    $sql->execute();
                }
            }
        }

        if($produtos !== ''){
            print_r('entrei');
            for($i=0; $i < count($produtos); $i++){
                if(!empty($produtos[$i])){
                    $sql3 = $this->db->prepare("INSERT prod_licitacao SET name = :name, licitacao_id = :licitacao_id, user_id = :user_id, data_cadastro = now()");
                    $sql3->bindValue(":name", $produtos[$i]);
                    $sql3->bindValue(":licitacao_id", $id);
                    $sql3->bindValue(":user_id", $_SESSION['lgUser']);
                    $sql3->execute();
                }
            }
        }
        exit;
    }

    public function del_licitacao($id) {
        $sql = $this->db->prepare("DELETE FROM cad_licitacao WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }


    public function cad_historico($titulo, $data_licitacao, $horario_licitacao, $obs, $data_cadastro, $user_id, $licitacao_id){
        $sql = $this->db->prepare("INSERT INTO hist_licitacoes SET titulo = :titulo, data_licitacao = :data_licitacao, horario_licitacao = :horario_licitacao, obs = :obs, data_cadastro = :data_cadastro, user_id = :user_id, licitacao_id = :licitacao_id");
        $sql->bindValue(":titulo", $titulo);
        $sql->bindValue(":data_licitacao", $data_licitacao);
        $sql->bindValue(":horario_licitacao", $horario_licitacao);
        $sql->bindValue(":obs", $obs);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->bindValue(":licitacao_id", $licitacao_id);
        $sql->execute();
    }

    public function get_historico($id){
        $array = array();

        $sql = $this->db->prepare("SELECT hist_licitacoes.obs AS hist_obs, hist_licitacoes.*, users.*, cad_arquivos.* 
        FROM hist_licitacoes 
        LEFT JOIN users ON users.id =  hist_licitacoes.user_id  
        LEFT JOIN cad_arquivos ON cad_arquivos.histLicitacao_id = hist_licitacoes.id  
        WHERE hist_licitacoes.licitacao_id = :id ORDER BY hist_licitacoes.id ASC");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
            return $array;
        } else {
            return 'Erro ao buscar dados';
        }
    }

    public function get_produtos($id){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM prod_licitacao WHERE licitacao_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function del_historico($id){
        $sql = $this->db->prepare("DELETE FROM hist_licitacoes WHERE licitacao_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function get_desconto($id){

        $array = array();

        $sql = $this->db->prepare("SELECT * FROM prod_licitacao WHERE licitacao_id = :id");
        $sql->bindValue(":id", $id);
        if($sql->execute()){
            $get_produtos = $sql->fetchAll(PDO::FETCH_ASSOC);
            $resultado = '
                    ';
                        foreach($get_produtos as $p){
                            $resultado .='
                            <tr>
                                <td>'.$p['name'].'</td>
                                <td><input type="text" class="form-control form-control-sm" value="'.$p['desconto'].'" name="desconto[]"></td>
                                <td><input type="text" value="'.$p['id'].'" name="prod_id[]" hidden></td>
                            </tr>';
                        }; 
                        $resultado .='
                    ';
                return $resultado;
        } else {
            return 'Erro ao Listar';
        }
    }

    public function cad_desconto($prod_id, $desconto){

        $sql = $this->db->prepare("UPDATE prod_licitacao SET desconto = :desconto WHERE id = :prod_id");
        $sql->bindValue(":desconto", $desconto);
        $sql->bindValue(":prod_id", $prod_id);
        $sql->execute();
    }

    public function filtrar_licitacoes($status, $tipo, $empresa, $sistema, $data_de, $data_ate, $valor_de, $valor_ate){
        
        $permissions = new Permissions();
        $user_permissions = $permissions->verifyPermissions($empresa);

        $user_perm = '';

        
        if(!empty($empresa)){
            $empresa = explode("|", $empresa);
            // $empresa = str_replace("\n", "", $empresa);
        }
        if(!empty($tipo)){
            $tipo = explode(",", $tipo);
        }
        if(!empty($sistema)){
            $sistema = explode(",", $sistema);
            $sistema = str_replace("\r\n", "", $sistema);
        }
        if(!empty($status)){
            $status = explode(",", $status);
        }
        

    //Filtro Para Múltiplas entradas - Empresas
        $q2 = '(';
        $i = 0;
        if(!empty($empresa)){
            foreach($empresa as $e){
                $q2 .='
                cad_empresas.id = :empresa'.$i;
                $i++;
                if($i < count($empresa)){
                    $q2 .= ' OR ';
                }   
            }
        }
        $q2 .=')';
        


    //Filtro para Múltiplas Entradas - Status
        $q3 = '(';
        $i = 0;
        if(!empty($status)){
            foreach($status as $s){
                $q3 .='
                cad_licitacao.status = :status'.$i;
                $i++;
                if($i < count($status)){
                    $q3 .= ' OR ';
                }   
            }
        }
        $q3 .=')';
        

    //Filtro para Múltiplas Entradas - Sistemas
        $q4 = '(';
        $i = 0;
        if(!empty($sistema)){
            foreach($sistema as $st){
                $q4 .='
                cad_licitacao.cad_system = :system'.$i;
                $i++;
                if($i < count($sistema)){
                    $q4 .= ' OR ';
                }   
            }
        }
        $q4 .=')';
       

    //Filtro para Múltiplas Entradas - Tipo
        $q5 = '(';
        $i = 0;
        if(!empty($tipo)){
            foreach($tipo as $t){
                $q5 .='
                cad_licitacao.modalidades = :type'.$i;
                $i++;
                if($i < count($tipo)){
                    $q5 .= ' OR ';
                }   
            }
        }
        $q5 .=')';


        if(empty($data_de)) { $data_de = '1900-01-01'; }
        if(empty($data_ate)) { $data_ate = '5000-01-01'; }


        if(empty($valor_de)) { $valor_de = '0.00'; }
        if(empty($valor_ate)) { $valor_ate = '3000000000.00'; }


        if(!empty($status)) { $status1 = ' AND '.$q3;
        } else {
            $status1 = '';
        }

        if(!empty($empresa)) { $empresa1 = ' AND '.$q2;
        } else {
            $empresa1 = '';
        }

        if(!empty($sistema)) { $sistema1 = ' AND '.$q4;
        } else {
            $sistema1 = '';
        }

        if(!empty($tipo)) { $tipo1 = ' AND '.$q5;
        } else {
            $tipo1 = '';
        }

        $query = "SELECT cad_empresas.name AS company_name, cad_licitacao.* 
                    FROM cad_licitacao 
                    LEFT JOIN cad_empresas ON (cad_licitacao.company = cad_empresas.id)
                    WHERE value >= :valor_de AND value <= :valor_ate AND cad_licitacao.data BETWEEN :data_de AND :data_ate $status1 $tipo1 $empresa1 $sistema1 GROUP BY cad_licitacao.id ORDER BY cad_licitacao.data DESC, cad_licitacao.hora ASC";
        $sql = $this->db->prepare($query);

        $sql->bindValue(":valor_de", $valor_de);
        $sql->bindValue(":valor_ate", $valor_ate);
        $sql->bindValue(":data_de", $data_de);
        $sql->bindValue(":data_ate", $data_ate);
        // (!empty($status)) ? $sql->bindValue(":status", $status) : 0;
        
        if(!empty($empresa)){
            $i = 0;
            foreach($empresa as $e){
                $sql->bindValue(":empresa".$i, $e);
                $i++;
            }
        }
        if(!empty($status)){
            $i = 0;
            foreach($status as $s){
                $sql->bindValue(":status".$i, $s);
                $i++;
            }
        }

        if(!empty($sistema)){
            $i = 0;
            foreach($sistema as $st){
                $sql->bindValue(":system".$i, $st);
                $i++;
            }
        }

        if(!empty($tipo)){
            $i = 0;
            foreach($tipo as $t){
                $sql->bindValue(":type".$i, $t);
                $i++;
            }
        }

        // (!empty($sistema)) ? $sql->bindValue(":sistema", $sistema) : 0;
        // (!empty($tipo)) ? $sql->bindValue(":tipo", $tipo) : 0;

            if($sql->execute()){
            // $sql->debugDumpParams();
            // exit;
                
            $listar_licitacoes = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            $resultado = '
            <table class="table table-striped table-hover table-sm" id="table_licitacoes">
                <thead class="thead-dark">
                    <tr>
                        <th>Data</th>
                        <th>Hora</th>
                        <th style="width: 10%">Sistema</th>
                        <th>Valor</th>
                        <th>Edital</th>
                        <th style="width: 20px">Id.</th>
                        <th>Órgão</th>
                        <th>Empresa</th>
                        <th>Observação</th>
                        <th>Ações</th>
                    </tr>
                </thead>';
                foreach($listar_licitacoes as $d){
                    $resultado .='
                    <tbody style="font-size: 12px">';
                        if($d['status'] == 'Homologado'){
                            $resultado .='
                            <tr style="background-color: #a6e0a4">';
                        }
                        if($d['status'] == 'Anulado'){
                            $resultado .='
                            <tr style="background-color: #e0a4a4">';
                        }
                        if($d['status'] == 'Perdido'){
                            $resultado .='
                            <tr style="background-color: #e0a4a4">';
                        }
                        if($d['status'] == 'Não Participado'){
                            $resultado .='
                            <tr style="background-color: #aacfff">';
                        }
                        if($d['status'] == 'Suspenso'){
                            $resultado .='
                            <tr style="background-color: #e0dca4">';
                        }
                        if($d['status'] == 'Em Andamento'){
                            $resultado .='
                            <tr style="background-color: #ffcff5">';
                        }
                        if($d['status'] == 'Recurso'){
                            $resultado .='
                            <tr style="background-color: #852871; color: #FFF">';
                        }
                        if($d['status'] == 'Cadastrado'){
                            $resultado .='
                            <tr style="background-color: #22608a; color: #FFF">';
                        }
                        if($d['status'] == 'Mandado de Segurança'){
                            $resultado .='
                            <tr style="background: linear-gradient(45deg, #FFC900, #FF0000, #FFC900); color: #fff">';
                        }
                        $resultado .='
                            <td>'.date("d/m/Y", strtotime($d['data'])).'</td>
                            <td>'.$d['hora'].'</td>
                            <td style="max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap" title="'.$d['cad_system'].'">'.$d['cad_system'].'</td>
                            <td style="width: 10%">R$ '.number_format($d['value'],2,',','.').'</td>
                            <td style="max-width: 80px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap" title="'.$d['auction'].'"">'.$d['auction'].'</td>
                            <td style="max-width: 50px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap" title="'.$d['complement'].'"">'.$d['complement'].'</td>
                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap" title="'.$d['agency'].'">'.$d['agency'].'</td>
                            <td style="max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap" title="'.$d['company_name'].'">'.$d['company_name'].'</td>
                            <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap" title="'.$d['obs'].'">'.$d['obs'].'</td>
                        <td>';
                        for($i=0; $i<count($user_permissions); $i++) {
                            if($user_permissions[$i][0]['companies'] == $d['company']) {
                                $user_perm = explode(',', $user_permissions[$i][0]['permission_id']);
                                if(in_array('7', $user_perm)) {
                                    $resultado .='<button class="btn btn-outline-info btn-sm" onclick="ver_licitacao('.$d['id'].')"><i class="fas fa-eye"></i></button>';
                                } else {
                                    $resultado .='<button class="btn btn-outline-secondary btn-sm" disabled><i class="fas fa-eye"></i></button>';
                                }
                                if(in_array('5', $user_perm)) {
                                    $resultado .='<button class="btn btn-outline-primary btn-sm" onclick="cad_historico('.$d['id'].')"><i class="fas fa-history"></i></button>';
                                } else {
                                    $resultado .='<button class="btn btn-outline-secondary btn-sm" disabled><i class="fas fa-history"></i></button>';
                                }
                                $resultado .='<button class="btn btn-outline-success btn-sm" onclick="cad_desconto('.$d['id'].')"><i class="fas fa-percent"></i></button>';
                                if(in_array('6', $user_perm)) {
                                    $resultado .='<button class="btn btn-outline-warning btn-sm" onclick="editar_licitacao('.$d['id'].')"><i class="fas fa-pen"></i></button>';
                                } else {
                                    $resultado .='<button class="btn btn-outline-secondary btn-sm" disabled><i class="fas fa-pen"></i></button>';
                                }
                                $resultado .='<button class="btn btn-outline-note btn-sm" onclick="addNote('.$d['id'].')"><i class="far fa-sticky-note"></i></button>';
                                if(in_array('8', $user_perm)) {
                                    $resultado .='<button class="btn btn-outline-danger btn-sm" onclick="excluir_licitacao('.$d['id'].')"><i class="fas fa-trash"></i></button>';
                                } else {
                                    $resultado .='<button class="btn btn-outline-secondary btn-sm" disabled><i class="fas fa-trash"></i></button>';
                                }
                            }
                        }
                            $resultado .='
                        </td>
                    </tr>
                </tbody>
            ';
                }
            $resultado .='    
            </table>
            ';
            return $resultado;
        } else {
            return 'Erro ao listar';
        }
    }

    public function upload_arquivo_licitacao($upload_arquivo, $licitacao_id, $data_cadastro, $user_id){
        $contrato_id = '';

        $sql = $this->db->prepare("SELECT id FROM hist_licitacoes WHERE licitacao_id = $licitacao_id ORDER BY id DESC limit 1");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetch(PDO::FETCH_ASSOC);
            $last_id = implode('', $array);
        }

        $ext = strtolower(substr($_FILES['upload_arquivo']['name'],-4)); //Pegando extensão do arquivo
        $new_name = md5(time(). rand(0,999)) . $ext; //Definindo um novo nome para o arquivo
        $dir = './documentos/'; //Diretório para uploads


        move_uploaded_file($_FILES['upload_arquivo']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo

            $sql = $this->db->prepare("INSERT INTO cad_arquivos SET url = :url, histContrato_id = :hist_id, histLicitacao_id = :licit_id, data_cadastro = :data_cadastro, user_id = :user_id");
            $sql->bindValue(":url", $new_name);
            $sql->bindValue(":hist_id", $contrato_id);
            $sql->bindValue(":licit_id", $last_id);
            $sql->bindValue(":data_cadastro", $data_cadastro);
            $sql->bindValue(":user_id", $user_id);
            $sql->execute();
        
    }

    public function get_winner($id){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM cad_empresas_vencedoras WHERE licitacao_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;


    }

    public function get_win($id){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM cad_empresas_vencedoras WHERE licitacao_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        for($i=0; $i < count($array); $i++){
            $array[$i]['value'] = number_format($array[$i]['value'], 2,',','.');
        }
        
        return $array;
    }

    public function notepadContratos($id){
        $data = array();
        $notes = '';
        $sql = $this->db->prepare("SELECT * FROM notepad_contratos WHERE licitacao_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $notes .='
            <button type="button" class="btn btn-info" onclick="addNewNote('.$id.')">Nova Nota</button><br/><hr/>
        ';
        foreach($data as $info){
            $notes .='
                <div class="notes">
                    <input type="text" name="licitacao_id" value="'.$id.'" hidden>
                    <div class="title">'.$info['title'].'</div>
                    <div class="text">'.$info['text'].'</div>
                    <div class="date">'.date("d/m/Y H:i:s", strtotime($info['data_cadastro'])).'</div>
                    <img src="'.BASE_URL.'assets/images/icons/trashbin.png" onclick="deleteNote('.$info['id'].')" class="noteDelete">
                </div>
            ';
        }

        return $notes;
    }

    public function showNoteModal($id){
        $form = '
            <label>Título:</label>
            <input type="text" name="licitacao_id" value="'.$id.'" hidden>
            <input type="text" class="form-control form-control-sm" name="noteTitle">
            <hr/>
            <label>Nota:</label>
            <textarea class="form-control form-control-sm" name="noteText" id="noteText"></textarea>
        ';

        return $form;
    }

    public function saveNewNote($id, $title, $text, $data_cadastro, $user_id){
        $sql = $this->db->prepare("INSERT INTO notepad_contratos SET title = :title, text = :text, licitacao_id = :id, data_cadastro = :data_cadastro, user_id = :user_id");
        $sql->bindValue(":title", $title);
        $sql->bindValue(":text", $text);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":data_cadastro", $data_cadastro);
        $sql->bindValue(":user_id", $user_id);
        $sql->execute();

        $notes = '';
        $sql = $this->db->prepare("SELECT * FROM notepad_contratos WHERE licitacao_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $notes .='
            <button type="button" class="btn btn-info" onclick="addNewNote('.$id.')">Nova Nota</button><br/><hr/>
        ';
        foreach($data as $info){
            $notes .='
            <div class="notes">
                <input type="text" name="licitacao_id" value="'.$id.'" hidden>
                <div class="title">'.$info['title'].'</div>
                <div class="text">'.$info['text'].'</div>
                <div class="date">'.date("d/m/Y H:i:s", strtotime($info['data_cadastro'])).'</div>
                <img src="'.BASE_URL.'assets/images/icons/trashbin.png" onclick="deleteNote('.$info['id'].')" class="noteDelete">
            </div>
            ';
        }

        return $notes;
    }

    public function deleteNote($id, $licitacao_id) {
        $data = array();
        $sql = $this->db->prepare("DELETE FROM notepad_contratos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        $notes = '';
        $sql = $this->db->prepare("SELECT * FROM notepad_contratos WHERE licitacao_id = :id");
        $sql->bindValue(":id", $licitacao_id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $notes .='
            <button type="button" class="btn btn-info" onclick="addNewNote('.$licitacao_id.')">Nova Nota</button><br/><hr/>
        ';
        foreach($data as $info){
            $notes .='
            <div class="notes">
                <input type="text" name="licitacao_id" value="'.$licitacao_id.'" hidden>
                <div class="title">'.$info['title'].'</div>
                <div class="text">'.$info['text'].'</div>
                <div class="date">'.date("d/m/Y H:i:s", strtotime($info['data_cadastro'])).'</div>
                <img src="'.BASE_URL.'assets/images/icons/trashbin.png" onclick="deleteNote('.$info['id'].')" class="noteDelete">
            </div>
            ';
        }

        return $notes;
    }
    
    public function fetchStatus_info(){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM status_info ORDER BY name ASC");
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function addStatusInfo($status_info, $data_cadastro, $user_id){
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM status_info WHERE name = :status_info");
        $sql->bindValue(":status_info", $status_info);
        $sql->execute();

        if($sql->rowCount() == 0){

            $sql = $this->db->prepare("INSERT INTO status_info SET name = :status_info, data_cadastro = :data_cadastro, user_id = :user_id");
            $sql->bindValue(":status_info", $status_info);
            $sql->bindValue(":data_cadastro", $data_cadastro);
            $sql->bindValue(":user_id", $user_id);
            $sql->execute();

            $sql = $this->db->prepare("SELECT * FROM status_info ORDER BY name ASC");
            $sql->execute();

            if($sql->rowCount() > 0){
                $array = $sql->fetchAll(PDO::FETCH_ASSOC);
            }

            $result ='
                <label for="status_info">Motivo do Status</label>
                <div class="input-group">
                    <select class="custom-select custom-select-sm" name="status_info" required>
                        <option value="">Selecione...</option>
                        <option disabled> ------------------------ </option>';
                        foreach($array as $info){
                            $result .='
                                <option>'.$info['name'].'</option>
                            ';
                        }
                        $result .='
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-success btn-sm" type="button" onclick="addStatusInfo()"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                ';
            return $result;
        } else {
            $sql = $this->db->prepare("SELECT * FROM status_info ORDER BY name ASC");
            $sql->execute();

            if($sql->rowCount() > 0){
                $array = $sql->fetchAll(PDO::FETCH_ASSOC);
            }

            $result ='
                <label for="status_info">Motivo do Status</label>
                <div class="input-group">
                    <select class="custom-select custom-select-sm" name="status_info" required>
                        <option value="">Opção já existente</option>
                        <option disabled> ------------------------ </option>';
                        foreach($array as $info){
                            $result .='
                                <option>'.$info['name'].'</option>
                            ';
                        }
                        $result .='
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-success btn-sm" type="button" onclick="addStatusInfo()"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                ';
            return $result;
        }
    }

    public function delete_hist($id){
        $data = array();
        $historico = '';
        //FETCH THE LICITACAO ID
        $sql = $this->db->prepare("SELECT * FROM hist_licitacoes WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $licitacao_id = $sql->fetch(PDO::FETCH_ASSOC);
            $licitacao_id = $licitacao_id['licitacao_id'];
        }
        
        //EXECUTE THE HISTORY EXCLUSION
        $sql = $this->db->prepare("DELETE FROM hist_licitacoes WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        //FETCH THE HISTORY AGAIN
        $sql = $this->db->prepare("SELECT users.name AS user, cad_arquivos.url AS url, hist_licitacoes.* FROM hist_licitacoes LEFT JOIN users ON (users.id = hist_licitacoes.user_id) LEFT JOIN cad_arquivos ON (hist_licitacoes.licitacao_id = cad_arquivos.histLicitacao_id) WHERE licitacao_id = :licitacao_id");
        $sql->bindValue(":licitacao_id", $licitacao_id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $history = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach($history as $hist){
                $historico .='
                    <tr>
                        <td>'.$hist['titulo'].'</td>
                        <td>'.$hist['data_licitacao'].'</td>
                        <td>'.$hist['horario_licitacao'].'</td>
                        <td>'.$hist['obs'].'</td>
                        <td>'.$hist['user'].'</td>';
                        if(!empty($hist['url'])){
                            $historico .='
                            <td><a href="./documentos/'.$hist['url'].'" target="_blank"><i class="fas fa-paperclip"></i></a></td>    
                            ';
                        } else {
                            $historico .='
                            <td><i class="fas fa-times btn-outline-secondary"></i></td>';
                        }
                        $historico .='
                        <td><button type="button" class="btn btn-outline-danger" onclick="delete_hist('.$hist['id'].')" style="text-align: center"><i class="fas fa-trash"></i></button></td>
                    </tr>
                ';
            }
        }

        return $historico;
    }

    public function allLicPanel() {
        $sql = $this->db->prepare("SELECT cad_empresas.name AS company_name, cad_licitacao.* FROM cad_licitacao 
            LEFT JOIN cad_empresas ON (cad_empresas.id = cad_licitacao.company)
            WHERE data BETWEEN DATE_ADD(CURDATE(), INTERVAL 0 DAY) AND DATE_ADD(CURDATE(), INTERVAL 10 DAY) ORDER BY data ASC, hora ASC");
        $sql->execute();

        if($sql->rowCount() > 0) {
            $info = $sql->fetchAll(PDO::FETCH_ASSOC);
            
            return $info;
        } else {
            return '';
        }
    }
}