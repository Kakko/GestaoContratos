const original_doc = $('#modal_documents').html();


//Cadastro Documentação
function cadDoc() {
    $('#modal_documents').html(original_doc);
    $('.valor').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
    $('#modal_documents').modal('show');
}


//ADD NEW CATEGORY
function addCategory() {
    $('#modal_addCategory').modal('show');
}

function cadCategory() {
    let name = $("[name='name']").val();

    $.post('', {
        doc_action: 'addCategory',
        name: name
    }, function(data){
        $('#cadCategories').html(data);
    })
}

//EDIT CATEGORY
function editCategory() {
    $('#modal_editCategory').modal('show');
}

function updCategory(){
    let name = $("[name='edit_name']").val();

    $.post('', {
        doc_action: 'addCategory',
        name: name
    }, function(data){
        $('#editCategories').html(data);
    })
}


//ADD NEW DOCUMENT TYPE
function addDocType() {
    $('#modal_addDocType').modal('show');
}

function cadDocType() {
    let name = $("[name='doctype']").val();

    $.post('', {
        doc_action: 'addDocType',
        name: name
    }, function(data){
        $('#cadDocType').html(data);
    })
}

//EDIT DOCUMENT TYPE
function editDocType() {
    $('#modal_editDocType').modal('show');
}

function updDocType() {
    let name = $("[name='edit_doctype']").val();

    $.post('', {
        doc_action: 'addDocType',
        name: name
    }, function(data){
        $('#editDocType').html(data);
    })
}

//CHANGE THE VALIDATE FIELD
function field_change(){
    if($('#expiration_days').hasClass('hidden')){
        $('#expiration_date').toggle('fast', function(){
            $('#expiration_date').addClass('hidden');
        })
        $('#expiration_days').toggle('fast', function(){
            $('#expiration_days').removeClass('hidden');
        })
    } else {
        $('#expiration_date').toggle('fast', function(){
            $('#expiration_days').addClass('hidden');
        })
        $('#expiration_days').toggle('fast', function(){
            $('#expiration_date').removeClass('hidden');
        })
    }
}

//SHOW SELECTED CITIES
function showCities(){
    let state = $("[name='state']").val();

    $.post('', {
        doc_action: 'show_cities',
        state: state
    }, function(data){
        $('#docCity').html(data);
    })
}

//VISUALIZE DOCUMENTS
function seeDoc(id){
    $('#modal_seeDoc').modal('show');
    $.post('', {
        doc_action: 'seeDoc',
        id: id
    }, function(data){
        $('#seeDoc').html(data);
    })
}

//DELETE UPLOADED FILE
function deleteFile(id, element){
    let c = confirm("Deseja Excluir?")
    if (c == true){
        $.post('', {
            doc_action: 'delete_file',
            id: id
        }, function(data){
            $(element).parent().parent().remove()
        })
    }
}

//EDIT DOCUMENT
function editDoc(id){
    $('#modal_editDoc').modal('show');
    $('.valor').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
    $.post('', {
        doc_action: 'edit_doc',
        id: id
    }, function(data){
        $('#editDoc').html(data);
    })
}

//DELETE DOCUMENT
function delDoc(id) {
    let c = confirm('Deseja excluir esse documento e todos seus arquivos vinculados à ele?')
    if (c == true) {
        $.post('', {
            doc_action: 'delete_doc',
            id: id
        }, function(data){
            window.location.reload();
        })
    }
}

// ADD COPY
function addCopy(id){

    $.post('', {
        doc_action: 'addCopy',
        id: id
    }, function(data){
        $('#n_copy-'+id).html(data);
    })
}

// REMOVE COPY
function removeCopy(id){
    $.post('', {
        doc_action: 'removeCopy',
        id: id
    }, function(data){
        $('#n_copy-'+id).html(data);
    })
}

function showSelectCompaniesDoc() {
    if(document.getElementById('multipleSelectCompanies').style.height == ""){
        document.getElementById('multipleSelectCompanies').style.height = "400px"
    } else {
        document.getElementById('multipleSelectCompanies').style.height = ""
    }
}

function selectDocItem(id) {
    if(document.getElementById('companyDocItem'+id).classList.contains('selected')){
        document.getElementById('companyDocItem'+id).classList.remove("selected");
        document.getElementById('companyDocValue'+id).classList.remove("selectedValue");
    } else {
        document.getElementById('companyDocItem'+id).classList.add("selected");
        document.getElementById('companyDocValue'+id).classList.add("selectedValue");
    }
}

//SEARCH ENGINE
function searchDoc(){

    let company = document.getElementsByClassName('getDocValue selectedValue')
    if(company.length == 0){
        company = document.getElementsByClassName('getDocValue')
    }

    let resultCompany = '';

    Array.from(company).forEach(function(valor, chave) {
        resultCompany += valor.value+'|'
    })

    let companyResult = resultCompany.slice(0, -1)
    var formData = new FormData()

    formData.append('company', companyResult);
    formData.append('doc_action', 'filter')

    const xhr = new XMLHttpRequest();
    xhr.open('POST', window.location.href, true);
    xhr.onreadystatechange = () => {
        if(xhr.readyState == 4){
            if(xhr.status == 200){
                document.getElementById('docs').innerHTML = xhr.responseText
            } else {
                alert('erro')
            }
        }
    }
    xhr.send(formData)

}