<?php
	require_once 'controllers/BaseController.php';
	require_once 'phplib/markdown.php';

	class ProjectController extends BaseController {
		public function ProjectController(){
			parent::BaseController();
		}


		function selectProject(){
			$pn = F3::get("PARAMS['projectName']");
			$pid = F3::get("PARAMS['projectId']");
			$this->session->set('projectName', $pn);
			$this->session->set('projectId', $pid);
			F3::reroute('/project/' . $pn);
		}

		function foo(){
			$db = $this->getDB($this->session->get("libraryName"));
			$project = $db->getProject($this->session->get('projectId'));

			F3::set('project', $project);

			F3::set('html_title', $this->session->get('projectName'));
			F3::set('content','project/render.html');
			F3::set('projectNav', 'project/nav.html');
			echo Template::serve('layout/site.html');
		}

		function form(){
			$db = $this->getDB($this->session->get("libraryName"));
			$pid = F3::get("PARAMS['projectId']");
			$pid = $pid == "" ? 0 : $pid;

			$project = $db->getProject($pid);

			F3::set('html_title', $pid == "" ? "New Project" : "Edit " . $project.get("name"));

			F3::set('project', $project);

			F3::set('content', 'project/form.html');
			$this->addF3Script('project/js/form.js');

			echo Template::serve('layout/site.html');
		}


		// just tweaks the title and description texts..
		function saveMetaDetails(){
			$data = F3::get('POST');
			$db = $this->getDB($this->session->get("libraryName"));

			$data['projectId'] = $data['projectId'] == "" ? 0 : $data['projectId'];
			$project = $db->getProject($data['projectId']);

			$data['description_html'] = markdown($data['description_md']);

			$project->initPropertiesFromArray($data);
			$project = $db->saveProject($project);

			F3::reroute('/project/load/' . $project->name . '/' . $project->id);

		}

		// changes the contents of the entire project include all sections within it. currently not sure if I need/want to split these
		function save(){

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