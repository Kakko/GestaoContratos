<div class="section_top">
    Relatórios Licitações
</div><br/>
<div class="container-fluid"><br/>
    <div class="container" style="border: 1px solid lightgray; border-radius: 5px; box-shadow: 0 0 10px gray; padding: 30px">
        <form method="POST" class="form-group" id="form_relatorios" target="_blank">
            <div class="row">
                <div class="col-sm-3">
                    <label for="data_de">Data de:</label>
                    <input type="text" name="tipo_relatorio" value="licitacao" hidden>
                    <input type="date" class="form-control form-control-sm" name="data_de">
                </div>
                <div class="col-sm-3">
                    <label for="data_de">Data até:</label>
                    <input type="date" class="form-control form-control-sm" name="data_ate">
                </div>
                <div class="col-sm-3">
                    <label for="status">Status:</label>
                    <select class="form-control form-control-sm" name="status">
                        <option value="">Selecione...</option>
                        <option>Pré Cadastro</option>
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
                    </select>
                </div>
                <div class="col-sm-3">
                    <label>Empresas Vencedoras:</label>
                    <select class="form-control form-control-sm" name="winner_company">
                        <option value="">Selecione...</option>
                        <?php foreach($winner_company as $win): ?>
                            <option><?php echo $win['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-4">
                    <label for="sistema">Sistema:</label>
                    <select class="form-control form-control-sm" name="sistema">
                        <option value="">Selecione...</option>
                        <?php foreach($get_sistemas as $s): ?>
                        <option><?php echo $s['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="sistema">Órgão:</label>
                    <select class="form-control form-control-sm" name="orgao">
                        <option value="">Selecione...</option>
                        <?php foreach($get_orgaos as $s): ?>
                        <option><?php echo $s['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-2" style="text-align: center">
                    <label>Agência:</label><br/>
                    <input type="checkbox" name="agencia" value="on">
                </div>
                <div class="col-sm-2" style="text-align: center">
                    <label>Agrupar Resultados:</label><br/>
                    <input type="checkbox" name="group" value="on">
                </div>
            </div><br/>
            <div class="row">
                <div class="col-sm-6">
                    <label for="sistema">Empresas:</label>
                    <select class="multiple_select" name="empresas[]" multiple style="height: 150px">
                        <option value="">Todas</option>
                        <?php foreach($get_empresas as $s): ?>
                            <?php 
                                $companyPermission = explode(',', $s['company_permission']);
                                if(in_array($s['id'], $companyPermission)): 
                            ?>
                            <option value="<?php echo $s['id']; ?>"><?php echo $s['name']; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="campos">Campos do Formulário</label>
                    <div class="report_fields">
                        <div class="check_area">
                            <label for="checkData">Data:</label>
                            <input type="checkbox" name="checkData" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkObj">Objeto:</label>
                            <input type="checkbox" name="checkObj" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkOrg">Órgão:</label>
                            <input type="checkbox" name="checkOrg" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkEdital">Edital:</label>
                            <input type="checkbox" name="checkEdital" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkSys">Sistema:</label>
                            <input type="checkbox" name="checkSys" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkComp">Empresa:</label>
                            <input type="checkbox" name="checkCom" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkStat">Status:</label>
                            <input type="checkbox" name="checkStat" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkSinf">Status Info:</label>
                            <input type="checkbox" name="checkSinf" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkVal">Valor:</label>
                            <input type="checkbox" name="checkVal" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkTit">Título:</label>
                            <input type="checkbox" name="checkTit" value="s">
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <input type="submit" class="btn btn-success" value="Gerar PDF" style="float: right; margin-top: -10px">
        </form>
    </div>
</div>
<style>
    .multiple_select {
        border: none;
        border-radius: 5px;
        outline: none;
    }
    .multiple_select option {
        border-bottom: 1px solid #DDD;
        margin-bottom: 3px;
    }

    .report_fields {
        width: 100%;
        height: 80%;
        border: 1px solid #CCC;
        border-radius: 5px;
        background-color: #FFF;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        align-items: center;
        background-color: #EEE;
    }
    .check_area {
        width: 25%;
        height: 25px;
        padding-left: 10px;
        font-weight: 500;
    }
    .check_area input {
        margin-left: 5px;
    }
</style>