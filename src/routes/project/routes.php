<?php
	F3::route('GET /@libraryName/@projectName', 'doxer\controllers\project\ProjectController->foo');
	F3::route('GET /@libraryName/newProject', 'doxer\controllers\project\ProjectController->form');
	F3::route('GET /@libraryName/@projectName/edit', 'doxer\controllers\project\ProjectController->form');
	F3::route('POST /@libraryName/@projectName/save', 'doxer\controllers\project\ProjectController->save');
	F3::route('POST /@libraryName//save', 'doxer\controllers\project\ProjectController->save');
	F3::route('Get /project/js/@resource', 'doxer\controllers\project\ProjectController->jsview');
?>