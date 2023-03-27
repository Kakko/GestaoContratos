<!-- <?php
	$user_companies = '';
	$user_perm = '';
	
	foreach($user_permissions as $up) {
		$user_companies .= $up['companies'].',';
		$user_perm .= $up['permission_id'].',';
	}

	$user_companies = substr($user_companies, 0, -1);
	$user_perm = substr($user_perm, 0, -1);

	$user_companies = explode(',', $user_companies); //CRIANDO O ARRAY COM AS EMPRESAS NO QUAL O USUÁRIO TEM PERMISSÃO DE ACESSAR
	$user_perm = explode(',', $user_perm); //CRIANDO O ARRAY COM AS PERMISSÕES QUE TEM O USUÁRIO NAS EMPRESAS SELECIONADAS
?> -->
<?php 
	$permissions = new Permissions();
?>
<style>
	.btn-outline-note {
		border-color: #EEA0FF !important;
		color: #BE00E8;
	}
	.btn-outline-note:hover,
	#note:hover {
		background-color: #EEA0FF;
	}
</style>
<div class="section_top">
	<div class="sectionTitle">
        Contratos
    </div>
    <div class="sectionAction">
		<?php if(in_array('1', $permissions->verifyAddPermission())): ?>
			<img src="<?php echo BASE_URL; ?>assets/images/icons/plus.png" onclick="cad_contrato()">
		<?php endif; ?>
    </div>
</div>
<br/>
<div class="container-fluid">
<div class="row">
	<div class="col-sm" style="z-index: 1" id="divParent">
		<button onclick="showSelectCompaniesContract()" class="selectButton" id="companyButton">Empresas <img src="<?php echo BASE_URL; ?>assets/images/icons/arrowDown.svg"></button>
		<div class="multipleSelectCompanies" id="multipleSelectCompanies">
			<?php foreach($get_companies as $o): ?>
				<?php 
					$companyPermission = explode(',', $o['company_permission']);
					if(in_array($o['id'], $companyPermission)): 
				?>
				<div tabindex="-1" class="companyItem" onclick="selectContractItem(<?php echo $o['id']; ?>)" id="companyItem<?php echo $o['id']; ?>">
					<?php echo $o['name']; ?><br/>
					<input type="number" id="companyValue<?php echo $o['id']; ?>" class="getValue" value="<?php echo $o['id']; ?>" hidden>
				</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="col-sm-1">
		<button id="sturButton" class="selectButton" onclick="showSturCodSearch()">Cód Stur <img src="<?php echo BASE_URL; ?>assets/images/icons/arrowDown.svg"></button>
		<div tabindex="-1" class="sturSearch" id="sturSearch">
			<input type="number" class="sturCodInput" id="sturCodInput" onclick="inputSturCod()">
		</div>
	</div>
	<div class="col-md" id="statusArea">
		<button id="statusButton" class="selectButton" onclick="showStatus()">Status <img src="<?php echo BASE_URL; ?>assets/images/icons/arrowDown.svg"></button>
		<div tabindex="-1" class="statusSearch" id="statusSearch">
			<div class="statusItem" onclick="selectContractStatus(this)">Novo</div>
			<div class="statusItem" onclick="selectContractStatus(this)">Ativo</div>
			<div class="statusItem" onclick="selectContractStatus(this)">Inativo</div>
		</div>
	</div>
	<div class="col-md" id="inadArea">
		<button id="inadButton" class="selectButton" onclick="showInadimplente()">Inadimplente <img src="<?php echo BASE_URL; ?>assets/images/icons/arrowDown.svg"></button>
		<div tabindex="-1" class="selectInadimplente" id="selectInadimplente">
			<div class="inadItem" onclick="selectContractInad(this)">Sim</div>
			<div class="inadItem" onclick="selectContractInad(this)">Não</div>
		</div>
	</div>
	<div class="col-md" id="clientArea">
		<button id="clientButton" class="selectButton" onclick="showClientName()">Nome do Cliente <img src="<?php echo BASE_URL; ?>assets/images/icons/arrowDown.svg"></button>
		<div tabindex="-1" class="selectClientName" id="selectClientName">
			<input type="text" class="form-control" id="searchClient" autocomplete="no" placeholder="Digite o nome do cliente" onkeyup="searchClientName()" value="">
			<div id="showClientArea">
				<?php foreach($getContratos as $s): ?>
					<?php if(!empty($s['nome_cliente'])): ?>
						<div class="clientItem" onclick="selectClientName(this)">
							<?php echo $s['nome_cliente']; ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<div class="col-md" id="dateArea">
		<button id="contractSearchButton" class="selectButton" onclick="contractDateSearch()">Data do Contrato <img src="<?php echo BASE_URL; ?>assets/images/icons/arrowDown.svg"></button>
		<div tabindex="-1" class="contractDateSearch" id="contractDateSearch">
			<div style="margin-top: 10px; margin-left: 10px">De:</div><input type="date" class="dateInput" name="data_de" id="data_de" onclick="dateDe()">
			<div style="margin-left: 10px">Até:</div><input type="date" class="dateInput" name="data_ate" id="data_ate" onclick="dateAte()">
		</div>
	</div>
	<div class="col-md">
		<button class="btn btn-primary" onclick="filtrarNewContracts()" style="width: 100%; height: 30px; border-radius: 8px; line-height: 15px">Pesquisar</button>
		
	</div>
