<?php
	
	namespace doxer\plugins\project;
	use \marshall\core\Menu as Menu;
	use \marshall\core\MenuItem as MenuItem;

	use \doxer\db\GatewayFactory as GatewayFactory;
	use \marshall\core\Session as Session;
	use \F3 as F3;


	class _plugin extends \marshall\core\BasePlugin {
		private $name = "Projects";

		private $prjs;
		private $session;
		private $lib;

		public function __construct(){

			//load libraries into session.
			$this->loadProjects();
		//	$this->setProject();


			parent::__construct();
		}


		public function getPluginName(){
			return $this->name;
		}

		public function addMenuItems(){

			$node = new MenuItem();
			$node->name = $this->name;
			$node->root_path = '/project/';
			$node->icon = 'icon-home';
			$node->sort_order = 30;

			$so = 10;
			if($this->prjs != null){
				foreach($this->prjs as $key => $prj){

					$child = new MenuItem();
					$child->name = $prj->name;
					$child->root_path="/$this->lib/$prj->name";
					$child->icon = '';
					$child->sort_order = $so;
					$so = $so + 10;
					$node ->addMenuItem($child);
				}
			}
			Menu::addMenu($node);
		}

		private function getDB($libraryName=""){
			$config = F3::get('dbsettings');
			if($libraryName != "")
					$config['library']= $libraryName;
			$factory = new GatewayFactory();
			return $factory->GetProjectGateway($config);
		}


		private function loadProjects(){
			$this->session = new Session();
			$this->lib = $this->session->get("libraryName");
			if($this->lib != ''){
				// get list of all projects in the current library..
				$db = $this->getDB($this->lib);
				$this->prjs = $db->getProjects();
				F3::set('projects', $this->prjs);
			}			
		}
	}
?>


