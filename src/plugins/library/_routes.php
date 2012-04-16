<?php

	F3::route('GET /library/load/@libraryName', 'doxer\controllers\library\LibraryController->selectLibrary');
	F3::route('GET /library/@libraryName*', 'doxer\controllers\library\LibraryController->home');

?>