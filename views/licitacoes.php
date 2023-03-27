<?php $permissions = new Permissions(); ?>
<div class="section_top">
    <div class="sectionTitle">
        Licitações
    </div>
    <div class="sectionAction">
    <?php if(in_array('5', $permissions->verifyAddPermission())): ?>
        <img src="<?php echo BASE_URL; ?>assets/images/icons/plus.png" onclick="cadastrar_licitacoes()">
    <?php endif; ?>
    </div>
</div>
<br/>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm" style="z-index: 1">
            <button onclick="showSelectCompanies()" class="selectButton">Empresas <img src="<?php echo BASE_URL; ?>assets/images/icons/arrowDown.svg"></button>
            <div class="multipleSelectCompanies" id="multipleSelectCompanies">
                <?php foreach($get_companies as $o): ?>
                    <?php 
                        $companyPermission = explode(',', $o['company_permission']);
                        if(in_array($o['id'], $companyPermission)): 
                    ?>
                    <div class="companyItem" onclick="selectItem(<?php echo $o['id']; ?>)" id="companyItem<?php echo $o['id']; ?>">
                        <?php echo $o['name']; ?><br/>
                        <input type="number" id="companyValue<?php echo $o['id']; ?>" class="getValue" value="<?php echo $o['id']; ?>" hidden>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-sm">
            <button onclick="showSelectStatus()" class="selectButton">Status <img src="<?php echo BASE_URL; ?>assets/images/icons/arrowDown.svg"></button>
            <div class="multipleSelectStatus" id="multipleSelectStatus">
                <div class="statusItem" onclick="selectStatus(this)">Pré Cadastro</div>
                <div class="statusItem" onclick="selectStatus(this)">Cadastrado</div>
                <div class="statusItem" onclick="selectStatus(this)">Em Andamento</div>
                <div class="statusItem" onclick="selectStatus(this)">Homologado</div>
                <div class="statusItem" onclick="selectStatus(this)">Suspenso</div>
                <div class="statusItem" onclick="selectStatus(this)">Anulado</div>
                <div class="statusItem" onclick="selectStatus(this)">Perdido</div>
                <div class="statusItem" onclick="selectStatus(this)">Adiada</div>
                <div class="statusItem" onclick="selectStatus(this)">Não Participado</div>
                <div class="statusItem" onclick="selectStatus(this)">Recurso</div>
                <div class="statusItem" onclick="selectStatus(this)">Fracassado</div>
                <div class="statusItem" onclick="selectStatus(this)">Revogado</div>
                <div class="statusItem" onclick="selectStatus(this)">Deserto</div>
                <div class="statusItem" onclick="selectStatus(this)">Mandado de Segurança</div>
            </div>
        </div>
        <div class="col-sm">
            <button onclick="showSelectType()" class="selectButton">Tipo <img src="<?php echo BASE_URL; ?>assets/images/icons/arrowDown.svg"></button>
                <div class="multipleSelectType" id="multipleSelectType">
                    <div class="typeItem" onclick="selectType(this)">Carta Convite</div>
                    <div class="typeItem" onclick="selectType(this)">Concorrência</div>
                    <div class="typeItem" onclick="selectType(this)">Tomada de Preço</div>
                    <div class="typeItem" onclick="selectType(this)">Pregão Presencial</div>
                    <div class="typeItem" onclick="selectType(this)">Pregão Eletrônico</div>
                    <div class="typeItem" onclick="selectType(this)">Cotação Eletrônica</div>
                    <div class="typeItem" onclick="selectType(this)">RDC</div>
                </div>
        </div>
        <div class="col-sm">
            <button onclick="showSelectSystems()" class="selectButton">Sistemas <img src="<?php echo BASE_URL; ?>assets/images/icons/arrowDown.svg"></button>
            <div class="multipleSelectSystems" id="multipleSelectSystems">
                <?php foreach($get_systems as $s): ?>
                    <div class="systemItem" onclick="selectSystem(<?php echo $s['id']; ?>)" id="systemItem<?php echo $s['id']; ?>">
                        <?php echo $s['name']; ?><br/>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-sm">
            <button class="selectButton" onclick="showSearchData()">Pesquisa por Data <img src="<?php echo BASE_URL; ?>assets/images/icons/arrowDown.svg"></button>
            <div class="dateSearch" id="dateSearch">
                <div style="margin-top: 10px; margin-left: 10px">De:</div><input type="date" class="dateInput" name="data_de" id="data_de">
                <div style="margin-left: 10px">Até:</div><input type="date" class="dateInput" name="data_ate" id="data_ate">
            </div>
        </div>
        <div class="col-sm">
            <button class="selectButton" onclick="showSearchValue()">Pesquisa por Valor <img src="<?php echo BASE_URL; ?>assets/images/icons/arrowDown.svg"></button>
            <div class="valueSearch" id="valueSearch">
                <div style="margin-top: 10px; margin-left: 10px">De:</div><input type="number" class="valueInput" name="valor_de" id="valor_de">
                <div style="margin-left: 10px">Até:</div><input type="number" class="valueInput" name="valor_ate" id="valor_ate">
            </div>
        </div>
        <div class="col-sm-2">
            <button class="btn btn-primary" onclick="filtrarNew()" style="width: 100%; height: 30px; border-radius: 8px; line-height: 15px">Pesquisar</button>
        </div>
    </div>
    <hr/>
    <br/>
    <div class="dados" style="height: calc(100vh - 220px); background-color: #f9f9f9; overflow: auto">
        <table class="table table-striped table-hover table-sm" id="table_licitacoes">
            <thead class="thead-dark">
                <tr>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Sistema</th>
                    <th>Valor</th>
                    <th>Edital</th>
                    <th>Id.</th>
                    <th>Órgão</th>
                    <th>Empresa</th>
                    <th>Observação</th>
                    <th style="width: 200px">Ações</th>
                </tr>
            </thead>
            <tbody style="font-size: 12px" id="resLic">
                
            </tbody>
        </table>
    </div>
    
