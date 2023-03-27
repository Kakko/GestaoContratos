<div class="section_top">
    Cadastros
</div>
<div class="container-fluid" style="height: 550px; overflow: auto; z-index: -999">
    <div class="cards">
        <div class="card_title">
            <h4>Empresas</h4>
        </div>
        <div class="card_body companies">
            <span><a href="<?php echo BASE_URL; ?>cadastros/ver_empresas"><?php echo $viewData['company_number']; ?></a></span>
            <!-- <p>Cadastradas</p> -->
            <button class="btn btn-success" onclick="cadastrar_empresas()">Cadastrar</button>
        </div>
    </div>
    <div class="cards">
        <div class="card_title">
            <h4>Sistema</h4>
        </div>
        <div class="card_body system">
            <span><a href="<?php echo BASE_URL; ?>cadastros/ver_sistemas"><?php echo $viewData['system_number']; ?></a></span>
            <!-- <p>Cadastradas</p> -->
            <button class="btn btn-success" onclick="cadastrar_sistemas()">Cadastrar</button>
        </div>
    </div>
    <div class="cards">
        <div class="card_title">
            <h4>Órgãos</h4>
        </div>
        <div class="card_body sectors">
            <span><a href="<?php echo BASE_URL; ?>cadastros/ver_orgaos"><?php echo $viewData['sector_number']; ?></a></span>
            <!-- <p>Cadastradas</p> -->
            <button class="btn btn-success" onclick="cadastrar_orgaos()">Cadastrar</button>
        </div>
    </div>
    <div class="cards">
        <div class="card_title">
            <h4>Produtos</h4>
        </div>
        <div class="card_body produtos">
            <span><a href="<?php echo BASE_URL; ?>cadastros/ver_produtos"><?php echo $viewData['produtos_number']; ?></a></span>
            <!-- <p>Cadastrados</p> -->
            <button class="btn btn-success" onclick="cadastrar_produtos()">Cadastrar</button>
        </div>
    </div>
    <div class="cards">
        <div class="card_title">
            <h4>Clientes</h4>
        </div>
        <div class="card_body clientes">
            <span><a href="<?php echo BASE_URL; ?>cadastros/ver_clientes"><?php echo $viewData['clients_number']; ?></a></span>
            <!-- <p>Cadastrados</p> -->
            <button class="btn btn-success" onclick="cadastrar_clientes()">Cadastrar</button>
        </div>
    </div>
    <div class="cards">
        <div class="card_title">
            <h4>Clientes - STUR</h4>
        </div>
        <div class="card_body clientes">
            <span><a href="<?php echo BASE_URL; ?>cadastros/ver_clientes"><?php echo $viewData['imported_client_number']; ?></a></span>
            <a href="<?php BASE_URL; ?>cadastros/ver_stur_clientes" style="margin-left: 0px"><button class="btn btn-warning">Importar</button></a>
        </div>
    </div>
</div>
<!-- Modal Adicionar Empresas-->
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
<!-- Modal Adicionar Sistemas-->
<div class="modal fade" id="modal_system">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Sistemas</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_system"><br />
				<!-- Modal body -->
				<div class="modal-body">
                    <div class="col-sm-12">
                        <label for="name">Nome:</label>
                        <input type="text" name="id" hidden>
                        <input type="text" name="acao_system" value="" hidden>
                        <input type="text" class="form-control form-control-sm" name="name" placeholder="Digite o nome do sistema" required>
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
<!-- Modal Adicionar Órgãos-->
<div class="modal fade" id="modal_agencies">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Órgãos</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_agencies"><br />
				<!-- Modal body -->
				<div class="modal-body">
                    <div class="col-sm-12">
                        <label for="name">Nome:</label>
                        <input type="text" name="id" hidden>
                        <input type="text" name="acao_agencies" value="" hidden>
                        <input type="text" class="form-control form-control-sm" name="name" placeholder="Digite o nome do Órgão" required>
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
<!-- Modal Adicionar Produtos-->
<div class="modal fade" id="modal_produtos">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Produtos</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_produtos"><br />
				<!-- Modal body -->
				<div class="modal-body">
                    <div class="col-sm-12">
                        <label for="name">Nome:</label>
                        <input type="text" name="id" hidden>
                        <input type="text" name="acao_produtos" value="" hidden>
                        <input type="text" class="form-control form-control-sm" name="name" placeholder="Digite o nome do Produto" required>
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
<!-- Modal Adicionar Clientes-->
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
                            <select class="form-control form-control-sm" name="city" disabled>
                                <option>Selecione...</option>
                            </select>
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
                                    <?php 
                                        $companyPermission = explode(',', $empresas['company_permission']);
                                        if(in_array($empresas['id'], $companyPermission)): 
                                    ?>
                                    <option value="<?php echo $empresas['id']; ?>"><?php echo $empresas['name']; ?></option>
                                    <?php endif; ?>
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
<div id="warning">
    
</div>
<div id="follow_up">
    
</div>
<script type="text/javascript" src="./assets/js/cadastrar.js"></script>

