<?php
	require_once 'controllers/BaseController.php';

	class ProjectController extends BaseController {
		function selectProject(){
			$pn = F3::get("PARAMS['projectName']");
			$this->session->set('project', $pn);
			F3::reroute('/project/' . $pn);
		}

		function foo(){
			F3::set('html_title', 'Bar');
			F3::set('content','project/render.html');
			F3::set('projectName', $this->session->get("project"));
			echo Template::serve('layout/site.html');
		}

		function form(){
			$db = $this->getDB();
			$pid = F3::get("PARAMS['projectId']");
			$pid = $pid == "" ? 0 : $pid;

			$project = $db->getProject($pid);

			F3::set('project', $project);

			F3::set('content', 'project/form.html');
			$this->addF3Script('project/js/form.js');

			echo Template::serve('layout/site.html');
		}

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