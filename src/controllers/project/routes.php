<?php
	require 'ProjectController.php';
	// handles calls directly to the users subdirectory..


	F3::route('GET /project/load/@projectName/@projectId', 'ProjectController->selectProject');

	F3::route('GET /project/@projectName*', 'ProjectController->foo');


?>