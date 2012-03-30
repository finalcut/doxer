<?php

	namespace doxer\db;
	use \doxer\db\IProjectsGateway as IProjectsGateway;
	use \doxer\model\Project as Project;
	use \doxer\model\Section as Section;
	use \doxer\model\Library as Library;
	use \Mongo as Mongo;
	use \MongoId as MongoId;


	class MongoProjectsGateway implements IProjectsGateway {

		private $vars = array();


		public function __construct($dbsettings){
			if(isset($dbsettings["name"]))
				$this->vars["name"] = $dbsettings["name"];
			if(isset($dbsettings["library"]))
				$this->vars["collectionName"] = $dbsettings["library"];
		}


		private function getCollection(){
			$mongoDB = new Mongo();
			$db = $mongoDB->selectDB($this->vars["name"]);
			return $db->selectCollection($this->vars["collectionName"]);
		}

		public function getProjects(){
			$collection = $this->getCollection();
			$cursor = $collection->find();
			$cursor->sort(array('name'=> 1));
			$projects = array();

			foreach($cursor as $id => $proj){
				$project = $this->readProject($proj);
				array_push($projects, $project);
			}

			return $projects;

		}

		private function readProject($proj){
			$project = new Project();

			$project->_id = $proj['_id'] . ""; // cast to a string


			if(isset($proj['name']))
				$project->name = $proj["name"];


			if(isset($proj['description_md']))
				$project->description_md = $proj["description_md"];
			if(isset($proj['description_html']))
				$project->description_html = $proj["description_html"];

			// just in case some wierd html slipped in the system..
			if($project->description_md == "")
				$project->description_html = "";


			return $project;
		}

		private function readSection($sec){
			$section = new Section();
			if(isset($sec["_id"]))
				$section->_id = $sec["_id"] . "";
			if(isset($sec["parent_id"]))
				$section->parent_id = $sec["parent_id"];
			if(isset($sec["name"]))
				$section->name = $sec["name"];
			if(isset($sec["body_md"]))
				$section->body_md = $sec["body_md"];
			if(isset($sec["body_html"]))
				$section->body_html = $sec["body_html"];
			if(isset($sec["order_ind"]))
				$section->order_ind = $sec["order_ind"];

			return $section;
		}


		public function getSection($id){
			$sec = $this->readSection($this->getObject($id, "section"));
			$sec->sections = $this->getSectionsForParent($sec->_id);
			return $sec;
		}


		public function getProject($id){
			$proj = $this->readProject($this->getObject($id, "project"));
			$proj->sections = $this->getSectionsForParent($proj->_id);
			return $proj;

		}

		private function getObject($id, $type){
			$collection = $this->getCollection();
			return $collection->findOne(array('_id' => new MongoId($id), 'type'=>$type));
		}

		public function getProjectByName($projectName){
			$collection = $this->getCollection();
			$proj = $collection->findOne(array('name' => $projectName, 'type'=>'project'));
			$project = $this->readProject($proj);
			$project->sections = $this->getSectionsForParent($project->_id);
			return $this->readProject($proj);
		}


		private function getSectionsForParent($id){
			$collection = $this->getCollection();
			$sec = $collection->find(array('parent_id'=>$id));
			$sections = array();
			foreach($sec as $s){
				$section = $this->readSection($s);
				$section->sections = $this->getSectionsForParent($section->_id);
				array_push($sections, $section);
			}
			return $sections;
		}


		public function saveProject($project){
			$col = $this->getCollection();

			$data = $project->toArray();
			if(!isset($data["_id"]) || $data["_id"] == ""){
				$temp = $this->getProjectByName($data["name"]);
				if($temp->_id != ""){
					$data["_id"] = new MongoId($temp->_id);
				}
			}
			// make sure that we don't save an object with a empty string for the _id; forcing mongo to generate one.
			if($data['_id'] == ""){
				unset($data['_id']);
			}
			unset($data["sections"]);

			$ret = $col->save($data); // this does an update or insert.. I guess based on the _id...""
			$project->_id = $data["_id"].""; // according to documentation the _id will be injected into the array..nice!

			return $project;
		}

		public function saveSection($section){
			$col = $this->getCollection();
			$data = $section->toArray();
			unset($data["sections"]);
			if($data["_id"] == "")
				unset($data["_id"]);

			$ret = $col->save($data);
			$section->_id = $data["_id"];
			return $section;
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
			usort($libraries, array("\doxer\model\Library","compare"));


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