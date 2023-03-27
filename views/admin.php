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
    Gerenciamento de Usuários
</div><br/>
<div class="container-fluid" style="width: 95%; height: calc(100vh - 150px); overflow: auto">
	<div style="padding-left: 3%">
		<button type="button" class="btn btn-info btn-sm" onclick="cad_user()">Cadastrar novo Usuário</button> |
		<!-- <button type="button" class="btn btn-info btn-sm" onclick="cad_novo_perm_grupo()">Cadastrar Novo Grupo de Permissões</button> | -->
		<button type="button" class="btn btn-warning btn-sm" onclick="ger_permissoes_sistema()">Permissões do Sistema</button> |
		<button type="button" class="btn btn-success btn-sm" onclick="ger_permissoes()">Permissões por Empresa</button>
	</div>
	<hr/>
	<div class="row">
		<table class="table table-striped table-hover table-sm" id="table_licitacoes">
			<thead class="thead-dark">
				<tr>
					<!-- <th>ID</th> -->
					<th>Nome</th>
					<th>E-mail</th>
					<th>Telefone</th>
					<th>Status</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($get_users as $u): ?>
					<?php if($u['status'] == 'Inativo'): ?>
						<tr>
							<!-- <td style="color: gray"><?php echo $u['id']; ?></td> -->
							<td style="color: gray"><?php echo $u['name']; ?></td>
							<td style="color: gray"><?php echo $u['email']; ?></td>
							<td style="color: gray"><?php echo $u['telefone']; ?></td>
							<td style="color: gray"><?php echo $u['status']; ?></td>
							<td>
								<button disabled class="btn btn-outline-secondary btn-sm" onclick="ver_usuario(<?php echo $u['id']; ?>)"><i class="fas fa-eye"></i></button>
								<button disabled class="btn btn-outline-secondary btn-sm" onclick="edit_perm(<?php echo $u['id']; ?>)"><i class="far fa-times-circle"></i></button>
								<button disabled class="btn btn-outline-secondary btn-sm" onclick="edit_usuario(<?php echo $u['id']; ?>)"><i class="fas fa-pen"></i></button>
								<button type="button" class="btn btn-outline-secondary btn-sm" onclick="inativar_usuario(<?php echo $u['id']; ?>)"><i class="fas fa-user-slash"></i></button>
								<button type="button" class="btn btn-outline-secondary btn-sm" onclick="setCompanies(<?php echo $u['id']; ?>)"><i class="far fa-building"></i></button>
							</td>
						</tr>
					<?php else: ?>
						<tr>
							<!-- <td><?php echo $u['id']; ?></td> -->
							<td><?php echo $u['name']; ?></td>
							<td><?php echo $u['email']; ?></td>
							<td><?php echo $u['telefone']; ?></td>
							<td><?php echo $u['status']; ?></td>
							<td>
								<button class="btn btn-outline-info btn-sm" onclick="ver_usuario(<?php echo $u['id']; ?>)"><i class="fas fa-eye"></i></button>
								<button class="btn btn-outline-success btn-sm" onclick="edit_perm(<?php echo $u['id']; ?>)"><i class="far fa-times-circle"></i></button>
								<button class="btn btn-outline-warning btn-sm" onclick="edit_usuario(<?php echo $u['id']; ?>)"><i class="fas fa-pen"></i></button>
								<button type="button" class="btn btn-outline-danger btn-sm" onclick="inativar_usuario(<?php echo $u['id']; ?>)"><i class="fas fa-user-slash"></i></button>
								<button type="button" class="btn btn-outline-primary btn-sm" onclick="setCompanies(<?php echo $u['id']; ?>)"><i class="far fa-building"></i></button>
							</td>
						</tr>
					<?php endif; ?>
					
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<!-- Modal Adicionar Usuários-->
<div class="modal fade" id="modal_usuarios">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Novos Usuários</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_usuarios"><br />
				<!-- Modal body -->
				<div class="modal-body">
                    <div class="row">
						<div class="col-sm">
							<label>Nome:</label>
							<input name="acao_usuario" value="cadastrar" hidden>
							<input name="id" value="" hidden>
							<input type="text" class="form-control form-control-sm" name="name">
						</div>
						<div class="col-sm">
							<label>E-mail:</label>
							<input type="mail" class="form-control form-control-sm" name="email">
						</div>
						<div class="col-sm">
							<label>Senha:</label>
							<input type="password" class="form-control form-control-sm" name="password">
						</div>
					</div><br/>
					<div class="row">
						<div class="col-sm-9">
							<label>Endereço:</label>
							<input type="text" class="form-control form-control-sm" name="endereco">
						</div>
						<div class="col-sm">
							<label>Telefone:</label>
							<input type="tel" class="form-control form-control-sm" name="telefone">
						</div>
					</div><br/>
					<div class="row">
						<div class="col-sm">
							<label>Observações:</label>
							<textarea class="form-control form-control-sm" name="obs" style="resize: none; height: 150px"></textarea>
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
<!-- Modal Incluir Empresas-->
<div class="modal fade" id="inc_companies">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Incluir Empresas</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- <form method="POST" class="form-group" id="setCompaniesForm"><br /> -->
				<!-- Modal body -->
				<div class="modal-body">
					<div class="showCompanies" id="showCompanies">
						
					</div>
					<br/>
					<div class="companyTitle">Empresa:</div>
					<div class="setCompaniesShow">
						<input type="text" value="" name="userId" id="userId" hidden>
						<?php foreach($getCompanies as $companies): ?>
							<div class="companyItem" dataID="<?php echo $companies['id']; ?>" id="companyItem<?php echo $companies['id']; ?>" onclick="selectCompany(<?php echo $companies['id']; ?>)">
								<?php echo $companies['name']; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-success" onclick="insertCompanies()">Salvar</button>
				</div>
			<!-- </form> -->
		</div>
	</div>
