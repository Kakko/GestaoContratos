// Licitações
function showSelectCompanies() {
    if(document.getElementById('multipleSelectCompanies').style.height == ""){
        document.getElementById('multipleSelectCompanies').style.height = "400px"
    } else {
        document.getElementById('multipleSelectCompanies').style.height = ""
    }

    if(document.getElementById('multipleSelectStatus').style.height = "400px"){
        document.getElementById('multipleSelectStatus').style.height = ""
    }

    if(document.getElementById('multipleSelectType').style.height = "400px"){
        document.getElementById('multipleSelectType').style.height = ""
    }

    if(document.getElementById('multipleSelectSystems').style.height = "400px"){
        document.getElementById('multipleSelectSystems').style.height = ""
    }

    if(document.getElementById('dateSearch').style.height = "150px"){
        document.getElementById('dateSearch').style.height = ""
    }
    if(document.getElementById('valueSearch').style.height = "150"){
        document.getElementById('valueSearch').style.height = ""
    }
}

function showSelectStatus() {
    if(document.getElementById('multipleSelectStatus').style.height == ""){
        document.getElementById('multipleSelectStatus').style.height = "400px"
    } else {
        document.getElementById('multipleSelectStatus').style.height = ""
    }

    if(document.getElementById('multipleSelectCompanies').style.height = "400px"){
        document.getElementById('multipleSelectCompanies').style.height = ""
    }

    if(document.getElementById('multipleSelectType').style.height = "400px"){
        document.getElementById('multipleSelectType').style.height = ""
    }

    if(document.getElementById('multipleSelectSystems').style.height = "400px"){
        document.getElementById('multipleSelectSystems').style.height = ""
    }

    if(document.getElementById('dateSearch').style.height = "150px"){
        document.getElementById('dateSearch').style.height = ""
    }
    if(document.getElementById('valueSearch').style.height = "150"){
        document.getElementById('valueSearch').style.height = ""
    }
}

function showSelectType() {
    if(document.getElementById('multipleSelectType').style.height == ""){
        document.getElementById('multipleSelectType').style.height = "250px"
    } else {
        document.getElementById('multipleSelectType').style.height = ""
    }

    if(document.getElementById('multipleSelectCompanies').style.height = "400px"){
        document.getElementById('multipleSelectCompanies').style.height = ""
    }

    if(document.getElementById('multipleSelectStatus').style.height = "400px"){
        document.getElementById('multipleSelectStatus').style.height = ""
    }

    if(document.getElementById('multipleSelectSystems').style.height = "400px"){
        document.getElementById('multipleSelectSystems').style.height = ""
    }

    if(document.getElementById('dateSearch').style.height = "150px"){
        document.getElementById('dateSearch').style.height = ""
    }
    if(document.getElementById('valueSearch').style.height = "150"){
        document.getElementById('valueSearch').style.height = ""
    }
}

function showSelectSystems() {
    if(document.getElementById('multipleSelectSystems').style.height == ""){
        document.getElementById('multipleSelectSystems').style.height = "400px"
    } else {
        document.getElementById('multipleSelectSystems').style.height = ""
    }

    if(document.getElementById('multipleSelectCompanies').style.height = "400px"){
        document.getElementById('multipleSelectCompanies').style.height = ""
    }

    if(document.getElementById('multipleSelectStatus').style.height = "400px"){
        document.getElementById('multipleSelectStatus').style.height = ""
    }

    if(document.getElementById('multipleSelectType').style.height = "400px"){
        document.getElementById('multipleSelectType').style.height = ""
    }

    if(document.getElementById('dateSearch').style.height = "150px"){
        document.getElementById('dateSearch').style.height = ""
    }
    if(document.getElementById('valueSearch').style.height = "150"){
        document.getElementById('valueSearch').style.height = ""
    }
    
}

