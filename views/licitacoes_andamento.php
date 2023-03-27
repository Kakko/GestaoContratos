<div class="section_top">
    Licitações em Andamento (Visualização Somente)
</div>
<br/>
<div class="container-fluid">
    <table class="table table-striped table-hover table-sm">
		<thead class="thead-dark">
			<tr>
				<th>Data</th>
				<th>Horário</th>
				<th>Sistema</th>
                <th>Valor</th>
                <th>Nº do Pregão</th>
                <th>Empresa</th>
                <th>Status</th>
                <th>Ações</th>
			</tr>
		</thead>
		<tbody> 
            <?php foreach($ver_licitacoes_andamento as $a): ?>
                <tr>
                <td><?php echo $a['data']; ?></td>
                    <td><?php echo $a['hora']; ?></td>
                    <td><?php echo $a['system']; ?></td>
                    <td><?php echo $a['value']; ?></td>
                    <td><?php echo $a['auction']; ?></td>
                    <td><?php echo $a['company']; ?></td>
                    <td><?php echo $a['status']; ?></td>
                    <td>
                        <button class="btn btn-outline-info" onclick="ver_licitacao(<?php echo $a['id']; ?>)"><i class="fas fa-eye"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
		</tbody>
	</table>
</div>
<!-- Modal Ver Licitações -->
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
				<div class="modal-body">
                    <div class="container-fluid" style="border: 1px solid lightgray; border-radius: 5px; box-shadow: 0 0 10px lightgray">
                        <div class="row">
                            <div class="col-sm-1">
                                <label style="font-weight: bolder">Data:</label><br/>
                                <input type="text" class="exib_dados" id="data" readonly>
                            </div>
                            <div class="col-sm-1">
                                <label style="font-weight: bolder">Hora:</label>
                                <input type="text" class="exib_dados" id="hora" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label style="font-weight: bolder">Sistema:</label>
                                <input type="text" class="exib_dados" id="system" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label style="font-weight: bolder">Valor:</label>
                                <input type="text" class="exib_dados" id="value" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label style="font-weight: bolder">Nº do Pregão:</label>
                                <input type="text" class="exib_dados" id="auction" readonly>
                            </div>
                            <div class="col-sm-1">
                                <label style="font-weight: bolder">Identificador</label>
                                <input type="text" class="exib_dados" id="complement" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label style="font-weight: bolder">Cidade:</label>
                                <input type="text" class="exib_dados" id="city" readonly>
                            </div>
                            <div class="col-sm-1">
                                <label style="font-weight: bolder">UF:</label>
                                <input type="text" class="exib_dados" id="uf" readonly>
                            </div>
                        </div>
                        <br><hr/>
                        <div class="row">
                            <div class="col-sm-2">
                                <label style="font-weight: bolder">Órgão:</label>
                                <input type="text" class="exib_dados" id="agency" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label style="font-weight: bolder">Empresa:</label>
                                <input type="text" class="exib_dados" id="company" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label style="font-weight: bolder">Status:</label>
                                <input type="text" class="exib_dados" id="status" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label style="font-weight: bolder">Esclarecimentos:</label>
                                <input type="text" class="exib_dados" id="esclarecimentos" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label style="font-weight: bolder">Ata:</label>
                                <input type="text" class="exib_dados" id="ata" readonly>
                            </div>
                            <div class="col-sm-2">
                                <label style="font-weight: bolder">Modalidades:</label>
                                <input type="text" class="exib_dados" id="modalidades" readonly>
                            </div>
                        </div>
                        <br><hr/>
                        <div class="row">
                            <div class="col-sm-3">
                                <label style="font-weight: bolder">Produtos:</label>
                                <input type="text" class="exib_dados" id="produtos" readonly>
                            </div>
                            <div class="col-sm-3">
                                <label style="font-weight: bolder">Desconto:</label>
                                <input type="text" class="exib_dados" id="desconto" readonly>
                            </div>
                            <div class="col-sm-3">
                                <label style="font-weight: bolder">Objetos:</label>
                                <input type="text" class="exib_dados" id="object" readonly>
                            </div>
                            <div class="col-sm-3">
                                <label style="font-weight: bolder">AG.Cadast / Ganho</label>
                                <input type="text" class="exib_dados" id="ag_cadast" readonly>
                            </div>
                        </div>
                        <br><hr/>
                        <div class="row">
                            <div class="col-sm-12">
                                <label style="font-weight: bolder">Observações:</label>
                                <textarea type="text" class="exib_dados" id="obs" style="resize: none" readonly></textarea>
                            </div>
                        </div>
                        <br><br/>
                        <div class="row" style="border-bottom: 1px solid lightgray; border-top: 1px solid lightgray">
                            <div class="col-sm-12" style="border-right: 1px solid lightgray">
                                <label style="font-weight: bolder">Histórico:</label>
                                <div id="historico">
                                    <table class="table table-striped table-hover table-sm">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Título</th>
                                                <th>Data</th>
                                                <th>Horário</th>
                                                <th>Observações</th>
                                                <th>Usuário</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-hist">
                                                
                                        </tbody>
                                    </table>                
                                </div>
                            </div>
                        </div>
                        <br/>
                    </div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-info" data-dismiss="modal">Fechar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
    function ver_licitacao(id) {
    $.post('', {
        acao_licitacoes: 'ver',
        id: id
    }, function(data) {
        let header = JSON.parse(data);
        // console.log(data);
        $("#data").val(header.header.data);
        $("#hora").val(header.header.hora);
        $("#system").val(header.header.system);
        $("#value").val(header.header.value);
        $("#auction").val(header.header.auction);
        $("#complement").val(header.header.complement);
        $("#city").val(header.header.city);
        $("#uf").val(header.header.uf);
        $("#agency").val(header.header.agency);
        $("#object").val(header.header.object);
        $("#company").val(header.header.company);
        $("#status").val(header.header.status);
        $("#esclarecimentos").val(header.header.esclarecimentos);
        $("#ag_cadast").val(header.header.ag_cadast);
        $("#obs").val(header.header.obs);


        $('#table-hist').html('');
        $(header.historico).each(function(index) {
            let table = `<tr>
                            <td>`+header.historico[index].titulo+`</td>
                            <td>`+header.historico[index].data_licitacao+`</td>
                            <td>`+header.historico[index].horario_licitacao+`</td>
                            <td>`+header.historico[index].obs+`</td>
                            <td>`+header.historico[index].name+`</td>
                        </tr>`

            $('#table-hist').html($('#table-hist').html()+table);
          });


        $('#ver_licitacoes').modal('show');

    })
}
</script>