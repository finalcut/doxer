<?php
	F3::route('GET /', 'doxer\controllers\HomeController->home');
	F3::route('GET /install', 'doxer\controllers\HomeController->install');
	F3::set('ONERROR', 'doxer\controllers\HomeController->errorHandler');
	F3::route('GET /markdownHelp', 'doxer\controllers\HomeController->markdownhelp');

	/*
		This is here for utility only.  See http://fatfree.sourceforge.net/page/optimization/keeping-javascript-and-css-on-a-healthy-diet

		for more info.  There is a problem though where the page sometimes will load without styles due to this being run.  It is recommended that you just include your css directly (minimize it yourself if necessary/possible)
	*/
	F3::route('GET /min',
			function() {
				Web::minify($_GET['base'],explode(',',$_GET['files']));
		},
		3600
	);

?>