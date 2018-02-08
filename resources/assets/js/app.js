$("input[name='naopatrimoniado']").change(function(){
  if($(this).val() == 1){
    checked_sim();
  }
  else {
    checked_nao();
  }
});

function checked_nao(){
  $('#sempatrimonio').attr('hidden',false).find('input').attr('required',true);
  $('#compatrimonio').attr('hidden',true).find('input').attr('required',false).val('');
}

function checked_sim(){
  $('#compatrimonio').attr('hidden',false).find('input').attr('required',true);
  $('#sempatrimonio').attr('hidden',true).find('input').attr('required',false).val('');
}
