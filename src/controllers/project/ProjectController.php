<?php
	require_once 'controllers/BaseController.php';

	class ProjectController extends BaseController {
		function foo(){
			F3::set('html_title', 'Bar');
			F3::set('content','project/render.html');
			echo Template::serve('layout/site.html');
		}
	}
?>