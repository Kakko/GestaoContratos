<div class="section_top">
	<div class="sectionTitle">
        Cadastro de Documentos
    </div>
    <div class="sectionAction">
        <img src="<?php echo BASE_URL; ?>assets/images/icons/plus.png" onclick="cadDoc()">        
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm" style="z-index: 1">
            <button onclick="showSelectCompaniesDoc()" class="selectButton" style="margin-top: 20px">Empresas <img src="<?php echo BASE_URL; ?>assets/images/icons/arrowDown.svg"></button>
            <div class="multipleSelectCompanies" id="multipleSelectCompanies">
                <?php foreach($getCompanies as $companies): ?>
                    <?php 
                        $companyPermission = explode(',', $companies['company_permission']);
                        if(in_array($companies['id'], $companyPermission)): 
                    ?>
                    <div class="companyItem" onclick="selectDocItem(<?php echo $companies['id']; ?>)" id="companyDocItem<?php echo $companies['id']; ?>">
                        <?php echo $companies['name']; ?><br/>
                        <input type="number" id="companyDocValue<?php echo $companies['id']; ?>" class="getDocValue" value="<?php echo $companies['id']; ?>" hidden>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-sm-8"></div>
        <div class="col-sm-2" style="margin-top: 20px">
            <button class="btn btn-primary" onclick="searchDoc()" style="width: 100%; height: 30px; border-radius: 8px; line-height: 15px">Pesquisar</button>
        </div>
    </div>
    <hr/>
    <div class="dados" style="height: calc(100vh - 220px); background-color: #f9f9f9; overflow: auto" id="docs">
        <?php foreach($getCategories as $cat): ?>
            <table class="table table-striped table-hover table-sm" id="table_licitacoes" style="font-size: 12px">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 350px; background-color: lightgray"><?php echo $cat['name']; ?></th>
                        <th style="width: 400px; background-color: lightgray">Empresa</th>
                        <th style="width: 200px; background-color: lightgray">Data de Emissão</th>
                        <th style="width: 200px; background-color: lightgray">Data de Vencimento</th>
                        <th style="width: 350px; background-color: lightgray">Descrição</th>
                        <th style="width: 200px; background-color: lightgray">Valor</th>
                        <th style="width: 150px; background-color: lightgray; text-align: center">Nº Cópias</th>
                        <th style="width: 350px; background-color: lightgray; text-align: center">Ação</th>
                    </tr>
                </thead>
                <tbody style="font-size: 12px">
                    <?php foreach($data as $doc): ?>
                        <?php 
                        $companyPermission = explode(',', $doc['company_permission']);
                            if(in_array($doc['company'], $companyPermission)): 
                        ?>
                            <?php if($cat['name'] == $doc['category']): ?>
                                <?php if($doc['expiration_date'] <= date("Y-m-d") && !empty($doc['expiration_date'])): ?>
                                    <tr style="background-color: #e0a4a4">
                                <?php elseif($doc['diff'] >= 1 && $doc['diff'] <= 7): ?>
                                    <tr style="background-color: #e0dca4">
                                <?php elseif($doc['expiration_date'] > date("Y-m-d")): ?>
                                    <tr>
                                <?php endif; ?>
                                        <td><?php echo $doc['doctype']; ?></td>
                                        <td><?php echo $doc['company_name']; ?></td>
                                        <td><?php echo date("d/m/Y", strtotime($doc['issue_date'])); ?></td>
                                        <td>
                                            <?php if(!empty($doc['expiration_date'])): ?>
                                                <?php echo date("d/m/Y", strtotime($doc['expiration_date'])); ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $doc['description']; ?></td>
                                        <td>R$ <?php echo number_format($doc['value'],2,',','.'); ?></td>
                                        <td id="n_copy-<?php echo $doc['id']; ?>" style="text-align: center">
                                            <?php if($users->hasPermission('Cadastrar_documentos')): ?>
                                                <button class="btn btn-outline-success btn-sm" id="button_plus" onclick="addCopy(<?php echo $doc['id']; ?>)"><i class="fas fa-plus"></i></button>
                                                    <?php echo $doc['n_copy']; ?>
                                                <button class="btn btn-outline-danger btn-sm" id="button_minus" onclick="removeCopy(<?php echo $doc['id']; ?>)"><i class="fas fa-minus"></i></button>
                                            <?php else: ?>
                                                <?php echo $doc['n_copy']; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: center">
                                            <button class="btn btn-outline-info btn-sm" onclick="seeDoc(<?php echo $doc['id']; ?>)"><i class="fas fa-eye"></i></button>
                                            <?php if($users->hasPermission('Cadastrar_documentos')): ?>
                                                <button class="btn btn-outline-warning btn-sm" onclick="editDoc(<?php echo $doc['id']; ?>)"><i class="fas fa-pen"></i></button>
                                                <button class="btn btn-outline-danger btn-sm" onclick="delDoc(<?php echo $doc['id']; ?>)"><i class="fas fa-trash"></i></button>
                                            <?php else: ?>
                                                <button class="btn btn-outline-secondary btn-sm" disabled><i class="fas fa-pen"></i></button>
                                                <button class="btn btn-outline-secondary btn-sm" disabled><i class="fas fa-trash"></i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal Add Documents -->
