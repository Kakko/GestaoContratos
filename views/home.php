<div class="section_top">
    Alertas
</div>
<div class="container-fluid">
    <div class="row warningsGeral">
        <div class="col-sm" id="warningsContrato">
            <h3>Contratos</h3>
            <?php foreach($companies as $company): ?>
              <?php
                $companyPermission = explode(',', $company['company_permission']);
                if(in_array($company['id'], $companyPermission)): ?>
                  <div class="contTitle">
                    <?php echo $company['name']; ?>
                    </div>
                    <?php foreach($contActualWarn as $cont): ?>
                      <?php if($cont['empresa'] == $company['id']): ?>
                        <div class="warnBoxContratos" onclick="showCont(<?php echo $cont['id']; ?>)">
                          <span>Término do Contrato: <?php echo $cont['n_contrato']; ?></span>
                        </div>
                      <?php endif; ?>
                    <?php endforeach; ?>
                    <?php foreach($contWeekWarn as $cont): ?>
                      <?php if($cont['empresa'] == $company['id']): ?>
                        <div class="warnBoxContratosWeek" onclick="showCont(<?php echo $cont['id']; ?>)">
                          <span>Término do Contrato: <?php echo $cont['n_contrato']; ?></span>
                        </div>
                      <?php endif; ?>
                    <?php endforeach; ?>
                    <?php foreach($contMonthWarn as $cont): ?>
                      <?php if($cont['empresa'] == $company['id']): ?>
                        <div class="warnBoxContratosMonth" onclick="showCont(<?php echo $cont['id']; ?>)">
                          <span>Término do Contrato: <?php echo $cont['n_contrato']; ?></span>
                        </div>
                    <?php endif; ?>
                  <?php endforeach; ?>
                <?php endif; ?>
              <?php endforeach; ?>
        </div>

        <div class="col-sm" id="warningsLicitacao">
            <h3>Licitações</h3>
            <?php if(!empty($licWarn)): ?>
                <?php foreach($licWarn as $lic): ?>
                    <div class="warnBoxLicitacao" onclick="showLic(<?php echo $lic['id']; ?>)">
                        <span>Licitação <?php echo $lic['auction']; ?> inicia às: <?php echo $lic['hora']; ?></span>
                    </div>
                <?php endforeach; ?>
                <?php if(!empty($licWarnWeek)): ?>
                  <?php foreach($licWarnWeek as $lic): ?>
                      <div class="warnBoxLicitacaoWeek" onclick="showLic(<?php echo $lic['id']; ?>)">
                          <span>Licitação <?php echo $lic['auction']; ?> inicia às: <?php echo $lic['hora']; ?> - ( <?php echo date("d/m/Y", strtotime($lic['data'])); ?> )</span>
                      </div>
                  <?php endforeach; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="col-sm" id="warningsDocumentos">
            <h3>Documentos</h3>
            <?php if(!empty($docsWarn)): ?>
                <?php foreach($docType as $type): ?>
                  <?php 
                    $companyPermission = explode(',', $company['company_permission']);  
                      if(in_array($type['company'], $companyPermission)): ?>
                      <div class="docTitle">
                        <?php echo $type['company_name']; ?>
                      </div>
                      <?php foreach($docsWarn as $docs): ?>
                          <?php if($type['company'] == $docs['company']): ?>
                              <?php if($docs['venc_dias'] < 0): ?>
                                  <div class="warnBoxDocumentosOutDated" onclick="showDocs(<?php echo $docs['id']; ?>)">
                                    <span>( <strong style="color: red"><?php echo $docs['category']; ?></strong> ) Documento <?php echo $docs['doctype']; ?> vence dia <?php echo $docs['expiration_date']; ?> - ( <?php echo $docs['venc_dias']; ?> dias)</span>
                                  </div>
                              <?php else: ?>
                                  <div class="warnBoxDocumentos" onclick="showDocs(<?php echo $docs['id']; ?>)">
                                    <span>( <strong style="color: red"><?php echo $docs['category']; ?></strong> ) Documento <?php echo $docs['doctype']; ?> vence dia <?php echo $docs['expiration_date']; ?> - ( <?php echo $docs['venc_dias']; ?> dias)</span>
                                  </div>
                              <?php endif; ?>
                          <?php endif; ?>
                    <?php endforeach; ?>
                  <?php endif; ?>  
                <?php endforeach; ?>    
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Adicionar Licitações-->
<div class="modal fade" id="warning_modal_licitacao" style="overflow: auto">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Licitações</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form method="POST" class="form-group" id="form_licitacoes1"><br />
          <!-- Modal body -->
          <div class="modal-body" id="modal_licitacao">
              
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Cadastro de Contratos -->
  <div class="modal fade" id="warning_modal_contratos">
    <div class="modal-dialog modal-xl" style="overflow: auto">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Contratos</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
          <!-- Modal body -->
        <form method="POST" id="form_cad_contratos">
          <div class="modal-body" id="modal_contratos">
            
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Add Documents -->
  <div class="modal fade" id="warning_modal_documentos">
    <div class="modal-dialog modal-xl">
      <div class="modal-content" style="z-index: -10">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Documentos</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
          <!-- Modal body -->
          <form method="POST" class="form-group" enctype="multipart/form-data">
              <input type="text" name="doc_action" value="cadNewDoc" hidden>
              <div class="modal-body" id="modal_documentos">
                  
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
              </div>
          </form>
      </div>
    </div>
  </div>
  <script src="<?php echo BASE_URL; ?>assets/js/warnings.js"></script>