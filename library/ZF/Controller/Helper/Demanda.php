<?php
class Zend_Controller_Action_Helper_Demanda extends Zend_Controller_Action_Helper_Abstract {

    public function maiusculo($string) {
        return strtoupper($string);
    }
	
	public function montaCondicaoQueryPesq($dados = '', $comparador = ' AND '){
		
		$resultado = '';
		// Campos textos condição ficam com LIKE
		$camposTexto = array('NUMERO_SGD','NUMERO_SCT','NUMERO_SEI'); 
		// Campos datas são formatados para rodar no oracle | Campo termina '_DT_INI' -> condição = '>=' | Campo termina '_DT_FIM' -> condição = '<='
		$camposData = array('DATA_CADASTRO_DT_INI', 'DATA_CADASTRO_DT_FIM','PRAZO_CONSIDERADO_DT_INI','PRAZO_CONSIDERADO_DT_FIM','DATA_CONCLUSAO_DT_INI','DATA_CONCLUSAO_DT_FIM');
		// Campos arrays criasse a condição IN() ou são preparados para subquery
		$camposArray = array('DEMANDANTE','DIRETORIA','CLASSIFICACAO_ID','DOCUMENTO_TIPO_ID','MODALIDADE_TIPO','STATUS_ID','UF','DEMANDADO');
		// Informa quais são os campos da subquery
		$camposSubquery = array('UF','MODALIDADE_TIPO','DEMANDADO', 'REGIAO_ID');
		// Converter o nome do campoArray para o nome da tabela
		$tabelaSubquery = array('UF'=> 'DEMANDA_UF', 'REGIAO_ID' => 'DEMANDA_REGIAO', 'MODALIDADE_TIPO' => 'DEMANDA_MODALIDADE', 'DEMANDADO' => 'DEMANDA_DEMANDADO');
		// Converte o nome do campoArray para o nome do campo da tabela
		$nomeCampoSubquery = array('UF' => 'UF_ID', 'REGIAO_ID' => 'REGIAO_ID', 'MODALIDADE_TIPO' => 'MODALIDADE_TIPO_ID', 'DEMANDADO' => 'DEMANDADO_ID');
		$camposEspeciais = array('VENCIDA','DILACAO');
		$tabela = 'DE.';
		if($dados != ''){
			$valores = array();
			$condicao = array();
			$condSubquery = array();
			parse_str($dados,$valores);
			foreach($valores as $c => $v){
				if($v != ''){
					if(in_array($c, $camposTexto)){
						$condicao[] = $tabela.$c." LIKE '".$v."%'";
					}
					if(in_array($c, $camposData)){
						$oper = ' = ';
						if(strstr($c, 'DT_INI')){
							$oper = ' >= ';
						}
						if(strstr($c, 'DT_FIM')){
							$oper = ' <= ';
						}
						$campo = str_replace("_DT_INI", "", $c);
						$campo = str_replace("_DT_FIM", "", $campo); 
						$data = implode('-',array_reverse(explode('/',$v)));
						$condicao[] = "TRUNC(".$tabela.$campo.")".$oper. "TRUNC(TO_DATE('".$data."', 'YYYY-MM-DD'))";
					}
					if(in_array($c, $camposArray)){
						if(in_array($c, $camposSubquery)){
							$tabelaSub = $tabelaSubquery[$c];
							$campoSub = $nomeCampoSubquery[$c];
							$subquery = $tabela."ID IN (SELECT DEMANDA_ID FROM APP_SGD.".$tabelaSub." WHERE ".$campoSub." IN ('".implode("','",$v)."'))";
							$condicao[] = $subquery;
						}else{
							$condicao[] = $tabela.$c." IN ('".implode("','",$v)."')";
						}
					}
					if(in_array($c, $camposEspeciais)){
						if($c == 'VENCIDA'){
							$oper = ($v == 'S')? '<': '>';
							$condicao[] = "TRUNC(".$tabela."PRAZO_CONSIDERADO) ".$oper." TRUNC(SYSDATE)";
						}
						if($c == 'DILACAO' and $v == 'S'){
							$condicao[] = $tabela."ID IN (SELECT DEMANDA_ID FROM APP_SGD.DEMANDA_DILACAO)";
						}
					}
				}
			}
			$resultado = array(implode($comparador, $condicao), $condSubquery);
		}
		return $resultado;
		
	}
    
    public function msgemaildemanda()
    {
        $msg = "<strong>[CADASTRO] – Título teste</strong><br><br>
                A Demanda com número 201807010 foi cadastra no sistema.<br><br>
                <b>Mensagem gerada automaticamente pelo sistema, por favor, não responda</b>
                ";
        return $msg;
    }
    
    public function msgemaildilatacao()
    {
        $msg = "<strong>[DILAÇÃO] –  Título teste</strong><br><br>
                A Demanda com número 201807010 teve prazo dilatado para 12/07/2018.<br><br>
                <b>Mensagem gerada automaticamente pelo sistema, por favor, não responda.</b>
                ";
        return $msg;
    }
    
    public function unsetPost(array $posts)
    {
        foreach($posts as $campo){
            unset($_POST[$campo]);
        }
    }
}