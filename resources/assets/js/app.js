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

$('#datepicker').datepicker({
    format: 'dd/mm/yyyy',
    language: 'pt-BR'
});

    
    var macAddress = document.getElementById("macaddress");

    function formatMAC(e) {
        var r = /([a-f0-9]{2})([a-f0-9]{2})/i,
            str = e.target.value.replace(/[^a-f0-9]/ig, "");

        while (r.test(str)) {
            str = str.replace(r, '$1' + ':' + '$2');
        }

        e.target.value = str.slice(0, 17);
    };

    macAddress.addEventListener("keyup", formatMAC, false);
    
