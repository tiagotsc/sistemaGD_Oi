//alert(moment('2018-10-20').isBefore('<?php echo date('Y-m-d');?>'));
var dataPrazo = $("#DATA_ANTERIOR").val().split('/').reverse().join('-');
var dataInicio = new Date(moment(dataPrazo).add(1, "days"));

$("#DATA_ATUAL").datepicker({
    dateFormat: 'dd/mm/yy',
    dayNames: ['Domingo','Segunda','Ter&ccedil;a','Quarta','Quinta','Sexta','S&aacute;bado','Domingo'],
    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b','Dom'],
    monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
    nextText: 'Pr&oacute;ximo',
    prevText: 'Anterior',
    minDate: dataInicio,
    
    // Traz o calendário input datepicker para frente da modal
    beforeShow :  function ()  { 
        setTimeout ( function (){ 
            $ ( '.ui-datepicker' ). css ( 'z-index' ,  99999999999999 ); 
        },  0 ); 
    },
    onSelect: function (date) {
        $("#frm-dilatar").valid();
    }
});

$.validator.addMethod("dataMin", function(value, element) { 
    var dataPrazo = $("#DATA_ANTERIOR").val().split('/').reverse().join('-'); 
    var dataDilacao = $("#DATA_ATUAL").val().split('/').reverse().join('-');
    if (dataDilacao.length == 10 && moment(dataPrazo).isBefore(dataDilacao) == true)
        return true;
    return false;
}, "Data inferior");  
	
$("#frm-dilatar").validate({
	debug: false,
	errorClass: 'error',
	errorElement: 'p',
	errorPlacement: function(error, element) {
	  element.parents('.form-group').append(error);
	  var msg = $(element).next('.help-block').text();
	  $(element).attr('aria-label', msg );
	},
	highlight: function(element, errorClass){
	  $(element)
	  .attr('aria-invalid', true)
	  .parents('.form-group')
	  .addClass('has-error');
	},
	unhighlight: function(element, errorClass){
	  $(element).removeAttr('aria-invalid')
	  .removeAttr('aria-label')
	  .parents('.form-group').removeClass('has-error');
	},
	rules: {
		DATA_ATUAL: {
			required: true,
            dataMin: true
		},
		MOTIVO: {
			required: true,
		},
	},
	messages: {
		DATA_ATUAL: {
			required: "Informe a data",
            dataMin: "Data inválida ou inferior a data prazo considerado!"
		},
		MOTIVO: {
			required: "Informe o motivo",
		},
	}
});

$("#salvar").on("click", function(){
	if($("#frm-dilatar").valid()){
		$("#salvar").prop('disabled', true).val('AGUARDE...');
		//$('#frm-dilatar').submit();
        $.post( CAMINHO_SISTEMA+'/index.php/demanda/dilatarsalvar', { 
            NUMERO_SGD: $("#NUMERO_SGD").val(),
            DEMANDA_ID: $("#DEMANDA_ID").val(),
            DATA_ANTERIOR: $("#DATA_ANTERIOR").val(),
            DATA_ATUAL: $("#DATA_ATUAL").val(),
            MOTIVO: $("#MOTIVO").val(),
            ORDEM: $("#ORDEM").val()
        }, function( data ) {
            if(data.status == 'ok'){
                var statusRes = 'alert alert-success';
                var msg = 'Demanda dilatada com sucesso!';
            }else{
                var statusRes = 'alert alert-danger';
                var msg = 'Erro ao dilatar demanda! Se o erro persistir, entre em contato com o administrador.';
            }
            var msgAlert = '<div class="'+statusRes+'" role="alert">';
                msgAlert += msg;
                msgAlert += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                msgAlert += '</div>';
            $( "#modal_conteudo_default" ).prepend( msgAlert );
            $("#salvar").prop('disabled', false).val('Delegar');
        }, "json");
	}
});
