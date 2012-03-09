<?php
	include_once 'bean.php';
	class User extends NonPersistentBean
	{
		// example of how to create your own constructor while calling the parent constructor
		public function User($libraryName){
			parent::NonPersistentBean();
			$this->libraryName = $libraryName;
		}


		public function getDefaults(){
			return array(
					'libraryName' =>""
			);
		}
	}
?>