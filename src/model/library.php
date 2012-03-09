<?php
	include_once 'bean.php';
	class Library extends NonPersistentBean
	{
		// example of how to create your own constructor while calling the parent constructor
		public function Library($name){
			parent::NonPersistentBean();
			$this->name = $name;
		}
		static function compare($a, $b){
			return strcmp($a->name, $b->name); // fall bck
		}


		public function getDefaults(){
			return array(
					'name' =>""
			);
		}
	}
?>