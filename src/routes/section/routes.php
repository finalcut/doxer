<?php
	F3::route('GET /@libraryName/@projectName/newsection', 'doxer\controllers\section\SectionController->form');
	F3::route('GET /@libraryName/@projectName/@uuid/edit', 'doxer\controllers\section\SectionController->form');
	F3::route('GET /@libraryName/@projectName/@uuid/save', 'doxer\controllers\section\SectionController->save');
	F3::route('GET /@libraryName/@projectName//save', 'doxer\controllers\section\SectionController->save');
?>