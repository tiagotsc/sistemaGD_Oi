<?php

class DemandaController extends Zend_Controller_Action {

	public function init() // called always before actions  
    {  
		$this->pasta_upload = 'demanda_anexo'; # HOMOLOGAÇÃO / PRODUÇÃO
		$this->destino_upload = UPLOAD_FILES_PATH.$this->pasta_upload.'/'; # HOMOLOGAÇÃO / PRODUÇÃO
		#$this->destino_upload = '/doc/aplicacao/demanda/demanda_anexo/'; # DESENVOLVIMENTO
        $this->Demanda = new Application_Model_DemandaMapper(); // DbTableMapper
		$this->LogAtividade = new Application_Model_LogatividadeMapper(); // DbTableMapper
		$this->modalidades = $this->getRequest()->getPost('MODALIDADE_TIPO');
		$this->ufs = $this->getRequest()->getPost('UF');
        $this->regioes = $this->getRequest()->getPost('REGIAO_ID');
		$camposTextArea = array('DESCRICAO', 'OBICE_DESCRICAO', 'OBSERVACAO', 'MOTIVO');
		$camposData = array('PRAZO', 'PRAZO_CONSIDERADO', 'DATA_ANTERIOR', 'DATA_ATUAL');
		$camposApagar = array('SGD_MASCARA','MODALIDADE_TIPO', 'UF', 'DILACAO' , 'REGIAO_ID');
		
		if(count($_POST)> 0){
			foreach($_POST as $c => $v){
				if(in_array($c, $camposTextArea)){
					$_POST[$c] = substr(addslashes($_POST[$c]),0, 999);
				}elseif(in_array($c, $camposData)){
					$_POST[$c] = new Zend_Db_Expr("TO_DATE('".implode('/',array_reverse(explode('/',$_POST[$c])))."','yyyy-mm-dd')");
				}else{
					$_POST[$c] = $_POST[$c];
				}
				if(in_array($c, $camposApagar)){
					unset($_POST[$c]);
				}
			}
		}
    }
	
	/*
	Tela de pesquisa
	*/
	public function indexAction()
	{
		$msg = ($this->_helper->flashMessenger->getMessages()? $this->_helper->flashMessenger->getMessages(): '');
		$this->view->status = $msg[0];
		$this->view->formElementos = $this->formulario('pesq');
		#$this->render('index'); // renderiza a view informada
		
	}
	
	/*
	Converte a consulta de grupo de demanda para JSON
	*/
	public function getdemandasjsonAction()
	{#$_POST['valores'] = "DATA_CADASTRO_DT_INI=01/06/2018&DATA_CADASTRO_DT_FIM=23/06/2018&DILACAO=S&VENCIDA=N&DATA_CONCLUSAO_DT_INI=23/06/2018";
		#$_POST['valores'] = "DATA_CADASTRO_DT_INI=01/06/2017";
        $condicao = $this->_helper->getHelper('Demanda')->montaCondicaoQueryPesq($_POST['valores']); 
		if(isset($condicao[0]) and $condicao[0] != ''){
			$dados = $this->Demanda->getDemandas($condicao);
		}else{
			$dados = array();
		}
		if(count($dados) > 0){
			echo json_encode(array('data' => $dados));
		}else{
			echo json_encode(array('data'=>''));
		}
		exit();
	}
	
	/*
	Upload do arquivo 
	*/
	public function upload($id) 
	{ 
		if (!file_exists($_SERVER['DOCUMENT_ROOT'].$this->destino_upload)) {
			mkdir($_SERVER['DOCUMENT_ROOT'].$this->destino_upload, 0777, TRUE);
		}
		$destino = $_SERVER['DOCUMENT_ROOT'].$this->destino_upload;
		$adapter = new Zend_File_Transfer_Adapter_Http();
		$adapter->setDestination($destino);
		$files = $adapter->getFileInfo();
		foreach ($files as $file => $info) {
			if(count($adapter->getFileName($file)) > 0 ){ // Se existir arquivo
				$extensao = pathinfo($adapter->getFileName($file));
				$nomeAtual = basename($adapter->getFileName($file));
				$nomeNovo = $id.'_'.date('s').'_'.md5($nomeAtual).'.'.$extensao['extension'];
				$adapter->addFilter('rename', $destino . $nomeNovo);
				// file uploaded & is valid
				if (!$adapter->isUploaded($file)) continue; 
				// receive the files into the user directory
				$adapter->receive($file); // this has to be on top
				$this->Demanda->gravaArquivos($id, $nomeAtual, $nomeNovo);
			}
		}
	}
    
