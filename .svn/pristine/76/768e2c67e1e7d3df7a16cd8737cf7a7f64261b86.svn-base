var table;
$(document).ready( function () {
	$(".table-modal-full").css('width','100%');

	jQuery.extend( jQuery.fn.dataTableExt.oSort, {
		"date-uk-pre": function ( a ) {
			if (a == null || a == "") {
				return 0;
			}
			var ukDatea = a.split('/');
			return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
		},
	 
		"date-uk-asc": function ( a, b ) {
			return ((a < b) ? -1 : ((a > b) ? 1 : 0));
		},
	 
		"date-uk-desc": function ( a, b ) {
			return ((a < b) ? 1 : ((a > b) ? -1 : 0));
		}
	} );	

    table = $('#table_pesq').DataTable( {
        "language": { 
            "url": CAMINHO_SISTEMA+"/js/datatable/language/dataTables.pt-br.json", 
			//"emptyTable": "Demanda(s) não encontrada(s)",
            select: { 
                rows: { 
                    _: "Você selecionou %d linhas", 
                    0: "Clique na linha para selecionar", 
                    1: "Apenas 1 linha foi selecionada" 
                }
            }
        },
		"processing": true,
		//oLanguage: {sProcessing: "<div class='batatableCarregando'>Carregando...</div>"},
        "ajax": {
            "url": CAMINHO_SISTEMA+'/index.php/demanda/getdemandasjson',
            "type": 'POST',
            "data": function(data){
			   data.valores = $("#demanda-pesq").serialize();
			}
        },
		searching: false,
        dom: 'Bfrtip', 
        select: true, 
        buttons: [ 
            {
                extend: 'excel', 
                text: 'Exportar excel',
				filename: 'relatorio',
                exportOptions: {
                    columns: [1,2,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33],
                    modifier: {
                        selected: null
                    }
                }
            }
        ],
        'columnDefs': [
		{
            targets: 0,
			orderable: false,
            data:   'ID',
            render: function ( data, type, row ) {
                if ( type === 'display' ) {
					var botoes = '';
					if(btDemEditar[PERFIL].indexOf(row.STATUS_ID) > -1){
						//botoes += '<a title="Editar" href="'+CAMINHO_SISTEMA+'/index.php/demanda/ficha/?id='+data+'" idEdit="'+data+'" class="editar"><i class="fas fa-edit fa-lg"></i></a>';
                        botoes += '<a title="Editar" href="#" idDemanda="'+data+'" class="editar"><i class="fas fa-edit fa-lg"></i></a>';
                    }
					if(btDemDelegar.indexOf(PERFIL) > -1){
						botoes += '<a href="#" idDemanda="'+data+'" title="Delegar" class="delegar iconMargem"><i class="fas fa-user-check fa-lg"></i></a>';
					}
					if(btDemDilatar[PERFIL].indexOf(row.STATUS_ID) > -1){
						botoes += '<a href="#" idDemanda="'+data+'" title="Dilatar" class="dilatar iconMargem"><i class="fas fa-calendar-check fa-lg"></i></a>';
					}
					if(btDemTratar[PERFIL].indexOf(row.STATUS_ID) > -1){
						botoes += '<a href="#" idDemanda="'+data+'" title="Tratar" class="tratar iconMargem"><i class="fas fa-check fa-lg"></i></a>';
					}
                    if(btDemReabrir.indexOf(PERFIL) > -1){
						botoes += '<a href="#" idDemanda="'+data+'" title="Reabrir" class="reabrir iconMargem"><i class="fas fa-sync fa-lg"></i></a>';
					}
                    if(btDemCancelar[PERFIL].indexOf(row.STATUS_ID) > -1){
						botoes += '<a title="Cancelar" href="#" idDemanda="'+data+'" class="cancelar iconMargem"><i class="fas fa-ban fa-lg"></i></a>';
					}
					if(btDemVisualizar.indexOf(PERFIL) > -1){
						botoes += '<a title="Visualizar" href="#" idDemanda="'+data+'" class="visualizar iconMargem"><i class="fas fa-search fa-lg"></a>';
					}
					return botoes;
                    //'<!--<a idDel="'+data+'" href="#" class="apagar iconMargem"><i class="fas fa-trash-alt fa-lg"></i></a>-->';
                }
                return data;
            },
            className: 'dt-body-center'
         },
         {
            targets: 1, 
            data: 'NUMERO_SGD', 
            className: 'dt-body-center' 
         },
         {
            targets: 2, 
            data: 'TITULO',
            className: 'dt-body-center'
         },
         {
            targets: 3,
            data: 'DEMANDANTE',
            className: 'dt-body-center' 
         },
		 {
            targets: 4,
			orderable: false,
            data: 'FAROL', render: function (data, type, row) {
                return type === 'display' ? /*'export'*/
                    '<i class="fas fa-circle fa-lg farol-'+data+'"></i>': '';
            },
            className: 'dt-body-center' 
         },
         {
            targets: 5,
            data: 'DOCUMENTO',
            className: 'dt-body-center' 
         },
         {
            targets: 6,
			type: 'date-uk',
            data: 'PRAZO_CONSIDERADO',
            className: 'dt-body-center'
         },
		 {
            targets: 7,
			type: 'date-uk',
            data: 'PRAZO',
            visible: false,
            className: 'dt-body-center'
         },
		 {
            targets: 8,
            data: 'UF',
            className: 'dt-body-center'
         },
		 {
            targets: 9,
            data: 'MODALIDADE',
            className: 'dt-body-center'
         },
		 {
            targets: 10,
            data: 'DIRETORIA',
			visible: false,
            className: 'dt-body-center' 
         },
		 {
            targets: 11,
            data: 'EMAIL',
			visible: false,
            className: 'dt-body-center' 
         },
		 {
            targets: 12,
            data: 'DATA_CADASTRO',
			visible: true,
            className: 'dt-body-center' 
         },
		 {
            targets: 13,
            data: 'STATUS',
			visible: true,
            className: 'dt-body-center' 
         },
		 {
            targets: 14,
            data: 'DESCRICAO',
			visible: false,
            className: 'dt-body-center' 
         },
		 {
            targets: 15,
            data: 'NUMERO_SCT',
			visible: false,
            className: 'dt-body-center' 
         },
		 {
            targets: 16,
            data: 'NUMERO_SEI',
			visible: false,
            className: 'dt-body-center' 
         },
		 {
            targets: 17,
            data: 'NUMERO_PADO',
			visible: false,
            className: 'dt-body-center' 
         },
		 {
            targets: 18,
            data: 'MULTA',
			visible: false,
            className: 'dt-body-center' 
         },
		 {
            targets: 19,
            data: 'OBICE',
			visible: false,
            className: 'dt-body-center' 
         },
		 {
            targets: 20,
            data: 'OBICE_DESCRICAO',
			visible: false,
            className: 'dt-body-center' 
         },
		 {
            targets: 21,
            data: 'FISC_PRE_ONSITE',
			visible: false,
            className: 'dt-body-center' 
         },
		 {
            targets: 22,
            data: 'FISC_REQ_OFFSITE',
			visible: false,
            className: 'dt-body-center' 
         },
		 {
            targets: 23,
            data: 'CLASSIFICACAO',
			visible: false,
            className: 'dt-body-center' 
         },
		 {
            targets: 24,
            data: 'FATOR_GERADOR',
			visible: false,
            className: 'dt-body-center' 
         },
		 {
            targets: 25,
            data: 'OBSERVACAO',
			visible: false,
            className: 'dt-body-center' 
         },
		 {
            targets: 26,
            data: 'REGIAO',
			visible: false,
            className: 'dt-body-center' 
         },
		 {
            targets: 27,
            data: 'DEMANDADO',
			visible: true,
            className: 'dt-body-center' 
         },
		 {
            targets: 28,
            data: 'DILATACAO_UM',
			visible: true,
            className: 'dt-body-center' 
         },
		 {
            targets: 29,
            data: 'MOTIVO_UM',
			visible: false,
            className: 'dt-body-center' 
         },
		 {
            targets: 30,
            data: 'DILATACAO_DOIS',
			visible: true,
            className: 'dt-body-center' 
         },
		 {
            targets: 31,
            data: 'MOTIVO_DOIS',
			visible: false,
            className: 'dt-body-center' 
         },
		 {
            targets: 32,
            data: 'DILATACAO_TRES',
			visible: true,
            className: 'dt-body-center' 
         },
		 {
            targets: 33,
            data: 'MOTIVO_TRES',
			visible: false,
            className: 'dt-body-center' 
         },
         {
            targets: 34,
            data: 'DATA_CONCLUSAO',
			visible: true,
            className: 'dt-body-center' 
         },
        ],
        select: { 
            /*style:    'multi+shift' */ 
            style:    'api'
        },
        'order': [[1, 'desc']]
    } );
    
    $('#table_pesq tbody').on( 'click', '.editar', function (event) {
		event.preventDefault();
		$('#modalDemandaPesq').modal('hide');
		montaModalDefault(CAMINHO_SISTEMA+'/index.php/demanda/ficha', $(this).attr("idDemanda"), "Editar demanda", "#modalDemandaPesq","S");
	} );
	
	$('#table_pesq tbody').on( 'click', '.delegar', function (event) {
        event.preventDefault();
		$('#modalDemandaPesq').modal('hide');
		montaModalDefault(CAMINHO_SISTEMA+'/index.php/demanda/delegar', $(this).attr("idDemanda")+'|index', "Delegar demanda", "#modalDemandaPesq","S");
    } );
	
	$('#table_pesq tbody').on( 'click', '.tratar', function (event) {
        event.preventDefault();
		$('#modalDemandaPesq').modal('hide');
		montaModalDefault(CAMINHO_SISTEMA+'/index.php/demanda/tratar', $(this).attr("idDemanda"), "Tratar demanda", "#modalDemandaPesq","S");
    } );
	
	$('#table_pesq tbody').on( 'click', '.dilatar', function (event) {
        event.preventDefault();
		$('#modalDemandaPesq').modal('hide');
		montaModalDefault(CAMINHO_SISTEMA+'/index.php/demanda/dilatar', $(this).attr("idDemanda"), "Dilatar demanda", "#modalDemandaPesq","S");
    } );
    
    $('#table_pesq tbody').on( 'click', '.cancelar', function (event) {
        event.preventDefault();
		$('#modalDemandaPesq').modal('hide');
		montaModalDefault(CAMINHO_SISTEMA+'/index.php/demanda/cancelar', $(this).attr("idDemanda"), "Cancelar demanda", "#modalDemandaPesq","S");
    } );
	
	$('#table_pesq tbody').on( 'click', '.visualizar', function (event) {
		event.preventDefault();
		$('#modalDemandaPesq').modal('hide');
		montaModalDefault(CAMINHO_SISTEMA+'/index.php/demanda/visualizar', $(this).attr("idDemanda"), "Visualizar demanda", "#modalDemandaPesq","S");
	} );
	
	/*$('#table_pesq tbody').on( 'click', '.editar', function (event) {
		$('#modalDemandaPesq').modal('hide');
		showLoading();
	} );*/
    
    $('#table_pesq tbody').on( 'click', '.reabrir', function (event) {
        event.preventDefault();
		$('#modalDemandaPesq').modal('hide');
		montaModalDefault(CAMINHO_SISTEMA+'/index.php/demanda/reabrir', $(this).attr("idDemanda"), "Reabrir demanda", "#modalDemandaPesq","S");
    } );
    
    $("#REGIAO_ID").on("change", function(){
        alimentaComboUfs(this, '');
    });
	
	$("#demanda-pesq").validate({
		debug: false,
		rules: {
			DATA_CADASTRO_DT_INI: {
				required: true
			}/*,
			DATA_CADASTRO_DT_FIM: {
				required: true
			}*/
		},
		messages: {
			DATA_CADASTRO_DT_INI: {
				required: "Informe a data"
			}/*,
			DATA_CADASTRO_DT_FIM: {
				required: "Informe a data"
			}*/
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
	
	//$(".delegar").on("click", function(event){ 
		//alert(1);
		//carregarAjax(CAMINHO_SISTEMA + "/demanda/delegar", "POST", "#modalTodos", "#frmComunicado");
		//$('#modalDemandaPesq').modal('hide');
		//$('#modalTodos').modal('show');
	//});
	
	//table.buttons().disable(); // Desabilita botões
	$("#pesq").on("click", function(){
		if($('#demanda-pesq').valid()){
			$('#modalDemandaPesq').modal('show');
			table.clear().draw();
			table.ajax.reload();
		}
		//var dados = $("#demanda-pesq").serialize();
		//alert(dados);
		//$.post( CAMINHO_SISTEMA+'/index.php/demanda/teste', { valores: dados }, function( data ) {
		  //$( ".result" ).html( data );
		//});
	});

} );