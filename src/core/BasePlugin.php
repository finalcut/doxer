<?php
	/*
		basic controller class.  All other controller classes SHOULD extend this class as it provides some useful helper methods
		that each controller will probably need.
	*/ 
	namespace marshall\core;

	abstract class BasePlugin {
		/*
			 if you override the constructor in your class; please make sure you call this one too. ex:
			 parent::BasePlugin();
		*/
		function __construct(){
			$this->addMenuItems();
		}
		 
		abstract function addMenuItems();

		 abstract function getPluginName();


		function dump($val){
			print_r("<pre>");
			print_r($val);
			print_r("</pre>");
		}

	}
?>