$('#naopatrimoniado').change(function(){
    if($(this).is(':checked')){
        $('#sempatrimonio').attr('hidden',false);
        $('#sempatrimonio input').attr('required',true);
        $('#compatrimonio').hide();
        $('#compatrimonio input').attr('required',false);
    }
    else {
        $('#compatrimonio').show();
        $('#compatrimonio input').attr('required',true);
        $('#sempatrimonio').attr('hidden',true);
        $('#sempatrimonio input').attr('required',false);
    }
});

if($('#naopatrimoniado').is(':checked')){
    $('#sempatrimonio').attr('hidden',false);
    $('#sempatrimonio input').attr('required',true);
    $('#compatrimonio').hide();
    $('#compatrimonio input').attr('required',false);
}
else {
    $('#compatrimonio').show();
    $('#compatrimonio input').attr('required',true);
    $('#sempatrimonio').attr('hidden',true);
    $('#sempatrimonio input').attr('required',false);
};