function showSearchData() {
    if(document.getElementById('dateSearch').style.height == ""){
        document.getElementById('dateSearch').style.height = "150px"
    } else {
        document.getElementById('dateSearch').style.height = ""
    }

    if(document.getElementById('multipleSelectCompanies').style.height = "400px"){
        document.getElementById('multipleSelectCompanies').style.height = ""
    }

    if(document.getElementById('multipleSelectStatus').style.height = "400px"){
        document.getElementById('multipleSelectStatus').style.height = ""
    }

    if(document.getElementById('multipleSelectType').style.height = "400px"){
        document.getElementById('multipleSelectType').style.height = ""
    }
    if(document.getElementById('multipleSelectSystems').style.height = "400px"){
        document.getElementById('multipleSelectSystems').style.height = ""
    }
    if(document.getElementById('valueSearch').style.height = "150"){
        document.getElementById('valueSearch').style.height = ""
    }
}

function showSearchValue() {
    if(document.getElementById('valueSearch').style.height == ""){
        document.getElementById('valueSearch').style.height = "150px"
    } else {
        document.getElementById('valueSearch').style.height = ""
    }

    if(document.getElementById('multipleSelectCompanies').style.height = "400px"){
        document.getElementById('multipleSelectCompanies').style.height = ""
    }

    if(document.getElementById('multipleSelectStatus').style.height = "400px"){
        document.getElementById('multipleSelectStatus').style.height = ""
    }

    if(document.getElementById('multipleSelectType').style.height = "400px"){
        document.getElementById('multipleSelectType').style.height = ""
    }
    if(document.getElementById('multipleSelectSystems').style.height = "400px"){
        document.getElementById('multipleSelectSystems').style.height = ""
    }
    if(document.getElementById('dateSearch').style.height = "150"){
        document.getElementById('dateSearch').style.height = ""
    }
}

//Contratos
function showSelectCompaniesContract() {
    
    document.getElementById('multipleSelectCompanies').style.height = "400px"

    function hasParentByNodeName(elem, nodeId) {
        
        const parent = elem.parentElement;
        if(parent === undefined || parent === null) return false;
        if(parent.id === nodeId) return true;
        else return hasParentByNodeName(parent, nodeId)
        
    }

    document.getElementById('companyButton').addEventListener('focusout', function blurHandler(e) {

        if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'divParent')) document.getElementById('multipleSelectCompanies').setAttribute('style', 'height: ');   

    })

    // function inputBlurHandler(e) {
    //     if(e.nativeEvent.relatedTarget === null || !hasParentByNodeName(e.nativeEvent.relatedTarget, 'UL')) setIsFocused(false);
    // }
}

function showSturCodSearch() {

    document.getElementById('sturSearch').style.height = "50px"

    function hasParentByNodeName(elem, nodeId) {
        const parent = elem.parentElement;
        
        if(parent === undefined || parent === null) return false;
        if(parent.id === nodeId) return true;
        else return hasParentByNodeName(parent, nodeId)
    }

    document.getElementById('sturButton').addEventListener('focusout', function blurHandler(e) {
        
        if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'sturSearch')) document.getElementById('sturSearch').setAttribute('style', 'height: ');
        
    })
}

function showStatus() {
    
    document.getElementById('statusSearch').style.height = "100px"
    
    function hasParentByNodeName(elem, nodeId) {
        const parent = elem.parentElement;
        
        if(parent === undefined || parent === null) return false;
        if(parent.id === nodeId) return true;
        else return hasParentByNodeName(parent, nodeId)
    }

    document.getElementById('statusButton').addEventListener('focusout', function blurHandler(e) {
        
        if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'statusArea')) document.getElementById('statusSearch').setAttribute('style', 'height: ');
        
    })
    
}

function showInadimplente() {
    
    document.getElementById('selectInadimplente').style.height = "70px"

    function hasParentByNodeName(elem, nodeId) {
        const parent = elem.parentElement;

        if(parent === undefined || parent === null) return false;
        if(parent.id === nodeId) return true;
        else return hasParentByNodeName(parent, nodeId)
    }

    document.getElementById('inadButton').addEventListener('focusout', function blurHandler(e) {

        if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'inadArea')) document.getElementById('selectInadimplente').setAttribute('style', 'height: ');
        
    })
}