</div>
<div class="row">
	<div id="contractExpiredArea" style="width: 270px; margin-left: 10px">
		<button id="expiredOnesButton" onclick="showSelectCompaniesContractExpired()" class="selectButton" style="margin-top: 10px">Contratos Vencidos <img src="<?php echo BASE_URL; ?>assets/images/icons/arrowDown.svg"></button>
		<div class="multipleSelectCompaniesExpired" id="multipleSelectCompaniesExpired">
			<?php foreach($get_companies as $o): ?>
				<?php 
					$companyPermission = explode(',', $o['company_permission']);
					if(in_array($o['id'], $companyPermission)): 
				?>
				<div tabindex="-1" class="companyItemExpired" onclick="selectContractItemExpired(<?php echo $o['id']; ?>)" id="companyItemExpired<?php echo $o['id']; ?>">
					<?php echo $o['name']; ?><br/>
					<input type="number" id="companyExpiredValue<?php echo $o['id']; ?>" class="getExpiredValue" value="<?php echo $o['id']; ?>" hidden>
				</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<br/>
<div class="newContract"><strong><?php echo $newCount; ?></strong> Novos Contratos Disponíveis </div>
<hr/>
<div style="float: left">
	<div style="width: 10px; height: 10px; background-color: green; float: left; margin-top: 5px; margin-right: 10px"></div><span>Adimplente</span>
</div>
<div style="float: left; margin-left: 20px">
	<div style="width: 10px; height: 10px; background-color: red; float: left; margin-top: 5px; margin-right: 10px"></div><span>Inadimplente</span>
</div>
<div style="float: left; margin-left: 20px">
	<div style="width: 10px; height: 10px; background-color: yellow; float: left; margin-top: 5px; margin-right: 10px"></div><span>Novo</span>
</div>
<div style="float: left; margin-left: 20px">
	<div style="width: 10px; height: 10px; background-color: lightgray; float: left; margin-top: 5px; margin-right: 10px"></div><span>Sem Dados</span>
</div>
<br/>
<div class="dados" style="height: calc(100vh - 310px); background-color: #f9f9f9; overflow: auto">
	<table class="table table-striped table-hover table-sm" id="table_contratos">
		<thead class="thead-dark">
			<tr>
				<th style="width: 10px"></th>
				<th>Cod Stur</th>
				<th>Nome do Cliente</th>
				<th>Emissor</th>
				<th>Valor:</th>
				<th>Nº do Contrato</th>
				<th>Empresa</th>
				<th>Término do Contrato</th>
				<th style="width: 18%">Ações</th>
			</tr>
		</thead>
		<tbody  style="font-size: 12px"> 
			
		</tbody>
	</table>
</div>

