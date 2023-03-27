<div class="section_top">
    Clientes Cadastrados
</div>
<br/>
<div class="container-fluid">
    <div style="height: 80vh; overflow: auto">
        <table class="table table-striped table-hover table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>Cód. STUR</th>
                    <th>Nome</th>
                    <th>Razão Social</th>
                    <th style="width: 150px">CNPJ</th>
                    <th style="width: 250px">Empresa</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody style="font-size: 10px"> 
                <?php foreach($get_clientes as $c): ?>
                    <tr>
                        <td><?php echo $c['stur_cod']; ?></td>
                        <td><?php echo $c['nome_cliente']; ?></td>
                        <td><?php echo $c['razao_social']; ?></td>
                        <td><?php echo $c['cnpj']; ?></td>
                        <td><?php echo $c['company_name']; ?></td>
                        <td style="width: 15%">
                            <button class="btn btn-outline-warning btn-sm" onclick="editar_clientes(<?php echo $c['id']; ?>)"><i class="fas fa-pen"></i></button>
                            <button class="btn btn-outline-danger btn-sm" onclick="excluir_clientes(<?php echo $c['id']; ?>)"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal Adicionar Sistemas-->
<div class="modal fade" id="modal_clientes">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Clientes</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_clientes"><br />
				<!-- Modal body -->
				<div class="modal-body">
                    <div class="row">
                        <div class="col-sm-1">
                            <label for="stur_cod">Cod. STUR</label>
                            <input type="text" name="id" hidden>
                            <input type="text" name="acao_clientes" value="" hidden>
                            <input type="number" class="form-control form-control-sm" name="stur_cod">
                        </div>
                        <div class="col-sm-4">
                            <label for="nome_cliente">Nome do Cliente:</label>
                            <input type="text" class="form-control form-control-sm" name="nome_cliente" required>
                        </div>
                        <div class="col-sm-4">
                            <label for="razao_social">Razão Social:</label>
                            <input type="text" class="form-control form-control-sm" name="razao_social">
                        </div>
                        <div class="col-sm-3">
                            <label for="cnpj">CNPJ / CPF:</label>
                            <input type="text" class="form-control form-control-sm" name="cnpj">
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm">
                            <label for="address">Endereço:</label>
                            <input type="text" class="form-control form-control-sm" name="address" required>
                        </div>
                        <div class="col-sm">
                            <label for="neighbour">Bairro:</label>
                            <input type="text" class="form-control form-control-sm" name="neighbour" required>
                        </div>
                        <div class="col-sm">
                            <label for="cep">CEP:</label>
                            <input type="text" class="form-control form-control-sm" name="cep" required>
                        </div>
                        <div class="col-sm">
                            <label for="phone">Telefone:</label>
                            <input type="text" class="form-control form-control-sm" name="phone">
                        </div>
                    </div>
                    <br/>
                    <hr/>
                    <div class="row">
                        <div class="col-sm">
                            <label for="state">Estado:</label>
                            <select class="form-control form-control-sm" name="state" onchange="fetchCities()">
                                <option value="">Selecione...</option>
                                <?php foreach($estados as $estado): ?>
                                    <option value="<?php echo $estado['id']; ?>"><?php echo $estado['estado']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm" id="city">
                            <label for="cidade">Cidade:</label>
                            <input type="text" class="form-control form-control-sm" name="city" disabled>
                        </div>
                        <div class="col-sm">
                            <label for="email">E-mail:</label>
                            <input type="mail" class="form-control form-control-sm" name="email">
                        </div>
                        <div class="col-sm">
                            <label>Empresa</label>
                            <select class="form-control form-control-sm" name="empresa" required>
                                <option value="">Selecione...</option>
                                <option disabled>-----------------------------------------------------------</option>
                                <?php foreach($getCompanies as $empresas): ?>
                                    <option><?php echo $empresas['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
					<button type="submit" class="btn btn-success">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="../assets/js/cadastrar.js"></script>