    public function enviaemailAction()
    {
        $tipo = $_GET['tipo'];
        switch($tipo){
            case 'demanda':
                #echo $this->_helper->getHelper('Demanda')->montacondicaoquery();
                $msg = $this->_helper->getHelper('Demanda')->msgemaildemanda(); 
            break;
            default:
                #echo $this->_helper->getHelper('Demanda')->montacondicaoquery();
                $msg = $this->_helper->getHelper('Demanda')->msgemaildilatacao(); 
        }
        echo $msg;
        exit();
    }
	
	/*
	Consulta uma única demanda
	*/
	public function getdemanda()
	{	#$_POST['ID'] = '4488';
		if(!isset($_POST['ID']) and !isset($_POST['NUMERO_SGD'])){
			return array();
		}

		#$_POST['NUMERO_SGD'] = '201806029';
		if(isset($_POST['ID']) and $_POST['ID'] != ''){
			$campo = 'ID';
			$valor = $this->getRequest()->getPost('ID');
		}else{
			$campo = 'NUMERO_SGD';
			$valor = $this->getRequest()->getPost('NUMERO_SGD');
		}
		$dados = $this->Demanda->getDemanda($campo.' = '.$valor);
		if($dados != ''){
			$resp['dados'] = $dados;
			$resp['demandado'] = $this->Demanda->getDemandados('DEMANDA_ID = '.$dados['ID']);
            $resp['dilatacoes'] = $this->Demanda->datasDilatacao('DEMANDA_ID = '.$dados['ID']);
			$resp['modalidades'] = $this->Demanda->getModalidades('DEMANDA_ID = '.$dados['ID']);
			$resp['ufs'] = $this->Demanda->getUfs('DEMANDA_ID = '.$dados['ID']); 
            $resp['regioes'] = $this->Demanda->getRegioes('DEMANDA_ID = '.$dados['ID']); 
			$resp['anexos'] = $this->Demanda->getAnexos('DEMANDA_ID = '.$dados['ID']);
			$resp['localfile'] = $this->destino_upload;
		}else{
			$resp = array();
		}
		return $resp;

	}
	
	public function visualizarAction()
	{
		#$this->_helper->layout->disableLayout(); // Desativa o layout
		#$id = $this->getRequest()->getParam('id');
		
		$this->_helper->layout->setLayout('nolayout');
		//$this->_helper->layout->disableLayout();
		$id = $this->getRequest()->getParam('valores');
		
		if($id and !$this->Demanda->verificaId($id)){
			$this->_helper->flashMessenger->addMessage("alert alert-warning|Demanda inexistente!");
			return $this->_helper->redirector('index');
		}
		$dados = $this->Demanda->getDemandas(array('DE.ID = '.$id));
		$this->view->valores = $dados[0];
		$this->view->anexos = $this->Demanda->getAnexos('DEMANDA_ID = '.$id);
		$this->view->logDemanda = $this->LogAtividade->getLogDemanda($id);
		#$this->view->localfile = substr($this->destino_upload, 0, -1);
		$this->view->localfile = $this->destino_upload;
	}
	
	/*
	Apaga o aruquivo anexado
	*/
	public function apagaanexoAction()
	{
		if(!isset($_POST['id']) and !isset($_POST['file'])){
			exit();
		}
		$res = $this->Demanda->apagaArquivo($this->getRequest()->getPost('id'));
		if($res){
			@unlink($_SERVER['DOCUMENT_ROOT'].$this->destino_upload.$this->getRequest()->getPost('file'));
			$status = 'ok';
		}else{
			$status = 'erro';
		}
		echo json_encode(array('status' => $status));
		exit();
	}
	
	/*
	Converte a consulta de uma única demanda em JSON
	*/
	public function getdemandajsonAction()
	{
		$dados = $this->getdemanda();
		if(count($dados) > 0){
			echo json_encode($dados);
		}else{
			echo json_encode(array('dados'=>''));
		}
		exit();
	}
	
