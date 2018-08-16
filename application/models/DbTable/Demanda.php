<?php

class Application_Model_DbTable_Demanda extends Zend_Db_Table_Abstract {
	
	public function init() {
		$this->_db 			= Zend_Registry::get("db1");
		$this->_db_mysql 	= Zend_Registry::get("db2");
		$this->_schema		= 'APP_SGD';
		$this->_name		= 'DEMANDA';
		$this->_schema_name	= $this->_schema.'.'.$this->_name;
		
	}
	
	public function getCampoInputDemandante(){
		#$this->_db->getProfiler()->setEnabled(true);
		$select = $this->_db->select()
						->distinct()
	                   ->from($this->_schema_name, array("DEMANDANTE AS ID","DEMANDANTE"),$this->_schema)
					   ->order('DEMANDANTE');
	    
	    return $this->_db->fetchPairs($select);
		#Zend_Debug::dump($this->_db->getProfiler()->getLastQueryProfile()->getQuery());
		#Zend_Debug::dump($this->_db->getProfiler()->getLastQueryProfile()->getQueryParams());
		#exit();
		
	}
    
    public function getCampoInputDemandado(){

		$select = $this->_db->select()
						->distinct()
	                   ->from($this->_schema.'.DEMANDA_DEMANDADO', array("DEMANDADO_ID","DEMANDADO_NOME"),$this->_schema)
					   ->order('DEMANDADO_NOME');
	    
	    return $this->_db->fetchPairs($select);
		
	}
	
	public function getCampoInputDiretoria(){
		$select = $this->_db->select()
						->distinct()
	                   ->from($this->_schema_name, array("DIRETORIA AS ID","DIRETORIA"),$this->_schema)
					   ->order('DIRETORIA');
	    
	    return $this->_db->fetchPairs($select);

	}
	
	public function insert($dados)
	{
		$this->_db->insert($this->_schema_name,$dados);
	}
	
	public function update($dados, $condicao)
	{
		#echo '<pre>'; print_r($dados); echo '<br><br>';
		#echo $condicao; exit();
		$this->_db->update($this->_schema_name, $dados, $condicao);
	}
    
    public function updateDilacoes($datas, $id)
	{
        if($datas != NULL){
            foreach($datas as $ordem => $data){ 
                $dt = new Zend_Db_Expr("TO_DATE('".implode('/',array_reverse(explode('/',$data)))."','yyyy-mm-dd')");
                $this->_db->update($this->_schema.'.DEMANDA_DILACAO', array('DATA_ATUAL' => $dt), array('ORDEM = '.$ordem, 'DEMANDA_ID = '.$id));
            }
        }
	}
    
    public function setBacklog()
    {
 
        $select = $this->_db->select()
	                   ->from($this->_schema_name, 'ID',$this->_schema)
                       ->where('STATUS_ID = 2')
	                   ->where('TRUNC(PRAZO_CONSIDERADO) - TRUNC(SYSDATE) <= -60');
		$resultado = $this->_db->fetchAll($select);
        $this->_db->update($this->_schema_name, array('STATUS_ID' => 3), 'STATUS_ID = 2 AND TRUNC(PRAZO_CONSIDERADO) - TRUNC(SYSDATE) <= -60');
        return $resultado;
        
    }
	
	public function getDemanda($condicao, $campos = array("*"))
	{
		$alter = "ALTER SESSION SET NLS_DATE_FORMAT = 'DD/MM/YYYY'";
		$this->_db->query ($alter);
		$alter = "ALTER SESSION SET NLS_TIMESTAMP_FORMAT='DD/MM/YYYY HH24:MI:SS'";
		$this->_db->query ($alter);
		$select = $this->_db->select()
	                   ->from($this->_schema_name, $campos,$this->_schema)
	                   ->where($condicao);
		return $this->_db->fetchRow($select);
	}
	
	public function verificaId($id)
	{
		$select = $this->_db->select()
	                   ->from($this->_schema_name, 'COUNT(*) QTD',$this->_schema)
	                   ->where('ID = '.$id);
		return $this->_db->fetchRow($select);
	}
	
