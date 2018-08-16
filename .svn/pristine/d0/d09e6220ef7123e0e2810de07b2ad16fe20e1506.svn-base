<?php

class Application_Model_LogatividadeMapper {
    
    protected $_dbTable;
	
	public function gravaLog($atividade, $motivo, $demandaId)
    {	
        return $this->getDbTable()->gravaLog($atividade, $motivo, $demandaId);
    }
	
	public function getLogDemanda($idDemanda)
	{
		return $this->getDbTable()->getLogDemanda($idDemanda);
	}
	
	public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_Logatividade();
        }
        return $this->_dbTable;
    }
    
}