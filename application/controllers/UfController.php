<?php

class UfController extends Zend_Controller_Action {

	public function indexAction() {
	    
		#$this->_helper->layout->disableLayout();
		#$this->_helper->layout->setLayout ( 'default' );
		
	}
	
	public function getufsregiaojsonAction()
	{ 
		$ufMapper = new Application_Model_UfMapper();
		$result = $ufMapper->getCampoInputRegiao($this->getRequest()->getPost('valores'));
		echo json_encode(array('dados' => $result));
		exit();
		#echo '<pre>'; print_r($result); exit();
		#$this->_helper->viewRenderer->setNoRender();
	}
    
}
