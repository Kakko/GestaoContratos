<style> 
    @keyframes rollMonkey {
            from {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            to {
                -ms-transform: rotate(720deg);
                -moz-transform: rotate(720deg);
                -webkit-transform: rotate(720deg);
                -o-transform: rotate(720deg);
                transform: rotate(720deg);
            }
        }

        .monkeyB {
            animation: rollMonkey 2s 3;
            animation-fill-mode: forwards;
        }
</style>
<div class="section_top">
    Análise de Contratos
</div><br/>
<form target="_blank" action="analise/analise_xls" method="POST">
    <div class="container-fluid">
        <div style="width: 50%; margin: auto">
            <div style="display: inline-block; width: 50%">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="data" value="contratos" id="contrato1" onchange="showContrato()">
                    <label class="form-check-label" for="contrato1">Contratos</label>
                </div>
            </div>
            <div style="display: inline-block">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="data" value="aditivos" id="aditivo1" onchange="showAditivo()">
                    <label class="form-check-label" for="aditivo1">Aditivo</label>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="hidden" id="contratosData">
                    <div style="display: inline-block">
                        <div class="col-sm" style="display: inline-block">
                            <label>Inicio Contrato de</label>
                            <input type="date" class="form-control form-control-sm" name="inicioContratode" id="inicioContratode">
                        </div>
                        <div class="col-sm" style="display: inline-block">
                            <label>Inicio Contrato até</label>
                            <input type="date" class="form-control form-control-sm" name="inicioContratoate" id="inicioContratoate">
                        </div>
                    </div>
                    <div style="display: inline-block">
                        <div class="col-sm" style="display: inline-block">
                            <label>Fim Contrato de</label>
                            <input type="date" class="form-control form-control-sm" name="fimContratode" id="fimContratode">
                        </div>
                        <div class="col-sm" style="display: inline-block">
                            <label>Fim Contrato até</label>
                            <input type="date" class="form-control form-control-sm" name="fimContratoate" id="fimContratoate">
                        </div>
                    </div>
                </div>
                <div class="hidden" id="aditivosData">
                    <div style="display: inline-block">
                            <div class="col-sm" style="display: inline-block">
                                <label>Inicio Aditivo de</label>
                                <input type="date" class="form-control form-control-sm" name="inicioAditivode" id="inicioAditivode">
                            </div>
                            <div class="col-sm" style="display: inline-block">
                                <label>Inicio Aditivo até</label>
                                <input type="date" class="form-control form-control-sm" name="inicioAditivoate" id="inicioAditivoate">
                            </div>
                        </div>
                        <div style="display: inline-block">
                            <div class="col-sm" style="display: inline-block">
                                <label>Fim Aditivo de</label>
                                <input type="date" class="form-control form-control-sm" name="fimAditivode" id="fimAditivode">
                            </div>
                            <div class="col-sm" style="display: inline-block">
                                <label>Fim Aditivo até</label>
                                <input type="date" class="form-control form-control-sm" name="fimAditivoate" id="fimAditivoate">
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <br/>
        <div style="width: 50%; margin: auto">
                <label>Selecione a Empresa:</label>
                <input type="text" name="acao_faturas" value="" hidden>
                <select class="form-control form-control-sm" name="empresa" id="empresa_analise" onchange="filtrar_empresas()">
                    <option>Selecione...</option>
                    <?php foreach($getCompanies as $e): ?>
                        <?php 
                            $companyPermission = explode(',', $e['company_permission']);
                            if(in_array($e['id'], $companyPermission)): 
                        ?>
                        <option value="<?php echo $e['id']; ?>"><?php echo $e['name']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
        </div>
        </input><br/>
        <div class="container-fluid" style="overflow: auto">
            <div style="width: 150%; height: 500px; margin: auto;" id="dados">
            
            </div>
        </div>
        <input type="button" class="btn btn-success" value="Gerar XLS" style="float: right; margin-right: 5%" onclick="gerar_xls()">
    <!-- Bolotinha -->
    <div id="BSOD" style="width: 100%; height: 100vh; background-color:rgba(0,0,0,0.5); position: absolute; display: none; top: 0; left: 0">
        <div id="loading" style="height: auto; align-self: center; position: absolute; left: 50%; top: 50%; margin-top: -120px; text-align: center">
        <img style="height: 120px" class="monkeyB" src="<?php echo BASE_URL; ?>assets/images/icons/logoMonkeyBranch.png" alt="">
        <br/><br/>
            <span style="font-size: 25px; font-weight: bolder">Carregando</span>
        </div>
    </div>
</form>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/analises.js"></script>