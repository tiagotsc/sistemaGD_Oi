<?php

class Documentotipo {
	
	private $ID;
	private $NOME;
	private $ATIVO;
	
	public function getId()
	{
		return $this->ID;
	}
	
	public function setId($ID)
	{
		$this->ID = $ID;
		return $this;
	}
	
	public function getNome()
	{
		return $this->NOME;
	}
	
	public function setNome($NOME)
	{
		$this->NOME = $NOME;
		return $this;
	}
	
	public function getAtivo()
	{
		return $this->ATIVO;
	}
	
	public function setAtivo($ATIVO)
	{
		$this->ATIVO = $ATIVO;
		return $this;
	}
	
}