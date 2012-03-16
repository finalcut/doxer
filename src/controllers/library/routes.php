<?php
	require 'LibraryController.php';
	// handles calls directly to the users subdirectory..


	F3::route('GET /library/load/@libraryName', 'LibraryController->selectLibrary');

	F3::route('GET /library/@libraryName*', 'LibraryController->home');


?>