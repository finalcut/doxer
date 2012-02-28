<?php
	F3::route('GET /',
		function() {
			F3::set('html_title', F3::get('projectname'));
			F3::set('content','home.html');
			echo Template::serve('layout/site.html');
		});

	F3::set('ONERROR', 'error_handler');

	function error_handler(){
		switch(F3::get('ERROR.code')){
			case 404:
				F3::set('html_title', 'PAGE NOT FOUND');
				F3::set('content', 'errors/404.html');
				echo Template::serve('layout/site.html');
				break;
			case 500:
				F3::set('html_title', 'OH SNAP - SOMETHINGS WRONG');
				F3::set('content', 'errors/500.html');
				echo Template::serve('layout/site.html');
				break;
		}
	}


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