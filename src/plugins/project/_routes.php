<?php
	// register the plugin:
	$plugin = new \doxer\plugins\project\_plugin();




	/* project level routes */
	F3::route('GET /@libraryName/@projectName', 'doxer\plugins\project\ProjectController->foo');
	F3::route('GET /@libraryName/newProject', 'doxer\plugins\project\ProjectController->form');
	F3::route('GET /@libraryName/@projectName/edit', 'doxer\plugins\project\ProjectController->form');
	F3::route('POST /@libraryName/@projectName/save', 'doxer\plugins\project\ProjectController->save');
	// two slashes before save is intentional
	F3::route('POST /@libraryName//save', 'doxer\plugins\project\ProjectController->save');
	F3::route('Get /project/js/@resource', 'doxer\plugins\project\ProjectController->jsview');

	/* section related routes */
	F3::route('GET /@libraryName/@projectName/newsection', 'doxer\plugins\project\SectionController->form');
	F3::route('GET /@libraryName/@projectName/@uuid/edit', 'doxer\plugins\project\SectionController->form');
	F3::route('GET /@libraryName/@projectName/@uuid/save', 'doxer\plugins\project\SectionController->save');
	// two slashes before save is intentional
	F3::route('GET /@libraryName/@projectName//save', 'doxer\plugins\project\SectionController->save');

?>