<?php

class Application_Form_Demanda extends Zend_Form {
	
	public $elementDecorators = array (
	    'ViewHelper',
    	'Label',
		'Errors'
    );	

	public $elementDecoratorsButton = array (
	    'ViewHelper',
    );

    public function init() {
    	
        #$this->setName('frmExtracao');
        #$this->setMethod('POST');

        // afetação
        
        $this->addElement(
        		'select','DOCUMENTO_TIPO_ID',
        		array(
        				'decorators' => $this->elementDecorators,
        				//'style' => 'width=178',
        				'required' => false,
						'class' => 'form-control',
						'multiOptions' => array(
							''	=> 'Selecione...',
						)
        		)
        );
        
        $this->DOCUMENTO_TIPO_ID->setRegisterInArrayValidator(false);
		
		$this->addElement(
        		'select','CLASSIFICACAO_ID',
        		array(
        				'decorators' => $this->elementDecorators,
        				//'style' => 'width=178',
        				'required' => false,
						'class' => 'form-control',
						'multiOptions' => array(
							''	=> 'Selecione...',
						)
        		)
        );
        
        $this->CLASSIFICACAO_ID->setRegisterInArrayValidator(false);
		
		$this->addElement(
        		'select','MODALIDADE_TIPO',
        		array(
        				'decorators' => $this->elementDecorators,
        				//'style' => 'width=178',
						'multiple' => true,
        				'required' => false,
						'class' => 'form-control'
        		)
        );
        
        $this->MODALIDADE_TIPO->setRegisterInArrayValidator(false);
		
		$this->addElement(
        		'select','REGIAO_ID',
        		array(
        				'decorators' => $this->elementDecorators,
        				//'style' => 'width=178',
        				'required' => false,
						'class' => 'form-control',
        		)
        );
        
        $this->REGIAO_ID->setRegisterInArrayValidator(false);
		
		$this->addElement(
        		'select','UF',
        		array(
        				'decorators' => $this->elementDecorators,
        				//'style' => 'width=178',
						'multiple' => true,
        				'required' => false,
						'class' => 'form-control',
        		)
        );
        
        $this->UF->setRegisterInArrayValidator(false);
		
		$this->addElement(
        		'select','OBICE',
        		array(
        				'decorators' => $this->elementDecorators,
        				//'style' => 'width=178',
        				'required' => false,
						'class' => 'form-control',
						'multiOptions' => array(
							''	=> 'Selecione...',
							'S' => 'Sim',
							'N' => 'Não'
						)
        		)
        );
        
        $this->OBICE->setRegisterInArrayValidator(false);
		
		$this->addElement(
        		'select','STATUS_ID',
        		array(
        				'decorators' => $this->elementDecorators,
        				//'style' => 'width=178',
        				'required' => false,
						'class' => 'form-control',
						'multiOptions' => array(
							''	=> 'Selecione...',
						)
        		)
        );
		
		$this->STATUS_ID->setRegisterInArrayValidator(false);
		
		$this->addElement(
        		'select','DEMANDANTE',
        		array(
        				'decorators' => $this->elementDecorators,
						'multiple' => true,
        				//'style' => 'width=178',
        				'required' => false,
						'class' => 'form-control'
        		)
        );
		
		$this->DEMANDANTE->setRegisterInArrayValidator(false);
		
		$this->addElement(
        		'select','DIRETORIA',
        		array(
        				'decorators' => $this->elementDecorators,
						'multiple' => true,
        				//'style' => 'width=178',
        				'required' => false,
						'class' => 'form-control'
        		)
        );
		
		$this->DIRETORIA->setRegisterInArrayValidator(false);
		
		$this->addElement(
        		'select','DEMANDADO',
        		array(
        				'decorators' => $this->elementDecorators,
        				'multiple' => false,
        				'required' => false,
						'class' => 'form-control',
						'multiOptions' => array(
							''	=> 'Selecione...',
						)
        		)
        );
        
        $this->DEMANDADO->setRegisterInArrayValidator(false);
		
		$this->addElement('radio', 'STATUS_CONCLUSAO', array(
			'label'=>'Status conclusão',
			'class' => 'form-check-label'/*,
			'multiOptions'=>array(
				'4' => 'Concluída',
				'5' => 'Female',
			),*/
		));
		
		$this->STATUS_CONCLUSAO->setRegisterInArrayValidator(false);
        
        $this->addElement(
        		'select','FATOR_GERADOR_ID',
        		array(
        				'decorators' => $this->elementDecorators,
        				//'style' => 'width=178',
        				'required' => false,
						'class' => 'form-control',
						'multiOptions' => array(
							''	=> 'Selecione...',
						)
        		)
        );
        
        $this->FATOR_GERADOR_ID->setRegisterInArrayValidator(false);
		
		/*$this->addElement(
				'radio', 'test', 
			array(
				'label'=>'Test Thing',
				'multiOptions'=>array(
					'male' => 'Male',
					'female' => 'Female',
				),
			)
		);
		
		$this->test->setRegisterInArrayValidator(false);*/
       
        
		// situação
		/*
 		$this->addElement(
			'select','slcSituacao',
			array(
					'decorators' => $this->elementDecorators,
					'style' => 'width=178',
					'multiple' => true,
					'required' => false
			)
		);
 		
		$this->slcSituacao->setRegisterInArrayValidator(false); 
		
		// data baixa SGFT
		$this->addElement(
				'text','txtDataBaixa1',
				array(
						'decorators' => $this->elementDecorators,
						'size' => '10',
						'required' => false
				)
		);
		
		$this->addElement(
				'text','txtDataBaixa2',
				array(
						'decorators' => $this->elementDecorators,
						'size' => '10',
						'required' => false
				)
		);
    	
		$this->addElement(
				'text','txtDataVal1',
				array(
						'decorators' => $this->elementDecorators,
						'size' => '10',
						'required' => false
				)
		);
		
		$this->addElement(
				'text','txtDataVal2',
				array(
						'decorators' => $this->elementDecorators,
						'size' => '10',
						'required' => false
				)
		);
		
		$this->addElement(
				'text','n_comunicado',
				array(
						'decorators' => $this->elementDecorators,
						'required' => false
				)
		);
		
		$this->addElement(
        		'select','coletado_ti',
        		array(
        				'decorators' => $this->elementDecorators,
        				'style' => 'width=178',
        				'required' => false,
						'multiOptions' => array(
							'TODOS'	=> 'Todos',
							'SIM'	=> 'Sim',
							'NAO'	=> 'Não',
						)
        		)
        );*/
		
    }
}