	public function dadosUsuarioSessao($idLogin)
	{
		if($idLogin == ''){
			return false;
		}
		$sql = "SELECT 
					ar.nome AS diretoria
				FROM ControleAcesso.ColaboradorArea AS ca
				INNER JOIN ControleAcesso.Area ar ON ca.Area_id = ar.id
				INNER JOIN ControleAcesso.Colaborador co ON co.id = ca.Colaborador_id
				WHERE co.loginPortal = '".$idLogin."' 
                LIMIT 1";
		return $this->_db_mysql->fetchRow($sql);
	}
    
    public function datasDilatacao($condicao)
	{
		$alter = "ALTER SESSION SET NLS_DATE_FORMAT = 'DD/MM/YYYY'";
		$this->_db->query ($alter);
		$alter = "ALTER SESSION SET NLS_TIMESTAMP_FORMAT='DD/MM/YYYY HH24:MI:SS'";
		$this->_db->query ($alter);
		$select = $this->_db->select()
	                   ->from($this->_schema.'.DEMANDA_DILACAO', array("*"),$this->_schema)
	                   ->where($condicao)
                       ->order('DATA_CADASTRO');
		return $this->_db->fetchAll($select);
	}
	
	public function getDemandas($condicao = '')
	{#echo '<pre>'; print_r($condicao); exit();
		$where = '';
		if($condicao != ''){
			$where = (isset($condicao[0]) and $condicao[0] != '')? 'WHERE '.$condicao[0]: '';
			#$condUf = (isset($condicao[1][0]) and $condicao[1][0] != '')? 'AND '.$condicao[1][0]: '';
		}
		
		$alter = "ALTER SESSION SET NLS_DATE_FORMAT = 'DD/MM/YYYY'";
		$this->_db->query ($alter);
		$alter = "ALTER SESSION SET NLS_TIMESTAMP_FORMAT='DD/MM/YYYY HH24:MI:SS'";
		$this->_db->query ($alter);
		$sql = "SELECT 
					DE.ID,
					DE.NUMERO_SGD,
					CASE 
						WHEN 
							DE.STATUS_ID IN (1,2) AND TRUNC(DE.PRAZO_CONSIDERADO) - TRUNC(SYSDATE) >= 2
								THEN 'verde'
						WHEN 
							DE.STATUS_ID IN (1,2) AND TRUNC(DE.PRAZO_CONSIDERADO) - TRUNC(SYSDATE) = 1
								THEN 'amarelo'
						WHEN 
							DE.STATUS_ID IN (1,2) AND TRUNC(DE.PRAZO_CONSIDERADO) - TRUNC(SYSDATE) = 0
								THEN 'laranja'
						WHEN 
							DE.STATUS_ID IN (1,2) AND TRUNC(DE.PRAZO_CONSIDERADO) - TRUNC(SYSDATE) < 0 AND TRUNC(DE.PRAZO_CONSIDERADO) - TRUNC(SYSDATE) > -60
								THEN 'vermelho'
						WHEN 
							DE.STATUS_ID IN (1,2,3) AND TRUNC(DE.PRAZO_CONSIDERADO) - TRUNC(SYSDATE) <= -60
								THEN 'roxo'
					ELSE 'cinza' END FAROL,
					DE.TITULO,
					DE.DEMANDANTE,
					DE.DIRETORIA,
					DE.EMAIL,
					DE.STATUS_ID,
					DE.DOCUMENTO_TIPO_ID,
					DO.NOME DOCUMENTO,
					DE.PRAZO_CONSIDERADO,
					DE.PRAZO,
                    DE.DATA_CONCLUSAO,
					DE.DATA_CADASTRO,
					ST.NOME STATUS,
					DE.DESCRICAO,
					DE.NUMERO_SCT,
					DE.NUMERO_SEI,
					DE.NUMERO_PADO,
					DE.MULTA,
					DE.OBICE,
					DE.OBICE_DESCRICAO,
					DE.FISC_PRE_ONSITE,
					DE.FISC_REQ_OFFSITE,
					CL.NOME CLASSIFICACAO,
					CL.DESCRICAO CLASSIFICACAO_DESCRICAO,
					FA.NOME FATOR_GERADOR,
					DE.OBSERVACAO,
					RE.NOME REGIAO,
                    DD. DEMANDADO_ID,
					DD. DEMANDADO_NOME DEMANDADO,
					DL.DATA_1 DILATACAO_UM,
					DL.DATA_2 DILATACAO_DOIS,
					DL.DATA_3 DILATACAO_TRES,
					DL.MOTIVO_1 MOTIVO_UM,
					DL.MOTIVO_2 MOTIVO_DOIS,
					DL.MOTIVO_3 MOTIVO_TRES,
					(
						SELECT 
							LISTAGG(UF.NOME, ' | ') WITHIN GROUP (ORDER BY UF.NOME) UF
						FROM APP_SGD.DEMANDA_UF DUF
						JOIN APP_SGD.UF UF ON UF.ID = DUF.UF_ID
						WHERE DUF.DEMANDA_ID = DE.ID 
					) UF,
					(
						SELECT
							LISTAGG(MO.NOME, ' | ') WITHIN GROUP (ORDER BY MO.NOME) MODALIDADE
						FROM APP_SGD.DEMANDA_MODALIDADE DM
						INNER JOIN APP_SGD.MODALIDADE_TIPO MO ON MO.ID = DM.MODALIDADE_TIPO_ID
						WHERE DE.ID = DM.DEMANDA_ID 
					) MODALIDADE
				FROM APP_SGD.DEMANDA DE
				LEFT JOIN APP_SGD.DOCUMENTO_TIPO DO ON DO.ID = DE.DOCUMENTO_TIPO_ID
				LEFT JOIN APP_SGD.STATUS ST ON ST.ID = DE.STATUS_ID
				LEFT JOIN APP_SGD.CLASSIFICACAO CL ON CL.ID = DE.CLASSIFICACAO_ID
				LEFT JOIN APP_SGD.REGIAO RE ON RE.ID = DE.REGIAO_ID
                LEFT JOIN APP_SGD.FATOR_GERADOR FA ON DE.FATOR_GERADOR_ID = FA.ID
				LEFT JOIN APP_SGD.DEMANDA_DEMANDADO DD ON DD.DEMANDA_ID = DE.ID	
                LEFT JOIN (
                    SELECT
                        DEMANDA_ID,
                        MAX(DECODE(ORDEM, 1, DATA_ATUAL)) DATA_1,
                        MAX(DECODE(ORDEM, 1, MOTIVO)) MOTIVO_1,
                        MAX(DECODE(ORDEM, 2, DATA_ATUAL)) DATA_2,
                        MAX(DECODE(ORDEM, 2, MOTIVO)) MOTIVO_2,
                        MAX(DECODE(ORDEM, 3, DATA_ATUAL)) DATA_3,
                        MAX(DECODE(ORDEM, 3, MOTIVO)) MOTIVO_3
                    FROM APP_SGD.DEMANDA_DILACAO
                    GROUP BY DEMANDA_ID
                ) DL ON DL.DEMANDA_ID = DE.ID ".$where;
				#echo '<pre>';
				#print_r($sql); exit();
			return $this->_db->fetchAll($sql);
	}
	
