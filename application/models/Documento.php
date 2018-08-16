<?php

class Application_Model_Documento {
	
	private $ID_DOCUMENTO;
	private $NUMERO;
	private $DESCRICAO;
	private $DATA_DOCUMENTO;
	private $LOCAL_ID;
	private $DATA_CADASTRO;
	private $ATIVO;
	
	public function __construct($ID_DOCUMENTO, $NUMERO, $DESCRICAO, $DATA_DOCUMENTO, $LOCAL_ID, $DATA_CADASTRO, $ATIVO) {
		
	}
	
	/*
	 * GETTERS
	*/
	
	/* public function getIdDocumento() {
		return $this->ID_DOCUMENTO;
	} */
	
	public function __get($name) {
	    $method = 'get'.$name;
	    return $this->$method();
	}
	
	/*
	 * SETTERS
	*/
	
	/* public function setIdDocumento($ID_DOCUMENTO) {
		$this->ID_DOCUMENTO = $ID_DOCUMENTO;
	} */
	
	public function __set($name, $value) {
	    $method = 'set'.$name;
	    $this->$method($value);
	}
	
	
}