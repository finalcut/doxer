<?php

	namespace doxer\db;
	use \doxer\db\ILibraryGateway as ILibraryGateway;
	use \doxer\plugins\library\model\Library as Library;
	use \Mongo as Mongo;
	use \MongoId as MongoId;


	class MongoLibraryGateway implements ILibraryGateway {

		private $vars = array();


		public function __construct($dbsettings){
			if(isset($dbsettings["name"]))
				$this->vars["name"] = $dbsettings["name"];
			if(isset($dbsettings["library"]))
				$this->vars["collectionName"] = $dbsettings["library"];
		}

		public function saveLibrary($libraryName){
			$mongoDB = new Mongo();
			$db = $mongoDB->selectDB($this->vars["name"]);
			$db->createCollection($libraryName);
			return new Library($libraryName);

		}

		public function getLibraries(){ // basically treating a collection as a schema sort of to separate projects by organization.
			$mongoDB = new Mongo();
			$db = $mongoDB->selectDB($this->vars["name"]);
			$cols = $db->listCollections();

			$libraries = array();

			foreach($cols as $collection){
				
				// name comes out in format db.collection so we need to remove the db. part of the name..
				$name = $collection . "";
				$parts = explode(".", $name);
				$name = $parts[1];



				$c = new Library($name);
				array_push($libraries, $c);
			}
			usort($libraries, array("\doxer\plugins\library\model\Library","compare"));


			return $libraries;
		}


		static function libraryCompare($a, $b){
			return strcmp($a->name, $b->name); 
		}


		function dump($var, $abort=false){
			print_r("<pre>");
			print_r($var);
			print_r("</pre>");
			if($abort){
				die();
			}
		}

	}
?>