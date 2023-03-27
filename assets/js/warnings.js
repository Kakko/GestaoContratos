function showCont(id) {
    $.post('', {
        acao_warning: 'exibirCont',
        id: id
    }, function(data){
        $('#modal_contratos').html(data)
    })
    $('#warning_modal_contratos').modal('show');
}

function showLic(id) {
    $.post('', {
        acao_warning: 'exibirLic',
        id: id
    }, function(data){
        $('#modal_licitacao').html(data)
    })
    $('#warning_modal_licitacao').modal('show');
}

function showDocs(id) {
    $.post('', {
        acao_warning: 'exibirDoc',
        id: id
    }, function(data){
        $('#modal_documentos').html(data)
    })
    $('#warning_modal_documentos').modal('show');
}

function closePop(id){
    
    var formData = new FormData();

    formData.append('id', id);
    formData.append('acao_warning', 'upd_warnings');

    const xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                document.getElementById('popup_area').innerHTML = xhr.responseText
                // console.log(xhr.responseText)
            } else {
                alert('Erro')
            }
        }
    }
    xhr.send(formData)
}