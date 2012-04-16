<?php

	namespace doxer\plugins\home;
	use \marshall\core\BaseController as BaseController;
	use \F3 as F3;
	use \Template as Template;

	class HomeController extends BaseController {

		function errorHandler(){
			switch(F3::get('ERROR.code')){
				case 404:
					F3::set('html_title', 'PAGE NOT FOUND');
					F3::set('content', 'core/views/404.html');
					echo Template::serve('core/layout/site.html');
					break;
				case 500:
					F3::set('html_title', 'OH SNAP - SOMETHINGS WRONG');
					F3::set('content', 'core/views/500.html');
					echo Template::serve('core/layout/site.html');
					break;
			}
		}

		function home(){
			F3::set('html_title', F3::get('projectname'));
			F3::set('content','home/views/home.html');
			echo Template::serve('core/layout/site.html');
		}

		function install(){
			F3::set('html_title', F3::get('projectname'));
			F3::set('content','home/install.html');
			echo Template::serve('core/layout/site.html');
		}

		function markdownhelp(){
			F3::set('content', 'home/views/mdd_help.htm');
			echo Template::serve('core/layout/bare.html');

		}
	}
?>