</div>
<!-- Modal Dados Usuários-->
<div class="modal fade" id="modal_usuario">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Dados do Usuário</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_usuarios"><br />
				<!-- Modal body -->
				<div class="modal-body">
                    <div class="row">
						<div class="col-sm">
							<label>Nome:</label>
							<div id="name" style="border-bottom: 1px solid green; border-right: 1px solid green"></div>
						</div>
						<div class="col-sm">
							<label>Email:</label>
							<div id="email" style="border-bottom: 1px solid green; border-right: 1px solid green"></div>
						</div>
						<div class="col-sm">
							<label>Telefone:</label>
							<div id="telefone" style="border-bottom: 1px solid green; border-right: 1px solid green"></div>
						</div>
					</div><hr/>
					<div class="row">
						<div class="col-sm">
							<label>Observação:</label>
							<textarea id="obs" class="form-control form-control-sm" style="resize: none; height:150px"></textarea>
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
<!-- Modal Adicionar Grupo Permissões-->
<div class="modal fade" id="cad_nova_perm_grupo">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Permissões</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_usuarios"><br />
				<!-- Modal body -->
				<div class="modal-body">
                    <label>Nome da Permissão:</label>
					<input type="text" name="acao_permission" value="cadastrar_grupo" hidden>
					<input type="text" class="form-control form-control-sm" name="name">
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
<!--Adicionar Permissões *REMOVER* -->
<div class="modal fade" id="cad_nova_perm">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Permissões do Sistema</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<label>Selecione o Usuário:</label>
				<select class="form-control form-control-sm" name="user_name" onchange="fetchSystemPermissions()">
					<option value="">Selecionar:</option>
					<option value="">------------------</option>
					<?php foreach($get_active_users as $user): ?>
						<option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
					<?php endforeach; ?>
				</select>
				<div id="sys_permissions">

				</div>
			</div>
			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
				<button onclick="save_system_permissions()" class="btn btn-success">Salvar</button>
			</div>
		</div>
	</div>
</div>
<!--Gerenciar Grupos / Permissões -->
<div class="modal fade" id="ger_permissoes">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Permissões por Empresa / Usuário</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- <form method="POST" class="form-group" id="form_usuarios"><br /> -->
				<!-- Modal body -->
				<div class="modal-body">
					<label>Selecione o Usuário:</label>
					<!-- <input type="text" name="acao_permission" value="gerenciar_grupos" hidden> -->
					<select class="form-control form-control-sm" name="company_user_name" onchange="fetchCompanies()">
						<option value="">Selecionar:</option>
						<option value="">------------------</option>
						<?php foreach($get_active_users as $user): ?>
							<option value="<?php echo $user['id']; ?>"><?php echo $user['name']; ?></option>
						<?php endforeach; ?>
					</select>
					<hr/>
					<div id="userCompanies">

					</div>
					
					<div id="permissionParams">

					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-success" onclick="saveCompanyPerm()" data-dismiss="modal">Salvar</button>
				</div>
			<!-- </form> -->
		</div>
	</div>
</div>
<!-- Modal Editar Grupo Permissões-->
<div class="modal fade" id="edit_perm_group">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div id="BSOD" style="width: 100%; height: 100%; background-color:rgba(0,0,0,0.5); z-index: 999; position: absolute; display: none; top: 0; left: 0">
				<div id="loading" style="height: auto; align-self: center; position: absolute; left: 40%; top: 60%; margin-top: -120px; text-align: center">
					<img style="height: 120px" class="monkeyB" src="<?php echo BASE_URL; ?>assets/images/icons/logoMonkeyBranch.png" alt="">
					<br/><br/>
					<span style="font-size: 25px; font-weight: bolder">Carregando</span>
				</div>
			</div>
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Editar Grupos de Permissões</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_usuarios"><br />
				<!-- Modal body -->
				<div class="modal-body">
					<div>
						<label>Selecione o Grupo de Permissões:</label>
						<input type="text" name="acao_permission" value="edit_perm_group" hidden>
						<select class="form-control form-control-sm" name="group_name" id="group_name" onchange="edit_group()">
							<option value=""></option>
							<?php foreach($getPermission_groups as $group): ?>
								<option><?php echo $group['name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div><hr/>
					<div id="permissions">
					
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
<!-- Modal Editar Grupo Permissões-->
<div class="modal fade" id="user_perm">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Grupo de Permissões</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_usuarios"><br />
				<!-- Modal body -->
				<div class="modal-body">
					<input type="text" name="acao_permission" value="" hidden>
					<input type="text" name="id" value="" hidden>
					<select class="form-control form-control-sm" name="group" id="group_name" required>
						<option value="">Selecione...</option>
						<?php foreach($getPermission_groups as $groups): ?>
							<option value="<?php echo $groups['id']; ?>"><?php echo $groups['name']; ?></option>
						<?php endforeach; ?>
					</select>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-success" onclick="upd_group()">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/admin.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/permission.js"></script>