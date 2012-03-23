<?php

	namespace doxer\model;
	use marshall\model\NonPersistentBean as NonPersistentBean;
	
	class User extends NonPersistentBean
	{
		// example of how to create your own constructor while calling the parent constructor
		public function __construct($libraryName){
			parent::__construct();
			$this->libraryName = $libraryName;
		}


		public function getDefaults(){
			return array(
					'libraryName' =>""
			);
		}
	}
?>