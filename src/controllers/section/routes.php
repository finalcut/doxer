<?php
	require 'SectionController.php';
	// handles calls directly to the users subdirectory..



	F3::route('GET /@libraryName/@projectName/newsection', 'SectionController->form');
	F3::route('GET /@libraryName/@projectName/@uuid/edit', 'SectionController->form');

	F3::route('GET /@libraryName/@projectName/@uuid/save', 'SectionController->save');
	F3::route('GET /@libraryName/@projectName//save', 'SectionController->save');
	
?>