<?php

	namespace doxer\model;
	use marshall\model\NonPersistentBean as NonPersistentBean;
	
	class Section extends NonPersistentBean
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

		static function compare($a, $b){
			if($a->order_ind == $b->order_ind){
				return strcmp($a->name, $b->name); // fall bck
			}
				
			return ($a->order_ind < $b->order_ind) ? -1 : 1;
		}

		public function moveChild($from, $to){
			//TODO:
		}


		public function addChildSection($section){
			//$this->sections[$section->uuid] = $section;
			array_push($this->sections, $section);
		}


		public function toArray(){
			$a = parent::toArray();

			$sections = array();
				foreach($a["sections"] as $sec){
					$s = $sec->toArray();
					//$sections[$s-uuid] = $s;
					array_push($sections, $s);
				}
			$a["sections"] = $sections;
			return $a;
		}


		public function getDefaults(){
			return array(
				 '_id'=>""
				,'name'=>""
				,'parent_id'=>""
				,'body_md'=>""
				,'body_html'=>""
				,'order_ind'=>0
				,'type'=>"section"
				,'sections'=>array()
			);
		}
	}