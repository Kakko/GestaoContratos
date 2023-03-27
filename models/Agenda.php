<?php
class Agenda extends Model {

    public function getAgendaLicitacao() {
        $array = array();

        $sql = $this->db->prepare("SELECT (SELECT companies FROM users WHERE id = :userID) as company_permission, cad_licitacao.* FROM cad_licitacao");
        $sql->bindValue(":userID", $_SESSION['lgUser']);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function getAgendaContratos() {
        $array = array();

        $sql = $this->db->prepare("SELECT (SELECT companies FROM users WHERE id = :userID) as company_permission, cad_contratos.* FROM cad_contratos");
        $sql->bindValue(":userID", $_SESSION['lgUser']);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function getAgendaDocuments() {
        $array = array();

        $sql = $this->db->prepare("SELECT (SELECT companies FROM users WHERE id = :userID) as company_permission, cad_documents.* FROM cad_documents");
        $sql->bindValue(":userID", $_SESSION['lgUser']);
        $sql->execute();

        if($sql->rowCount() > 0){
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }


    //INICIO EXIBIÇÃO AGENDA
    public function fetchLicitacao($id){ //LICITAÇÕES NA AGENDA
        $data = '';

        $sql = $this->db->prepare("SELECT * FROM cad_licitacao WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $info = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $prod = array();
        $sql = $this->db->prepare("SELECT * FROM prod_licitacao WHERE licitacao_id = :id"); //PRODUTOS CADASTRADOS
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $prod = $sql->fetch(PDO::FETCH_ASSOC);
        }

        $sql = $this->db->prepare("SELECT * FROM cad_empresas_vencedoras WHERE licitacao_id = :id"); //EMPRESAS VENCEDORAS
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $comp = $sql->fetch(PDO::FETCH_ASSOC);
        }

        $sql = $this->db->prepare("SELECT cad_arquivos.url, hist_licitacoes.* FROM hist_licitacoes
        LEFT JOIN cad_arquivos ON (cad_arquivos.histLicitacao_id = hist_licitacoes.id)
        WHERE licitacao_id = :id"); //HISTÓRICO DAS LICITAÇÕES
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $hist = $sql->fetch(PDO::FETCH_ASSOC);
        }

        foreach($info as $dados){
            $data = '
            <div class="container-fluid" style="border: 1px solid lightgray; border-radius: 5px; box-shadow: 0 0 10px lightgray">
                <div class="row">
                    <div class="col-sm">
                        <label style="font-weight: bolder">Data:</label><br/>
                        <input type="text" class="exib_dados" id="data" value="'.$dados['data'].'" readonly>
                    </div>
                    <div class="col-sm">
                        <label style="font-weight: bolder">Hora:</label>
                        <input type="text" class="exib_dados" id="hora" value="'.$dados['hora'].'" readonly>
                    </div>
                    <div class="col-sm">
                        <label style="font-weight: bolder">Sistema:</label>
                        <input type="text" class="exib_dados" id="system" value="'.$dados['cad_system'].'" readonly>
                    </div>
                    <div class="col-sm">
                        <label style="font-weight: bolder">Valor:</label>
                        <input type="text" class="exib_dados" id="value" value="'.$dados['value'].'" readonly>
                    </div>
                    <div class="col-sm">
                        <label style="font-weight: bolder">Complemento:</label>
                        <input type="text" class="exib_dados" id="complemento" value="'.$dados['complemento'].'" readonly>
                    </div>
                    <div class="col-sm">
                        <label style="font-weight: bolder">Nº do Pregão:</label>
                        <input type="text" class="exib_dados" id="auction" value="'.$dados['auction'].'" readonly>
                    </div>
                    <div class="col-sm">
                        <label style="font-weight: bolder">Identificador</label>
                        <input type="text" class="exib_dados" id="complement" value="'.$dados['complement'].'" readonly>
                    </div>
                    <div class="col-sm">
                        <label style="font-weight: bolder">Cidade:</label>
                        <input type="text" class="exib_dados" id="city" value="'.$dados['city'].'" readonly>
                    </div>
                    <div class="col-sm">
                        <label style="font-weight: bolder">UF:</label>
                        <input type="text" class="exib_dados" id="uf" value="'.$dados['uf'].'" readonly>
                    </div>
                </div>
                <br><hr/>
                <div class="row">
                    <div class="col-sm-2">
                        <label style="font-weight: bolder">Órgão:</label>
                        <input type="text" class="exib_dados" id="agency" value="'.$dados['agency'].'" readonly>
                    </div>
                    <div class="col-sm-2">
                        <label style="font-weight: bolder">Empresa:</label>
                        <input type="text" class="exib_dados" id="company" value="'.$dados['company'].'" readonly>
                    </div>
                    <div class="col-sm-2">
                        <label style="font-weight: bolder">Status:</label>
                        <input type="text" class="exib_dados" id="status" value="'.$dados['status'].'" readonly>
                    </div>
                    <div class="col-sm-2">
                        <label style="font-weight: bolder">Esclarecimentos:</label>
                        <input type="text" class="exib_dados" id="esclarecimentos" value="'.$dados['esclarecimentos'].'" readonly>
                    </div>
                    <div class="col-sm-2">
                        <label style="font-weight: bolder">Ata:</label>
                        <input type="text" class="exib_dados" id="ata" value="'.$dados['ata'].'" readonly>
                    </div>
                    <div class="col-sm-2">
                        <label style="font-weight: bolder">Modalidades:</label>
                        <input type="text" class="exib_dados" id="modalidades" value="'.$dados['modalidades'].'" readonly>
                    </div>
                </div>
                <br><hr/>
                <div class="row">
                    <div class="col-sm-4">
                        <label style="font-weight: bolder">Objetos:</label>
                        <input type="text" class="exib_dados" id="object" value="'.$dados['object'].'" readonly>
                    </div>
                    <div class="col-sm-4">
                        <label style="font-weight: bolder">Agenciamento</label>
                        <input type="text" class="exib_dados" id="ag_cadast" value="'.$dados['ag_cadast'].'" readonly>
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
                            <tbody id="table_prod">
                                <tr>
                                    <td>'.$prod['name'].'</td>
                                    <td>'.$prod['desconto'].'</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br><hr/>
                <div class="row">
                    <div class="col-sm-8">
                        <label style="font-weight: bolder">Observações:</label>
                        <textarea type="text" class="exib_dados" id="obs" style="resize: none" readonly>'.$dados['obs'].'</textarea>
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
                            <tbody id="table_win">
                                <tr>';
                                    if(!empty($comp['name'])){
                                        $data .='
                                        <td>'.$comp['name'].'</td>
                                        <td>'.number_format($comp['value'], 4, ',', '.').'</td>
                                        <td>'.$comp['perc'].' %</td>';
                                    } else {
                                        $data .='
                                        <td> - </td>
                                        <td> - </td>
                                        <td> - </td>';
                                    }
                                    $data .='
                                </tr>
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
                                        <th>Download</th>
                                    </tr>
                                </thead>
                                <tbody id="table-hist">
                                    <tr>';
                                        if(!empty($hist['licitacao_id'])){
                                            $data .='
                                            <td>'.$hist['titulo'].'</td>
                                            <td>'.$hist['data_licitacao'].'</td>
                                            <td>'.$hist['horario_licitacao'].'</td>
                                            <td>'.$hist['obs'].'</td>
                                            <td><a href="'.BASE_URL.'documentos/'.$hist['url'].'" target="_blank"><i class="fas fa-paperclip"></i></a></td>';
                                        } else {
                                            $data .='
                                            <td> - </td>
                                            <td> - </td>
                                            <td> - </td>
                                            <td> - </td>
                                            <td> - </td>';
                                        }
                                        $data .='
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <br/>
            </div>
            ';
        }
        return $data;
    }

    public function fetchContratos($id){

        $data = '';

        $sql = $this->db->prepare("SELECT * FROM cad_contratos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $dados = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        $sql = $this->db->prepare("SELECT cad_arquivos.url, hist_contratos.* FROM hist_contratos
        LEFT JOIN cad_arquivos ON (cad_arquivos.histContrato_id = hist_contratos.id)
        WHERE contrato_id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $history = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        foreach($dados as $dado){
            $data .='
            <div class="row">
                <div class="col-md-1">
                    <label style="font-weight: bolder">Cod:</label><br/>
                    <input id="cod_stur" class="exib_dados" type="text" value="'.$dado['cod'].'" readonly>
                </div>
                <div class="col-md">
                    <label style="font-weight: bolder">Nome Cliente:</label><br/>
                    <input id="nome_cliente" class="exib_dados" type="text" value="'.$dado['nome_cliente'].'" readonly>
                </div>
                <div class="col-md-3">
                    <label style="font-weight: bolder">Razão Social:</label><br/>
                    <input id="razao_social_ver" class="exib_dados" type="text" value="'.$dado['razao_social'].'" readonly>
                </div>
                <div class="col-md">
                    <label style="font-weight: bolder">Nº do Contrato:</label><br/>
                    <input id="n_contrato" class="exib_dados" type="text" value="'.$dado['n_contrato'].'" readonly>
                </div>
                <div class="col-md">
                    <label style="font-weight: bolder">Emissor</label><br/>
                    <input id="emissor" class="exib_dados" type="text" value="'.$dado['emissor'].'" readonly>
                </div>
                <div class="col-md">
                    <label style="font-weight: bolder">Empresa:</label><br/>
                    <input id="empresa" class="exib_dados" type="text" value="'.$dado['empresa'].'" readonly>
                </div>
            </div>
            <br><br/>
            <div class="row">
                <div class="col-md-3">
                    <label style="font-weight: bolder">CNPJ:</label><br/>
                    <input id="cnpj_ver" class="exib_dados" type="text" value="'.$dado['cnpj'].'" readonly>
                </div>
                <div class="col-md-2">
                    <label style="font-weight: bolder">Tipo de Cliente:</label><br/>
                    <input id="cod2" class="exib_dados" type="text" value="'.$dado['cod2'].'" readonly>
                </div>
                <div class="col-md-2">
                    <label style="font-weight: bolder">Valor:</label><br/>
                    <input id="valor" class="exib_dados" type="text" value="'.number_format($dado['valor'], 2, ',', '.').'" readonly>
                </div>
                <div class="col-md-2">
                    <label style="font-weight: bolder">Quantitativo:</label>
                    <input type="text" class="exib_dados" id="complemento" value="'.$dado['complemento'].'" readonly>
                </div>
                <div class="col-md-3">
                    <label style="font-weight: bolder">Faturamento:</label><br/>
                    <input id="faturamento" class="exib_dados" type="text" value="'.$dado['faturamento'].'" readonly>
                </div>
            </div>
            <br><br/>
            <div class="row">
                <div class="col-md-3">
                    <label style="font-weight: bolder">Vencimento:</label><br/>
                    <input id="vencimento" class="exib_dados" type="text" value="'.$dado['vencimento'].'" readonly>
                </div>
                <div class="col-md-2">
                    <label style="font-weight: bolder">Reembolso</label>
                    <input id="reembolso" type="text" class="exib_dados" name="reembolso" value="'.$dado['reembolso'].'">
                </div>
                <div class="col-md-3">
                    <label style="font-weight: bolder">Detalhes:</label><br/>
                    <input id="detalhes" class="exib_dados" type="text" value="'.$dado['detalhes'].'" readonly>
                </div>
                <div class="col-md-3">
                    <label style="font-weight: bolder">Situação:</label><br/>
                    <input id="situacao" class="exib_dados" type="text" value="'.$dado['situacao'].'" readonly>
                </div>
                <div class="col-md-1">
                    <label style="font-weight: bolder">Lei Kandir:</label><br/>
                    <input id="lei_kandir" class="exib_dados" type="text" value="'.$dado['lei_kandir'].'" readonly>
                </div>
            </div>
            <br><br/>
            <div class="row">
                <div class="col-md-6">
                    <label style="font-weight: bolder">Início do Contrato:</label><br/>
                    <input id="inicio_contrato" class="exib_dados" type="text" value="'.date("d/m/Y", strtotime($dado['inicio_contrato'])).'" readonly>
                </div>
                <div class="col-md-6">
                    <label style="font-weight: bolder">Final do Contrato</label><br/>
                    <input id="fim_contrato" class="exib_dados" type="text" value="'.date("d/m/Y", strtotime($dado['fim_contrato'])).'" readonly>
                </div>
            </div>
            <br><br/>
                <div id="button_licitacaoInfo">

                </div>
            <br/><br/><br/>
            <div class="row" style="border-bottom: 1px solid lightgray; border-top: 1px solid lightgray">
                <div class="col-md-12" style="border-right: 1px solid lightgray">
                    <label style="font-weight: bolder">Histórico:</label>
                    <div id="historico">
                        <table class="table table-striped table-hover table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Título</th>
                                    <th>Data</th>
                                    <th>Horário</th>
                                    <th>Observações</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody id="table-hist">';
                                foreach($history as $hist){
                                    if(!empty($hist['contrato_id'])){
                                        $data .= '
                                        <tr>
                                            <td>'.$hist['titulo'].'</td>
                                            <td>'.$hist['data_contrato'].'</td>
                                            <td>'.$hist['horario_contrato'].'</td>
                                            <td>'.$hist['obs'].'</td>
                                            <td><a href="'.BASE_URL.'documentos/'.$hist['url']. '" target="_blank"><i class="fas fa-paperclip"></i></a></td>
                                        </tr>';
                                    } else {
                                        $data .='
                                        <tr>
                                            <td> - </td>
                                            <td> - </td>
                                            <td> - </td>
                                            <td> - </td>
                                            <td> - </td>
                                        </tr>';
                                    }
                                }
                                $data .='
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            ';
        }

        return $data;
    }
}