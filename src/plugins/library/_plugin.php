<?php
	
	namespace doxer\plugins\library;
	use \marshall\core\Menu as Menu;
	use \marshall\core\MenuItem as MenuItem;
	use \F3 as F3;

	use \doxer\db\GatewayFactory as GatewayFactory;
	use \marshall\core\Session as Session;


	class _plugin extends \marshall\core\BasePlugin {

		private $libs;
		private $session;
		private $thisLibrary = "";

		public function __construct(){

			//load libraries into session.
			$this->loadLibraries();
			$this->setLibrary();


			parent::__construct();
		}

		private $name = "Libraries";

		public function getPluginName(){
			return $this->name;
		}

		public function addMenuItems(){

			$node = new MenuItem();
			$node->name = $this->name;
			if($this->thisLibrary != "")
				$node->name .= ": $this->thisLibrary";
			$node->root_path = '/Library/';
			$node->icon = 'icon-book';
			$node->sort_order = 20;

			$so = 10;
			foreach($this->libs as $key => $lib){

				$child = new MenuItem();
				$child->name = $lib->name;
				$child->root_path="/library/load/$lib->name";
				$child->icon = '';
				$child->sort_order = $so;
				$so = $so + 10;
				$node ->addMenuItem($child);
			}

			Menu::addMenu($node);



		}


		private function setLibrary(){
			$this->session = new Session();
			$this->thisLibrary = $this->session->get("libraryName");
			F3::set("libraryName", $this->thisLibrary);
		}

		private function getDB($libraryName=""){
			$config = F3::get('dbsettings');
			if($libraryName != "")
					$config['library']= $libraryName;
			$factory = new GatewayFactory();
			return $factory->GetLibraryGateway($config);
		}
		private function loadLibraries(){
			// gets executed before the current route..
			$db = $this->getDB();


			$libs  = $db->getLibraries();
			if(count($libs) == 0){
				$newLib = $db->saveLibrary('Default');
				array_push($newLib);
			}

			$this->libs = $libs;


			F3::set('libraries', $libs);
		}



	}
?>