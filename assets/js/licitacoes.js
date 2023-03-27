const cad_licitacao = $('#modal_licitacoes').html();
//Cadastro da Licitação
function cadastrar_licitacoes() {
    $('#modal_licitacoes').html(cad_licitacao);
    $('.valor').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
    $("[name='acao_licitacoes']").val('cadastrar');
    $('#cadWinnerCompany').attr('disabled', '');
    $('#modal_licitacoes').modal('show');
}

//Abrir Modal Add Sistema
function addSystem(){
    $("[name='addsystem']").val('');
    $('#modal_addSystem').modal('show');
}

//Add Sistema - Modal
function cadSystem(){
    let system = $("[name='addSystem']").val();

    $.post('', {
        acao_licitacoes: 'addSistema_modal',
        system: system
    }, function(data){
        $('#system_cad').html(data);
    })
}
//Abrir Modal Add Órgão
function addOrgao(){
    $("[name='addOrgao']").val('');
    $('#modal_addOrgao').modal('show');
}

//Add Órgão - Modal
function cadOrgao(){
    let orgao = $("[name='addOrgao']").val();

    $.post('', {
        acao_licitacoes: 'addOrgao_modal',
        orgao: orgao
    }, function(data){
        $('#orgao').html(data);
    })
}

//Abrir Modal Stauts Info
function addStatusInfo(){
    $("[name='addStatusInfo']").val('');
    $('#modal_statusInfo').modal('show');
}

//Add Status Info - Modal
function cadStatusInfo(){
    let status_info = $("[name='addStatusInfo']").val();

    $.post('', {
        acao_licitacoes: 'addStatusInfo',
        status_info: status_info
    }, function(data){
        $('#statusInfo').html(data);
    })
}
//Salvar Licitação
function saveLicitacao(){
    let form = document.getElementById('form_licitacoes1');
    $.ajax({
        type: 'POST',
        url: '',
        data: new FormData(form),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data){

        }
    });


    filtrar();
}
//Ver Licitação
function ver_licitacao(id) {
    $.post('', {
        acao_licitacoes: 'ver',
        id: id
    }, function(licitacao) {
        $('#verLicitacao').html(licitacao);
    });
    $('#ver_licitacoes').modal('show');
}
//Edição da Licitação
function editar_licitacao(id) {
    $.post('', {
        acao_licitacoes: 'ver_edit',
        id: id
    }, function(licitacao) {

        $('#ver_edit').html(licitacao);
        
        $('#winner_company').removeAttr('disabled', '');
        $('#addWinnerCompany2').removeAttr('disabled', '');
        $('#addWinnerCompany2').removeClass('btn-secondary');
        $('#addWinnerCompany2').addClass('btn-success');
        $('#winner_value').removeAttr('disabled', '');
        $('#winner_perc').removeAttr('disabled', '');
        $('#addcadWinnerCompany').removeAttr('disabled', '');
        $("[name='acao_licitacoes']").val('atualizar');
        $('#modal_updLicitacoes').modal('show');
        get_cnpj();
        // $('.valor').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

    });
}

//Atualizar a Licitação
function updLicitacao(){
    let form = document.getElementById('updLic');
    $.ajax({
        type: 'POST',
        url: '',
        data: new FormData(form),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data){
            // console.log(data)
        }
    });


    filtrarNewLicUpd();
}

//Exclusão da Licitação
function excluir_licitacao(id) {
    let c = confirm("Deseja excluir?")
    if (c == true) {
        $.post('', {
            acao_licitacoes: 'excluir',
            id: id
        }, function(data) {
            window.location.reload();
        });
    }
}

function excluir_prod(id){
    let c = confirm("Deseja excluir este produto?")
    if (c == true) {
        $.post('', {
            acao_licitacoes: 'excluir_prod',
            id: id
        }, function(data) {
            window.location.reload();
        });
    }
}

//Ver Histórico

function cad_historico(id) {
    $("[name='acao_historico']").val('cadastrar');
    $("[name='id']").val(id);
    $('#ver_historico').modal('show');
}

//Inserir o desconto no produto

function cad_desconto(id) {
    $.post('', {
        acao_desconto: 'edit_desconto',
        id: id
    }, function(data) {
        $('#tdado').html(data);

        $("[name='acao_desconto']").val('atualizar');
        $('#ver_desconto').modal('show');
    });
}

//Filtrar

function filtrar() {
    let tipo = $('#tipo').val();
    let status = $('#status_pesquisa').val();
    let empresa = $('#empresa').val();
    let sistema = $('#sistema').val();
    let data_de = $('#data_de').val();
    let data_ate = $('#data_ate').val();
    let valor_de = $('#valor_de').val();
    let valor_ate = $('#valor_ate').val();

    $.post('', {
        acao_licitacoes: 'filtrar',
        tipo: tipo,
        status: status,
        empresa: empresa, 
        sistema: sistema,
        data_de: data_de,
        data_ate: data_ate,
        valor_de: valor_de,
        valor_ate: valor_ate
    }, function(data) {

        $('#table_licitacoes').html(data);
    });
}

function listar_cidades(){
    let estado = $("[name='uf']").val();

    $.post('', {
        acao_licitacoes: 'estado',
        estado: estado
    }, function(data){

        $('#cidade').html(data);
    })
}

function get_cnpj(){
    let empresa = $("[name='company']").val();

    $.post('', {
        acao_licitacoes: 'get_cnpj',
        empresa: empresa
    }, function(data){
        var cnpj = JSON.parse(data)

        $('#company_cnpj').val(cnpj.cnpj);
    })
}
//Cadastros Empresas Vencedoras

