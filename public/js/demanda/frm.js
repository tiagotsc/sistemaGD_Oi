$(document).ready(function(){
	
	$(".obice_desc").hide();
	$(".fisc").hide();
	$("#info").hide();
	exibeOculta("#DOCUMENTO_TIPO_ID", "change", '7', ".fisc");
	exibeOculta("#OBICE", "change", 'S', ".obice_desc");
	if($("#ID").length == 1){
		calendario("#PRAZO","", $("#frm-demanda"));
		$("#PRAZO_CONSIDERADO").prop('readonly', true);
	}else{
		calendario("#PRAZO","#PRAZO_CONSIDERADO", $("#frm-demanda"));
		calendario("#PRAZO_CONSIDERADO","", $("#frm-demanda"));
	}
	
	$("#buscarDemanda").on("click", function(){
		if($("#SGD_MASCARA").val() == ''){
			alert('Digite o número da demanda para busca!');
			$("#SGD_MASCARA").focus();
		}else{
			showLoading();
			carregaDemanda('', $("#SGD_MASCARA").val());
		}
	});
    
    $("#REGIAO_ID").on("change", function(){
        alimentaComboUfs(this, '');
    });
	
	function carregaDemanda(id, numero)
	{	
		showLoading();
		$.ajax({
		  type: "POST",
		  url: CAMINHO_SISTEMA+'/index.php/demanda/getdemandajson',          
		  data: {
			ID: id,
			NUMERO_SGD: numero
		  },
		  dataType: "json",
		  error: function(res) {
			alert('Erro ao carregar dado');
		  },
		  success: function(res) { 

			if(res.dados['ID'] !== undefined){
				
				$("#TITULO").val(res.dados['TITULO']);
				$("#DESCRICAO").val(quebraLinha(res.dados['DESCRICAO']));
				$("#DOCUMENTO_TIPO_ID").val(res.dados['DOCUMENTO_TIPO_ID']); 
				$("#DOCUMENTO_TIPO_ID").trigger("change");
				$("#NUMERO_SCT").val(res.dados['NUMERO_SCT']);
				$("#NUMERO_SEI").val(res.dados['NUMERO_SEI']);
				$("#NUMERO_PADO").val(res.dados['NUMERO_PADO']);
				$("#MULTA").val(res.dados['MULTA']);
				$("#OBICE").val(res.dados['OBICE']);
				$("#OBICE").trigger("change");
				$("#OBICE_DESCRICAO").val(quebraLinha(res.dados['OBICE_DESCRICAO']));
				$("#FISC_PRE_ONSITE").val(res.dados['FISC_PRE_ONSITE']);
				$("#FISC_REQ_OFFSITE").val(res.dados['FISC_REQ_OFFSITE']);
				$("#CLASSIFICACAO_ID").val(res.dados['CLASSIFICACAO_ID']);
				$("#CLASSIFICACAO_ID").trigger("change");
				$("#FATOR_GERADOR_ID").val(res.dados['FATOR_GERADOR_ID']);
				$("#PRAZO").val(res.dados['PRAZO']);
				$("#PRAZO_CONSIDERADO").val(res.dados['PRAZO_CONSIDERADO']);
				$("#TITULO").val(res.dados['TITULO']);
				$("#NUMERO_SGD").val(res.dados['NUMERO_SGD']);
				//$("#REGIAO_ID").val(res.dados['REGIAO_ID']);
                selecionaValorComboMulti('#REGIAO_ID', res.regioes, 'REGIAO_ID');
                alimentaComboUfs($("#REGIAO_ID"), res.ufs);
				selecionaValorComboMulti('#MODALIDADE_TIPO', res.modalidades, 'MODALIDADE_TIPO_ID');
				//selecionaValorComboMulti('#UF', res.ufs, 'UF_ID');
				if($("#ID").length == 1){
					$("#STATUS_ID").val(res.dados['STATUS_ID']);
					$("#OBSERVACAO").val(quebraLinha(res.dados['OBSERVACAO'])); 
					$("#DEMANDANTE").val(res.dados['DEMANDANTE']); 
					$("#DIRETORIA").val(res.dados['DIRETORIA']); 
					$("#EMAIL").val(res.dados['EMAIL']);
					$("#DATA_CADASTRO").val(res.dados['DATA_CADASTRO']);
					if(res.anexos.length > 0){
						var tabela = '<table class="table">';
							tabela += '<tr>';
							tabela += '<th>Nome</th>';
							tabela += '<th>Data</th>';
							tabela += '<th>Ação</th>';
							tabela += '</tr>';
						$.each(res.anexos, function(){
							tabela += '<tr>';
							tabela += '<td><a href="'+res.localfile+this.CRIPTOGRAFIA+'" target="_blank">'+this.NOME+'</a></td>';
							tabela += '<td>'+this.DATA_CADASTRO+'</td>';
							if((btDemRemoverAnexo.indexOf(res.dados['STATUS_ID']) > -1)){
								tabela += '<td><a idDel="'+this.ID+'" nomeFile="'+this.CRIPTOGRAFIA+'" href="#" class="apagarFile"><i class="fas fa-trash-alt fa-lg"></i></a></td>';
							}else{
								tabela += '<td></td>';
							}
							tabela += '</tr>';
						});
						$("#anexos").html(tabela);
						$(".apagarFile").on("click", function(event){
							event.preventDefault(); 
							var r = confirm("Deseja apagar o arquivo?");
							if (r == true) {
								showLoading('Apagando...');
								var elemento = $(this);
								$.post( CAMINHO_SISTEMA+'/index.php/demanda/apagaanexo', { id: $(this).attr('idDel'), file: $(this).attr('nomeFile') }, function( data ) {
									if(data.status == 'ok'){
										elemento.parent().parent().remove();
									}else{
										alert('Não foi possível apagar');
									}
									hideLoading();
								}, "json");
							}
						});
					}
                    let dilatacao = '';
                    $("#dilatacoes").html('');
                    $.each(res.dilatacoes, function(){
                        //alert(this.DATA_ATUAL);
                        dilatacao += '<div class="form-group col-md-4">';
                        dilatacao += '<label>'+this.ORDEM+'ª data dilatação</label>';
                        dilatacao += '<input type="text" class="form-control" readonly value="'+this.DATA_ATUAL+'">';
                        dilatacao += '<label>Motivo</label>';
                        dilatacao += '<textarea class="form-control" rows="5" readonly>'+this.MOTIVO+'</textarea>';
                        dilatacao += '</div>';
                    });
                    $("#dilatacoes").html(dilatacao);
					if(PERFIL == 1){
						//$("#DEMANDADO").prop('readonly', false); 
						if(res.demandado.length > 0){
							$("#DEMANDADO").val(res.demandado[0]['DEMANDADO_NOME']);
						}
						var demandadoObrigatorio = ['2','3','4'];
						if(demandadoObrigatorio.indexOf(res.dados['STATUS_ID']) > -1){
							$( "#DEMANDADO" ).rules( "add", {
							  required: true,
							  messages: {
								required: "Adicione o demandado através do ícone."
							  }
							});
						}
					}
				}
			}else{
				$("#TITULO").val('');
				$("#DESCRICAO").val('');
				$("#DOCUMENTO_TIPO_ID").val(''); 
				$("#NUMERO_SCT").val('');
				$("#NUMERO_SEI").val('');
				$("#NUMERO_PADO").val('');
				$("#MULTA").val('');
				$("#OBICE").val('');
				$("#OBICE_DESCRICAO").val('');
				$("#FISC_PRE_ONSITE").val('');
				$("#FISC_REQ_OFFSITE").val('');
				$("#CLASSIFICACAO_ID").val('');
				$("#FATOR_GERADOR").val('');
				$("#PRAZO").val('');
				$("#PRAZO_CONSIDERADO").val('');
				$("#OBSERVACAO").val('');
				$("#TITULO").val('');
				$("#NUMERO_SGD").val('');
				$("#REGIAO_ID").val('');
				$("#MODALIDADE_TIPO").val('');
				$("#UF").val('');
				$(".obice_desc").hide();
				$(".fisc").hide();
				$("#info").hide();
				if($("#ID").length == 1){
					$("#STATUS_ID").val('');
					$("#OBSERVACAO").val('');
				}
				alert('Demanda não encontrada!');
			}
			hideLoading();
		  }
		}); 		
	}
	
	$("#delegar").on("click", function(){
		event.preventDefault();
		montaModalDefault(CAMINHO_SISTEMA+'/index.php/demanda/delegar', $(this).attr("idDemanda")+'|ficha', "Delegar demanda", "","S");
	});
	
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
                $('#frm-demanda').valid();
            });
		//}else{
			//$(this).hide();
		//}
	});
	
	$("#CLASSIFICACAO_ID").on("change", function(){ 
		$("#info").attr("title", '');
		if($(this).val() != ''){
			showLoading();
			$.ajax({
			  type: "POST",
			  url: CAMINHO_SISTEMA+'/index.php/classificacao/getclassificacao',          
			  data: {
				id: $(this).val()
			  },
			  dataType: "json",
			  error: function(res) {
				alert('Erro ao carregar dado');
			  },
			  success: function(res) { 
				$("#info").attr("title", res.DESCRICAO);
				hideLoading();
				$("#info").show();
			  }
			}); 
		}else{
			$("#info").hide();
		}
	});
	
    $.validator.addMethod('filesize', function (value, element, param) {
		return this.optional(element) || (element.files[0].size <= param)
	}, 'Arquivo grande demais 40 MB');
    
	$("#frm-demanda").validate({
		debug: false,
		rules: {
			TITULO: {
				required: true
			},
			DESCRICAO: {
				required: true
			},
			DOCUMENTO_TIPO_ID: {
				required: true
			},
			CLASSIFICACAO_ID: {
				required: true
			},
			"MODALIDADE_TIPO[]": {
				required: true
			},
			FATOR_GERADOR_ID: {
				required: true
			},
			PRAZO: {
				required: true
			},
			PRAZO_CONSIDERADO: {
				required: true
			},
			REGIAO_ID: {
				required: true
			},
			"UF[]": {
				required: true
			},
			OBICE_DESCRICAO: {
				required : {
							   depends: function(element){
								   var status = false;
								   if( $("#OBICE").val() == 'S'){
									   var status = true;
								   }
								   //console.log("yesname is: "+status);
								   return status;
							   }
						   }
			}//,
			//"anexo[]": {
				//required: true
			//}
		},
		messages: {
			TITULO: {
				required: "Informe o título"
			},
			DESCRICAO: {
				required: "Informe a descrição"
			},
			DOCUMENTO_TIPO_ID: {
				required: "Selecione o tipo"
			},
			CLASSIFICACAO_ID: {
				required: "Selecione a classificação"
			},
			"MODALIDADE_TIPO[]": {
				required: "Selecione a modalidade"
			},
			FATOR_GERADOR_ID: {
				required: "Selecione o fator gerador"
			},
			PRAZO: {
				required: "Informe o prazo"
			},
			PRAZO_CONSIDERADO: {
				required: "Informe o prazo considerado"
			},
			REGIAO_ID: {
				required: "Selecione a região"
			},
			"UF[]": {
				required: "Selecione a UF"
			},
			OBICE_DESCRICAO: {
				required: "Informe a descrição"
			}//,
			//"anexo[]": {
				//required: true
			//}
		}/*,
		submitHandler: function(form) { // SUBMETER POR AJAX
			//alert($(form).serialize());
			//alert('AJAX');
			//$("#salvar").prop('disabled', true).val('AGUARDE...');
			$("#salvar").prop('disabled', true).val('AGUARDE...');
			$(form).submit();
			//showLoading();
			
		}*/
	});

	/*$('#salvar').click(function(e) {
    e.preventDefault();
    var titulo = $('#TITULO').val();
	var documento = $('#DOCUMENTO_TIPO_ID').val();
	var qualificacao = $('#QUALIFICACAO_ID').val();
    var descricao = $('#DESCRICAO').val();
    
 
    $(".error").remove();
	var status = 'ok';
    if (titulo.length < 1) {
      $('#TITULO').after('<span class="error">Preencha o campo, por favor!</span>');
	  status = 'erro';
    }
    if (documento.length < 1) {
      $('#DOCUMENTO_TIPO_ID').after('<span class="error">Selecione, por favor!</span>');
	  status = 'erro';
    }
	if (descricao.length < 1) {
      $('#DESCRICAO').after('<span class="error">Preencha o campo, por favor!</span>');
	  status = 'erro';
    }
	
	if(status == 'ok'){
		$('#frm-demanda').submit();
	}*/
    /*if (email.length < 1) {
      $('#email').after('<span class="error">This field is required</span>');
    } else {
      var regEx = /^[A-Z0-9][A-Z0-9._%+-]{0,63}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/;
      var validEmail = regEx.test(email);
      if (!validEmail) {
        $('#email').after('<span class="error">Enter a valid email</span>');
      }
    }
    if (password.length < 8) {
      $('#password').after('<span class="error">Password must be at least 8 characters long</span>');
    }*/
  //});
	
	$("#salvar").on("click", function(){
		if($('#frm-demanda').valid()){
			$("#salvar").prop('disabled', true).val('AGUARDE...');
            if($("#ID").length == 1){
                var formdata = new FormData($('#frm-demanda')[0]);
                $.ajax({
                    type: 'POST',
                    url: $("#frm-demanda").attr('action'),
                    data: formdata ,
                    dataType: "json",
                    processData: false,
                    contentType: false
                }).done(function (data) {
                    if($("#ID").length == 1){
                        var msgOk = 'Alterado';
                        var msgErro = 'alterar';
                    }else{
                        var msgOk = 'Gravado';
                        var msgErro = 'gravar';
                    }
                    if(data.status == 'ok'){
                        var statusRes = 'alert alert-success';
                        var msg = msgOk+' com sucesso! Número SGD: '+data.numero;
                    }else{
                        var statusRes = 'alert alert-danger';
                        var msg = 'Erro ao '+msgErro+'! Se o erro persistir, entre em contato com o administrador.';
                    }
                    var msgAlert = '<div class="'+statusRes+'" role="alert">';
                        msgAlert += msg;
                        msgAlert += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        msgAlert += '</div>';
                    $( "#modal_conteudo_default" ).prepend( msgAlert );
                    $("#salvar").prop('disabled', false).val('Salvar');
                });
            }else{
                $('#frm-demanda').submit();
            }
		}
	});
	
	if($("#ID").length == 1){ // Existe ID (Edição)
		carregaDemanda($("#ID").val(),''); 
		$("#frm-demanda").attr('action',CAMINHO_SISTEMA+'/index.php/demanda/editar');
		$( "#OBSERVACAO" ).rules( "add", {
		  required: true,
		  messages: {
			required: "Selecione a observação"
		  }
		});
		$( ".anexo" ).rules( "add", {
		  required: true,
		  messages: {
			required: "Selecione a observação"
		  }
		});
	}
});