function showClientName() {
    
    document.getElementById('selectClientName').style.height = "400px"

    function hasParentByNodeName(elem, nodeId) {
        const parent = elem.parentElement;

        if(parent === undefined || parent === null) return false;
        if(parent.id === nodeId) return true;
        else return hasParentByNodeName(parent, nodeId)
    }

    document.getElementById('clientButton').addEventListener('focusout', function blurHandler(e) {

        
        if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'clientArea')) document.getElementById('selectClientName').setAttribute('style', 'height: ');
        
    })
}

function contractDateSearch() {
    
    document.getElementById('contractDateSearch').style.height = "180px"

    function hasParentByNodeName(elem, nodeId) {
        const parent = elem.parentElement;

        if(parent === undefined || parent === null) return false;
        if(parent.id === nodeId) return true;
        else return hasParentByNodeName(parent, nodeId)
    }

    document.getElementById('contractSearchButton').addEventListener('focusout', function blurHandler(e) {
        
        if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'dateArea')) document.getElementById('contractDateSearch').setAttribute('style', 'height: ');
        
    })
}

function showSelectCompaniesContractExpired() {

    document.getElementById('multipleSelectCompaniesExpired').style.height = "400px"

    function hasParentByNodeName(elem, nodeId) {
        const parent = elem.parentElement;

        if(parent === undefined || parent === null) return false;
        if(parent.id === nodeId) return true;
        else return hasParentByNodeName(parent, nodeId)
    }

    document.getElementById('expiredOnesButton').addEventListener('focusout', function blurHandler(e) {
        
        if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'contractExpiredArea')) document.getElementById('multipleSelectCompaniesExpired').setAttribute('style', 'height: ');
        
    })
}

function closeAllContractFilters() {

    document.getElementById('multipleSelectCompanies').style.height = ""
    document.getElementById('sturSearch').style.height = ""
    document.getElementById('statusSearch').style.height = ""
    document.getElementById('selectInadimplente').style.height = ""
    document.getElementById('selectClientName').style.height = ""
    document.getElementById('contractDateSearch').style.height = ""
    document.getElementById('multipleSelectCompaniesExpired').style.height == ""
}
function closeAllLicitacaoFilters() {

    document.getElementById('multipleSelectCompanies').style.height = ""
    document.getElementById('multipleSelectStatus').style.height = ""
    document.getElementById('multipleSelectType').style.height = ""
    document.getElementById('multipleSelectSystems').style.height = ""
    document.getElementById('dateSearch').style.height = ""
    document.getElementById('valueSearch').style.height = ""
}

//Licitações
function selectItem(id) {
    if(document.getElementById('companyItem'+id).classList.contains('selected')){
        document.getElementById('companyItem'+id).classList.remove("selected");
        document.getElementById('companyValue'+id).classList.remove("selectedValue");
    } else {
        document.getElementById('companyItem'+id).classList.add("selected");
        document.getElementById('companyValue'+id).classList.add("selectedValue");
    }
}

function selectStatus(ele) {
    if(ele.classList.contains('selected')){
        ele.classList.remove("selected");
    } else {
        ele.classList.add("selected");
    }
}

function selectType(ele) {
    if(ele.classList.contains('selected')){
        ele.classList.remove("selected");
    } else {
        ele.classList.add("selected");
    }
}

function selectSystem(id) {
    if(document.getElementById('systemItem'+id).classList.contains('selected')){
        document.getElementById('systemItem'+id).classList.remove("selected");
        
    } else {
        document.getElementById('systemItem'+id).classList.add("selected");
        
    }
}

//Contratos
function selectContractItem(id) {
    if(document.getElementById('companyItem'+id).classList.contains('selected')){
        
        document.getElementById('companyItem'+id).classList.remove("selected");
        document.getElementById('companyValue'+id).classList.remove("selectedValue");

        document.getElementById('companyItem'+id).addEventListener('focusout', function blurHandler(e) {
        
            if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'divParent')) document.getElementById('multipleSelectCompanies').setAttribute('style', 'height: ');   
            
        })

    } else {
        document.getElementById('companyItem'+id).classList.add("selected");
        document.getElementById('companyValue'+id).classList.add("selectedValue");

        document.getElementById('companyItem'+id).addEventListener('focusout', function blurHandler(e) {
            
            if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'divParent')) document.getElementById('multipleSelectCompanies').setAttribute('style', 'height: ');   
            
        })
    }

    function hasParentByNodeName(elem, nodeId) {
        
        const parent = elem.parentElement;
      
        if(parent === undefined || parent === null) return false;
        if(parent.id === nodeId) return true;
        else return hasParentByNodeName(parent, nodeId)
        
    }
}

