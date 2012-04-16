<?php
	
	namespace doxer\plugins\library\model;
	use marshall\core\NonPersistentBean as NonPersistentBean;

	class Library extends NonPersistentBean
	{
		// example of how to create your own constructor while calling the parent constructor
		public function __construct($name){
			parent::__construct();
			$this->name = $name;
			$this->oldname = $name;
		}
		static function compare($a, $b){
			return strcmp($a->name, $b->name); // fall bck
		}


		public function getDefaults(){
			return array(
					'name' =>"",
					'oldname'=>""
			);
		}
	}
?>