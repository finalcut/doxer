<?php
	require_once 'controllers/BaseController.php';

	class HomeController extends BaseController {

		function errorHandler(){
			switch(F3::get('ERROR.code')){
				case 404:
					F3::set('html_title', 'PAGE NOT FOUND');
					F3::set('content', 'errors/404.html');
					echo Template::serve('layout/site.html');
					break;
				case 500:
					F3::set('html_title', 'OH SNAP - SOMETHINGS WRONG');
					F3::set('content', 'errors/500.html');
					echo Template::serve('layout/site.html');
					break;
			}
		}

		function home(){
			F3::set('html_title', F3::get('projectname'));
			F3::set('content','home/home.html');
			echo Template::serve('layout/site.html');
		}

		function install(){
			F3::set('html_title', F3::get('projectname'));
			F3::set('content','home/install.html');
			echo Template::serve('layout/site.html');
		}
	}
?>