<?php
	require 'ProjectController.php';
	// handles calls directly to the users subdirectory..


	F3::route('GET /project/load/@projectName/@projectId', 'ProjectController->selectProject');

	F3::route('GET /project/@projectName*', 'ProjectController->foo');

	F3::route('GET /project/create', 'ProjectController->form');

	F3::route('GET /project/edit/@projectId', 'ProjectController->form');

	F3::route('POST /project/save', 'ProjectController->save');

	F3::route('Get /project/js/@resource', 'ProjectController->jsview');
?>