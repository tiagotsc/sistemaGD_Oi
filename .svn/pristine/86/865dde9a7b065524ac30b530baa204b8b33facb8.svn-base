var table;
$(document).ready( function () {

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
            "url": CAMINHO_SISTEMA+'/index.php/fatorgerador/getDadosjson',
            "type": 'POST',
            "data": function(data){
			   data.valores = $("#frm-pesq").serialize();
			}
        },
		searching: false,
        dom: 'frtip', 
        select: true, 
        'columnDefs': [
		{
            targets: 0,
			orderable: false,
            data:   'ID',
            render: function ( data, type, row ) {
                if ( type === 'display' ) {
					var botoes = '';
					if(btFtEditar.indexOf(PERFIL) > -1){
						botoes += '<a title="Editar" href="'+CAMINHO_SISTEMA+'/index.php/fatorgerador/ficha/?id='+data+'" idEdit="'+data+'" class="editar"><i class="fas fa-edit fa-lg"></i></a>';
					}
					return botoes;
                }
                return data;
            },
            className: 'dt-body-center'
         },
         {
            targets: 1, 
            data: 'NOME', 
            className: 'dt-body-center' 
         },
         {
            targets: 2, 
            data: 'ATIVO',
            className: 'dt-body-center'
         }
        ],
        select: { 
            style:    'api' 
        },
        'order': [[1, 'asc']]
    } );
	
	$('#table_pesq tbody').on( 'click', '.editar', function (event) {
		showLoading();
	} );
	
	$("#pesq").on("click", function(){
		table.clear().draw();
		table.ajax.reload();
	});

} );