</div>

<!-- Modal Atualizar Licitações-->
<div class="modal fade" id="modal_updLicitacoes" style="overflow: auto">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Licitações</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="updLic"><br />
				<!-- Modal body -->
				<div class="modal-body" id="ver_edit">
                    
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-primary" onclick="updLicitacao()" data-dismiss="modal">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
<!-- Modal Adicionar Licitações-->
<div class="modal fade" id="modal_licitacoes" style="overflow: auto">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Licitações</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_licitacoes1"><br />
				<!-- Modal body -->
				<div class="modal-body" id="modal_limpo" onclick="closeAgency()">
                    <div class="row">
                        <div class="col-sm">
                            <label for="name">Data:</label>
                            <input type="text" name="id" hidden>
                            <input type="text" name="acao_licitacoes" value="cadastrar" hidden>
                            <input type="date" class="form-control form-control-sm" name="data" required>
                        </div>
                        <div class="col-sm-1">
                            <label for="hora">Horario:</label>
                            <input type="time" class="form-control form-control-sm" name="hora" required>
                        </div>
                        <div class="col-sm" id="system_cad">
                            <label for="system">Sistema:</label>
                            <div class="input-group">
                                <select class="custom-select custom-select-sm" name="system" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach($get_systems as $s): ?>
                                        <option><?php echo $s['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success btn-sm" type="button" onclick="addSystem()"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <label for="value">Valor:</label>
                            <input type="text" class="form-control form-control-sm valor" name="value" placeholder="R$">
                        </div>
                        <div class="col-sm">
                            <label for="complemento">Complemento:</label>
                            <input type="text" class="form-control form-control-sm" name="complemento">
                        </div>
                        <div class="col-sm">
                            <label for="auction">Nº Edital:</label>
                            <input type="text" class="form-control form-control-sm" name="auction" placeholder="______ / ______" required>
                        </div>
                        <div class="col-sm-1">
                            <label for="-">Identificador</label>
                            <input type="text" class="form-control form-control-sm" name="complement" placeholder="______ - ______">
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                    <div class="col-sm">
                            <label for="uf">Estado:</label>
                            <select class="form-control form-control-sm" name="uf" onchange="listar_cidades()">
                                <option value="">Selecionar...</option>
                                <?php foreach($get_estados as $e): ?>
                                    <option><?php echo $e['estado']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm" id="cidade">
                            <label for="city">Cidade:</label>
                            <input type="text" class="form-control form-control-sm" name="city" readonly>
                        </div>
                        <div class="col-sm" id="orgao">
                            <label for="agencies">Órgão:</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm searchAgency" name="agency" placeholder="Digite para Buscar o Órgão" onkeyup="searchAgency()" value="">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success btn-sm" type="button" onclick="addOrgao()"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="form-control form-control-sm resultAgency" style="height: 400px; width: 500px; position: absolute; z-index: 999; overflow: auto" hidden>
                            </div>
                        </div>
                        <div class="col-sm">
                            <label for="produtos">Produtos:</label>
                            <select class="form-control form-control-sm" name="produtos[]" multiple>
                            <option value="" style="font-weight: bolder; text-decoration: underline">Nenhum Produto</option>
                                <?php foreach($get_produtos as $p): ?>
                                    <option><?php echo $p['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-2">
                            <label for="companies">Empresas:</label>
                            <select class="form-control form-control-sm" name="company" onchange="get_cnpj()">
                                <option value="">Selecione...</option>
                                <?php foreach($get_companies as $o): ?>
                                    <?php 
                                        $companyPermission = explode(',', $o['company_permission']);
                                        if(in_array($o['id'], $companyPermission)): 
                                    ?>
                                    <option value="<?php echo $o['id']; ?>"><?php echo $o['name']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input type="text" name="cnpj" id="company_cnpj" hidden>
                        <div class="col-sm-2">
                            <label for="status">Status:</label>
                            <select class="form-control form-control-sm" name="status"  required>
                                <option value="">Selecione...</option>
                                <option>Pré Cadastro</option>
                                <option>Cadastrado</option>
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
                                <option>Mandado de Segurança</option>
                            </select>
                        </div>
                        <div class="col-sm-2" id='statusInfo'>
                            <label for="status_info">Motivo do Status</label>
                            <div class="input-group">
                                <select class="custom-select custom-select-sm" name="status_info" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach($status_info as $info): ?>
                                        <option><?php echo $info['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success btn-sm" type="button" onclick="addStatusInfo()"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <label for="esclarecimentos">Esclarecimentos:</label>
                            <select class="form-control form-control-sm" name="esclarecimentos">
                                <option value="">Selecione...</option>
                                <option>Enviado</option>
                                <option>Não Enviado</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label for="ata">Ata:</label>
                            <select class="form-control form-control-sm" name="ata">
                                <option value="">Selecione...</option>
                                <option>Sim</option>
                                <option>Não</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label for="modalidades">Modalidades:</label>
                            <select class="form-control form-control-sm" name="modalidades">
                                <option value="">Selecione...</option>
                                <option>Carta Convite</option>
                                <option>Concorrência</option>
                                <option>Tomada de Preço</option>
                                <option>Pregão Presencial</option>
                                <option>Pregão Eletrônico</option>
                                <option>Cotação Eletrônica</option>
                                <option>RDC</option>
                                <option>Internacional</option>
                            </select>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="object">Objeto:</label>
                            <textarea class="form-control form-control-sm" name="object" style="height: 50px; resize: none"></textarea>
                        </div>
                        <div class="col-sm-3">
                            <label for="ag_cadast">Agenciamento</label>
                            <textarea class="form-control form-control-sm" name="ag_cadast" style="height: 50px; resize: none"></textarea>
                        </div>

                        <div class="col-sm-2" style="background-color: lightgray">
                            <label>Empresa Vencedora:</label>
                            <div id="wcompany_select">
                                <div class="input-group">
                                    <select class="custom-select custom-select-sm" name="winner_company" id="winner_company" disabled>
                                        <option value="">Selecione...</option>
                                        <?php foreach($winner_company as $s): ?>
                                            <option><?php echo $s['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary btn-sm" type="button" onclick="addWinnerCompany()" id="addWinnerCompany2" disabled><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1" style="background-color: lightgray">
                            <label>Valor:</label>
                            <input type="text" class="form-control form-control-sm valor4" name="winner_value" disabled id="winner_value">
                        </div>
                        <div class="col-sm-1" style="background-color: lightgray">
                            <label>Porcentagem:</label>
                            <input type="number" class="form-control form-control-sm" name="winner_perc" disabled id="winner_perc">
                        </div>
                        <div class="col-sm-1" style="background-color: lightgray">
                            <button type="button" class="btn btn-info" onclick="cadWinnerCompany()" style="width: 100%; margin-top: 25px" id="addcadWinnerCompany" disabled>Adicionar</button>
                        </div>
                    </div>
                    <hr/>
                    <div class="row" style="border-bottom: 1px solid lightgray; border-top: 1px solid lightgray">
                        <div class="col-sm-5">
                            <label style="font-weight: bolder">Produtos:</label>
                            <div id="historico">
                                <table class="table table-striped table-hover table-sm">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="text-align: center">Nome:</th>
                                            <th>Ação:</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-prod">
                                            
                                    </tbody>
                                </table>                
                            </div>
                        </div>
                        <div class="col-sm-2"></div>
                        <div class="col-sm-5">
                            <label style="font-weight: bolder">Empresas Vencedoras:</label>
                            <div id="historico">
                                <table class="table table-striped table-hover table-sm">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Nome:</th>
                                            <th>Valor:</th>
                                            <th>Porcentagem:</th>
                                            <th>Ação:</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-winner">
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tbody>
                                </table>                
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="obs">Observações</label>
                            <textarea name="obs" class="form-control form-control-sm" style="height: 100px; resize: none"></textarea>
                        </div>
                    </div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-primary" onclick="saveLicitacao()" data-dismiss="modal">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal Ver Licitações-->
<div class="modal fade" id="ver_licitacoes">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Visualizar as Licitações</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_licitacoes"><br />
				<!-- Modal body -->
				<div class="modal-body" id="verLicitacao">
                    
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-info" data-dismiss="modal">Fechar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal Histórico -->
<div class="modal fade" id="ver_historico">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Histórico</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" enctype="multipart/form-data" id="form_historico"><br />
				<!-- Modal body -->
				<div class="modal-body">
                    <div class="container-fluid" style="border: 1px solid lightgray; border-radius: 5px; box-shadow: 0 0 10px lightgray">
                    <br/>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="titulo">Título</label>
                                <input type="text" class="form-control form-control-sm" name="titulo">
                            </div>
                            <div class="col-sm-4">
                                <label for="data_licitacao">Data:</label>
                                <input type="text" name="id" hidden>
                                <input type="text" name="acao_historico" value="ver" hidden>
                                <input type="date" class="form-control form-control-sm" name="data_licitacao">
                            </div>
                            <div class="col-sm-4">
                                <label for="horario_licitacao">Horário:</label>
                                <input type="time" class="form-control form-control-sm" name="horario_licitacao">
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="obs">Histórico:</label>
                                <textarea class="form-control form-control-sm" name="obs" style="height: 150px; resize: none"></textarea>
                            </div>
                        </div><hr/>
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
                    <button type="submit" class="btn btn-success">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal Desconto -->
<div class="modal fade" id="ver_desconto" style="background-color: rgba(0,0,0,0.8)">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Desconto por Produto</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_desconto"><br />
				<!-- Modal body -->
				<div class="modal-body">
                    <table class="table table-striped table-hover table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th>Produto</th>
                                <th style="width: 50px">Desconto</th>
                                <th style="width: 100px"></th>
                            </tr>
                        </thead>
                            <input type="text" value="" name="acao_desconto" hidden>
                            <input type="text" name="id" hidden>
                        <tbody id="tdado">


                        </tbody>
                    </table>
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
<!-- Modal Add Sistema -->
<div class="modal fade addSystem" id="modal_addSystem" style="background-color: rgba(0,0,0,0.8)">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Novo Sistema</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_addSystem"><br />
				<!-- Modal body -->
				<div class="modal-body">
                    <label>Adicionar Sistema</label>
                    <input type="text" class="form-control form-control-sm" name="addSystem">
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-success" onclick="cadSystem()" data-dismiss="modal">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal Add Órgão -->
<div class="modal fade addSystem" id="modal_addOrgao" style="background-color: rgba(0,0,0,0.8)">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Novo Órgão</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_addOrgao"><br />
				<!-- Modal body -->
				<div class="modal-body">
                    <label>Adicionar Órgão</label>
                    <input type="text" class="form-control form-control-sm" name="addOrgao">
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-success" onclick="cadOrgao()" data-dismiss="modal">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal Add Winner Company -->
<div class="modal fade" id="modal_addWinnerCompany" style="background-color: rgba(0,0,0,0.8)">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Empresa Vencedora</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <!-- Modal body -->
            <div class="modal-body">
                <label>Adicionar Empresa Vencedora</label>
                <input type="text" class="form-control form-control-sm" name="wcompany">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" onclick="cadCompanyWinner()" data-dismiss="modal">Salvar</button>
            </div>
		</div>
	</div>
</div>
<!-- Modal Add Status Info -->
<div class="modal fade addSystem" id="modal_statusInfo" style="background-color: rgba(0,0,0,0.8)">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Nova Informação de Status</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_addOrgao"><br />
				<!-- Modal body -->
				<div class="modal-body">
                    <label>Adicionar Nova Informação de Status</label>
                    <input type="text" class="form-control form-control-sm" name="addStatusInfo" maxlength="45">
                    <span style="font-size: 12px; color:lightgray">Max 45 caracteres</span>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-success" onclick="cadStatusInfo()" data-dismiss="modal">Salvar</button>
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
<div id="BSOD" style="width: 100%; height: 100vh; background-color:rgba(0,0,0,0.5); position: absolute; display: none; top: 0; left: 0">
<div id="loading" style="height: auto; align-self: center; position: absolute; left: 50%; top: 50%; margin-top: -120px; text-align: center">
<img style="height: 120px" class="monkeyB" src="<?php echo BASE_URL; ?>assets/images/icons/logoMonkeyBranch.png" alt="">
<script type="text/javascript" src="./assets/js/licitacoes.js"></script>