<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8' />

    <!-- Configurações do FullCalendar.io -->
    <link type="text/css" href='./packages/core/main.css' rel='stylesheet' />
    <link type="text/css" href='./packages/daygrid/main.css' rel='stylesheet' />
    <link type="text/css" href='./packages/timegrid/main.css' rel='stylesheet' />
    <link type="text/css" href='./packages/list/main.css' rel='stylesheet' />
    <script src='./packages/core/main.js'></script>
    <script src='./packages/interaction/main.js'></script>
    <script src='./packages/daygrid/main.js'></script>
    <script src='./packages/timegrid/main.js'></script>
    <script src='./packages/list/main.js'></script>
    <script src='./packages/core/locales/pt-br.js'></script>
    <!-- Final das configurações do FullCalendar.io -->
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        // var initialLocaleCode = 'pt-br';
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
          eventClick: function(info) {
            var eventObj = info.event;
            // console.log(eventObj.groupId);
            
            //LICITAÇÕES
            if(eventObj.backgroundColor == '#3788d8'){
              let id = eventObj.groupId;
              // console.log(id);
              $.post('', {
                agenda_action: 'exibir_licitacao',
                id: id
              }, function(data){
                $('#modal_licitacao').html(data)
              })
              
              $('#agenda_modal_licitacoes').modal('show');

            }

            //CONTRATOS
            if(eventObj.backgroundColor == '#F08080'){
              let id = eventObj.groupId;

              $.post('', {
                agenda_action: 'exibir_contratos',
                id: id
              }, function(data){
                $('#modal_contratos').html(data)
              })
              
              $('#agenda_modal_contratos').modal('show');

            }

            //DOCUMENTOS
            if(eventObj.backgroundColor == '#94e49b'){
              let id = eventObj.groupId;

              $.post('', {
                agenda_action: 'exibir_documentos',
                id: id
              }, function(data){
                console.log(data);
                $('#modal_documentos').html(data)
              })
              
              $('#agenda_modal_documentos').modal('show');

            }

            // if (eventObj.url) {
            //   alert(
            //     'Clicked ' + eventObj.title + '.\n' +
            //     'Will open ' + eventObj.url + ' in a new tab'
            //   );

            //   window.open(eventObj.url);

            //   info.jsEvent.preventDefault(); // prevents browser from following link in current tab.
            // } else {
              
            // }
          },

          locale: 'pt-br',
          plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
          height: 'parent',
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
          },
          defaultView: 'dayGridMonth',
          // defaultDate: '2020-02-12',
          navLinks: true, // can click day/week names to navigate views
          editable: false,
          eventLimit: true, // allow "more" link when too many events
          nowIndicator: true,



          events: [
            
            <?php foreach($getAgendaLicitacao as $lic): ?>
              <?php 
                $companyPermission = explode(',', $lic['company_permission']);
                if(in_array($lic['company'], $companyPermission)): 
              ?>
              {
                groupId: '<?php echo $lic['id']; ?>',
                title: 'Licitação nº <?php echo $lic['auction']; ?>',
                start: '<?php echo $lic['data']; ?>T<?php echo $lic['hora']; ?>',
                color: '#3788d8',
                description: 'teste descrição',
                // url: ''
              },
              <?php endif; ?>
            <?php endforeach; ?>

            <?php foreach($getAgendaDocuments as $doc): ?>
              <?php 
                $companyPermission = explode(',', $doc['company_permission']);
                if(in_array($doc['company'], $companyPermission)): 
              ?>
              {
                groupId: '<?php echo $doc['id']; ?>',
                title: 'Documento Cat - <?php echo $doc['category']; ?>',
                start: '<?php echo $doc['expiration_date']; ?>',
                color: '#94e49b',
              },
              <?php endif; ?>
            <?php endforeach; ?>
            
            <?php foreach($getAgendaContratos as $cont): ?>
              <?php 
                $companyPermission = explode(',', $cont['company_permission']);
                if(in_array($cont['empresa'], $companyPermission)): 
              ?>
              {
                groupId: '<?php echo $cont['id']; ?>',
                title: 'Término - <?php echo $cont['n_contrato']; ?>',
                start: '<?php echo $cont['fim_contrato']; ?>',
                color: '#F08080'
              },
              <?php endif; ?>
            <?php endforeach; ?>
            // {
            //   title: 'All Day Event',
            //   start: '2020-02-01',
            // },
            // {
            //   title: 'Long Event',
            //   start: '2020-02-07',
            //   end: '2020-02-10'
            // },
            // {
            //   groupId: 999,
            //   title: 'Repeating Event',
            //   start: '2020-02-09T16:00:00'
            // },
            // {
            //   groupId: 999,
            //   title: 'Repeating Event',
            //   start: '2020-02-16T16:00:00'
            // },
            // {
            //   title: 'Conference',
            //   start: '2020-02-11',
            //   end: '2020-02-13'
            // },
            // {
            //   title: 'Meeting',
            //   start: '2020-02-12T10:30:00',
            //   end: '2020-02-12T12:30:00'
            // },
            // {
            //   title: 'Lunch',
            //   start: '2020-02-12T12:00:00'
            // },
            // {
            //   title: 'Meeting',
            //   start: '2020-02-12T14:30:00'
            // },
            // {
            //   title: 'Happy Hour',
            //   start: '2020-02-12T17:30:00'
            // },
            // {
            //   title: 'Dinner',
            //   start: '2020-02-12T20:00:00'
            // },
            // {
            //   title: 'Birthday Party',
            //   start: '2020-02-13T07:00:00'
            // },
            // {
            //   title: 'Click for Google',
            //   url: 'http://google.com/',
            //   start: '2020-02-28'
            // }
          ],

          // eventColor: '#F08080',
          eventTimeFormat: { // like '14:30:00'
            hour: '2-digit',
            minute: '2-digit',
            meridiem: true,
          },

          


        });

        calendar.render();
      });

    </script>

    <style>

      html, body {
        overflow: hidden; /* don't do scrollbars */
        font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
        font-size: 14px;
      }

      #calendar-container {
        position: fixed;
        top: 50px;
        left: 50px;
        right: 15px;
        bottom: 50px;
      }

      .fc-header-toolbar {
        /*
        the calendar will be butting up against the edges,
        but let's scoot in the header's buttons
        */
        padding-top: 1em;
        padding-left: 1em;
        padding-right: 1em;
      }
    }
    </style>

  </head>
  <body>

    <div id='calendar-container'>
      <div id='calendar'></div>
    </div>
    <div id="warning">
    
    </div>
    <div id="follow_up">
        
    </div>
    
    <!-- Modal Adicionar Licitações-->
  <div class="modal fade" id="agenda_modal_licitacoes" style="overflow: auto">
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
  <div class="modal fade" id="agenda_modal_contratos">
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
  <div class="modal fade" id="agenda_modal_documentos">
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
  </body>
</html>
