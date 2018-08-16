<?php

class Application_Model_FatorgeradorMapper {
    
    protected $_dbTable;
	
	public function getCampoInput()
    {
        return $this->getDbTable()->getCampoInput();
    }
    
    public function getDados()
    {
        return $this->getDbTable()->getDados();
    }
    
    public function getDado($id)
    {
        return $this->getDbTable()->getDado($id);
    }
    
    public function insert($dados)
	{
		$this->getDbTable()->insert($dados);
	}
	
	public function update($dados, $id)
	{
		$condicao = 'ID = '.$id;
		$db = $this->getDbTable()->update($dados, $condicao);
	}
	
	public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_Fatorgerador();
        }
        return $this->_dbTable;
    }
    
}