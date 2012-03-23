<?php

	namespace doxer\db;
	use doxer\db\mongoProjectsGateway as mongoProjectsGateway;

	/* lame object name I know.. sue me. */


	class GatewayFactory{

		public function __construct(){
		}

		public function GetProjectGateway($dbsettings){
			if(!isset($dbsettings['type']))
				$dbsettings['type'] = 'mongo';

			$dbsettings['type'] = strtolower($dbsettings['type']);


			switch($dbsettings['type']){
				case "mongo":
				default:
					return new MongoProjectsGateway($dbsettings);
			}

		}

	}

?>