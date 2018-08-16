<?php

class Application_Form_Documento extends Zend_Form {
	
	public $elementDecorators = array ('ViewHelper', 'Label', 'Errors');
	public $elementDecoratorsButton = array ('ViewHelper');
	
    public function init() {
    	
        $this->setName('frmDocumento');
        $this->setMethod('POST');
        
        // id
        $this->addElement(
        		'hidden','hdnIdDocumento',
        		array('decorators' => $this->elementDecorators)
        );
        
    }
        
    public function criar() {
        
        ////////////// bloco 1 
        
        // nome
        $this->addElement(
            'text','txtNome',
            array(
                'decorators' => $this->elementDecorators,
                'class' => 'form-control form-control-sm',
                'placeholder' => 'Nome'
            )
        );
        
        // UF
        $this->addElement(
            'select','slcUF',
            array(
                'decorators' => $this->elementDecorators,
                'class' => 'form-control form-control-sm',
                'required' => true,
                'validators' => array(
                    array('NotEmpty', true)
                )
            )
        );
        
        $this->slcUF->getValidator('NotEmpty')->setMessages(array(Zend_Validate_NotEmpty::IS_EMPTY => 'O campo UF é obrigatório!'));
        $this->slcUF->setRegisterInArrayValidator(false);
        
        // cidade
        $this->addElement(
            'select','slcCidade',
            array(
                'decorators' => $this->elementDecorators,
                'class' => 'form-control form-control-sm',
                'multiple' => true,
                'required' => false
            )
        );
        
        // data 1
        $this->addElement(
            'text','txtData1',
            array(
                'decorators' => $this->elementDecorators,
                'class' => 'form-control form-control-sm',
                'value' => date("d/m/Y"),
                'disabled' => true
            )
        );
        
        // data 2
        $this->addElement(
            'text','txtData2',
            array(
                'decorators' => $this->elementDecorators,
                'class' => 'form-control form-control-sm',
                'id' => 'datepicker',
                'placeholder' => 'Data do Documento',
                'required' => true,
                'validators' => array(
                    array('NotEmpty', true)
                )
            )
        );
        
        $this->txtData2->getValidator('NotEmpty')->setMessages(array(Zend_Validate_NotEmpty::IS_EMPTY => 'O campo Data do Documento é obrigatório!'));
        
        $this->addElement(
            'submit', 'salvar', 
            array(
                'decorators' => $this->elementDecoratorsButton,
                'class'		=> 'btn btn-success',
                'label'    => 'Salvar',
                'formmethod' => 'post'
            )
        );
        
        ////////////// bloco 2
        
        // descrição
        $this->addElement(
            'textarea','txtDescricao',
            array(
                'decorators' => $this->elementDecorators,
                'class' => 'form-control form-control-sm',
                'rows' => 2
            )
        );
        
        // radio
        $this->addElement(
            'text','rdoLetra', // js transforma em radio
            array(
                'decorators' => $this->elementDecorators,
                'class' => 'form-check-input radio'
            )
        );
        
        // checkbox
        $this->addElement(
            'checkbox','chkNumero',
            array(
                'decorators' => $this->elementDecorators,
                'class' => 'form-check-input'
            )
        );
        
    }
    
    public function consultar() {
        
    }
    
}