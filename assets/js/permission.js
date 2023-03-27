$(function(){
    $('.tabitem').on('click', function(){ //Alternar entre classes
        $('.activetab').removeClass('activetab');
        $(this).addClass('activetab');

        var item = $('.activetab').index();
        $('.tabbody').hide();
        $('.tabbody').eq(item).show();
    })
});

// function setPermissionsInGroup() {
//     let permissionGroup = document.getElementById('permissionGroup').value
//     if(permissionGroup){
//         var formData = new FormData();


//         formData.append('permissionGroup', permissionGroup)
//         formData.append('acao_permission', 'showPermissionParams')

//         const xhr = new XMLHttpRequest();
//         xhr.open('POST', window.location.href, true);
//         xhr.onreadystatechange = () => {
//             if(xhr.readyState == 4){
//                 if(xhr.status == 200){
//                     document.getElementById('permissionParams').innerHTML = xhr.responseText
//                 } else {
//                     alert('Erro')
//                 }
//             }
//         }
//         xhr.send(formData)
//     }
// }

function fetchSystemPermissions() {
    let user = document.querySelector("[name='user_name']").value;
    
    var formData = new FormData();


    formData.append('user_id', user)
    formData.append('acao_permission', 'showUserSystemPermissions')

    const xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                document.getElementById('sys_permissions').innerHTML = xhr.responseText
            } else {
                alert('Erro')
            }
        }
    }
    xhr.send(formData)
}

function save_system_permissions() {
    let perms = document.getElementsByClassName('perm_selected')
    let id = document.querySelector("[name = 'user_name']").value;
    
    let resultGroup = '';

    Array.from(perms).forEach(function(valor, chave) {
        resultGroup += valor.getAttribute('permID')+','
    })
    
    let groupResult = resultGroup.slice(0, -1)
    
    var formData = new FormData();
    
    formData.append('params', groupResult);
    formData.append('id', id);
    formData.append('acao_permission', 'insert_system_params')

    const xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                alert(xhr.responseText)
                window.location.reload()
            } else {
                alert('erro')
            }
        }
    }
    xhr.send(formData)
}

function fetchCompanies() {
    let user = document.querySelector("[name='company_user_name']").value;
    
    var formData = new FormData();


    formData.append('user', user)
    formData.append('acao_permission', 'showUserCompanies')

    const xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                document.getElementById('userCompanies').innerHTML = xhr.responseText
            } else {
                alert('Erro')
            }
        }
    }
    xhr.send(formData)
    
}

function showCompanyPermission(ele){

    markItem(ele)
    let selectedGroup = '';
    let selected = document.querySelectorAll('.selected')

    // Array.from(selected).forEach(function(valor, chave) {
    //     selectedGroup += valor.getAttribute('permID')+','
    // })

    let id = document.querySelector('.selected').getAttribute('cid');
    let user_id = document.querySelector('.selected').getAttribute('uid');
    
    var formData = new FormData();
    
    formData.append('user_id', user_id)
    formData.append('id', id)
    formData.append('acao_permission', 'set_company_permissions')

    const xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                document.getElementById('permissionParams').innerHTML = xhr.responseText
            } else {
                alert('erro')
            }
        }
    }
    xhr.send(formData)


}

function markItem(ele){
    
    if(ele.classList.contains('selected')){
        ele.classList.remove('selected')
    } else {
        ele.classList.add('selected')
    }
}

function markPermItem(ele){
    
    if(ele.classList.contains('perm_selected')){
        ele.classList.remove('perm_selected')
    } else {
        ele.classList.add('perm_selected')
    }
}

function savePermGroup() {
    let perms = document.getElementsByClassName('selected')
    let id = document.getElementById('permissionGroup').value;
    
    let resultGroup = '';

    Array.from(perms).forEach(function(valor, chave) {
        resultGroup += valor.getAttribute('permID')+','
    })
    
    let groupResult = resultGroup.slice(0, -1)
    
    var formData = new FormData();
    
    formData.append('params', groupResult);
    formData.append('id', id);
    formData.append('acao_permission', 'insert_params')

    const xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                alert(xhr.responseText)
                window.location.reload()
            } else {
                alert('erro')
            }
        }
    }
    xhr.send(formData)
}

function saveCompanyPerm() {
    let resultGroup = '';
    let companyGroup = '';

    let company_id = document.querySelectorAll('.selected');
    let user_id = document.querySelector('.selected').getAttribute('uid');
    let perms = document.querySelectorAll('.perm_selected')

    Array.from(perms).forEach(function(valor, chave) {
        resultGroup += valor.getAttribute('permID')+','
    })    
    Array.from(company_id).forEach(function(valor, chave) {
        companyGroup += valor.getAttribute('cid')+','
    })

    let groupResult = resultGroup.slice(0, -1) //REMOVER A VÍRGULA DO ÚLTIMO PARÂMETRO
    let groupCompany = companyGroup.slice(0, -1) //REMOVER A VÍRGULA DO ÚLTIMO PARÂMETRO
    
    var formData = new FormData();
    
    formData.append('params', groupResult);
    formData.append('company_id', groupCompany);
    formData.append('user_id', user_id);
    formData.append('acao_permission', 'insert_company_params')

    const xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                alert(xhr.responseText)
                // window.location.reload()
            } else {
                alert('erro')
            }
        }
    }
    xhr.send(formData)
}