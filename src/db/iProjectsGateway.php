<?php
	namespace doxer\db;
	/*
		it is true that this entire project will probably only ever be used by myself AND it will probably 
		always be written using mongodb in the backend; I figured; why not abstract this part out so that
		... just in case .... I can switch persistence layers later and not really rewrite my entire application
		which would otherwise have to know about interfacing with the object model returned from mongo.

	*/
	interface IProjectsGateway{

		public function getProjects();

		public function getProject($id);

		public function getProjectByName($projectName);

		public function saveProject($project);

	}

?>