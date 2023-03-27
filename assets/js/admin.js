function cad_user(){
    $('#form_usuarios')[0].reset();
    $("[name='acao_usuario']").val('cadastrar');
    $('#modal_usuarios').modal('show');
}

function ver_usuario(id){
    $.post('', {
        acao_usuario: 'ver',
        id: id
    }, function(data){
        let dados = JSON.parse(data);

        $("#name").html(dados.name);
        $("#email").html(dados.email);

        if(dados.telefone == ''){
            $("#telefone").html('Não Cadastrado');
        } else {
            $("#telefone").html(dados.telefone);   
        }
        $("#obs").html(dados.obs);

        $('#modal_usuario').modal('show');
    })
}

function edit_usuario(id){
    $.post('', {
        acao_usuario: 'ver',
        id: id
    }, function(data){
        let dados = JSON.parse(data);
        $("[name='id']").val(dados.id);
        $("[name='name']").val(dados.name);
        $("[name='email']").val(dados.email);
        $("[name='password']").val();
        $("[name='endereco']").val(dados.endereco);
        $("[name='telefone']").val(dados.telefone);
        $("[name='obs']").val(dados.obs);
        

        $("[name='acao_usuario']").val('edit');
        $('#modal_usuarios').modal('show');
    })
}

function inativar_usuario(id){
    let c = confirm("Deseja Alterar o Status do Usuário?")
    if(c == true){
        $.post('', {
            acao_usuario: 'inativar',
            id: id
        }, function(){
            window.location.reload();
        })
    }

}

function cad_novo_perm_grupo(){
    $("[name='acao_permission']").val('cadastrar_grupo');
    $('#cad_nova_perm_grupo').modal('show');
}

function cad_nova_perm(){
    $("[name='acao_permission']").val('cad_permissoes');
    $('#cad_nova_perm').modal('show');
}

function ger_permissoes(){
    $("[name='acao_permission']").val('gerenciar_grupos');
    $('#ger_permissoes').modal('show');
}

function ger_permissoes_sistema(){
    $("[name='acao_permission']").val('gerenciar_grupos_sistema');
    $('#cad_nova_perm').modal('show');
}

function edit_permission_group(){
    $("[name='acao_permission']").val('edit_perm_group');
    $('#edit_perm_group').modal('show');
}

function setCompanies(id){
    $("#userId").val(id)
    $('#inc_companies').modal('show');

    fetchRegisteredCompanies(id)
}

function edit_group(){
    let group_name = $('#group_name').val();

    $('#BSOD').css('display', 'block');

    $.post('', {
        acao_permission: 'edit_perm_group',
        group_name: group_name
    }, function(data){
        $('#permissions').html(data);

        $('#BSOD').css('display', 'none');
    })
}
function remover_permissao(id){
    let group_name = $('#group_name').val();
    let c = confirm("Deseja Remover essa Permissão?")
    if(c == true){
        $.post('', {
            acao_permission: 'remove_perm',
            id: id,
            group_name: group_name
        }, function(data){
            window.location.reload();
        })
    }
}

function edit_perm(id){
    $.post('', {
        acao_permission: 'ver',
        id: id
    }, function(data){
        let dados = JSON.parse(data)
        $("[name='group']").val(dados.group);
        $("[name='id']").val(dados.id);
    })

    // $("[name='acao_permission']").val('user_perm');
    $('#user_perm').modal('show');
}

function upd_group(){
    let group = $("[name='group']").val();
    let id = $("[name='id']").val();
    $.post('', {
        group: group,
        id: id,
        acao_permission: 'edit'
    }, function(data){
        window.location.reload();
    })
}

function selectCompany(id) {
    if(document.getElementById('companyItem'+id).classList.contains('selected')){
        document.getElementById('companyItem'+id).classList.remove("selected");
    } else {
        document.getElementById('companyItem'+id).classList.add("selected");
    }
}

function fetchRegisteredCompanies(id) {
    var formData = new FormData();
    formData.append('id', id)
    formData.append('acao_permission', 'fetch_registeredCompanies')

    const xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                document.getElementById('showCompanies').innerHTML = xhr.responseText;
            } else {
                alert('erro')
            }
        }
    }
    xhr.send(formData);
}

function insertCompanies() {
    let companies = document.getElementsByClassName('companyItem selected')
    let id = document.getElementById('userId').value
    let resultCompany = '';

    Array.from(companies).forEach(function(valor, chave) {
        resultCompany += valor.getAttribute('dataID')+','
    })

    let companyResult = resultCompany.slice(0, -1)

    var formData = new FormData();

    formData.append('companies', companyResult);
    formData.append('id', id)
    formData.append('acao_permission', 'setCompanies')

    const xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                document.getElementById('showCompanies').innerHTML = xhr.responseText;
            } else {
                alert('erro')
            }
        }
    }
    xhr.send(formData)
}

function removeCompanyPermission(id) {

    let userID = document.getElementById('userId').value

    var formData = new FormData()
    formData.append('id', id)
    formData.append('userID', userID)
    formData.append('acao_permission', 'removeCompanyPermission')

    const xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true)

    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4) {
            if(xhr.status == 200){
                document.getElementById('showCompanies').innerHTML = xhr.responseText;
            } else {
                alert('erro')
            }
        }
    }
    xhr.send(formData)
}


