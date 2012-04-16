<?php
	namespace doxer\controllers\project;
	use \doxer\controllers\BaseController as BaseController;
	use \doxer\model\Project as Project;
	use \doxer\model\Section as Section;
	use \F3 as F3;
	use \Template as Template;

	require_once 'phplib/markdown.php';

	class ProjectController extends BaseController {
		public function __construct(){
			parent::__construct();

			$params = F3::get('PARAMS');
			$project = new Project();

			if(isset($params['projectName'])) {
				$projectName = $params['projectName'];
				$db = $this->getDB($this->session->get("libraryName"));
				$project = $db->getProjectByName($projectName);
			}

			$this->session->set('projectName', $project->name);
			$this->session->set('projectId', $project->_id);

			F3::set('project', $project);
			F3::set('projectName', $this->session->get("projectName"));

		}


		function foo(){

			F3::set('html_title', "Project: " . $this->session->get('projectName'));
			F3::set('subNav', 'project/head.html');
			F3::set('content','project/render.html');
			F3::set('projectNav', 'project/nav.html');
			echo Template::serve('layout/site.html');
		}

		function form(){
			$project = F3::get('project');

			F3::set('html_title', $project == false ? "New Project" : "Edit " . $project->name);

			F3::set('content', 'project/form.html');
			$this->addF3Script('project/js/form.js');

			echo Template::serve('layout/site.html');
		}


		// just tweaks the title and description texts..
		function save(){
			$data = F3::get('POST');
			$db = $this->getDB($this->session->get("libraryName"));


			$data['_id'] = $data['_id'] == "" ? 0 : $data['_id'];
			$project = $db->getProject($data['_id']);

			$data['description_html'] = markdown($data['description_md']);

			$project->initPropertiesFromArray($data);
			$project = $db->saveProject($project);

			F3::reroute('/' . F3::get('libraryName') . '/' . $project->name);

		}

		
		/*
			any javascript view files being used for this subdirectory will be returned via this method..
		*/
		function jsview(){
			$this->writeJavascriptHeaders();

			$this->loadresource( '/js/','');
		}


		/*
			if the resource param isn't provided in the calling url an empty string is put there; for example
			when /directory/listing is called there is no resouce being found (see routes.php in this directory to see how resource is assigned)
			however the listing function in this file can still call this becuase it basically hardcodes the resource value in the path variable as listing.html
		*/
		private function loadresource($path, $ext){
			F3::set('content','project' . $path . F3::get('PARAMS["resource"]') . $ext);
				echo Template::serve('layout/bare.html');
			
		}
	}
?>