function inputSturCod() {
    function hasParentByNodeName(elem, nodeId) {
        const parent = elem.parentElement;
        
        if(parent === undefined || parent === null) return false;
        if(parent.id === nodeId) return true;
        else return hasParentByNodeName(parent, nodeId)
    }

    document.getElementById('sturCodInput').addEventListener('focusout', function blurHandler(e) {
        
        if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'sturSearch')) document.getElementById('sturSearch').setAttribute('style', 'height: ');
        
    })
}

function selectContractItemExpired(id) {
    if(document.getElementById('companyItemExpired'+id).classList.contains('selected')){
        document.getElementById('companyItemExpired'+id).classList.remove("selected")
        document.getElementById('companyExpiredValue'+id).classList.remove("selectedExpiredValue")

        document.getElementById('companyItemExpired'+id).addEventListener('focusout', function blurHandler(e) {
        
            if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'contractExpiredArea')) document.getElementById('multipleSelectCompaniesExpired').setAttribute('style', 'height: ');
            
        })
    } else {
        document.getElementById('companyItemExpired'+id).classList.add("selected");
        document.getElementById('companyExpiredValue'+id).classList.add("selectedExpiredValue")

        document.getElementById('companyItemExpired'+id).addEventListener('focusout', function blurHandler(e) {
        
            if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'contractExpiredArea')) document.getElementById('multipleSelectCompaniesExpired').setAttribute('style', 'height: ');
            
        })
    }

    function hasParentByNodeName(elem, nodeId) {
        const parent = elem.parentElement;

        if(parent === undefined || parent === null) return false;
        if(parent.id === nodeId) return true;
        else return hasParentByNodeName(parent, nodeId)
    }
}

function selectContractStatus(ele){
    if(ele.classList.contains('selected')){
        ele.classList.remove("selected");

        document.getElementById('statusSearch').addEventListener('focusout', function blurHandler(e) {
        
            if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'statusArea')) document.getElementById('statusSearch').setAttribute('style', 'height: ');
            
        })

    } else {
        ele.classList.add("selected");

        document.getElementById('statusSearch').addEventListener('focusout', function blurHandler(e) {
        
            if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'statusArea')) document.getElementById('statusSearch').setAttribute('style', 'height: ');
            
        })
    }

    function hasParentByNodeName(elem, nodeId) {
        const parent = elem.parentElement;
        
        if(parent === undefined || parent === null) return false;
        if(parent.id === nodeId) return true;
        else return hasParentByNodeName(parent, nodeId)
    }
}
function selectContractInad(ele){
    if(ele.classList.contains('selected')){
        ele.classList.remove("selected");

        document.getElementById('selectInadimplente').addEventListener('focusout', function blurHandler(e) {

            if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'inadArea')) document.getElementById('selectInadimplente').setAttribute('style', 'height: ');
            
        })
    } else {
        ele.classList.add("selected");

        document.getElementById('selectInadimplente').addEventListener('focusout', function blurHandler(e) {

            if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'inadArea')) document.getElementById('selectInadimplente').setAttribute('style', 'height: ');
            
        })
    }

    function hasParentByNodeName(elem, nodeId) {
        const parent = elem.parentElement;

        if(parent === undefined || parent === null) return false;
        if(parent.id === nodeId) return true;
        else return hasParentByNodeName(parent, nodeId)
    }
}

