function filtrar_faturas(){
    let empresa = $('#empresa_faturas').val();
    $('#BSOD').css('display', 'block');
    $.post('rel_faturas', {
        acao_faturas: 'filtrar',
        empresa: empresa
    }, function(data){
        $('#cliente').html(data);
        $('#BSOD').css('display', 'none');
    })
}

function listar_dados(){
    let empresa = $('#empresa_faturas').val();
    let clientes = $('#clientes').val(); // Pegando o CODCLI
    let status = $('#status').val();

    $('#BSOD').css('display', 'block');
    
    
    $.post('rel_faturas', {
        acao_faturas: 'dados_clientes',
        empresa: empresa,
        clientes: clientes,
        status: status
    }, function(data){

        $('#info_clientes').html(data);
        $('#BSOD').css('display', 'none');
    })
}

function searchClient() {
    let company = document.getElementById('company_id').value
    let stur_cod = document.getElementById('stur_cod').value

    var formData = new FormData();

    formData.append('company', company);
    formData.append('stur_cod', stur_cod);
    formData.append('acao_faturas', 'searchCodClient')

    const xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                document.getElementById('clientes').innerHTML = xhr.responseText
                // console.log(xhr.responseText)
            } else {
                alert('Erro')
            }
        }
    }
    xhr.send(formData)

}

