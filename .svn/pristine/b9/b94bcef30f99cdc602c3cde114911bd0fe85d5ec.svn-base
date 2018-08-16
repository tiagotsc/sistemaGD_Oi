<?php

class DocumentoController extends Zend_Controller_Action {
    
    public function criarAction() {
        
        $this->_helper->layout->disableLayout();
    	
        $formDocumento = new Application_Form_Documento();
        $formDocumento->criar();
        
        $ufMapper = new Application_Model_Mapper_UF();
        $formDocumento->slcUF->addMultiOption('','Selecione')->addMultiOptions($ufMapper->buscarUFs());
        
        $cidadeMapper = new Application_Model_Mapper_Cidade();
        $formDocumento->slcCidade->addMultiOptions($cidadeMapper->buscarCidades());
        
        $this->view->numeros = array(1, 2, 3);
        $this->view->letras = array('a', 'b', 'c');
        $this->view->formDocumento = $formDocumento;
        
    }
    
    public function processarcriarAction() {
        
        $this->_helper->layout->disableLayout();
        $params = $this->_request->getParams();
        
        try {
            
        } catch (Exception $e) {
            
        }
        
    }
    
    public function consultarAction() {
        
        $this->_helper->layout->disableLayout();
        
    }    
        
}

