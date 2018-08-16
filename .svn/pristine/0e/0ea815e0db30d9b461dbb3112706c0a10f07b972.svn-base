$("#frm").validate({
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
		MOTIVO: {
			required: true,
		}
	},
	messages: {
		MOTIVO: {
			required: "Informe o motivo",
		}
	}
});

$("#salvar").on("click", function(){
	if($("#frm").valid()){
		$("#salvar").prop('disabled', true).val('AGUARDE...');
		//$('#frm').submit();
        var formdata = new FormData($('#frm')[0]);
        $.ajax({
            type: 'POST',
            url: CAMINHO_SISTEMA+'/index.php/demanda/cancelarsalvar',
            data: formdata ,
            dataType: "json",
            processData: false,
            contentType: false
        }).done(function (data) {
            if(data.status == 'ok'){
                var statusRes = 'alert alert-success';
                var msg = 'Demanda cancelada com sucesso!';
            }else{
                var statusRes = 'alert alert-danger';
                var msg = 'Erro ao cancelar demanda! Se o erro persistir, entre em contato com o administrador.';
            }
            var msgAlert = '<div class="'+statusRes+'" role="alert">';
                msgAlert += msg;
                msgAlert += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                msgAlert += '</div>';
            $( "#modal_conteudo_default" ).prepend( msgAlert );
            $("#salvar").prop('disabled', false).val('Salvar cancelamento');
        });
	}
});
