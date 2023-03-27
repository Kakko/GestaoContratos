<div class="section_top">
    Empresas Cadastradas
</div>
<br/>
<div class="container-fluid">
	<div class="dados" style="height: 80vh; overflow: auto">
		<table class="table table-striped table-hover table-sm">
			<thead class="thead-dark">
				<tr>
					<th>Nome</th>
					<th>E-mail</th>
					<th>Cidade</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($get_companies as $c): ?>
                    <?php 
                        $companyPermission = explode(',', $c['company_permission']);
                        if(in_array($c['id'], $companyPermission)): 
                    ?>
					<tr style="font-size: 12px">
						<td style="width: 50%"><?php echo $c['name']; ?></td>
						<td><?php echo $c['email']; ?></td>
						<td style="width: 15%"><?php echo $c['city']; ?></td>
						<td style="width: 15%">
							<button class="btn btn-outline-warning btn-sm" onclick="editar_empresa(<?php echo $c['id']; ?>)"><i class="fas fa-pen"></i></button>
							<button class="btn btn-outline-danger btn-sm" onclick="excluir_empresa(<?php echo $c['id']; ?>)"><i class="fas fa-trash"></i></button>
						</td>
					</tr>
                    <?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<!-- Modal Adicionar -->
<div class="modal fade" id="modal_company">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Empresas</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_company"><br />
				<!-- Modal body -->
				<div class="modal-body">
				<div class="row">
                        <div class="col-sm-6">
                            <label for="name">Nome:</label>
                            <input type="text" name="id" hidden>
                            <input type="text" name="acao_company" value="" hidden>
                            <input type="text" class="form-control form-control-sm" name="name" placeholder="Digite o nome da empresa" required>
                        </div>
                        <div class="col-sm-3">
                            <label for="email">E-mail:</label>
                            <input type="email" class="form-control form-control-sm" name="email" placholder="Digite o email de contato (se houver)">
                        </div>
                        <div class="col-sm-3">
                            <label for="cnpj">CNPJ:</label>
                            <input type="text" class="form-control form-control-sm" name="cnpj">
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-5">
                            <label for="address1">Endereço:</label>
                            <input type="text" class="form-control form-control-sm" name="address1" placeholder="Digite o endereço da empresa">
                        </div>
                        <div class="col-sm-2">
                            <label for="address2">Complemento:</label>
                            <input type="text" class="form-control form-control-sm" name="address2" placeholder="Apto / Casa">
                        </div>
                        <div class="col-sm-3">
                            <label for="city">Cidade:</label>
                            <select class="form-control form-control-sm" name="city">
                                <option value="">Selecione a Cidade:</option>
                                <?php foreach($cidades as $c): ?>
                                    <option value="<?php echo $c['cidade']; ?>"><?php echo $c['cidade']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label for="uf">Estado:</label>
                            <select class="form-control form-control-sm" name="uf">
                                <option value="">Selecione o Estado:</option>
                                <?php foreach($estados as $c): ?>
                                    <option value="<?php echo $c['uf']; ?>"><?php echo $c['estado']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm">
                            <label for="phone1">Telefone 1:</label>
                            <input type="tel" class="form-control form-control-sm" name="phone1">
                        </div>
                        <div class="col-sm">
                            <label for="phone1">Telefone 2:</label>
                            <input type="text" class="form-control form-control-sm" name="phone2">
                        </div>
                        <div class="col-sm">
                            <label for="contact_name">Nome do Contato:</label>
                            <input type="text" class="form-control form-control-sm" name="contact_name" placeholder="Digite o nome do contato:">
                        </div>
                        <div class="col-sm">
                            <label>Tipo:</label>
                            <select class="form-control form-control-sm" name="tipo">
                                <option value="A">Agência</option>
                                <option value="E">Empresa</option>
                            </select>
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

