<?php

	namespace doxer\plugins\library;
	use \marshall\core\BaseController as BaseController;
	use \F3 as F3;
	use \Template as Template;


	class LibraryController extends BaseController {

		public function __construct(){
			parent::__construct();
		}


		function selectLibrary(){
			//TODO: identify the library to load, and then send the user on to the 
			$pn = F3::get("PARAMS['libraryName']");
			$this->session->set('libraryName', $pn);
			$this->session->set('projectName', false);
			F3::reroute('/library/' . $pn);
		}

		function home(){
			F3::set('html_title', $this->session->get('libraryName'));
			F3::set('subNav', 'library/views/head.html');
			F3::set('content','library/views/home.html');
			echo Template::serve('core/layout/site.html');
		}
	}
?>