<?php
	require 'ProjectController.php';
	// handles calls directly to the users subdirectory..


	F3::route('GET /@libraryName/@projectName', 'ProjectController->foo');

	F3::route('GET /@libraryName/newProject', 'ProjectController->form');

	F3::route('GET /@libraryName/@projectName/edit', 'ProjectController->form');

	F3::route('POST /@libraryName/@projectName/save', 'ProjectController->save');
	F3::route('POST /@libraryName//save', 'ProjectController->save');

	F3::route('Get /project/js/@resource', 'ProjectController->jsview');
?>