function selectClientName(ele){
    if(ele.classList.contains('selected')){
        ele.classList.remove("selected");
        

        document.getElementById('selectClientName').addEventListener('focusout', function blurHandler(e) {

        
            if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'clientArea')) document.getElementById('selectClientName').setAttribute('style', 'height: ');
            
        })
    } else {
        ele.classList.add("selected");

        document.getElementById('selectClientName').addEventListener('focusout', function blurHandler(e) {

        
            if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'clientArea')) document.getElementById('selectClientName').setAttribute('style', 'height: ');
            
        })
    }

    function hasParentByNodeName(elem, nodeId) {
        const parent = elem.parentElement;

        if(parent === undefined || parent === null) return false;
        if(parent.id === nodeId) return true;
        else return hasParentByNodeName(parent, nodeId)
    }
}

function dateDe() {
    function hasParentByNodeName(elem, nodeId) {
        const parent = elem.parentElement;

        if(parent === undefined || parent === null) return false;
        if(parent.id === nodeId) return true;
        else return hasParentByNodeName(parent, nodeId)
    }

    document.getElementById('data_de').addEventListener('focusout', function blurHandler(e) {
        
        if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'contractDateSearch')) document.getElementById('contractDateSearch').setAttribute('style', 'height: ');
        
    })
}

function dateAte() {
    function hasParentByNodeName(elem, nodeId) {
        const parent = elem.parentElement;

        if(parent === undefined || parent === null) return false;
        if(parent.id === nodeId) return true;
        else return hasParentByNodeName(parent, nodeId)
    }

    document.getElementById('data_ate').addEventListener('focusout', function blurHandler(e) {
        
        if(e.relatedTarget === null || !hasParentByNodeName(e.relatedTarget, 'contractDateSearch')) document.getElementById('contractDateSearch').setAttribute('style', 'height: ');
        
    })
}

//Licitação
function filtrarNew() {

    // let company = document.getElementsByClassName('companyItem selected')
    // if(company.length == 0){
    //     company = document.getElementsByClassName('companyItem')
    // }
    
    let company = document.getElementsByClassName('getValue selectedValue')
    if(company.length == 0){
        company = document.getElementsByClassName('getValue')
    }

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
        resultCompany += valor.value+'|'
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

    let companyResult = resultCompany.slice(0, -1)
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

//Contratos

function filtrarNewContracts() {
    
    // let company = document.getElementsByClassName('companyItem selected')
    // if(company.length == 0){
    //     company = document.getElementsByClassName('companyItem')
    // }
    let company = document.getElementsByClassName('getValue selectedValue')
    if(company.length == 0){
        company = document.getElementsByClassName('getValue')
    }
    
    let sturcod = document.getElementById('sturCodInput').value
    let status = document.getElementsByClassName('statusItem selected')
    let inadimplente = document.getElementsByClassName('inadItem selected')
    let client = document.getElementsByClassName('clientItem selected')
    let data_de = document.getElementById('data_de').value
    let data_ate = document.getElementById('data_ate').value
    let expired = document.getElementsByClassName('getExpiredValue selectedExpiredValue')

    let resultCompany = '';
    let resultStatus = '';
    let resultInadimplente = '';
    let resultClient = '';
    let resultExpired = '';
    
    Array.from(company).forEach(function(valor, chave) {
        resultCompany += valor.value+'|'
    })
    Array.from(status).forEach(function(valor, chave){
        resultStatus += valor.innerText+','
    })
    Array.from(inadimplente).forEach(function(valor, chave) {
        resultInadimplente += valor.innerText+','
    })
    Array.from(client).forEach(function(valor, chave) {
        resultClient += valor.innerText+'|'
    })
    
    Array.from(expired).forEach(function(valor, chave) {
        resultExpired += valor.value+'|';
    })

    let companyResult = resultCompany.slice(0, -1)
    let statusResult = resultStatus.slice(0, -1)
    let inadimplenteResult = resultInadimplente.slice(0, -1)
    let clientResult = resultClient.slice(0, -1)
    let expiredResult = resultExpired.slice(0, -1)
    
    var formData = new FormData();

    formData.append('empresa', companyResult);
    formData.append('status', statusResult)
    formData.append('cod_stur', sturcod)
    formData.append('inadimplencia', inadimplenteResult)
    formData.append('nome_cliente', clientResult)
    formData.append('data_de', data_de)
    formData.append('data_ate', data_ate)
    formData.append('expired', expiredResult)
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

