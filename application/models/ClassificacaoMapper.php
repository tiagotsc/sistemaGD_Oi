<?php

class Application_Model_ClassificacaoMapper {
    
    protected $_dbTable;
	
	public function getCampoInput()
    {
        return $this->getDbTable()->getCampoInput();
 
        // custom return
        /*$result = array();
        foreach($resultSet as $row){
            $user = new User();
            $user->setId($row->user_id)
                 ->setName($row->name)
                 ->setEmail($row->email);
            $result[] = $user;
        }
 
        return $result;*/
		/*echo '<pre>';
		foreach($resultSet as $r){
			echo $r['NOME']; echo '<br>';
		}
		exit();*/
		#return $resultSet;
    }
	
	public function getClassificacao($id)
	{
		return $this->getDbTable()->getClassificacao($id);
	}
	
	public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_Classificacao();
        }
        return $this->_dbTable;
    }
    
}