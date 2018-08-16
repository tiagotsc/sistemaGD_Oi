<?php

class Application_Model_DbTable_Fatorgerador extends Zend_Db_Table_Abstract {
	
	public function init() {
		$this->_db 			= Zend_Registry::get("db1");
		$this->_schema		= 'APP_SGD';
		$this->_name		= 'FATOR_GERADOR';
		$this->_schema_name	= $this->_schema.'.'.$this->_name;
	}
	
	public function getCampoInput(){

		$select = $this->_db->select()
	                   ->from($this->_schema_name, array("ID","NOME"),$this->_schema)
	                   ->where("ATIVO = '1'");
	    
	    return $this->_db->fetchPairs($select);
		
	}
    
    public function getDados(){

        $condicao = '';
        if(isset($_POST['valores'])){
            $res = parse_str($_POST['valores'],$dados);
            $condicao .= ($dados['NOME'] != '')? " AND NOME LIKE '%".$dados['NOME']."%'": '';
            $condicao .= ($dados['ATIVO'] != '')? " AND ATIVO = ".$dados['ATIVO']: '';
        }
    
	    $sql = "SELECT 
                ID,
                NOME,
                CASE WHEN ATIVO = 1 THEN 'Ativo' ELSE 'Inativo' END AS ATIVO
                FROM APP_SGD.FATOR_GERADOR 
                WHERE 1=1".$condicao."
                ORDER BY NOME ASC";
	    return $this->_db->fetchAll($sql);
	    
	}
    
    public function getDado($id){

		$select = $this->_db->select()
	                   ->from($this->_schema_name, array("*"),$this->_schema)
	                   ->where("ID = ".$id);
	    
	    return $this->_db->fetchRow($select);
		
	}
    
    public function insert($dados)
	{
		$this->_db->insert($this->_schema_name, $dados);
	}
    
    public function update($dados, $condicao)
	{
		$this->_db->update($this->_schema_name, $dados, $condicao);
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