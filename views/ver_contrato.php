<!-- <?php foreach($returnContrato as $return): ?>
    <form method="POST">
        <div class="section_top">
            Edição do contrato nº: <u><?php echo $return['n_contrato']; ?></u>
        </div>
            <div class="container-fluid" style="background-color: #fff; width: 90%; height: 500px; box-shadow: 0 0 20px gray; border-radius: 10px; margin-top: 50px; padding-top: 10px">
                <div class="row">
                    <div class="col-md-1">
                        <label for="cod">Cód STUR:</label>
                        <input type="number" class="form-control form-control-sm" name="cod" value="<?php echo $return['cod']; ?>" id="cod" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="nome_cliente">Nome Cliente:</label>
                        <select class="form-control form-control-sm" name="nome_cliente" onchange="cod_stur()" id="cliente_contrato">
                            <option value="<?php echo $return['nome_cliente']; ?>"><?php echo $return['nome_cliente']; ?></option>
                            <option disabled>----------------------------------------------------------------------</option>
                            <?php foreach($getNomeCliente as $nome_cliente): ?>
                                <option><?php echo $nome_cliente['nome_cliente']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="razao_social">Razão Social:</label>
                        <input type="text" class="form-control form-control-sm" name="razao_social" value="<?php echo $return['razao_social']; ?>" id="razao_social" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="cnpj">CNPJ:</label>
                        <input type="text" class="form-control form-control-sm" value="<?php echo $return['cnpj']; ?>" name="cnpj" id="cnpj" readonly>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-2">
                        <label for="n_contrato">Nº do Contrato:</label>
                        <input type="text" class="form-control form-control-sm" value="<?php echo $return['n_contrato']; ?>" name="n_contrato">
                    </div>
                    <div class="col-md-2">
                        <label for="emissor">Emissor:</label>
                        <input type="text" class="form-control form-control-sm" value="<?php echo $return['emissor']; ?>" name="emissor">
                    </div>
                    <div class="col-md-5">
                        <label for="empresa">Empresa:</label>
                        <input type="text" class="form-control form-control-sm" value="<?php echo $return['empresa']; ?>" name="empresa" readonly>
                    </div>
                    <div class="col-md-1">
                        <label for="cod2">Cód:</label>
                        <input type="text" class="form-control form-control-sm" value="<?php echo $return['cod2']; ?>" name="cod2">
                    </div>
                    <div class="col-md-2">
                        <label for="valor">Valor:</label>
                        <input type="text" class="form-control form-control-sm valor" value="<?php echo $return['valor']; ?>" name="valor">
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-2">
                        <label for="faturamento">Faturamento:</label>
                        <input type="text" class="form-control form-control-sm" value="<?php echo $return['faturamento']; ?>" name="faturamento">
                    </div>
                    <div class="col-md-2">
                        <label for="vencimento">Vencimento:</label>
                        <input type="text" class="form-control form-control-sm" value="<?php echo $return['vencimento']; ?>" name="vencimento">
                    </div>
                    <div class="col-md-2">
                        <label>Reembolso</label>
                        <input type="text" class="form-control form-control-sm" value="<?php echo $return['reembolso']; ?>" name="reembolso">
                    </div>
                    <div class="col-md-6">
                        <label for="detalhes">Detalhes:</label>
                        <input type="text" class="form-control form-control-sm" value="<?php echo $return['detalhes']; ?>" name="detalhes">
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md">
                        <label for="situacao">Situação:</label>
                        <select class="form-control form-control-sm" name="situacao">
                            <option><?php echo $return['situacao']; ?></option>
                            <option disabled>-----------------------------------------------</option>
                            <option>Ativo</option>
                            <option>Inativo</option>
                        </select>
                    </div>
                    <div class="col-md">
                        <label for="lei_kandir">Lei Kandir:</label>
                        <select class="form-control form-control-sm" name="lei_kandir">
                            <option><?php echo $return['lei_kandir']; ?></option>
                            <option disabled>-----------------------------------------------</option>
                            <option value="S">Sim</option>
                            <option value="N">Não</option>
                        </select>
                    </div>
                    <div class="col-md">
                        <label for="inicio">Início do Contrato:</label>
                        <input type="date" class="form-control form-control-sm" name="inicio_contrato" value="<?php echo $return['inicio_contrato']; ?>">
                    </div>
                    <div class="col-md">
                        <label for="fim">Fim do Contrato:</label>
                        <input type="date" class="form-control form-control-sm" name="fim_contrato" value="<?php echo $return['fim_contrato']; ?>">
                    </div>
                </div><br/><br/>
                <input type="submit" class="btn btn-success" style="float:right; margin-left: 10px" value="Salvar">
                <a href="<?php echo BASE_URL; ?>agenda"><button type="button" class="btn btn-info" style="float:right">Voltar</button></a>
            </div>
    </form>
<?php endforeach; ?> -->