<?php
header("Content-type: text/html; charset=utf-8");
/******************************************************************
                        Constantes de Configuração
********************************************************************/

defined('PERFIL_ADM') || define('PERFIL_ADM',1); // Administrador
defined('PERFIL_SOL') || define('PERFIL_SOL',6); // Solicitante
defined('PERFIL_EQU') || define('PERFIL_EQU',9); // Equipe

// Título da aplicação
defined('APPLICATION_TITLE') || define('APPLICATION_TITLE', 'Sistema GD');

// Sistema operacional do servidor
defined('OS') || define('OS', (stripos($_SERVER["SERVER_SOFTWARE"], "win32") == TRUE ? "WINDOWS" : "UNIX"));

// Tipo de barra a utilizar de acordo com o sistema
defined('BAR') || define('BAR', (OS == "WINDOWS" ? "\\" : "/"));

// Separador de caminhos de acordo com o sistema
defined('PATH_SEPARATOR') || define('PATH_SEPARATOR', (OS == "WINDOWS" ? ";" : ":"));

// Caminho completo para a pasta da aplicação    
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__).BAR.'..'));
#defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Nome da aplicação
defined('APPLICATION_NAME') || define('APPLICATION_NAME', ltrim(strrchr(APPLICATION_PATH, BAR), BAR));

// Ambiente da aplicação
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));
#define('APPLICATION_ENV',($_SERVER['HTTP_HOST'] == 'localhost')? 'development':'production');

// Caminhos da aplicação
// defined('CAMINHO_SISTEMA') || define('CAMINHO_SISTEMA','/aplicacao/'.APPLICATION_NAME.'/public/index.php');
defined('ROOT_PATH') || define('ROOT_PATH', '/aplicacao/'.APPLICATION_NAME.'/public');
defined('LIBRARY_PATH') || define('LIBRARY_PATH', '/biblioteca');
defined('INTERNAL_LIBRARY_PATH') || define('INTERNAL_LIBRARY_PATH', '/aplicacao/'.APPLICATION_NAME.'/library');
defined('UPLOAD_FILES_PATH') || define('UPLOAD_FILES_PATH', '/doc/aplicacao/'.APPLICATION_NAME.'/');

// Endereço do PortalDO de produção
defined('PRODUCTION_PATH') || define('PRODUCTION_PATH', 'http://portaldo.intranet');


/******************************************************************
                    Constantes da Aplicação
********************************************************************/

// ATIVO/INATIVO
defined('COD_ATIVO') || define('COD_ATIVO', 1);
defined('COD_INATIVO') || define('COD_INATIVO', 0);

// PERFIS
defined('COD_PERFIL_ADMINISTRADOR') || define('COD_PERFIL_ADMINISTRADOR', 1);
defined('COD_PERFIL_DIAGNOSTICO') || define('COD_PERFIL_DIAGNOSTICO', 11);
defined('COD_PERFIL_CONVIDADO') || define('COD_PERFIL_CONVIDADO', 13);


/******************************************************************
                        Inicialização do Zend
********************************************************************/

/* set_include_path(implode(PATH_SEPARATOR,
        array(
            realpath(APPLICATION_PATH . '/../../biblioteca/php/zend/zend-1.11.11/'),
            realpath(APPLICATION_PATH . '/controllers'),
            get_include_path(),))); */

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/../../biblioteca/php/zend/zend-1.11.11'),
    realpath(APPLICATION_PATH . '/controllers'),
    realpath(APPLICATION_PATH . '/models'),
    get_include_path(),
)));


require_once 'Zend/Application.php';

$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '../../../../config/configSistemaGD.ini'
);

$application->bootstrap()->run();
