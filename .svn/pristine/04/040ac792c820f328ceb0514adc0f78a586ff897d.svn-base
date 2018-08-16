$(document).ready(function(){
    
	$("#frm").validate({
		debug: false,
		rules: {
			NOME: {
				required: true
			}
		},
		messages: {
			NOME: {
				required: "Informe o nome"
			}
		}
	});
	
	$("#salvar").on("click", function(){
		if($('#frm').valid()){
			$("#salvar").prop('disabled', true).val('AGUARDE...');
			$('#frm').submit();
		}
	});

});