	public function getModalidades($condicao)
	{
		$select = $this->_db->select()
	                   ->from($this->_schema.'.DEMANDA_MODALIDADE', array("*"),$this->_schema)
	                   ->where($condicao);
		return $this->_db->fetchAll($select);
	}
	
	public function getUfs($condicao)
	{
		$select = $this->_db->select()
	                   ->from($this->_schema.'.DEMANDA_UF', array("*"),$this->_schema)
	                   ->where($condicao);
		return $this->_db->fetchAll($select);
	}
    
    public function getRegioes($condicao)
	{
		$select = $this->_db->select()
	                   ->from($this->_schema.'.DEMANDA_REGIAO', array("*"),$this->_schema)
	                   ->where($condicao);
		return $this->_db->fetchAll($select);
	}
	
	public function getAnexos($condicao)
	{
		$select = $this->_db->select()
	                   ->from($this->_schema.'.DEMANDA_ANEXO', array("*"),$this->_schema)
	                   ->where($condicao);
		return $this->_db->fetchAll($select);
	}
	
	public function geraNumero($data)
	{
		$select = $this->_db->select()
	                   ->from($this->_schema_name, array("MAX(NUMERO_SGD) + 1 AS NUMERO"),$this->_schema)
	                   ->where("NUMERO_SGD LIKE '".$data."%'");
	    
	    return $this->_db->fetchRow($select);
	}
	
