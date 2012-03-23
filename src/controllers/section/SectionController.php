<?php
	namespace doxer\controllers\section;

	use \doxer\controllers\BaseController as BaseController;
	use \doxer\model\Project as Project;
	use \doxer\model\Section as Section;
	use \F3 as F3;
	use \Template as Template;

	require_once 'phplib/markdown.php';

	class SectionController extends BaseController {
		public function __construct(){
			parent::__construct();

			$params = F3::get('PARAMS');
			$project = new Project();
			$section = new Section();

			if(isset($params['uuid'])) {
				$uuid = $params['uuid'];
				$db = $this->getDB($this->session->get("libraryName"));
				$section = $db->getSection($uuid);
			}

			F3::set('section', $section);
		}


		function form(){
			$section = \F3::get('section');

			F3::set('html_title', $section == false ? "New Section" : "Edit " . $section->name);


			F3::set('content', 'project/sectionForm.html');
			$this->addF3Script('project/js/sectionForm.js');

			echo Template::serve('layout/site.html');
		}


		// just tweaks the title and description texts..
		function save(){
			$data = \F3::get('POST');
			$data['id'] = $data['projectId'] == "" ? 0 : $data['projectId'];


			$db = $this->getDB($this->session->get("libraryName"));

/*
	TODO: figure out how to save a specific section somewhere in the document.
			$project = $db->getProject($data['projectId']);



			$data['description_html'] = markdown($data['description_md']);

			$project->initPropertiesFromArray($data);
			$project = $db->saveProject($project);

			\F3::reroute('/' . \F3::get('libraryName') . '/' . $project->name);
*/

		}

		
	}
?>