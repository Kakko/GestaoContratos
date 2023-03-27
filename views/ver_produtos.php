<div class="section_top">
    Produtos Cadastrados
</div>
<br/>
<div class="container-fluid">
	<div style="height: 80vh; overflow: auto">
		<table class="table table-striped table-hover table-sm">
			<thead class="thead-dark">
				<tr>
					<th>Nome</th>
					<th>Data de Criação</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody style="font-size: 12px">
				<?php foreach($get_produtos as $s): ?>
					<tr>
						<td style="width: 50%"><?php echo $s['name']; ?></td>
						<td><?php echo $s['data_cadastro']; ?></td>
						<td style="width: 15%">
							<button class="btn btn-outline-warning btn-sm" onclick="editar_produtos(<?php echo $s['id']; ?>)"><i class="fas fa-pen"></i></button>
							<button class="btn btn-outline-danger btn-sm" onclick="excluir_produtos(<?php echo $s['id']; ?>)"><i class="fas fa-trash"></i></button>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<!-- Modal Adicionar Sistemas-->
<div class="modal fade" id="modal_produtos">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Cadastrar Produtos</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="form_system"><br />
				<!-- Modal body -->
				<div class="modal-body">
                    <div class="col-sm-12">
                        <label for="name">Nome:</label>
                        <input type="text" name="id" hidden>
                        <input type="text" name="acao_produtos" value="" hidden>
                        <input type="text" class="form-control form-control-sm" name="name" placeholder="Digite o nome do sistema">
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