function addWinnerCompany(){
    $("[name='addWinnerCompany']").val('');
    $('#modal_addWinnerCompany').modal('show');
}

function cadCompanyWinner(){
    let wcompany = $("[name='wcompany']").val();

    $.post('', {
        acao_licitacoes: 'winner',
        wcompany: wcompany
    }, function(data){
        $('#wcompany_select').html(data);
    })
}
let winner_default = $('#wcompany_select').html();
function cadWinnerCompany(){
    let winner_company = $("[name='winner_company']").val();
    let winner_value = $("[name='winner_value']").val();
    let winner_perc = $("[name='winner_perc']").val();
    let licitacao_id = $("[name='id']").val();

    $.post('', {
        acao_licitacoes: 'cad_winnerCompany',
        winner_company: winner_company,
        winner_value: winner_value,
        winner_perc: winner_perc,
        licitacao_id: licitacao_id
    }, function(data){
        $('#table-winner').html(data);
        $("[name='winner_value']").val(0);
        $("[name='winner_perc']").val(0);
    })
}

function delete_winner(id){
    let licitacao_id = $("[name='licitacao_id']").val();
    let c = confirm("Deseja Excluir?")
    if (c == true){
        $.post('', {
            acao_licitacoes: 'delete_winner',
            licitacao_id: licitacao_id,
            id: id
        }, function(data){

            $('#table-winner').html(data);
        });
    }
}

function delete_hist(id){
    let hist_id = id;
    let c = confirm("Deseja Excluir?")
    if (c == true){
        $.post('', {
            acao_licitacoes: 'delete_hist',
            hist_id: hist_id,
            id: id
        }, function(historico){
            $('#table-hist').html(historico);
        });
    }

}
//Blocos de Anotações
function addNote(id){
    $.post('', {
        id: id,
        acao_licitacoes: 'notepad'
    }, function(notes){
        $('#notes').html(notes);
    })
   
    $('#contNote').modal('show');
}

function addNewNote(id) {
    $.post('', {
        id: id,
        acao_licitacoes: 'showNoteModal'
    }, function(form){
        $('#addNewNote').html(form);
    })
    
    $('#newNote').modal('show');
}

function saveNewNote(){
    let id = $("[name='licitacao_id']").val();
    let title = $("[name='noteTitle']").val();
    let text = $("[name='noteText']").val();

    $.post('', {
        id: id,
        title: title,
        text: text,
        acao_licitacoes: 'save_note'
    }, function(notes){
        $('#notes').html(notes);
    })
}

function deleteNote(id) {
    let licitacao_id = $("[name='licitacao_id']").val();
    let c = confirm("Deseja excluir esta Anotação?")
    if (c == true) {
        $.post('', {
            acao_licitacoes: 'deleteNote',
            licitacao_id: licitacao_id,
            id: id
        }, function(notes) {
            $('#notes').html(notes);
        });
    }
}

//Search Agency
function searchAgency() {
    let agency = $('.searchAgency').val()

    $.post('', {
        acao_licitacoes: 'searchAgency',
        agency
    }, function(data) {
        $('.resultAgency').removeAttr('hidden')
        $('.resultAgency').html(data)
    })
}

function selectAgency(id){
    $.post('', {
        acao_licitacoes: 'setAgency',
        id
    }, function(data){
        $('.searchAgency').val(data)
        $('.resultAgency').attr('hidden', true)
    })

}

function closeAgency(){ 
    $('.resultAgency').attr('hidden', true)
}

$(document).ready(function() {
    $('.valor').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
});
$(document).ready(function() {
    $('.valor4').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false, precision: 4});
});

function filtrarNewLicUpd() {

    let company = document.getElementsByClassName('companyItem selected')
    let statusItem = document.getElementsByClassName('statusItem selected')
    let type = document.getElementsByClassName('typeItem selected')
    let system = document.getElementsByClassName('systemItem selected')

    let data_de = document.getElementById('data_de').value
    let data_ate = document.getElementById('data_ate').value

    let valor_de = document.getElementById('valor_de').value
    let valor_ate = document.getElementById('valor_ate').value

    let resultCompany = '';
    let resultStatus = '';
    let resultType = '';
    let resultSystem = '';
    
    Array.from(company).forEach(function(valor, chave) {
        resultCompany += valor.innerText+'-z/'
    })
    Array.from(statusItem).forEach(function(valor, chave) {
        resultStatus += valor.innerText+','
    })
    Array.from(type).forEach(function(valor, chave){
        resultType += valor.innerText+','
    })
    Array.from(system).forEach(function(valor, chave) {
        resultSystem += valor.innerText+','
    })

    let companyResult = resultCompany.slice(0, -3)
    let statusResult = resultStatus.slice(0, -1)
    let typeResult = resultType.slice(0, -1)
    let systemResult = resultSystem.slice(0, -1)
    
    var formData = new FormData();

    formData.append('company', companyResult);
    formData.append('status', statusResult)
    formData.append('type', typeResult)
    formData.append('system', systemResult)
    formData.append('data_de', data_de)
    formData.append('data_ate', data_ate)
    formData.append('valor_de', valor_de)
    formData.append('valor_ate', valor_ate)
    formData.append('acao_licitacoes', 'filtrar')

    const xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                document.getElementById('table_licitacoes').innerHTML = xhr.responseText
            } else {
                alert('Erro')
            }
        }
    }
    xhr.send(formData)

    closeAllLicitacaoFilters()
}