<div class="section_top">
    Relatórios
</div><br/>
<div class="container-fluid">
    <form method="POST" class="form-group" id="form_relatorios" target="_blank">
        <div class="row">
            <div class="col-sm-3">
                <label for="tipo_relatorio">Tipo:</label>
                <select class="form-control form-control-sm" name="tipo_relatorio">
                    <option>Licitações</option>
                    <option>Contratos</option>
                </select>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-sm-3">
                <label for="status">Status:</label>
                <select class="form-control form-control-sm" name="status">
                    <option value="">Selecione...</option>
                    <option>Pré Cadastro</option>
                    <option>Em Andamento</option>
                    <option>Homologado</option>
                    <option>Suspenso</option>
                    <option>Anulado</option>
                    <option>Perdido</option>
                </select>
            </div>
            <div class="col-sm-3">
                <label for="status">Empresa:</label>
                <select class="form-control form-control-sm" name="empresa">
                    <option value="">Selecione...</option>
                    <option>Todos</option>
                    <option>Ativo</option>
                    <option>Inativo</option>
                </select>
            </div>
            <div class="col-sm-3">
                <label for="status">Sistema:</label>
                <select class="form-control form-control-sm" name="sistema">
                    <option value="">Selecione...</option>
                    <option>Todos</option>
                    <option>Ativo</option>
                    <option>Inativo</option>
                </select>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-sm-2">
                <label for="finalizado">Contrato Ativo: <span style="color:red; font-weight: bold">*</span></label>
                <select class="form-control form-control-sm" name="finalizado">
                    <option value="">Selecione...</option>
                    <option>Sim</option>
                    <option>Não</option>
                </select>
            </div>
            <div class="col-sm-3">
                <label for="status">Cliente: <span style="color:red; font-weight: bold">*</span></label>
                <select class="form-control form-control-sm" name="cliente">
                    <option value="">Selecione...</option>
                    <option>Todos</option>
                    <option>Ativo</option>
                    <option>Inativo</option>
                </select>
            </div>
            <!-- <div class="col-sm-2">
                <label for="finalizado">Inadimplente: <span style="color:red; font-weight: bold">*</span></label>
                <select class="form-control form-control-sm" name="inadimplente">
                    <option readonly>Selecione...</option>
                    <option>Sim</option>
                    <option>Não</option>
                </select>
            </div> -->
        </div>
        <br/>
        <span style="color:red; font-weight: bold">*</span> - Somente Contratos
        <hr/>
        <input type="submit" class="btn btn-success" value="Gerar PDF" style="float: right">
    </form>
</div>



