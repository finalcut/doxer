<?php
session_start();
 // you really shouldn't ever have to touch this file; it just does everythign without assistence..

// this gets F3 working.. it has to happen first.
require_once '../f3/lib/base.php';
 

// make sure your config.cfg file is correct for your application.
F3::config('config.cfg');

// this just initializes a variable you can use in your controllers in order to have js files included at the end of the rendering of the page.
// remember, JQUERY is avaiable to you.
F3::set('scripts', array());

// this is a variable that will hold javascript files that you want to use F3 variables in and thus have pre-process before being downloaded
F3::set('f3scripts',array());

/* 
	this is a smart little utility that will find your route handlers and include them auto-magically.
	by default we assume your route handlers and controllers will be in the "controllers" directory under the project
	so long as you follow the convention of naming your route handlers routes.php they will be included by default thus
	as soon as you create a new route handler it will start being seen without any additional configuration on your part.

*/
require_once 'f3_utility/find_routes.php';


// this just makes sure your page has a title if you forget to set one in your controller action; pleae don't muck with it.
	// at this point, if no html_title value was set; we will try to set one!
	$title = F3::get("html_title") == null
					? (  F3::get("projectname") == null ? "No ProjectName or Html_Title provided" : F3::get("projectname") ) 
					: F3::get("html_title");

	F3::set("html_title", $title);



// this happens last - and is what sets the page render in motion based on whatever you have happening in your controller.
F3::run();
 


?>
