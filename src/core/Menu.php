<?php
	/*
		basic controller class.  All other controller classes SHOULD extend this class as it provides some useful helper methods
		that each controller will probably need.
	*/ 
	namespace marshall\core;
	use \F3 as F3;

	class Menu {

		static function addMenu($menuItem){
			$menu = F3::get("menu");
			$menu = is_array($menu) ? $menu : array();

			array_push($menu, $menuItem);
			usort($menu, array("\marshall\core\MenuItem","compare"));
			F3::set('menu',$menu);
		}


		static function addMenuItem($menuItem){
			$menu = F3::get("menu");
			if(in_array($menuItem->parent, $menu)){
				array_push($menu[$menuItem->parent]['val'], $menuItem);
				usort($menu[$menuItem->parent]['val'], array("\marshall\core\MenuItem","compare"));

			}
			F3::set('menu',$menu);
		}

	}
?>