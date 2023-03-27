function edit_import(id){
    $('#modal_edit_import').modal('show');

    let company_id = document.getElementById('company_id_'+id).innerHTML

    var formData = new FormData();

    formData.append('company_id', company_id)
    formData.append('id', id)
    formData.append('acao_import', 'verify')

    const xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                document.getElementById('stur_client_edit').innerHTML = xhr.responseText
                // console.log(xhr.responseText)
            } else {
                alert('Erro')
            }
        }
    }
    xhr.send(formData)
}

function addSturClient() {
    document.getElementById('maskLoading').style = "display: flex"

    let cod_stur = document.getElementById('cod_stur').value;
    let name = document.getElementById('name').value;
    let razao_social = document.getElementById('razao_social').value;
    let cpf_cnpj = document.getElementById('cpf_cnpj').value;
    let endereco = document.getElementById('endereco').value;
    let bairro = document.getElementById('bairro').value;
    let cep = document.getElementById('cep').value;
    let phone = document.getElementById('phone').value;
    let email = document.getElementById('email').value;
    let cidade = document.getElementById('cidade').value;
    let estado = document.getElementById('estado').value;
    let empresa_id = document.getElementById('empresa_id').value;

    var formData = new FormData();

    formData.append('cod_stur', cod_stur)
    formData.append('name', name)
    formData.append('razao_social', razao_social)
    formData.append('cpf_cnpj', cpf_cnpj)
    formData.append('endereco', endereco)
    formData.append('bairro', bairro)
    formData.append('cep', cep)
    formData.append('phone', phone)
    formData.append('email', email)
    formData.append('cidade', cidade)
    formData.append('estado', estado)
    formData.append('empresa_id', empresa_id)
    formData.append('acao_import', 'insert')

    const xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                // console.log(xhr.responseText)
                alert(xhr.responseText);
            } else {
                alert('Erro')
                // document.getElementById('maskLoading').style = "display: none"
            }
        }
    }
    xhr.send(formData)
    setTimeout(function(){
        window.location.reload();
    }, 5000);
}

function remove_import(id) {

    let c = confirm('Deseja remover o cliente da importação?')

    if(c == true){
        document.getElementById('maskLoading').style = "display: flex"
        let company_id = document.getElementById('company_id_'+id).innerHTML

        var formData = new FormData();

        formData.append('company_id', company_id)
        formData.append('id', id)
        formData.append('acao_import', 'remove')

        const xhr = new XMLHttpRequest();
        xhr.open('POST', window.location.href, true);
        xhr.onreadystatechange = () => {
            if(xhr.readyState == 4){
                if(xhr.status == 200){
                    // alert('Cliente Removido com Sucesso')
                } else {
                    alert('Erro')
                }
            }
        }
        xhr.send(formData)
        
        setTimeout(function(){
            window.location.reload();
        }, 5000);
        // document.getElementById('maskLoading').style = "display: none"
            
    }
}
