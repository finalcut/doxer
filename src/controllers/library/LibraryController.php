<?php
	require_once 'controllers/BaseController.php';

	class LibraryController extends BaseController {

		public function LibraryController(){
			parent::BaseController();
		}


		function selectLibrary(){
			//TODO: identify the library to load, and then send the user on to the 
			$pn = F3::get("PARAMS['libraryName']");
			$this->session->set('libraryName', $pn);
			F3::reroute('/library/' . $pn);
		}

		function home(){
			F3::set('html_title', $this->session->get('libraryName'));
			F3::set('content','library/home.html');
			F3::set('libraryName', $this->session->get("libraryName"));
			echo Template::serve('layout/site.html');
		}
	}
?>