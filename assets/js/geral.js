function rel_cliente() {
    let empresa = $('#empresa').val();
    $('#BSOD').css('display', 'block');
    $.post('', {
        acao_relatorio: 'empresa',
        empresa: empresa
    }, function(dados) {
        $('#rel_clientes').html(dados);
        $('#BSOD').css('display', 'none');
    })
}

function gerar_relatorio() {
    let empresa = $('#empresa').val();
    let codtipo = $("[name='codtipo']").val();
    let situacao = $("[name='situacao']").val();
    $('#BSOD').css('display', 'block');
    $.post('', {
        acao_relatorio: 'info_clientes',
        empresa: empresa,
        codtipo: codtipo,
        situacao: situacao,
    }, function(tabela) {
        $('#table_dados').html(tabela);
        $('#BSOD').css('display', 'none');
    })
}
