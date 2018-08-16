<?php

class ClassificacaoController extends Zend_Controller_Action {

	public function indexAction() {
	    
		#$this->_helper->layout->disableLayout();
		#$this->_helper->layout->setLayout ( 'default' );
		
	}
	
	public function getclassificacaoAction()
	{
		#$_POST['id'] = 8;
		$classificacaoMapper = new Application_Model_ClassificacaoMapper();
		$result = $classificacaoMapper->getClassificacao($this->getRequest()->getPost('id'));
		echo json_encode($result);
		exit();
		#echo '<pre>'; print_r($result); exit();
		#$this->_helper->viewRenderer->setNoRender();
	}
    
}
