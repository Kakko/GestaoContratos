//Cadastrar Contratos
function cad_contrato(){
    $('.col-md-1 > [name="acao_contratos"]').val('cadastrar');
    $('#cad_contratos').modal('show');
}
function insertContrato() {
    let form = document.getElementById('newContract');
    // console.log(form)
    $.ajax({
        type: 'POST',
        url: '',
        data: new FormData(form),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data){
            alert('Contrato Cadastrado com Sucesso');
            // console.log(data)
        }
    });


    // filtrar();
}
//Editar Contratos
function editar_contrato(id) {
    $.post('', {
        acao_contratos: 'edit',
        id: id
    }, function(data){
        $("#editContratos").html(data);

        $("[name='acao_contratos']").val('updContrato');
        $('#modal_contratos').modal('show');
    });

    // filtrar();
}

function updContrato(){
    let form = document.getElementById('updContrato');
    let nome = $("[name='nome_cliente']").val();
    
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

    filtrarNewContractsUpd();
}

function ver_contrato(id) {
    $.post('', {
        acao_contratos: 'ver',
        id: id
    }, function(contratos) {
        $('#verContrato').html(contratos);

        $('#ver_contrato').modal('show');

    })
}
const hist_licitacao = $('#infoLicitacao').html();

function licitacaoInfo(id){
    $.post('', {
        acao_contratos: 'licitacao_info',
        id: id
    }, function(dados){

        $('#licitacao_info').html(dados)
    })

    // $('#infoLicitacao').html(hist_licitacao);
    $('#infoLicitacao').modal();
}
// const hist_cadastro = document.getElementById('hist_cadastro').innerHTML //ERRO DE NÃO CARREGAR CORRETAMENTE O EDITOR
function cad_historico(id) {
    
    // document.getElementById('hist_cadastro').innerHTML = hist_cadastro
    $('.note-editable').html('');
    $('#form_historico').each(function(){
        this.reset();
    });
    $(".col-md-4 > [name='acao_contratos']").val('cad_historico');
    $("[name='id']").val(id);
    $('#hist_cadastro').modal('show');
}

function saveHist() {
    let form = document.getElementById('form_historico');
    $.ajax({
        type: 'POST',
        url: '',
        data: new FormData(form),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data){
            console.log(data)
        }
    });


    filtrarNewContractsUpd();
}

function ver_info(id){

    $.post('', {
        acao_contratos: 'info',
        id: id
    }, function(data) {
        $('#ver_info').modal('show');
        $('#dados_stur').html(data);
    });
}

$(document).ready(function() {
    $('.valor').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
});

function cod_stur(){
    let nome = $("#cliente_contrato").val();

    $.post('', {
        acao_contratos: 'cod_stur',
        nome: nome
    }, function(data){
        var dado = JSON.parse(data);

        $("#cod").val(dado.stur_cod);
        $("#razao_social").val(dado.razao_social);
        $("#cnpj").val(dado.cnpj);
        $("#empresa_show").val(dado.company_name);
        $("#empresa").val(dado.empresa_id);


    })
}

function cod_stur_cad(){
    let nome = $("#cad_cliente_contrato").val();
    $.post('', {
        acao_contratos: 'cod_stur',
        nome: nome
    }, function(data){

        var dado = JSON.parse(data);
        $("#cod_cad").val(dado.stur_cod);
        $("#razao_social_cad").val(dado.razao_social);
        $("#cnpj_cad").val(dado.cnpj);
        $("#empresa_cad").val(dado.empresa_id);
        $("#empresa_cad_show").val(dado.company_name);


    })
}

function searchCod() {
    let cod = $("#cod_cad").val()

    $.post('', {
        acao_contratos: 'searchCod',
        cod
    }, function(data){
        var dados = JSON.parse(data);

        $("#cad_cliente_contrato").val(dados.id);
        $("#razao_social_cad").val(dados.razao_social);
        $("#cnpj_cad").val(dados.cnpj);
        $('#empresa_cad').val(dados.empresa);
    })
}

function searchEditCod() {
    let cod = $("#cod").val()
    let empresa = $("#empresa").val();
    $.post('', {
        acao_contratos: 'searchCod',
        cod,
        empresa
    }, function(data){
        var dados = JSON.parse(data);
        console.log(dados)

        $("#cliente_contrato").val(dados.nome_cliente);
        $("#razao_social").val(dados.razao_social);
        $("#cnpj").val(dados.cnpj);
        $('#empresa').val(dados.empresa);
    })
}

