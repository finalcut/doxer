<?php

	namespace marshall\core;
	/* 
		this class should only be inheirited by model objects that don't have some form of persistence
		since we use the F3 there are nice built in options for handling attribute definitions etc using
		one of the various ORM options included in the framework.  Check out http://fatfree.sourceforge.net/page/data-mappers for more information if you are going to persist your data 
	*/
	abstract class NonPersistentBean {

		/*
			 if you override the constructor in your class; please make sure you call this one too. ex:
			 parent::__construct();
		*/
		function __construct(){
			$this->initPropertiesFromArray(array());
		}
		 

		 // In case you don't know what abstract means; it means if you extend this class (and you should) then you
		 // must provide a definition for this method in your class.  
		 abstract function getDefaults();


		 /* the F3 framework captures all form and url variables in an array called PARAMS
		 	the idea here is that you can populate a bean within the project from these
		 	PARAMS by using this function; just pass in the PARAMS array.

		 	NOTE however, that you also have to define an array of default values that you will accept 
		 	in yoru actual bean class.  See user->getDefaults(); in the php_boilerplate project for an example.
		*/
		 function initPropertiesFromArray($props){

		 	$fields = $this->getDefaults();

		 	$useProps = is_array($props);
			
			foreach ($fields as $field => $default){
				$this->$field = $useProps && isset($props[$field]) ? $props[$field] : $default;
			}
		 }

		 function toString(){
		 	$fields = $this->getDefaults();

		 	$o = "";
		 	foreach($fields as $field => $value){

		 		/* safety check to make sure the properties were initialized on the object.
		 		  due to the dynamic nature of the attribute setting isset will always return false
		 		  so we have to look in the objects variables to determine if it is actually set
		 		*/
		 		if(array_key_exists($field, get_object_vars($this))) {
		 			$o .= $field . ": " . $this->$field . "\n";
		 		} 
		 	
			 }
		 	return $o;
		 }

		 function toArray(){
		 	$fields = $this->getDefaults();
		 	$o = array();
		 	foreach($fields as $field => $value){

		 		/* safety check to make sure the properties were initialized on the object.
		 		  due to the dynamic nature of the attribute setting isset will always return false
		 		  so we have to look in the objects variables to determine if it is actually set
		 		*/
		 		if(array_key_exists($field, get_object_vars($this))) {
		 			$o[$field] = $this->$field;
		 		} 
		 	
			 }
		 	return $o;
		 }
	}
?>