	/*
	Formulário de demanda
	*/
	public function formulario($tipoFrm = 'frm'){
		
		$documentotipoMapper = new Application_Model_DocumentotipoMapper();
		$classificacaoMapper = new Application_Model_ClassificacaoMapper();
		$modalidadetipoMapper = new Application_Model_ModalidadetipoMapper();
		$regiaoMapper = new Application_Model_RegiaoMapper();
		$UFMapper = new Application_Model_UfMapper();
		$StatusMapper = new Application_Model_StatusMapper();
        $fatorgeradorMapper = new Application_Model_FatorgeradorMapper();
		#print_r($documentotipoMapper->fetchAll()); 
		#print_r($classificacaoMapper->getCampoInput());
		#exit();
		$formElementos = new Application_Form_Demanda();
		#$formElementos->UF->addMultiOptions($UFMapper->getCampoInput());
        $formElementos->REGIAO_ID->multiple = 1;
		if($tipoFrm == 'pesq'){
			$formElementos->REGIAO_ID->options = array();
			$formElementos->CLASSIFICACAO_ID->options = array();
			$formElementos->CLASSIFICACAO_ID->multiple = 1;
			$formElementos->DOCUMENTO_TIPO_ID->options = array();
			$formElementos->DOCUMENTO_TIPO_ID->multiple = 1;
			$formElementos->STATUS_ID->options = array();
			$formElementos->STATUS_ID->multiple = 1;
			$formElementos->DEMANDANTE->addMultiOptions($this->Demanda->getCampoInputDemandante());
            $formElementos->DEMANDADO->options = array();
            $formElementos->DEMANDADO->addMultiOptions($this->Demanda->getCampoInputDemandado());
            $formElementos->DEMANDADO->multiple = 1;
			$formElementos->DIRETORIA->addMultiOptions($this->Demanda->getCampoInputDiretoria());
		}
		if($tipoFrm == 'frm' and isset($_GET['id'])){
			$formElementos->STATUS_ID->options = array();
		}
		$formElementos->DOCUMENTO_TIPO_ID->addMultiOptions($documentotipoMapper->getCampoInput());
		$formElementos->CLASSIFICACAO_ID->addMultiOptions($classificacaoMapper->getCampoInput());
		$formElementos->MODALIDADE_TIPO->addMultiOptions($modalidadetipoMapper->getCampoInput());
		$formElementos->REGIAO_ID->addMultiOptions($regiaoMapper->getCampoInput());
		$formElementos->STATUS_ID->addMultiOptions($StatusMapper->getCampoInput());
        $formElementos->FATOR_GERADOR_ID->addMultiOptions($fatorgeradorMapper->getCampoInput());
		return $formElementos;
		
	}
	
	/*
	Abre formulário tanto de cadastro e edição
	*/
	public function fichaAction()
	{
		#$id = $this->getRequest()->getParam('id');
        $id = $this->getRequest()->getParam('valores');
		$this->verificaIdDemanda($id);
        if($id != null){
            #$this->_helper->layout->setLayout('nolayout');
            $this->_helper->layout->disableLayout();
        }
		$msg = ($this->_helper->flashMessenger->getMessages()? $this->_helper->flashMessenger->getMessages(): '');
		$this->view->status = $msg[0];
		$this->view->id = $id;
		$this->view->formElementos = $this->formulario('frm');
		#$this->render('index'); // renderiza a view informada
	}
	
