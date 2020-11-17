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
    $('#equipamento_ip').attr('hidden',false).find('input').attr('required',true);
  }
  else {
    $('#equipamento_ip').attr('hidden',true).find('input').attr('required',false);
  }
});
