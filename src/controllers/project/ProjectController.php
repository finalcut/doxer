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
	}
?>