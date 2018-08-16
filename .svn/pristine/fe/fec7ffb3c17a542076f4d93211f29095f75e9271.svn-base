<?php

class DebugController extends Zend_Controller_Action {

	public function indexAction() {
		phpinfo();
        exit();
	}
	
	public function arquivoAction()
    {
        $arquivo = file(APPLICATION_PATH . '../../../../config/configSistemaGD.ini');
        #$arquivo = file(APPLICATION_PATH . '../../../../htdocs/aplicacao/demanda-SP3/public/index.php');
        
        #$novo = fopen("../../../../config/TESTE.ini", "w");
        
        $cont = 1;
        foreach($arquivo as $ar){
            echo (strlen($cont) == 1)? '0': ''; echo $cont++.' - | '.$ar; echo '<br>';
            #fwrite($novo, $ar);
        }
        #fclose($novo);
        exit();
    }
    
    public function sessaoAction()
    {
        echo '<pre>';
        print_r($_SESSION);
        exit();
    }
	
	public function testeAction()
	{
		echo '<pre>SESSION:<br>'; print_r($_SESSION); echo '<br><br>';
		echo 'Endreço servidor: '; print_r($_SERVER['DOCUMENT_ROOT']); echo '<br><br>';
		echo 'Constante upload: '.UPLOAD_FILES_PATH; echo '<br><br>';
		echo 'Atributo destino upload: '.$this->destino_upload; echo '<br>'; exit();
		#echo '<pre>'; print_r($this->Demanda->dadosUsuarioSessao(12876));
		#exit();
		echo $_SERVER['DOCUMENT_ROOT']; echo '<br><br>';
		echo $this->destino_upload; exit();
		
		echo UPLOAD_FILES_PATH; echo '<br><br>';
		echo BAR;echo '<br>';
		$diretorio = $_SERVER['DOCUMENT_ROOT'].UPLOAD_FILES_PATH.'teste'.BAR;
		echo $this->destino_upload; echo '<br>';
		echo $diretorio; exit();
		if (!file_exists($diretorio)) {
			mkdir($diretorio, 0777, TRUE);
		}
		exit();
		echo $this->destino_upload; echo '<br><br>';
		unlink($this->destino_upload.'65_22_f2667289050dcf334e1ee90446848bae.txt');
		exit();
		echo APPLICATION_NAME; echo '<br>'; echo '<br>';
		echo UPLOAD_FILES_PATH; exit();
		#$this->_helper->layout->disableLayout();
		#$this->render('index');
		/*if(isset($_POST['valores'])){
			$valores = array();
			parse_str($_POST['valores'],$valores);
			echo '<pre>';
			print_r($valores);
		}
		echo '<br><br>----------------------------------------<br><br>';
		
		$condicao = $this->_helper->getHelper('Demanda')->montaCondicaoQueryPesq($_POST['valores']); 
		echo '<pre>';
		print_r($_POST['valores']); echo '<br><br>';
		print_r($condicao); exit();*/
		#$dados = $this->Demanda->getDemandas($condicao);
	}
    
}