	/*
	Salva o cadastro
	*/
	public function cadastraAction()
	{ 
		set_time_limit(0);
		//$this->getRequest()->getPost('id', null); //$_POST['id']
		//$this->getRequest()->getParam('key'); // $_GET['key']
        $numero = $this->Demanda->geraNumero(date('Ym'));
		$dados = $this->getRequest()->getPost();
		$dados += array('NUMERO_SGD' => $numero);
        
		try {
			$this->Demanda->begin();
			$this->Demanda->insert($dados);
			$id = $this->Demanda->ultimoId();
			$this->Demanda->gravaModalidades($id, $this->modalidades);
			$this->Demanda->gravaUfs($id, $this->ufs); 
            $this->Demanda->gravaRegioes($id, $this->regioes);
			$this->upload($id);
			$this->LogAtividade->gravaLog('Cadastro Demanda', 'Cadastro',$id);
			$this->Demanda->commit();
			$this->_helper->flashMessenger->addMessage("alert alert-success|Gravado com sucesso! Número SGD: ".$numero);
		} catch (Exception $e){
			$this->Demanda->rollback();
			$this->_helper->flashMessenger->addMessage("alert alert-danger|Erro ao gravar! Se o erro persistir, entre em contato com o administrador.");
			#echo $e->getMessage();
		}
		return $this->_helper->redirector('ficha');
	}
	/*
	Salva a edição
	*/
	public function editarAction()
	{	
		set_time_limit(0); 
		$id = $this->getRequest()->getPost('ID');
		$numero = $_POST['NUMERO_SGD'];
        $this->_helper->getHelper('Demanda')->unsetPost(array('ID','NUMERO_SGD','DATA_CADASTRO','DEMANDADO'));
		$dados = $this->getRequest()->getPost();
		$status = 'erro';
  
		try {
			$this->Demanda->begin();
			$this->Demanda->update($dados, $id);
			$this->Demanda->gravaModalidades($id, $this->modalidades);
			$this->Demanda->gravaUfs($id, $this->ufs);
            $this->Demanda->gravaRegioes($id, $this->regioes);
			$this->upload($id);
			$this->LogAtividade->gravaLog('Alteração Demanda', 'Alteração',$id); 
			$this->Demanda->commit();
            $status = 'ok';
			#$this->_helper->flashMessenger->addMessage("alert alert-success|Alterada com sucesso! Número SGD: ".$numero);
		} catch (Exception $e){
			$this->Demanda->rollback();
            $status = 'erro';
			#$this->_helper->flashMessenger->addMessage("alert alert-danger|Erro ao alterar! Se o erro persistir, entre em contato com o administrador.");
			#echo $e->getMessage();
		}
        echo json_encode(array('status' => $status, 'numero' => $numero));
        exit();
		#return $this->_helper->redirector('ficha', null, null, array('id' => $id));
	}
	
	public function delegarAction()
	{
		//$this->_helper->layout->setLayout('nolayout');
		#$_POST['valores'] = '41|ficha';
		$this->_helper->layout->disableLayout();
		
		$dadosAjax = explode('|',$this->getRequest()->getParam('valores'));
		$id = $dadosAjax[0];
		$this->verificaIdDemanda($id);
		$dados = $this->Demanda->getDemandas(array('DE.ID = '.$id));
		$formElementos = new Application_Form_Demanda();
		$formElementos->DEMANDADO->addMultiOptions($this->Demanda->getCampoDemandadoInput());
		$formElementos->DEMANDADO->setValue($dados[0]['DEMANDADO_ID']);
		
		$this->view->formElementos = $formElementos;
		$this->view->id = $id;
		$this->view->redirect = $dadosAjax[1];
		$this->view->valores = $dados[0];
		$this->view->anexos = $this->Demanda->getAnexos('DEMANDA_ID = '.$id);
		$this->view->localfile = $this->destino_upload;
		
	}
	
	public function delegarsalvarAction()
	{
        $status = 'erro';
		$id = $this->getRequest()->getPost('ID');
		try {
			$this->Demanda->begin();
			$this->Demanda->delegarSalvar($this->getRequest()->getPost('DEMANDADO'),$this->getRequest()->getPost('NOME'),$id);
			$this->Demanda->update(array('STATUS_ID' => 2), $id);
			$this->LogAtividade->gravaLog('Delegação de Demanda', 'Delegação',$id);
			$this->Demanda->commit();
			#$this->_helper->flashMessenger->addMessage("alert alert-success|Demandado associado com sucesso!");
            $status = 'ok';
		} catch (Exception $e){
            $this->Demanda->rollback();
            $status = 'erro';
			#$this->_helper->flashMessenger->addMessage("alert alert-danger|Erro ao associar demandado! Se o erro persistir, entre em contato com o administrador.");
			#echo $e->getMessage();
		}
		echo json_encode(array('status' => $status));
        exit();
		#$destino = $this->getRequest()->getPost('redirect');
		#$params = ($destino == 'ficha')? array('id' => $this->getRequest()->getPost('ID')): array();
		// Action, controller, módulo, parâmetros
		#return $this->_helper->redirector($destino, null, null, $params);
	}
	
