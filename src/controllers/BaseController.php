<?php
	/*
		basic controller class.  All other controller classes SHOULD extend this class as it provides some useful helper methods
		that each controller will probably need.
	*/ 

	function __autoload($class_name){
		include $class_name . '.php';
	}

	require_once("model/session.php");
	require_once("db/gatewayFactory.php");
	class BaseController {
		public $session;

		function beforeRoute(){
			// gets executed before the current route..
			$this->session = new Session();

			$config = F3::get('dbsettings');
			$factory = new GatewayFactory();
			$db = $factory->GetProjectGateway($config);



			F3::set('libraries', $db->getLibraries());

			// load all the projects avaiable..


			F3::set('html_title', 'BEFORE');
		}

		function afterRoute(){
			// gets executed after the current route..
		}
		/* if you need to include one or more script files in your site pass them into this funciton.
		the scripts will be added to the bottom of the site (for faster page load) and will also be included AFTER 
		jquery and bootstrap so that all of the methods within those scripts are available to your scripts.

		Scripts will be made available in the order they are added to this function.  Check /views/layout/footer.html to
		see how they are included.
		*/
		function addScript($scriptFile){
			$this->addScriptFile($scriptFile,"scripts");
		}


		/*
			if you need to include one ore more javascript files in yoru site but you want to use F3 variables within those javascript
			files then use this function.  This file will be rendered on the server before being returned.  It basically works just like
			addScript above.  

			NOTE:  rendered scripts are returned before non-rendered scripts and in the order they are added to this function
			see /views/layout/footer.html 
		*/
		function addf3Script($scriptFile){
			$this->addScriptFile($scriptFile,"f3scripts");
		}

		private function addScriptFile($scriptFile, $key){
			$scripts = F3::get($key);
			array_push($scripts,$scriptFile);
			F3::set($key, $scripts);
		}


		// basically makes it so the content returned can't be cached since it is already outdated.
		function writeNoCacheHeaders(){
			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		}

		// tells the browser what is coming back is json and not html
		function writeJsonHeaders(){
			$this->writeNoCacheHeaders();
			header('Content-type: application/json');
		}

		// tells the browser what is coming back is javascript..
		function writeJavascriptHeaders(){
			$this->writeNoCacheHeaders();
			header('Content-type: text/javascript');
		}


		function dump($var){
			print_r("<pre>");
			print_r($var);
			print_r("</pre>");
		}

	}
?>