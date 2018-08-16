<?php

class Application_Model_DbTable_Logatividade extends Zend_Db_Table_Abstract {
	
	public function init() {
		$this->_db 			= Zend_Registry::get("db1");
		$this->_schema		= 'APP_SGD';
		$this->_name		= 'LOG_ATIVIDADE';
		$this->_schema_name	= $this->_schema.'.'.$this->_name;
	}
	
	public function getLogDemanda($idDemanda){
		
		$alter = "ALTER SESSION SET NLS_DATE_FORMAT = 'DD/MM/YYYY'";
		$this->_db->query ($alter);
		$alter = "ALTER SESSION SET NLS_TIMESTAMP_FORMAT='DD/MM/YYYY HH24:MI:SS'";
		$this->_db->query ($alter);
		$select = $this->_db->select()
	                   ->from($this->_schema_name, array("*"),$this->_schema)
					   ->order( array( 'DATA ASC') )
	                   ->where("DEMANDA_ID = ".$idDemanda);
	    return $this->_db->fetchAll($select);
		
	}
	
	public function gravaLog($atividade, $motivo, $demandaid)
	{
		$dados['USUARIO'] = utf8_encode($_SESSION['Zend_Auth']['storage']['nome']);
		$dados['DIRETORIA'] = utf8_encode($_SESSION['Zend_Auth']['storage']['diretoria']);
		$dados['EMAIL'] = $_SESSION['Zend_Auth']['storage']['email'];
		$dados['ATIVIDADE'] = $atividade;
		$dados['MOTIVO'] = $motivo;
		$dados['DEMANDA_ID'] = $demandaid;
		$this->_db->insert($this->_schema_name,$dados);
	}
	
	protected function iniciaTransacao() {
	    
	    $this->_db->beginTransaction();
	    
	}
	
	protected function finalizaTransacaoSucesso() {
	    
	    $this->_db->commit();
	    
	}
	
	protected function finalizaTransacaoErro() {
	    
	    $this->_db->rollBack();
	    
	}
	
	protected function inserir($doc) {
	
		$this->_db->insert($this->_schema_name, (array) $doc);
	
	}
	
	protected function atualizar($doc) {
	    
	    $this->_db->update($this->_schema_name, $doc);
	    
	}
	
	protected function buscarTodos() {
	    
	    $select = $this->_db->select()
	                   ->from($this->_schema_name);
	    
	    return $this->_db->fetchAll($select);
	    
	}
	
	protected function buscarPorId($idDoc) {
	    
	    $select = $this->_db->select()
	                   ->from($this->_schema_name)
            	       ->where('ID_DOCUMENTO = ?', $idDoc);
	    
	    return $this->_db->fetchRow($select);
	    
	}
	
	protected function buscarPorDescricao($descricaoDoc) {
	    
	    $select = $this->_db->select()
	                   ->from($this->_schema_name)
	                   ->where('DESCRICAO LIKE (?)', $descricaoDoc);
	    
	    return $this->_db->fetchAll($select);
	    
	}
	
	protected function consultar($params) {
        	    
        $select = $this->_db->select()
                    ->from (array('DOC'=>$this->_schema_name),array())	                           
                    ->joininner(array('STS'=> $this->_schema.'STATUS'), 'DOC.STATUS_ID = STS.ID_STATUS',
                        array('STS.DESCRICAO AS STATUS'))
                        ->joinleft(array('UFA' => $this->_schema.'UF_AFETADA'), 'DOC.ID_DOCUMENTO = UFA.DOCUMENTO_ID',
                        array('UFA.UF_AFETADAS'));
        
        if(!empty($params['numDocumento'])) {
           $select->where('DOC.NUMERO = ?', $params['numDocumento']);
        }
        if(!empty($params['dataInicioEmissao']) && !empty($params['dataFimEmissao'])) {
           $select->where('DOC.DATA_EMISSAO >= ?', $params['dataInicioEmissao']."00:00");
           $select->where('DOC.DATA_EMISSAO <= ?', $params['dataFimEmissao']."23:59");
        }
        if(!empty($params['status'])) {
           $select->where('STS.ID_STATUS = ?', $params['status']);
        } 
        if(!empty($params['ufs'])) {
           if (count($params['ufs']) == 1) {
               foreach ($params['ufs'] as $uf) {
                   $select->where("UFA.UF_AFETADAS = '".$uf."' OR UFA.UF_AFETADAS LIKE '".'%'.$uf.'%'."'");
               }
           } else {
               $count = 0;
               foreach ($params['ufs'] as $uf) {
                   if ($count == 0) {
                       $condicao = "(UFA.UF_AFETADAS = '".$uf."' OR UFA.UF_AFETADAS LIKE '".'%'.$uf.'%'."')";
                   } else {
                       $condicao .= " OR (UFA.UF_AFETADAS = '".$uf."' OR UFA.UF_AFETADAS LIKE '".'%'.$uf.'%'."')";
                   }
                   $count ++;
               }
               $select->where($condicao);
           }
        }
    	
	    return $this->_db->fetchAll($select);
	    
	}
	
	protected function calcularPrazo($numDoc) {
	    
	    $stmt = $this->_db->prepare("CALL SP_CALCULA_PRAZO(?)", $numDoc);
	    $stmt->bindParam (1, $prazo, null, 20);
	    
	    $stmt->execute();
	    $stmt->closeCursor();
	    
	    return $prazo;
	    
	}
	
	
}