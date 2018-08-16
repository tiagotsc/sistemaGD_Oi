<?php

class FatorgeradorController extends Zend_Controller_Action {

    public function init()
    {
        $this->Fatorgerador = new Application_Model_FatorgeradorMapper(); // DbTableMapper
        $this->formElementos = new Application_Form_Fatorgerador();
    }
    
	public function indexAction()
    {
        $msg = ($this->_helper->flashMessenger->getMessages()? $this->_helper->flashMessenger->getMessages(): '');
		$this->view->status = $msg[0];
	}
	
	public function getdadosjsonAction()
    {
		$dados = $this->Fatorgerador->getDados();
		if(count($dados) > 0){
			echo json_encode(array('data' => $dados));
		}else{
			echo json_encode(array('data'=>''));
		}
		exit();
    }
    
    public function fichaAction()
    {
        $id = $this->getRequest()->getParam('id');
        if(isset($id)){
            $dados = $this->Fatorgerador->getDado($id);
            if(!empty($dados)){
                $this->formElementos->NOME->setValue($dados['NOME']);
                $this->formElementos->ATIVO->setValue($dados['ATIVO']);
                $this->view->id = $id;
            }
        }
        $this->view->formElementos = $this->formElementos;
    }
    
    public function salvaAction()
    {
        try {
            if(!isset($_POST['ID'])){
                $msg = "Cadastrado";
                $this->Fatorgerador->insert($this->getRequest()->getPost());
            }else{
                $msg = "Alterado";
                $id = $_POST['ID'];
                unset($_POST['ID']);
                $this->Fatorgerador->update($this->getRequest()->getPost(), $id);
            }
            $this->_helper->flashMessenger->addMessage("alert alert-success|".$msg." com sucesso!");
        } catch (Exception $e){
            $this->_helper->flashMessenger->addMessage("alert alert-danger|Erro! Se o erro persistir, entre em contato com o administrador.");
        }
        return $this->_helper->redirector('index');
    }
    
}
