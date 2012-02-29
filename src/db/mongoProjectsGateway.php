<?php
	require_once 'IProjectsGateway.php';
	require_once 'src/model/project.php';
	require_once 'src/model/section.php';

	class MongoProjectsGateway implements IProjectsGateway {

		private $vars = array();


		public function MongoProjectsGateway($dbsettings){
			if(isset($dbsettings["name"]))
				$this->vars["name"] = $dbsettings["name"];
			if(isset($dbsettings["collection"]))
				$this->vars["collectionName"] = $dbsettings["collection"];
		}

		private function getCollection(){
			$mongoDB = new Mongo();
			$db = $mongoDB->selectDB($this->vars["name"]);
			return $db->selectCollection($this->vars["collectionName"]);
		}

		public function getProjects(){
			$collection = $this->getCollection();
			$cursor = $collection->find();

			$projects = array();

			foreach($cursor as $id => $proj){
				$project = new Project();
				$project->id = $id . ""; // cast to a string


				if(isset($proj['name']))
					$project->name = $proj["name"];


				if(isset($proj['description_md']))
					$project->description_md = $proj["description_md"];
				if(isset($proj['description_html']))
					$project->description_html = $proj["description_html"];

				// just in case some wierd html slipped in the system..
				if($project->description_md == "")
					$project->description_html = "";

				$project->sections = $this->getSectionsForObject($proj);

				array_push($projects, $project);
			}

			return $projects;

		}

		public function saveProject($project){
			$col = $this->getCollection();

			$data = $project->toArray();
			if(isset($data["id"]) && $data["id"] != ""){
				$data["_id"] = new MongoId($data["id"]);
			}



			$ret = $col->save($data); // this does an update or insert.. I guess based on the _id...""
			$project->id = $data["_id"].""; // according to documentation the _id will be injected into the array..nice!
			return $project;
		}


		private function getSectionsForObject($obj){
				$sections = array();
				if(isset($obj['sections'])){
					foreach($obj['sections'] as $sec){


						$section = new Section();
						if(isset($sec["_id"]))
							$section->id = $sec["_id"] . "";
						if(isset($sec["name"]))
							$section->name = $sec["name"];
						if(isset($sec["body_md"]))
							$section->body_md = $sec["body_md"];
						if(isset($sec["body_html"]))
							$section->body_html = $sec["body_html"];
						if(isset($sec["order_ind"]))
							$section->order_ind = $sec["order_ind"];

						if(isset($sec["sections"]))
							$section->sections = $this->getSectionsForObject($sec);

						array_push($sections, $section);

					}
				}

				return $sections;
		}


		public function getProject($id){
		}


	}
?>