function excluir_contrato(id) {
    let c = confirm("Deseja excluir este Contrato?")
    if (c == true) {
        $.post('', {
            acao_contratos: 'excluir',
            id: id
        }, function(data) {

            window.location.reload();
        });
    }
}

function deleteHist(id) {
    let c = confirm("Deseja excluir este Registro?")
    if (c == true) {
        $.post('', {
            acao_contratos: 'excluirHist',
            id: id
        }, function(data) {
            window.location.reload();
        });
    }
}

function delete_hist(id){
    let hist_id = id;
    let c = confirm("Deseja Excluir?")
    if (c == true){
        $.post('', {
            acao_contratos: 'delete_hist',
            hist_id: hist_id,
            id: id
        }, function(historico){

            $('#table-hist').html(historico);
        });
    }
}

function addNote(id){
    $.post('', {
        id: id,
        acao_contratos: 'notepad'
    }, function(notes){
        $('#notes').html(notes);
    })

    $('#contNote').modal('show');
}

function addNewNote(id) {
    $.post('', {
        id: id,
        acao_contratos: 'showNoteModal'
    }, function(form){
        $('#addNewNote').html(form);
    })

    $('#newNote').modal('show');
}

function saveNewNote(){
    let id = $("[name='contrato_id']").val();
    let title = $("[name='noteTitle']").val();
    let text = $("[name='noteText']").val();

    $.post('', {
        id: id,
        title: title,
        text: text,
        acao_contratos: 'save_note'
    }, function(notes){
        $('#notes').html(notes);
    })
}

function deleteNote(id) {
    let contrato_id = $("[name='contrato_id']").val();
    let c = confirm("Deseja excluir esta Anotação?")
    if (c == true) {
        $.post('', {
            acao_contratos: 'deleteNote',
            contrato_id: contrato_id,
            id: id
        }, function(notes) {
            $('#notes').html(notes);
        });
    }
}

function showAditivos() {
    if(document.getElementById('inicio').style.display == 'none'){
        document.getElementById('inicio').style = "display: block"
        document.getElementById('fim').style = "display: block"
        document.getElementById('value').style = "display: block"
    } else {
        document.getElementById('inicio').style = "display: none"
        document.getElementById('fim').style = "display: none"
        document.getElementById('value').style = "display: none"
    }
}

function xlsContratos(){
    alert('teste');
}

function filtrarNewContractsUpd() {
    let company = document.getElementsByClassName('companyItem selected')
    let sturcod = document.getElementById('sturCodInput').value
    let status = document.getElementsByClassName('statusItem selected')
    let inadimplente = document.getElementsByClassName('inadItem selected')
    let client = document.getElementsByClassName('clientItem selected')
    let data_de = document.getElementById('data_de').value
    let data_ate = document.getElementById('data_ate').value

    console.log(client);

    let resultCompany = '';
    let resultStatus = '';
    let resultInadimplente = '';
    let resultClient = '';
    
    Array.from(company).forEach(function(valor, chave) {
        resultCompany += valor.innerText+'-z/'
    })
    Array.from(status).forEach(function(valor, chave){
        resultStatus += valor.innerText+','
    })
    Array.from(inadimplente).forEach(function(valor, chave) {
        resultInadimplente += valor.innerText+','
    })
    Array.from(client).forEach(function(valor, chave) {
        resultClient += valor.innerText+','
    })

    let companyResult = resultCompany.slice(0, -3)
    let statusResult = resultStatus.slice(0, -1)
    let inadimplenteResult = resultInadimplente.slice(0, -1)
    let clientResult = resultClient.slice(0, -1)
    
    var formData = new FormData();

    formData.append('empresa', companyResult);
    formData.append('status', statusResult)
    formData.append('cod_stur', sturcod)
    formData.append('inadimplencia', inadimplenteResult)
    formData.append('nome_cliente', clientResult)
    formData.append('data_de', data_de)
    formData.append('data_ate', data_ate)
    formData.append('acao_contratos', 'filtrar')

    const xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                document.getElementById('table_contratos').innerHTML = xhr.responseText
            } else {
                alert('Erro')
            }
        }
    }
    xhr.send(formData)

    closeAllContractFilters()
}

function searchClientName() {

    let client = document.getElementById('searchClient').value;

    var formData = new FormData();

    formData.append('client', client);
    formData.append('acao_contratos', 'searchClient')

    const xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                document.getElementById('showClientArea').innerHTML = xhr.responseText
            } else {
                alert('Erro')
            }
        }
    }
    xhr.send(formData)
}




