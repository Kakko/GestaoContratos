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
    Relatórios Gerais
</div><br/>
<form target="_blank" action="rel_clientes_xls" method="POST">
    <div class="container-fluid">
        <div style="width: 50%; margin: auto">
            <label>Selecione a Empresa:</label>
            <select class="form-control form-control-sm" name="empresa" id="empresa" onchange="rel_cliente()">
                <option value="">Selecione...</option>
                <?php foreach($getCompanies as $e): ?>
                    <?php 
                        $companyPermission = explode(',', $e['company_permission']);
                        if(in_array($e['id'], $companyPermission)): 
                    ?>
                    <option><?php echo $e['name']; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <br />
        <hr/>
        <br/>
        <div id="rel_clientes" style="width: 50%; margin: auto">
        
        </div>
        <br/>
        <div id="table_dados" style="width: 90%; margin: auto">
        
        </div>
    </div>
    <!-- Bolotinha -->
    <div id="BSOD" style="width: 100%; height: 100vh; background-color:rgba(0,0,0,0.5); position: absolute; display: none; top: 0; left: 0">
        <div id="loading" style="height: auto; align-self: center; position: absolute; left: 50%; top: 50%; margin-top: -120px; text-align: center">
        <img style="height: 120px" class="monkeyB" src="<?php echo BASE_URL; ?>assets/images/icons/logoMonkeyBranch.png" alt="">
        <br/><br/>
            <span style="font-size: 25px; font-weight: bolder">Carregando</span>
        </div>
    </div>
</form>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/geral.js"></script>