<div class="modal fade" id="modal_documents">
	<div class="modal-dialog modal-xl">
		<div class="modal-content" style="z-index: -10">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Novo Documento</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <!-- Modal body -->
            <form method="POST" class="form-group" enctype="multipart/form-data">
                <input type="text" name="doc_action" value="cadNewDoc" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm">
                            <label>Empresa:</label>
                            <select class="form-control form-control-sm" name="company" required>
                                <option value="" readonly>Selecione...</option>
                                <option disabled></option>
                                <?php foreach($getCompanies as $companies): ?>
                                    <option value="<?php echo $companies['id']; ?>"><?php echo $companies['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm" id="cadCategories">
                            <label>Categoria</label>
                            <div class="input-group">
                                <select class="custom-select custom-select-sm" name="categories" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach($getCategories as $cat): ?>
                                        <option><?php echo $cat['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success btn-sm" type="button" onclick="addCategory()"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm" id="cadDocType">
                            <label>Tipo Documento</label>
                            <div class="input-group">
                                <select class="custom-select custom-select-sm" name="docType" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach($getDocType as $doc): ?>
                                        <option><?php echo $doc['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success btn-sm" type="button" onclick="addDocType()"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <label>Endereço</label>
                            <input type="text" class="form-control form-control-sm" name="address">
                        </div>
                    </div>
                    <br/><hr/>
                    <div class="row">
                        <div class="col-sm">
                            <label>Data de Emissão</label>
                            <input type="date" class="form-control form-control-sm" name="issue_date" required>
                        </div>
                        <div class="switch_modules col-sm-2">
                            <label>Validade por:</label><br/>
                            <span style="margin-left: 5px">Data</span>
                            <label class="switch">
                                <input type="checkbox" onchange="field_change()">
                                <span class="slider round"></span>
                            </label>
                            <span>Dias</span>
                        </div>
                        <div class="col-sm">
                            <div id="expiration_date">
                                <label>Validade</label>
                                <input type="date" class="form-control form-control-sm" name="expiration_date">
                            </div>
                            <div id="expiration_days" class="hidden">
                                <label>Validade</label>
                                <input type="number" class="form-control form-control-sm" name="expiration_day" id="expiration_days">
                            </div>
                        </div>
                        <div class="col-sm">
                            <label>Valor</label>
                            <input type="text" class="form-control form-control-sm valor" name="value">
                        </div>
                        <div class="col-sm">
                            <label>Estado</label>
                            <select class="form-control form-control-sm" name="state" onchange="showCities()" required>
                                <option>Selecione...</option>
                                <?php foreach($states as $state): ?>
                                    <option><?php echo $state['estado']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm" id="docCity">
                            <label>Cidade</label>
                            <select class="form-control form-control-sm" name="city" required disabled>
                                <option>Selecione...</option>
                            </select>
                        </div>
                        <div class="col-sm">
                            <label>Qtd Cópias</label>
                            <input type="number" class="form-control form-control-sm" name="n_copy" required>
                        </div>
                    </div>
                    <br/><hr/>
                    <div class="row">
                        <div class="col-sm">
                            <label>Descrição</label>
                            <textarea class="form-control form-control-sm" name="description" style="height: 100px; resize: none"></textarea>
                        </div>
                    </div>
                    <br/><hr/>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Anexar Arquivos</label>
                            <input type="file" name="doc_file[]" multiple>
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

<!-- Modal Add Categories -->
<div class="modal fade" id="modal_addCategory">
	<div class="modal-dialog">
		<div class="modal-content" style="background-color: #F2F3F4; border: 1px solid black; box-shadow: 0 0 10px black">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Nova Categoria</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm">
                        <label>Nome da Categoria</label>
                        <input type="text" class="form-control form-control-sm" name="name">
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" onclick="cadCategory()" data-dismiss="modal">Salvar</button>
            </div>
		</div>
	</div>
</div>
<!-- Modal New Document Type -->
<div class="modal fade" id="modal_addDocType">
	<div class="modal-dialog">
		<div class="modal-content" style="background-color: #F2F3F4; border: 1px solid black; box-shadow: 0 0 10px black">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Novo Tipo de Documento</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm">
                        <label>Nome:</label>
                        <input type="text" class="form-control form-control-sm" name="doctype">
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" onclick="cadDocType()" data-dismiss="modal">Salvar</button>
            </div>
		</div>
	</div>
</div>
<!-- Modal Visualizar Documentos -->
<div class="modal fade" id="modal_seeDoc">
	<div class="modal-dialog modal-xl">
		<div class="modal-content" style="background-color: #F2F3F4; border: 1px solid black; box-shadow: 0 0 10px black">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Visualizar Documento</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <!-- Modal body -->
            <div class="modal-body" id="seeDoc">
                
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" onclick="cadCategory()" data-dismiss="modal">Salvar</button>
            </div>
		</div>
	</div>
</div>
<!-- Modal Edição Documentos -->
<div class="modal fade" id="modal_editDoc">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Editar Documento</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <!-- Modal body -->
            <form method="POST" class="form-group" enctype="multipart/form-data">
                <div class="modal-body" id="editDoc">
                
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
<!-- Modal Edit Categories -->
<div class="modal fade" id="modal_editCategory">
	<div class="modal-dialog">
		<div class="modal-content" style="background-color: #F2F3F4; border: 1px solid black; box-shadow: 0 0 10px black">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Nova Categoria</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm">
                        <label>Nome da Categoria</label>
                        <input type="text" class="form-control form-control-sm" name="edit_name">
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" onclick="updCategory()" data-dismiss="modal">Salvar</button>
            </div>
		</div>
	</div>
</div>
<!-- Modal Edit Document Type -->
<div class="modal fade" id="modal_editDocType">
	<div class="modal-dialog">
		<div class="modal-content" style="background-color: #F2F3F4; border: 1px solid black; box-shadow: 0 0 10px black">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Inserir Novo Tipo de Documento</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm">
                        <label>Nome:</label>
                        <input type="text" class="form-control form-control-sm" name="edit_doctype">
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" onclick="updDocType()" data-dismiss="modal">Salvar</button>
            </div>
		</div>
	</div>
</div>
<script src="<?php echo BASE_URL; ?>assets/js/documents.js"></script>
