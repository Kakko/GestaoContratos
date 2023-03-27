//Avisos Licitações
$(document).ready(function(){
    let aviso = 'avisar_licitacoes';
    $.post('home', {
        aviso: aviso
    }, function(data){
        
        $('.avisos_diarios').html(data);

        setInterval(show_adiados, 300000); //5min
        // setInterval(show_adiados, 2000); //5min
        setInterval(inicio_licitacao, 150000); // 2.30min;
        // setInterval(inicio_licitacao, 3000); // 2.30min;
    })

})

function ok_licitacao(id){
    $.post('home', {
        aviso: 'ok',
        id: id,
    }, function(data){
        $('.avisos_diarios').html(data);
    })
}

function adiar_licitacao(id){
    $.post('home', {
        aviso: 'adiado',
        id: id,
    }, function(data){
        $('.avisos_diarios').html(data);
    })
}

//Avisos Licitações Adiadas

function show_adiados(){
    let aviso = 'licitacoes_adiadas';
    $.post('home', {
        aviso: aviso
    }, function(data){
        $('.avisos_adiados').html(data);
    })
}

function fechar_adiados(id){
    $.post('home', {
        aviso: 'fechar_adiado',
        id: id
    }, function(data){
        $('.avisos_adiados').html(data);
    })
}

function acompanhar_adiados(id){
    let c = confirm('Deseja Acompanhar esta licitação? Você será avisado instantes antes do início da licitação');
    if(c == true){
        $.post('home', {
            aviso: 'acompanhar_adiado',
            id: id
        }, function(data){
            $('.avisos_adiados').html(data);
        })
    }
}

function inicio_licitacao(){
    $.post('home', {
        aviso: 'inicio_licitacao',
    }, function(data){
        $('.avisos_inicio').html(data);
    })
}