	public function tratarAction()
	{
		$this->_helper->layout->disableLayout();
		$id = $this->getRequest()->getParam('valores');
		$this->verificaIdDemanda($id);
		$dados = $this->Demanda->getDemanda('ID = '.$id);
		$formElementos = new Application_Form_Demanda();
		$StatusMapper = new Application_Model_StatusMapper();
		$formElementos->STATUS_CONCLUSAO->addMultiOptions($StatusMapper->getCampoInput(' AND ID IN(4,5)'));
        $formElementos->STATUS_CONCLUSAO->setValue($dados['STATUS_ID']);
		
		$dados = $this->Demanda->getDemandas(array('DE.ID = '.$id));
		$this->view->ID = $id;
		$this->view->valores = $dados[0];
		$this->view->anexos = $this->Demanda->getAnexos('DEMANDA_ID = '.$id);
		$this->view->logDemanda = $this->LogAtividade->getLogDemanda($id);
		$this->view->localfile = $this->destino_upload;
        $this->view->dilatacoes = $this->Demanda->datasDilatacao('DEMANDA_ID = '.$id);
		$this->view->formElementos = $formElementos;
	}
	
	public function tratarsalvarAction()
	{
        $status = 'erro';
		$id = $this->getRequest()->getPost('ID');
		$dtConc = new Zend_Db_Expr("TO_DATE('".date('Y/m/d')."','yyyy-mm-dd')");
		try {
			$this->Demanda->begin();
			$this->Demanda->update(array('DATA_CONCLUSAO' => $dtConc,'STATUS_ID' => $this->getRequest()->getPost('STATUS_CONCLUSAO')), $id);
			$this->upload($id);
			$this->LogAtividade->gravaLog('Tratamento de Demanda', 'Tratamento',$id);
			$this->Demanda->commit();
            $status = 'ok';
			#$this->_helper->flashMessenger->addMessage("alert alert-success|Demanda tratada com sucesso!");
		} catch (Exception $e){
            $this->Demanda->rollback();
            $status = 'erro';
			#$this->_helper->flashMessenger->addMessage("alert alert-danger|Erro ao tratar demanda! Se o erro persistir, entre em contato com o administrador.");
			#echo $e->getMessage();
		}
        echo json_encode(array('status' => $status));
        exit();
		// Action, controller, módulo, parâmetros
		#return $this->_helper->redirector('index', null, null, array());
	}
    
    public function reabrirAction()
	{
		$this->_helper->layout->disableLayout();
		$id = $this->getRequest()->getParam('valores');
		$this->verificaIdDemanda($id);
		$dados = $this->Demanda->getDemandas(array('DE.ID = '.$id));
		$formElementos = new Application_Form_Demanda();
        $formElementos->DEMANDADO->addMultiOptions($this->Demanda->getCampoDemandadoInput());
		$formElementos->DEMANDADO->setValue($dados[0]['DEMANDADO_ID']);
		$dados = $this->Demanda->getDemandas(array('DE.ID = '.$id));
		$this->view->ID = $id;
		$this->view->valores = $dados[0];
		$this->view->logDemanda = $this->LogAtividade->getLogDemanda($id);
        $this->view->dilatacoes = $this->Demanda->datasDilatacao('DEMANDA_ID = '.$id);
		$this->view->formElementos = $formElementos;
	}
    
    public function reabrirsalvarAction()
    {#echo '<pre>'; print_r($_POST); echo '<br>'; print_r($_FILES); exit();
        $status = 'erro';
        $id = $this->getRequest()->getPost('ID');
        $dilacoes = $this->getRequest()->getPost('dilacao');
        $demandado_id = $this->getRequest()->getPost('DEMANDADO');
        $demandado_nome = $this->getRequest()->getPost('NOME');
        $this->_helper->getHelper('Demanda')->unsetPost(array('dilacao','DEMANDADO','NOME','ID'));
        $_POST['STATUS_ID'] = 2;
        try {
			$this->Demanda->begin();
            $this->Demanda->update($this->getRequest()->getPost(), $id);
            $this->Demanda->delegarSalvar($demandado_id, $demandado_nome, $id);
            $this->Demanda->updateDilacoes($dilacoes, $id);
            $this->LogAtividade->gravaLog('Reabertura de Demanda', 'Reabertura',$id);
			$this->Demanda->commit();
			#$this->_helper->flashMessenger->addMessage("alert alert-success|Reaberto com sucesso!");
            $status = 'ok';
		} catch (Exception $e){
            $this->Demanda->rollback();
			#$this->_helper->flashMessenger->addMessage("alert alert-danger|Erro ao reabrir demanda! Se o erro persistir, entre em contato com o administrador.");
			#echo $e->getMessage();
            $status = 'erro';
		}
        echo json_encode(array('status' => $status));
        exit();
		// Action, controller, módulo, parâmetros
		#return $this->_helper->redirector('ficha', null, null, array('id' => $id));
            
    }
	
