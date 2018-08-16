<?php

class TarefaagendadaController extends Zend_Controller_Action {

    public function init()
    {
        $this->Demanda = new Application_Model_DemandaMapper(); // DbTableMapper
		$this->LogAtividade = new Application_Model_LogatividadeMapper(); // DbTableMapper
    }

	public function indexAction() {
		
	}
	
	public function setbacklogAction()
    {
        $this->LogAtividade->gravaLog('Envio backlog - Início', 'Iniciando processo',null);
        try {
            $this->Demanda->begin();
            $demandasId = $this->Demanda->setBacklog();
            foreach($demandasId as $id){
                $this->LogAtividade->gravaLog('Envio backlog', 'Processo automatico de backlog',$id['ID']);
            }
			$this->Demanda->commit();
            $this->LogAtividade->gravaLog('Envio backlog - Fim', 'Conclusão com sucesso',null);
        } catch (Exception $e){
            $this->Demanda->rollback();
            $this->LogAtividade->gravaLog('Envio backlog - Fim', 'Erro na conclusão',null);
        }
        exit();
    }
    
}
