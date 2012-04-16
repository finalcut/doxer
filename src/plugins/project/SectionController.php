<?php
	namespace doxer\plugins\project;
	use \marshall\core\BaseController as BaseController;
	use \doxer\plugins\project\model\Project as Project;
	use \doxer\plugins\project\model\Section as Section;
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

		function beforeRoute(){
			F3::set("libraryName", F3::get("PARAMS['libraryName']"));
			F3::set("projectName", F3::get("PARAMS['projectName']"));

		}
		function form(){
			$section = \F3::get('section');

			F3::set('html_title', $section == false ? "New Section" : "Edit " . $section->name);


			F3::set('content', 'project/views/sectionForm.html');
			$this->addF3Script('project/js/sectionForm.js');

			echo Template::serve('core/layout/site.html');
		}



		// just tweaks the title and description texts..
		function save(){
			$data = F3::get('POST');
			$db = $this->getDB($this->session->get("libraryName"));


			$data['_id'] = $data['_id'] == "" ? 0 : $data['_id'];
			$section = $db->getSection($data['_id']);
			$project = $db->getProjectByName(F3::get("projectName"));
			$data['parent_id'] = $project->_id;


			$data['body_html'] = markdown($data['body_md']);

			$section->initPropertiesFromArray($data);
			$section = $db->saveSection($section);

			F3::reroute('/' . F3::get('libraryName') . '/' . F3::get("projectName"));

		}



		
	}
?>