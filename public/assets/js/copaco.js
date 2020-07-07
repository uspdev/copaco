$(document).ready(function() {
  $("#rede_id").hide();
});

$("input[name='rede']").change(function(){
  if (this.checked)
      $("#rede_id").show();
    else
      $("#rede_id").hide();
});

$("input[name='naopatrimoniado']").change(function(){
  if($(this).val() == 1){
    checked_sim('naopatrimoniado');
  }
  else {
    checked_nao('naopatrimoniado');
  }
});

function checked_nao(name){
  if (name == 'naopatrimoniado') {
    $('#sempatrimonio').attr('hidden',false).find('input').attr('required',true);
    $('#compatrimonio').attr('hidden',true).find('input').attr('required',false).val('');
  }
  else {
    $('#equipamento_ip').attr('hidden',true).find('input').attr('required',false);
  }
}

function checked_sim(name){
  if (name == 'naopatrimoniado') {
    $('#compatrimonio').attr('hidden',false).find('input').attr('required',true);
    $('#sempatrimonio').attr('hidden',true).find('input').attr('required',false).val('');
  }
  else {
    $('#equipamento_ip').attr('hidden',false).find('input').attr('required',true);
  }
}

$('#datepicker').datepicker({
    format: 'dd/mm/yyyy',
    language: 'pt-BR',
    startDate: 'today',
    autoclose: true,
    todayHighlight: true
});

    
    var macAddress = document.getElementById("macaddress");

    function formatMAC(e) {
        var r = /([a-f0-9]{2})([a-f0-9]{2})/i,
            str = e.target.value.replace(/[^a-f0-9]/ig, "");
            str = str.toUpperCase();

        while (r.test(str)) {
            str = str.replace(r, '$1' + ':' + '$2');
        }

        e.target.value = str.slice(0, 17);
    };

    macAddress.addEventListener("keyup", formatMAC, false);
    
$("input[name='fixarip']").change(function(){
  if($(this).val() == 1){
    checked_sim('fixarip');
  }
  else {
    checked_nao('fixarip');
  }
});
