function module_change() {
    // $('.topo').removeClass('topo').addClass('light_test');
    if($('#contratos').hasClass('hidden')){
        $('#contratos').toggle('slow', function(){
            $('#contratos').removeClass('hidden');
        })
        $('#documentos').toggle('slow', function(){
            $('#documentos').addClass('hidden');
        })
    } else {
        $('#contratos').toggle('slow', function(){
            $('#documentos').removeClass('hidden');
        })
        $('#documentos').toggle('slow', function(){
            $('#contratos').addClass('hidden');
        })
        
    }
}