</div>
<!-- Modal Cadastro de Contratos -->
<div class="modal fade" id="cad_contratos">
	<div class="modal-dialog modal-xl" style="overflow: auto">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Novo Contrato</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<form method="POST" id="newContract">
					<div class="row">
						<div class="col-md-1">
							<label for="cod">Cód STUR:</label>
							<input type="text" name="acao_contratos" value="cadastrar" hidden>
							<input type="number" class="form-control form-control-sm" name="cod_stur" id="cod_cad" onchange="searchCod()" readonly>
						</div>
						<div class="col-md-4">
							<label for="nome_cliente">Nome Cliente:</label>
							<select class="form-control form-control-sm" name="nome_cliente_contrato" onchange="cod_stur_cad()" id="cad_cliente_contrato" required>
								<option value="">Selecione...</option>
								<?php foreach($getNomeCliente as $nome_cliente): ?>
									<option value="<?php echo $nome_cliente['id']; ?>"><?php echo $nome_cliente['nome_cliente']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-5">
							<label for="razao_social">Razão Social:</label>
							<input type="text" class="form-control form-control-sm" name="razao_social" id="razao_social_cad" readonly>
						</div>
						<div class="col-md-2">
							<label for="cnpj">CNPJ:</label>
							<input type="text" class="form-control form-control-sm" name="cnpj" id="cnpj_cad" readonly>
						</div>
					</div>
					<hr/>
					<div class="row">
						<div class="col-md-2">
							<label for="n_contrato">Nº do Contrato:</label>
							<input type="text" class="form-control form-control-sm" name="n_contrato" require>
						</div>
						<div class="col-md-2">
							<label for="emissor">Emissor:</label>
							<input type="text" class="form-control form-control-sm" name="emissor">
						</div>
						<div class="col-md-3">
							<label for="empresa">Empresa:</label>
							<input type="text" class="form-control form-control-sm" name="empresa_id" id="empresa_cad" hidden>
							<input type="text" class="form-control form-control-sm" name="empresa" id="empresa_cad_show" readonly>
						</div>
						<div class="col-md-1">
							<label for="cod2">Cód:</label>
							<input type="text" class="form-control form-control-sm" name="cod2">
						</div>
						<div class="col-md-2">
							<label for="valor">Valor:</label>
							<input type="text" class="form-control form-control-sm valor" name="valor" required>
						</div>
						<div class="col-md-2">
							<label>Complemento:</label>
							<input type="text" class="form-control form-control-sm" name="complemento">
						</div>
					</div>
					<hr/>
					<div class="row">
						<div class="col-md-2">
							<label for="faturamento">Faturamento:</label>
							<input type="text" class="form-control form-control-sm" name="faturamento">
						</div>
						<div class="col-md-2">
							<label for="vencimento">Vencimento:</label>
							<input type="text" class="form-control form-control-sm" name="vencimento">
						</div>
						<div class="col-md-2">
							<label>Reembolso</label>
							<input type="text" class="form-control form-control-sm" name="reembolso">
						</div>
						<div class="col-md-6">
							<label for="detalhes">Detalhes:</label>
							<input type="text" class="form-control form-control-sm" name="detalhes">
						</div>
					</div>
					<hr/>
					<div class="row">
						<div class="col-md">
							<label for="situacao">Situação:</label>
							<select class="form-control form-control-sm" name="situacao">
								<option>Ativo</option>
								<option>Inativo</option>
							</select>
						</div>
						<div class="col-md">
							<label for="lei_kandir">Lei Kandir:</label>
							<select class="form-control form-control-sm" name="lei_kandir">
								<option value="S">Sim</option>
								<option value="N">Não</option>
							</select>
						</div>
						<div class="col-md">
							<label for="inicio">Início do Contrato:</label>
							<input type="date" class="form-control form-control-sm" name="inicio_contrato" require>
						</div>
						<div class="col-md">
							<label for="fim">Fim do Contrato:</label>
							<input type="date" class="form-control form-control-sm" name="fim_contrato" require>
						</div>
					</div>
				</div>
			</form>
			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
				<button type="button" class="btn btn-success" onclick="insertContrato()" data-dismiss="modal">Cadastrar</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Adicionar Sistemas-->
