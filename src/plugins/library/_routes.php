<?php
	// register the plugin:
	$plugin = new \doxer\plugins\library\_plugin();




	F3::route('GET /library/load/@libraryName', 'doxer\plugins\library\LibraryController->selectLibrary');
	F3::route('GET /library/@libraryName*', 'doxer\plugins\library\LibraryController->home');

?>