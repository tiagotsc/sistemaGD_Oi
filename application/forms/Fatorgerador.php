<?php

class Application_Form_Fatorgerador extends Zend_Form {
	
	public $elementDecorators = array (
	    'ViewHelper',
    	'Label',
		'Errors'
    );	

	public $elementDecoratorsButton = array (
	    'ViewHelper',
    );

    public function init() {
        
        $this->addElement(
        		'text','NOME',
        		array(
        				'decorators' => $this->elementDecorators,
        				'required' => false,
						'class' => 'form-control'
        		)
        );
		
		$this->addElement(
        		'select','ATIVO',
        		array(
        				'decorators' => $this->elementDecorators,
        				//'style' => 'width=178',
        				'required' => false,
						'class' => 'form-control',
						'multiOptions' => array(
                            '1' => 'Ativo',
                            '0' => 'Inativo'
						)
        		)
        );
		
    }
}