<div class="modal fade" id="modal_contratos">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Contratos</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="updContrato"><br />
				<!-- Modal body -->
				<div class="modal-body" id="editContratos">
                    
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-success" onclick="updContrato()" data-dismiss="modal">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal Ver Contrato-->
<div class="modal fade" id="ver_contrato" style="overflow: auto">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Visualizar os Contratos</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group"><br />
				<!-- Modal body -->
				<div class="modal-body" id="verContrato">
                    
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal Histórico -->
<div class="modal fade" id="hist_cadastro">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Histórico</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_historico" enctype="multipart/form-data"><br />
				<!-- Modal body -->
				<div class="modal-body">
                    <div class="container-fluid" style="border: 1px solid lightgray; border-radius: 5px; box-shadow: 0 0 10px lightgray">
                    <br/>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="titulo">Título</label>
                                <input type="text" class="form-control form-control-sm" name="titulo">
                            </div>
                            <div class="col-md-4">
                                <label for="data_contrato">Data:</label>
                                <input type="text" name="id" hidden>
                                <input type="text" name="acao_contratos" value="ver" hidden>
                                <input type="date" class="form-control form-control-sm" name="data_contrato">
                            </div>
                            <div class="col-md-4">
                                <label for="horario_contrato">Horário:</label>
                                <input type="time" class="form-control form-control-sm" name="horario_contrato">
                            </div>
                        </div>
						<br/>
						<div class="row" style="height: 70px">
							<div class="col-sm-1">
								<label for="aditivo">Aditivo</label><br/>
								<input type="checkbox" name="check_aditivo" value="s" style="margin-left: 40%" onChange="showAditivos()">
							</div>
							<div class="col-sm-3 aditivo" id="inicio" style="display: none">
								<label>Início Aditivo</label>
								<input type="date" class="form-control form-control-sm" name="inicioAditivo">
							</div>
							<div class="col-sm-3 aditivo" id="fim" style="display: none">
								<label>Fim Aditivo</label>
								<input type="date" class="form-control form-control-sm" name="fimAditivo">
							</div>
							<div class="com-sm-3 aditivo" id="value" style="display: none">
								<label>Valor Aditivo</label>
								<input type="number" class="form-control form-control-sm" name="valueAditivo" placeholder="R$ 0,00">
							</div>
						</div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="obs">Histórico:</label>
                                <textarea class="form-control form-control-sm" name="obs" style="resize: none" id="summernote"></textarea>
                            </div>
                        </div>
						<hr/>
						<div class="row">
							<div class="col-md-12">
								<label for="upload_arquivo">Envio de Arquivos:</label><br/>
								<input type="file" name="upload_arquivo"><br/>
							</div>
						</div>
                    <br/>
                    </div>
                    <br/>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-success" onClick="saveHist()" data-dismiss="modal">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Ver Informação do Stur -->
<div class="modal fade" id="ver_info">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Ver Informação:</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
				<!-- Modal body -->
				<div class="modal-body" id="dados_stur">
                    
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal Info Licitação -->
<div class="modal fade info"  style="background-color: rgba(0, 0, 0,0.8)" id="infoLicitacao">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Informação da Licitação:</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
				<!-- Modal body -->
				<div class="modal-body" id="infoLicitacao">
					<div id="licitacao_info">
					
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal Notepad -->
<div class="modal fade info" id="contNote">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Anotações</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body" id="notes">
				
			</div>
			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal New Note -->
<div class="modal fade info" id="newNote" style="background-color: rgba(0, 0, 0,0.8); padding-top: 150px">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Nova Nota</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body" id="addNewNote">

			</div>
			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-success" onclick="saveNewNote()" data-dismiss="modal">Salvar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			</div>
		</label>
	</div>
</div>
<script>
	    $('#summernote').summernote({
		tabsize: 2,
		height: 150,
		toolbar: [
			['style', ['style']],
			['font', ['bold', 'underline', 'clear']],
			['para', ['ul', 'ol', 'paragraph']],
			['table', ['table']]
			]
		});
</script>
<script type="text/javascript" src="./assets/js/contratos.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/warnings.js"></script>



