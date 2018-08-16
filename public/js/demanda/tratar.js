//$(document).ready(function(){
	
	$("#add_file").on("click", function(event){
		event.preventDefault();
		//if($(".upload").length <= 2){
			var contAnexo = $('[name*="anexo"]').length;
			var campo = '<div class="form-group col-md-4">';
				campo += '<label><b>Tamanho máximo permitido: 40MB</b>';
				campo += '<input class="form-control upload" type="file" name="anexo['+contAnexo+']" id="anexo['+contAnexo+']">';
				campo += '</label>';
				campo += '<a class="removeFile" href="#"><i class="fas fa-trash-alt  fa-lg"></i></a>';
				campo += '</div>';
			$("#arquivos").append(campo);
			$(".removeFile").on("click", function(event){
				event.preventDefault();
				$(this).parent().remove();
				$("#add_file").show();
			});
			$('[name*="anexo"]').each(function () {
				$( this ).rules( "add", {
				  required: true,
				  filesize: 41943040,
				  messages: {
					required: "Selecione o arquivo.",
					filesize: "Tamanho do arquivo maior que o permitido! Favor salvar a demanda sem arquivo anexado e entrar em contato com a Equipe."
				  }
				});
			});
            $(".upload").on('change', function(){
                $('#frm-tratar').valid();
            });
		//}else{
			//$(this).hide();
		//}
	});
	
	$.validator.addMethod('filesize', function (value, element, param) {
		return this.optional(element) || (element.files[0].size <= param)
	}, 'Arquivo grande demais, esta acima de 40 MB');
		
	$("#frm-tratar").validate({
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
			STATUS_CONCLUSAO: {
				required: true
			}/*,
			"anexo[]": {
				required: true,
				filesize: 41943040
			},*/
		},
		messages: {
			STATUS_CONCLUSAO: {
				required: "Selecione o status"
			}/*,
			"anexo[]": {
				required: "Selecione o arquivo",
				filesize: "Grande demais"
			},*/
		}
	});
	
	$("#salvar").on("click", function(){
		if($("#frm-tratar").valid()){
			$("#salvar").prop('disabled', true).val('AGUARDE...');
			//$('#frm-tratar').submit();
            var formdata = new FormData($('#frm-tratar')[0]);
            $.ajax({
                type: 'POST',
                url: CAMINHO_SISTEMA+'/index.php/demanda/tratarsalvar',
                data: formdata ,
                dataType: "json",
                processData: false,
                contentType: false
            }).done(function (data) {
                if(data.status == 'ok'){
                    var statusRes = 'alert alert-success';
                    var msg = 'Demanda tratada com sucesso!';
                }else{
                    var statusRes = 'alert alert-danger';
                    var msg = 'Erro ao tratar demanda! Se o erro persistir, entre em contato com o administrador.';
                }
                var msgAlert = '<div class="'+statusRes+'" role="alert">';
                    msgAlert += msg;
                    msgAlert += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    msgAlert += '</div>';
                $( "#modal_conteudo_default" ).prepend( msgAlert );
                $("#salvar").prop('disabled', false).val('Delegar');
            });
            
		}
	});

//});