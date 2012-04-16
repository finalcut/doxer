<?php
	namespace marshall\core;

	class MenuItem extends \marshall\core\NonPersistentBean
	{
		// example of how to create your own constructor while calling the parent constructor
		public function __construct(){
			parent::__construct();
		}

		static function compare($a, $b){
			return $a->sort_order == $b->sort_order ? strcmp($a->name, $b->name) : $a->sort_order > $b->sort_order;
		}

		/* 
			all classes that extend bean must define this method.
			basically, instead of creating getters and setters for each property
			of the class and then having a constructor that sets the defaults this
			method must exist and it will happen automatically
		*/


		public function addMenuItem($menuItem){
			array_push($this->children, $menuItem);
			usort($this->children, array("\marshall\core\MenuItem","compare"));
		}		

		public function getDefaults(){
			return array(
				 'name'=>""
				,'root_path'
				,'icon'=>""
				,'children'=>array()
				,'sort_order'=>10

			);
		}
	}