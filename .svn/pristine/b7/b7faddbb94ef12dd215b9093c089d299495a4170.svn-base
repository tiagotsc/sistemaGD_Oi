<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	
    protected function _initCache() {
        
	    // Habilita o cache para metadados de tabelas utilizadas pelo Zend_Db
	    $cache = Zend_Cache::factory(
		                            'Core',
	                                'File',
				                    array('automatic_serialization' => true ),
				                    array('cache_dir'               => realpath("../data/cache"))
	    );
	    Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);
        
	}	
	
	protected function _initDbAdapter() {
	   
	    /********************************************************************
	           Habilita recurso de conexão com múltiplos bancos de dados
	    *********************************************************************/
	    $resource = $this->getPluginResource('multidb');
	    $resource->init();
		Zend_Registry::set("db1", $resource->getDb("db1")); // Oracle
		Zend_Registry::set("db2", $resource->getDb("db2")); // Mysql
	    #$db1 = $resource->getDb('db1');
	    #$db2 = $resource->getDb('db2');
	    #Zend_Registry::set('oracle', $db1);
	    #Zend_Registry::set('mysql', $db2);
	    
	}
    
    public function _initAcl() {
        
        $frontController = Zend_Controller_Front::getInstance();
    	$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->setFallbackAutoloader(true);
		
    	/******************************************************************
                                Sessao Global do Portal
        ******************************************************************/
        
        session_name("usuarios"); //pega a sessao do portal
        Zend_Session::start(true); //inicia a sessao GLOBAL
        Zend_Registry::set('sessao', new Zend_Session_Namespace());
        
        $demanda = new Application_Model_DemandaMapper();
        if(strpos($_SERVER['REQUEST_URI'], 'tarefaagendada') == true){
            $usuario['id_login'] 	  = 'SISTEMA';
            $usuario['nome']          = 'SISTEMA';
            $usuario['diretoria']     = 'SISTEMA';
            $usuario['perfis']        = '1';
            $usuario['email']        = 'sistema@sistema.com.br';
        
        }else{

            $dadosUsuarioSessao = $demanda->dadosUsuarioSessao($_SESSION['USUARIO']['id_login']);
            $usuario['login'] = $_SESSION['USUARIO']['id_login'];
            #$usuario['idColaborador'] = $_SESSION['USUARIO']['idColaborador'];
            $usuario['nome'] = $_SESSION['USUARIO']['nome'];
            $usuario['diretoria'] = $dadosUsuarioSessao['diretoria'];
            $usuario['email'] = $_SESSION['USUARIO']['email'];
            $usuario['perfis'] = $_SESSION['USUARIO']['aplicacoes']['appSistemaGD'];
        
        }
		
        if (APPLICATION_ENV == 'development') {
            
            $auth = Zend_Auth::getInstance();
            
            /******************************************************************
                                    Dados do Desenvolvedor
            *******************************************************************/
            $dadosUsuarioSessao = $demanda->dadosUsuarioSessao('F93103');
            $usuario['id_login'] 	  = 'F93103';
            #$usuario['idColaborador'] = '12876';
            $usuario['nome']          = 'Allan Paixão';
			$usuario['diretoria']     = $dadosUsuarioSessao['diretoria'];
            $usuario['perfis']        = '1';
			$usuario['email']        = 'allan.paixao@teste.com.br';
            
            $auth->getStorage()->write($usuario);
            $acl = new ControleAcl($auth);
            $plugin = new PluginAcl($auth, $acl);
            $frontController->registerPlugin($plugin);
                        
        } else { // production
            
            if(isset($_SESSION['USUARIO'])) {
                
                if (empty($_SESSION['USUARIO'])) {
                    
                    header("location:".PRODUCTION_PATH);
                    
                } else {
                    
                    if(!empty($_SESSION['USUARIO']['id_login']) && !empty($_SESSION['USUARIO']['nome'])) {
                        
                        $auth = Zend_Auth::getInstance();
						$dadosUsuarioSessao = $demanda->dadosUsuarioSessao($_SESSION['USUARIO']['id_login']);
                        $usuario['login'] = $_SESSION['USUARIO']['id_login'];
						#$usuario['idColaborador'] = $_SESSION['USUARIO']['idColaborador'];
                        $usuario['nome'] = $_SESSION['USUARIO']['nome'];
						$usuario['diretoria'] = $dadosUsuarioSessao['diretoria'];
						$usuario['email'] = $_SESSION['USUARIO']['email'];
                        $usuario['perfis'] = $_SESSION['USUARIO']['aplicacoes']['appSistemaGD'];
                        $auth->getStorage()->write($usuario);
                        $acl = new ControleAcl($auth);
                        $plugin = new PluginAcl($auth, $acl);
                        $frontController->registerPlugin($plugin);
                                                
                    } else {
                        
                        header("location:".PRODUCTION_PATH);
                        
                    }
                    
                }
                
            } else {
                
                header("location:".PRODUCTION_PATH);
                
            }
            
        }
        
    }
    
    public function _initView() {
        
    	$this->bootstrap("layout");
    	$layout = $this->getResource("layout");
    	$view = $layout->getView();
    	$view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
    	//$view->jQuery()->addStylesheet("css/start/jquery-ui-1.9.2.custom.css")
    	               //->setLocalPath('js/jquery-1.8.3.js')
    	               //->setUiLocalPath("js/jquery-ui-1.9.2.custom.min.js");
        
    	$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
    	$viewRenderer->setView($view);
    	Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
    	
    }
	
	protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Application',
            'basePath'  => APPLICATION_PATH,
        ));
        
        return $autoloader;
    }
	
	/**
	* _initHelpers
	*
	* @desc Sets alternative ways to helpers
	*/
	protected function _initHelpers()
	{
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
		$viewRenderer->initView();
	 
		// add zend view helper path
		$viewRenderer->view->addHelperPath(APPLICATION_PATH.BAR.'library'.BAR.'ZF'.BAR.'View'.BAR.'Helper'.BAR);
	 
		// add zend action helper path
		Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH.BAR.'library'.BAR.'ZF'.BAR.'Controller'.BAR.'Helper'.BAR);
	}
    
}