	public function dilatarAction()
	{
		$this->_helper->layout->disableLayout();
		$id = $this->getRequest()->getParam('valores');
		$this->verificaIdDemanda($id);
		$dados = $this->Demanda->getDemandas(array('DE.ID = '.$id));
		$this->view->ID = $id;
        $this->view->dilatacoes = $this->Demanda->datasDilatacao('DEMANDA_ID = '.$id);
		$this->view->valores = $dados[0];
	}
	
	public function dilatarsalvarAction()
	{
        $status = 'erro';
        $this->_helper->getHelper('Demanda')->unsetPost(array('NUMERO_SGD'));
		$id = $this->getRequest()->getPost('DEMANDA_ID');
		$dados = $this->getRequest()->getPost();
		try {
			$this->Demanda->begin();
			$this->Demanda->insereDilacao($dados);
			$this->Demanda->update(array('PRAZO_CONSIDERADO' => $this->getRequest()->getPost('DATA_ATUAL')),$id);
			$this->LogAtividade->gravaLog('Dilatação de Demanda', $this->getRequest()->getPost('MOTIVO'),$id);
			$this->Demanda->commit();
            $status = 'ok';
			#$this->_helper->flashMessenger->addMessage("alert alert-success|Demanda dilatada com sucesso!");
		} catch (Exception $e){
            $this->Demanda->rollback();
            $status = 'erro';
			#$this->_helper->flashMessenger->addMessage("alert alert-danger|Erro ao dilatar demanda! Se o erro persistir, entre em contato com o administrador.");
			#echo $e->getMessage();
		}
        echo json_encode(array('status' => $status));
        exit();
		// Action, controller, módulo, parâmetros
		#return $this->_helper->redirector('index', null, null, array());
	}
    
    public function cancelarAction()
	{
		$this->_helper->layout->disableLayout();
		$id = $this->getRequest()->getParam('valores');
		$this->verificaIdDemanda($id);
		$dados = $this->Demanda->getDemandas(array('DE.ID = '.$id));
		$this->view->ID = $id;
		$this->view->valores = $dados[0];
	}
	
	public function cancelarsalvarAction()
	{
        $status = 'erro';
		$id = $this->getRequest()->getPost('DEMANDA_ID');
		try {
			$this->Demanda->begin();
			$this->Demanda->update(array('STATUS_ID' => 6, 'MOTIVO' => $this->getRequest()->getPost('MOTIVO')),$id);
			$this->LogAtividade->gravaLog('Cancelamento de Demanda', $this->getRequest()->getPost('MOTIVO'),$id);
			$this->Demanda->commit();
			#$this->_helper->flashMessenger->addMessage("alert alert-success|Demanda cancelada com sucesso!");
            $status = 'ok';
		} catch (Exception $e){
            $this->Demanda->rollback();
			#$this->_helper->flashMessenger->addMessage("alert alert-danger|Erro ao cancelar demanda! Se o erro persistir, entre em contato com o administrador.");
			#echo $e->getMessage();
            $status = 'erro';
		}
        echo json_encode(array('status' => $status));
        exit();
		// Action, controller, módulo, parâmetros
		#return $this->_helper->redirector('index', null, null, array());
	}
	
	// Verifica se demanda existe
	public function verificaIdDemanda($id)
	{
		if($id and !$this->Demanda->verificaId($id)){
			$this->_helper->flashMessenger->addMessage("alert alert-warning|Demanda inexistente!");
			return $this->_helper->redirector('index');
		}
	}
	
	public function testeformAction()
	{
		echo '<pre>'; print_r($_POST); exit();
	}
	
	public function infoAction(){
		phpinfo();
		exit();
	}
    
}
