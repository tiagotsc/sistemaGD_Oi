$(document).ready(function(){
	
	// Cria combo autocomplete
	$('#DEMANDADO').select2({
	  //placeholder: 'Selecione uma opção',
	  dropdownParent: $('#modalDefault')
	}).on("select2:select", function(e) {// Change
	//alert(e.params.data.id); // Id
	$("#NOME").val(e.params.data.text);
	$('#frm-delegar').valid()
	});

	$("#frm-delegar").validate({
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
			DEMANDADO: {
				required: true
			}
		},
		messages: {
			DEMANDADO: {
				required: "Selecione o demandado"
			}
		}
	});

	$("#salvar").on("click", function(){
			if($('#frm-delegar').valid()){
				//$("#frm-delegar").submit();
				$("#salvar").prop('disabled', true).val('AGUARDE...');
                
                $.post( CAMINHO_SISTEMA+'/index.php/demanda/delegarsalvar', { 
                    DEMANDADO: $("#DEMANDADO").val(),
                    NOME: $("#NOME").val(),
                    ID: $("#ID").val()
                }, function( data ) {
                    if(data.status == 'ok'){
                        var statusRes = 'alert alert-success';
                        var msg = 'Demandado associado com sucesso!';
                    }else{
                        var statusRes = 'alert alert-danger';
                        var msg = 'Erro ao associar demandado! Se o erro persistir, entre em contato com o administrador.';
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
	
});