	public function ultimoId()
	{
		return $this->_db->fetchRow("SELECT ".$this->_schema.".SEQ_DEMANDA_ID.CURRVAL FROM DUAL");
	}
	
	public function gravaModalidades($id, $modalidades)
	{
		$this->_db->delete($this->_schema.".DEMANDA_MODALIDADE", "DEMANDA_ID = ".$id);
		foreach($modalidades as $mod){
			$dados = array("DEMANDA_ID" => $id, "MODALIDADE_TIPO_ID" => $mod);
			$this->_db->insert($this->_schema.".DEMANDA_MODALIDADE", $dados);
		}
	}
	
	public function gravaUfs($id, $ufs)
	{
		$this->_db->delete($this->_schema.".DEMANDA_UF", "DEMANDA_ID = ".$id);
		foreach($ufs as $uf){
			$dados = array("DEMANDA_ID" => $id, "UF_ID" => $uf);
			$this->_db->insert($this->_schema.".DEMANDA_UF", $dados);
		}
	}
    
    public function gravaRegioes($id, $regioes)
	{
		$this->_db->delete($this->_schema.".DEMANDA_REGIAO", "DEMANDA_ID = ".$id);
		foreach($regioes as $re){
			$dados = array("DEMANDA_ID" => $id, "REGIAO_ID" => $re);
			$this->_db->insert($this->_schema.".DEMANDA_REGIAO", $dados);
		}
	}
	
	public function gravaArquivos($id, $nomeAtual, $nomeNovo)
	{
		$dados = array('DEMANDA_ID' => $id, 'NOME' => $nomeAtual, 'CRIPTOGRAFIA' => $nomeNovo);
		$this->_db->insert($this->_schema.".DEMANDA_ANEXO", $dados);
	}
	
	public function apagaArquivo($id)
	{
		return $this->_db->delete($this->_schema.".DEMANDA_ANEXO", "ID = ".$id);
	}
	
	public function getCampoDemandadoInput()
	{
		$sql = "SELECT 
				DISTINCT
				co.id, co.nome
				FROM ControleAcesso.Colaborador AS co
				INNER JOIN ControleAcesso.PerfilAplicacaoColaborador AS cop ON co.id = cop.Colaborador_idColaborador
				INNER JOIN Perfil AS pe ON pe.id = cop.PerfilAplicacao_Perfil_id
				WHERE pe.id IN (1,9)
				ORDER BY co.nome";
		return $this->_db_mysql->fetchPairs($sql);
	}
	
	public function delegarSalvar($idDemandado, $nomeDemandado, $idDemanda)
	{
		$this->_db->delete($this->_schema.".DEMANDA_DEMANDADO", "DEMANDA_ID = ".$idDemanda);
		$dados = array('DEMANDA_ID' => $idDemanda, 'DEMANDADO_ID' => $idDemandado, 'DEMANDADO_NOME' => $nomeDemandado);
		$this->_db->insert($this->_schema.".DEMANDA_DEMANDADO", $dados);
	}
	
	public function getDemandados($condicao = '1=1')
	{
		$select = $this->_db->select()
	                   ->from($this->_schema.'.DEMANDA_DEMANDADO', array("*"),$this->_schema)
	                   ->where($condicao);
		return $this->_db->fetchAll($select);
	}
	
	public function insereDilacao($dados)
	{
		$this->_db->insert($this->_schema.".DEMANDA_DILACAO", $dados);
	}
	
	public function begin(){
	    
	    $this->_db->beginTransaction();
	    
	}
	
	public function commit() {
	    
	    $this->_db->commit();
	    
	}
	
	public function rollback() {
	    
	    $this->_db->rollBack();
	    
	}
	
	
}