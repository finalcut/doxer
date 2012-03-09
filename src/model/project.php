<?php
	include_once 'bean.php';
	include_once 'section.php';
	class Project extends NonPersistentBean
	{
		// example of how to create your own constructor while calling the parent constructor
		public function Project(){
			parent::NonPersistentBean();
		}

		/* 
			all classes that extend bean must define this method.
			basically, instead of creating getters and setters for each property
			of the class and then having a constructor that sets the defaults this
			method must exist and it will happen automatically
		*/

		public function addSection($section){
			array_push($this->sections,$section);
		}


		public function getDefaults(){
			return array(
				 'id'=>""
				,'name'=>""
				,'description_md'=>""
				,'description_html'=>""
				,'sections'=>array()
			);
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

			$sections = array();
				foreach($a["sections"] as $sec){
					$s = $sec->toArray();
					array_push($sections,$s);
				}
			$a["sections"] = $sections;
			return $a;
		}
	}