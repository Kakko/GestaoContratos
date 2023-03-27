<div class="section_top">
    Relatórios Contratos
</div><br/>
<div class="container-fluid"><br/>
    <div class="container" style="border: 1px solid lightgray; border-radius: 5px; box-shadow: 0 0 10px gray; padding: 30px">
        <form method="POST" class="form-group" id="form_relatorios" target="_blank">
            <div class="row">
                <div class="col-sm-3">
                    <label for="data_de">Início Contrato de:</label>
                    <input type="text" name="tipo_contratos" value="contratos" hidden>
                    <input type="date" class="form-control form-control-sm" name="inicio_de">
                </div>
                <div class="col-sm-3">
                    <label for="data_de">Início Contrato até:</label>
                    <input type="date" class="form-control form-control-sm" name="inicio_ate">
                </div>
                <div class="col-sm-3">
                    <label for="data_de">Fim Contrato de:</label>
                    <input type="date" class="form-control form-control-sm" name="fim_de">
                </div>
                <div class="col-sm-3">
                    <label for="data_de">Fim Contrato até:</label>
                    <input type="date" class="form-control form-control-sm" name="fim_ate">
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-5">
                    <label for="nome_cliente">Nome Cliente:</label>
                    <select class="form-control form-control-sm" name="id_cliente">
                        <option value="">Selecione...</option>
                        <?php foreach($nome_cliente as $c): ?>
                            <option value="<?php echo $c['id']; ?>"><?php echo $c['id']; ?> - <?php echo $c['nome_cliente']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="sistema">Empresa:</label>
                    <select class="form-control form-control-sm" name="empresas">
                        <option value="">Selecione...</option>
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
                <div class="col-sm-2">
                    <label for="situacao">Situação:</label>
                    <select class="form-control form-control-sm" name="situacao">
                        <option value="">Selecione...</option>
                        <option>Ativo</option>
                        <option>Inativo</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="lei_kandir">Lei Kandir:</label>
                    <select class="form-control form-control-sm" name="lei_kandir">
                        <option value="">Selecione...</option>
                        <option>Sim</option>
                        <option>Não</option>
                    </select>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-3">
                    <label for="inadimplente">Cliente Inadimplente:</label>
                    <select class="form-control form-control-sm" name="inadimplente">
                        <option value="">Selecione...</option>
                        <option>Sim</option>
                        <option>Não</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="estado">Estado:</label>
                    <select class="form-control form-control-sm" name="state">
                        <option value="">Selecione...</option>
                        <?php foreach($estados as $state): ?>
                            <option value="<?php echo $state['id']; ?>"><?php echo $state['estado']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="campos">Campos do Formulário</label>
                    <div class="report_fields">
                        <div class="check_area">
                            <label for="checkCode">STUR:</label>
                            <input type="checkbox" name="checkCode" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkName">Nome:</label>
                            <input type="checkbox" name="checkName" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkContrato">Contrato:</label>
                            <input type="checkbox" name="checkContrato" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkEmissor">Emissor:</label>
                            <input type="checkbox" name="checkEmissor" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkCNPJ">CNPJ:</label>
                            <input type="checkbox" name="checkCNPJ" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkValue">Valor:</label>
                            <input type="checkbox" name="checkValue" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkCod2">Código:</label>
                            <input type="checkbox" name="checkCod2" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkVencimento">Vencimento:</label>
                            <input type="checkbox" name="checkVencimento" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkMail">Email:</label>
                            <input type="checkbox" name="checkMail" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkPhone">Telefone:</label>
                            <input type="checkbox" name="checkPhone" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkSituacao">Situação:</label>
                            <input type="checkbox" name="checkSituacao" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkKandir">Lei Kandir:</label>
                            <input type="checkbox" name="checkKandir" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkDetails">Detalhes:</label>
                            <input type="checkbox" name="checkDetails" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkAditivo">Aditivo:</label>
                            <input type="checkbox" name="checkAditivo" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkSTURValue">Valor STUR:</label>
                            <input type="checkbox" name="checkSTURValue" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkProfitValue">Lucro STUR:</label>
                            <input type="checkbox" name="checkProfitValue" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkContStart">Data Início:</label>
                            <input type="checkbox" name="checkContStart" value="s">
                        </div>
                        <div class="check_area">
                            <label for="checkContEnd">Data Fim:</label>
                            <input type="checkbox" name="checkContEnd" value="s">
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <input type="submit" class="btn btn-success" value="Gerar PDF" style="float: right">
            <input type="button" class="btn btn-info" value="Gerar XLS" style="float: right; margin-right: 10px" onclick="xlsContratos()">
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
<script>
    function xlsContratos(){
        let form_original = $('#form_relatorios').html();
        $('#form_relatorios').attr('action', 'xlsContratos');
        $("[name='tipo_contratos']").val('contratos_xls');
        $('#form_relatorios').submit();
        $('#form_relatorios').removeAttr('action');
        $('#form_relatorios')[0].reset();
    }
</script>