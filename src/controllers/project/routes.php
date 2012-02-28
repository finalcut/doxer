<?php
	require 'ProjectController.php';
	// handles calls directly to the users subdirectory..


	F3::route('GET /project/@projectName*', 'ProjectController->foo');


?>