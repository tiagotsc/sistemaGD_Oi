
<?php
class PluginAcl extends Zend_Controller_Plugin_Abstract {
    
    private $_auth;
    private $_acl;
    
    // Setando o modulo quando nao tem usuario logado
    //private $_noauth = array('module' => 'default','controller' => 'index','action' => 'index');
    
    // Setando o modulo quando nao tem permissao de acesso
    private $_noacl = array ('module' => 'default', 'controller' => 'error', 'action' => 'semautorizacao' );
    
    // Setando o modulo para indisponibilidade do preenchimento do questionario
    private $_userBloqueado = array ('module' => 'default', 'controller' => 'error', 'action' => 'usuariobloqueado' );
    
    public function __construct($auth, $acl) {
        $this->_auth = $auth;
        $this->_acl = $acl;
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        
    	try {
    		
	        $bOk = 'false';
	        $bloqueado = 'false';
	        // Verifica se tem usuario logado
	        if ($this->_auth->hasIdentity ()) {
	            // Caso tenha, pega dados do usuario
	            $identity = $this->_auth->getIdentity();
	            if(isset($identity['perfis'])) {
	                $value = $identity['perfis'];
	                if (!$this->_acl->isAllowed($value, strtolower($request->controller), strtolower($request->action))) {
	                    // Usuario nao tem permissao ao resource
	                    // Verifica o motivo dele nao ter permissao
	                    // Verifica se est� logado
	                    if (!$this->_auth->hasIdentity()) {
	                        //Nao est� logado, logo nao tem permissao
	                        header ( "location:http://localhost" );
	                    }
	                }else {
	                    $bOk = 'true';
	                }
	            }else{
	                $roles = '';
	                $bOk = 'false';
	                $bloqueado = 'true';
	            }
	
	            if(!$this->_acl->has(strtolower($request->controller))) {
	                $resource = null;
	            }
	
	            if ($bOk == 'false') {
	                if ($bloqueado == 'true'){
	                    $request->setModuleName($this->_userBloqueado['module']);
	                    $request->setControllerName($this->_userBloqueado['controller']);
	                    $request->setActionName($this->_userBloqueado['action']);
	                }else{
	                    $request->setModuleName($this->_noacl['module']);
	                    $request->setControllerName($this->_noacl['controller']);
	                    $request->setActionName($this->_noacl ['action']);
	                }
	            }else {
	                $request->setModuleName(strtolower($request->module));
	                $request->setControllerName(strtolower($request->controller));
	                $request->setActionName(strtolower($request->action));                    
	            }
	        } else {
	            header("location:http://localhost");    
	        }
    	} catch (Exception $e) {
    		throw $e;
    	}
    }
}
