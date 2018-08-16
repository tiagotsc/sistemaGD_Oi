/*
Necessita -> Jquery UI, Jquery Validate (Caso queira validar ao clicar)
Aplica o calendário Jquery UI
- DataOrigem -> Campo que receberá o calendário (Obrigatório)
- DataDestino -> Campo que receberá o mesmo conteúdo da dataOrigem (Opcional)
- formValidate -> Formulário que será validado (Opcional)
*/
function calendario(dataOrigem, dataDestino, formValidate)
{ 
	$(dataOrigem).datepicker({
		dateFormat: 'dd/mm/yy',
		dayNames: ['Domingo','Segunda','Ter&ccedil;a','Quarta','Quinta','Sexta','S&aacute;bado','Domingo'],
		dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','S&aacute;b','Dom'],
		monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
		nextText: 'Pr&oacute;ximo',
		prevText: 'Anterior',
		
		// Traz o calendário input datepicker para frente da modal
		beforeShow :  function ()  { 
			setTimeout ( function (){ 
				$ ( '.ui-datepicker' ). css ( 'z-index' ,  99999999999999 ); 
			},  0 ); 
		},
		onSelect: function (date) {
			// Your CSS changes, just in case you still need them
			//$('a.ui-state-default').removeClass('ui-state-highlight');
			//$(this).addClass('ui-state-highlight');
			if(dataDestino != ''){
				$(dataDestino).val(date);
			}
			if(formValidate != ''){
				formValidate.valid();
			}
		}
	});
}

/*
Necessita -> Jquery
Exibe / Oculta elemente
- elemento -> Elemento que terá seu evento manupilado (Obrigatório)
- evento -> Evento que será manupilado papa o elemento informado (Obrigatório)
- valor -> Valor usado para verificação de exibição (.show()) (Obrigatório)
- manupila -> Elemento que será exibido / ocultado (Obrigatório)

*/
function exibeOculta(elemento, evento, valor, manupila)
{
	
	$(elemento).on(evento, function(){
		if($(this).val() == valor){
			$(manupila).show();
		}else{
			$(manupila).hide();
		}
	});
		
}

/*
Quebra linha
elemento -> Elemento (Textarea,<p>,<div>,...) que sofrerá a quebrado de linha natural (Obrigatório)
*/
function quebraLinha(elemento)
{ 
	if(elemento === null){
		return '';
	}
	return elemento.replace(/<br ?\/?>/ig,"\n");
}

/*
Quebra linhas por palavras do texto / conteúdo
elemento -> Elemento (Textarea,<p>,<div>,...) que terá as linhas quebradas por palavras (Obrigatório)
*/
function quebraPorPalavras(elemento)
{
	if(elemento === null){
		return '';
	}
	return elemento.texto.replace(/\s/g,'\n');
}

/*
Necessita do Jquery
Marca (selected) na select combo multiple as opções que estão presente no dadosArray informado
elementoCombo -> Select combo multiple que será manipulada
dadosArray -> Array de dados que será iterado
campoArray -> Nome do campo dadosArray que será comparado com os valores da combo para devida seleção
*/
function selecionaValorComboMulti(elementoCombo, dadosArray, campoArray)
{
	if(Array.isArray(dadosArray)){
		if(dadosArray.length > 0){
			$.each(dadosArray, function(i,e){
				$(elementoCombo+" option[value='" + e[campoArray] + "']").prop("selected", true);
			});
		}
	}
}

function alimentaComboUfs(elemento, marcados){
    showLoading('Carregando UFs...');
    var selecionados = new Array();
    $('option:selected', $(elemento)).each(function() {
      selecionados.push($(elemento).val());
    });
    $("#UF").html('<option value="">Carregando...</option>');
    if(selecionados.join(',') != ''){
        $.post( CAMINHO_SISTEMA+'/index.php/uf/getufsregiaojson', { valores: selecionados.join(',') }, function( data ) {
          $("#UF").html('');
          //if(data.dados.length > 0){
              $.each(data.dados, function() {
                  $("#UF").append('<option value="'+this.ID+'" label="'+this.NOME+'">'+this.NOME+'</option>');
              });
          //}
          if(marcados != ''){
            selecionaValorComboMulti('#UF', marcados, 'UF_ID');
          }
          hideLoading();
        }, "json");
    }else{
        $("#UF").html('');
    }
}

/*
Debuga elemento
obj -> elemento que será debugado
*/
function dump(obj) {
	var out = '';
	for (var i in obj) {
		out += i + ": " + obj[i] + "\n";
	}
	alert(out);
	// or, if you wanted to avoid alerts...
	var pre = document.createElement('pre');
	pre.innerHTML = out;
	document.body.appendChild(pre)
}