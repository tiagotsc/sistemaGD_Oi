$(document).ready(function(){
	$('.numero').mask('0#');
	$(".menuItem").click(function(){
		showLoading();
	});
	
	$(function() {
		$(document).tooltip();
	});
	
	$('.data_mask').mask('00/00/0000');
	calendario(".data","","");
	
});

function montaModalDefault(caminho, parametros, modalTitulo, modalOpcaoAbrir, fullModal){
	$("#modal_titulo_default").html('Aguarde...');
	$("#modal_conteudo_default").html( '' );
	$('#modalDefault').modal('show');
	if(fullModal == 'S'){
		if($( "#modalFullDefault" ).hasClass( "modal-full" ) == false){
			$("#modalFullDefault").addClass( "modal-full" );
		}
	}else{
		$("#modalFullDefault").removeClass( "modal-full" );
	}
	$.post( caminho, { valores: parametros }, function( data ) {
		$("#modal_titulo_default").html(modalTitulo);
		$( "#modal_conteudo_default" ).html( data );
	});
	if(modalOpcaoAbrir != ''){
		$("#modal_default_close").on("click", function(){
			$(modalOpcaoAbrir).modal('show');
		});
	}
}