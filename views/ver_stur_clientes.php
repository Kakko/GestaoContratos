<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/stur_import.css">
<div class="section_top">
    Clientes dos Stur - Aprovação
</div>
<br/>
<div class="container-fluid">
    <div style="height: 80vh; overflow: auto">
        <?php echo $import_client_stur; ?>
    </div>
</div>

<!-- Modal Atualizar Licitações-->
<div class="modal fade" id="modal_edit_import" style="overflow: auto">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Verificar Cliente Importado - Stur</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST" class="form-group" id="updLic"><br />
				<!-- Modal body -->
				<div class="modal-body" id="stur_client_edit">
                    
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-primary" onclick="addSturClient()" data-dismiss="modal">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/import_stur.js"></script>