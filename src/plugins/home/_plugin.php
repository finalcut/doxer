<?php
	
	namespace doxer\plugins\home;
	use \marshall\core\Menu as Menu;
	use \marshall\core\MenuItem as MenuItem;

	class _plugin extends \marshall\core\BasePlugin {
		private $name = "Home";

		public function getPluginName(){
			return $this->name;
		}

		public function addMenuItems(){

			$node = new MenuItem();
			$node->name = $this->name;
			$node->root_path = '/';
			$node->icon = 'icon-home';
			$node->sort_order = 10;

			Menu::addMenu($node);

		}
	}
?>