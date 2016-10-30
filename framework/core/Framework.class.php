<?php
class Framework{

	public static function run()
	{
		self::init();
		self::autoload();
		self::dispatch();
	}

	private static function init(){
		//define path constant
		define('DS', DIRECTORY_SEPARATOR);
		define('ROOT', getcwd().DS);
		define('APP_PATH', ROOT.'application'.DS);
		define('FRAMWORK_PATH', ROOT.'framework'.DS);
		define('PUBLIC_PATH', ROOT.'public'.DS);

		//application
		define('CONFIG_PATH', APP_PATH.'config'.DS);
		define('CONTROLLER_PATH', APP_PATH.'controller'.DS);
		define('MODEL_PATH', APP_PATH.'models'.DS);
		define('VIEW_PATH', APP_PATH.'views'.DS);

		//framework
		define('CORE_PATH', FRAMWORK_PATH.'core'.DS);
		define('DB_PATH', FRAMWORK_PATH.'database'.DS);
		define('HELPER_PATH', FRAMWORK_PATH.'helpers'.DS);
		define('LIB_PATH', FRAMWORK_PATH.'libraries'.DS);

		define('UPLOAD_PATH', PUBLIC_PATH.'uploads'.DS);

		//define platform, controller, action, for example:
		//index.php?p=admin&c=Goods&a=add
		define('PLATFORM', isset($_REQUEST['p'])?$_REQUEST['p']:'home');
		define('CONTROLLER', isset($_REQUEST['c'])?$_REQUEST['c']:'index');
		define('ACTION', isset($_REQUEST['a'])?$_REQUEST['a']:index);

		define('CURR_CONTROLLER_PATH', CONTROLLER_PATH.PLATFORM.DS);
		define('CURR_VIEW_PATH', VIEW_PATH.PLATFORM.DS);

		//load core classes
		require CORE_PATH.'Controller.class.php';
		require CORE_PATH.'Loader.class.php';
		require DB_PATH.'Mysql.class.php';
		require CORE_PATH.'Model.class.php';

		//load configure file
		$$GLOBALS['config'] = include CONFIG_PATH.'config.php';

		//start session
		session_start();
	}

	//autoloading
	private static function autoload(){
		spl_autoload_register( array(__CLASS__ , 'load'));
	}

	//define a custom load method
	private static function load($classname){
		//here simply auto load app&rsquo; s controller and model classes
		if(substr($classname, -10) == 'Controller'){
			//Controller
			require_once CURR_CONTROLLER_PATH. "$classname.class.php";
		}else if(substr($classname, -5) == 'Model'){
			require_once MODEL_PATH."$classname.class.php";
		}
	}

	//Routing and dispatching
	private static function dispatch(){
		// Instantiate the controller class and call its method
		$controller_name = CONTROLLER . 'Controller';
		$action_name = ACTION . 'Action';
		$controller = new $controller_name;
		$controller->$action_name();
	}
}
?>