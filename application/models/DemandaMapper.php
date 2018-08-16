<?php

class Application_Model_DemandaMapper {
    
    protected $_dbTable;
	
	public function getCampoInputDemandante()
    {
        return $this->getDbTable()->getCampoInputDemandante();
 
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
    
    public function getCampoInputDemandado()
    {
        return $this->getDbTable()->getCampoInputDemandado();
    }
	
	public function getCampoInputDiretoria()
    {
        return $this->getDbTable()->getCampoInputDiretoria();
    }
	
	public function getCampoDemandadoInput()
	{
		return $this->getDbTable()->getCampoDemandadoInput();
	}
	
	public function getDemanda($condicao, $campos = array("*")){
		return $this->getDbTable()->getDemanda($condicao, $campos);
	}
	
	public function dadosUsuarioSessao($id)
	{
		return $this->getDbTable()->dadosUsuarioSessao($id);
	}
	
	public function getDemandas($condicao = '')
	{
		return $this->getDbTable()->getDemandas($condicao);
	}
	
	public function verificaId($id)
	{
		$resp = $this->getDbTable()->verificaId($id);
		return $resp['QTD'];
	}
	
	public function apagaArquivo($id)
	{
		return $this->getDbTable()->apagaArquivo($id);
	}
	
	public function getModalidades($condicao)
	{
		return $this->getDbTable()->getModalidades($condicao);
	}
	
	public function getUfs($condicao)
	{
		return $this->getDbTable()->getUfs($condicao);
	}
	
    public function getRegioes($condicao)
	{
		return $this->getDbTable()->getRegioes($condicao);
	}
    
	public function getAnexos($condicao)
	{
		return $this->getDbTable()->getAnexos($condicao);
	}
	
	public function delegarSalvar($idDemandado, $nomeDemandado, $idDemanda)
	{
		return $this->getDbTable()->delegarSalvar($idDemandado, $nomeDemandado, $idDemanda);
	}
	
	public function insert($dados)
	{
		$db = $this->getDbTable()->insert($dados);
		#echo $db->lastSequenceId("SEQ_DEMANDA_ID");exit();
		#$this->ID = $this->getDbTable()->_db->lastSequenceId("seq_demanda_id");
		#$this->ultimoId();
	}
	
	public function update($dados, $id)
	{
		$condicao = 'ID = '.$id;
		$db = $this->getDbTable()->update($dados, $condicao);
	}
    
    public function updateDilacoes($datas, $id)
    {
        return $this->getDbTable()->updateDilacoes($datas, $id);
    }
    
    public function setBacklog()
    {
        return $this->getDbTable()->setBacklog();
    }
	
	public function getDemandados($condicao)
	{
		return $this->getDbTable()->getDemandados($condicao);
	}
	
	public function ultimoId()
	{
		$db = $this->getDbTable()->ultimoId();
		return $db['CURRVAL'];
	}
	
	public function geraNumero($data)
	{
		$result = $this->getDbTable()->geraNumero($data);
		if($result['NUMERO'] != ''){
			$novoNumero = $result['NUMERO'];
		}else{
			$novoNumero = date('Ym').'001';
		}
		return $novoNumero;
	}
	
	public function gravaModalidades($id, $modalidades)
	{
		if($modalidades !== null){
			$this->getDbTable()->gravaModalidades($id, $modalidades);
		}
	}
	
	public function gravaUfs($id, $ufs)
	{
		if($ufs !== null){
			$this->getDbTable()->gravaUfs($id, $ufs);
		}
	}
    
    public function gravaRegioes($id, $regioes)
	{
		if($regioes !== null){ 
			$this->getDbTable()->gravaRegioes($id, $regioes);
		}
	}
	
	public function gravaArquivos($id, $nomeAtual, $nomeNovo)
	{
		if($nomeAtual !== null and $nomeNovo !== null){
			$this->getDbTable()->gravaArquivos($id, $nomeAtual, $nomeNovo);
		}
	}
	
	public function insereDilacao($dados)
	{
		$this->getDbTable()->insereDilacao($dados);
	}
    
    public function datasDilatacao($condicao)
    {
        return $this->getDbTable()->datasDilatacao($condicao);
    }
	
	public function begin()
	{
		$this->getDbTable()->begin();
	}
	
	public function commit()
	{
		$this->getDbTable()->commit();
	}
	
	public function rollback()
	{
		$this->getDbTable()->rollback();
	}
	
	public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_Demanda();
        }
        return $this->_dbTable;
    }
    
}