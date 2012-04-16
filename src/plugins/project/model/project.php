<?php

	namespace doxer\model;
	use marshall\model\NonPersistentBean as NonPersistentBean;

	class Project extends NonPersistentBean
	{
		// example of how to create your own constructor while calling the parent constructor
		public function __construct(){
			parent::__construct();
		}

		/* 
			all classes that extend bean must define this method.
			basically, instead of creating getters and setters for each property
			of the class and then having a constructor that sets the defaults this
			method must exist and it will happen automatically
		*/

		public function addSection($section){
			//$this->sections[$section->uuid] = $section;
			array_push($this->sections, $section);
		}


		public function initPropertiesFromArray($ary){
			parent::initPropertiesFromArray($ary);
			$this->sections = array();
			if(isset($ary["sections"])){
				foreach($ary["sections"] as $s){
					$section = new Section();
					$section->initPropertiesFromArray($s);
					$this->addSection($section);
				}
			}
		}

		public function toArray(){
			$a = parent::toArray();


			return $a;
		}


		public function getDefaults(){
			return array(
				'_id'=>""
				,'name'=>""
				,'description_md'=>""
				,'description_html'=>""
				,'type'=>"project"
				,'sections'=>array()
			);
		}
		
	}