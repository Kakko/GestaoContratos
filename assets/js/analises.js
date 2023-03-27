function showContrato() {
    if($('#contratosData').hasClass('hidden')){
        $('#aditivosData').fadeOut('fast');
        $('#aditivosData').addClass('hidden');
        $('#contratosData').fadeIn('slow');
        $('#contratosData').removeClass('hidden');
        $('#inicioAditivo').val('');
        $('#aditivosData').css('position', 'relative');
        $('#fimAditivo').val('');
    }
}
function showAditivo() {    
    if($('#aditivosData').hasClass('hidden')){
        $('#contratosData').css('fast');
        $('#contratosData').fadeOut('fast');
        $('#contratosData').addClass('hidden');
        $('#aditivosData').fadeIn('slow');
        $('#aditivosData').removeClass('hidden');
        $('#inicioContrato').val('');
        $('#fimContrato').val('');
    }
}

function filtrar_empresas(){
    let empresa = $('#empresa_analise').val();
    let inicioContratode = $('#inicioContratode').val();
    let inicioContratoate = $('#inicioContratoate').val();
    let fimContratode = $('#fimContratode').val();
    let fimContratoate = $('#fimContratoate').val();
    let inicioAditivode = $('#inicioAditivode').val();
    let inicioAditivoate = $('#inicioAditivoate').val();
    let fimAditivode = $('#fimAditivode').val();
    let fimAditivoate = $('#fimAditivoate').val();

    $('#BSOD').css('display', 'block');
    $.post('', {
        acao_analise: 'filtrar',
        empresa: empresa,
        inicioContratode: inicioContratode,
        inicioContratoate: inicioContratoate,
        fimContratode: fimContratode,
        fimContratoate: fimContratoate,
        inicioAditivode: inicioAditivode,
        inicioAditivoate: inicioAditivoate,
        fimAditivode: fimAditivode,
        fimAditivoate: fimAditivoate

    }, function(data){
        tabela = data;
        $('#dados').html(tabela);
        $('#BSOD').css('display', 'none');
    })
}

function gerar_xls(){
    let table = tabela;
   $.post('analise/analise_xls', {
        acao_analise: 'criar',
        table: table,
   }, function(data){
       let dado = data;
        window.open('analise/analise_xls', '_blank');
   });
}
