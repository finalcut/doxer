# Doxer
Doxer is a project designed to make it sort of easy to write documentation about different projects.  At the moment it is just an idea.  However, it will use markdown on the composition end and mongodb as a repository.  It will be written in php as that is a platform that is regularly avaiable where I work.   Because of my inspiration it will also be using the [waypoints.js][waypoints] Jquery plugin to help keep the navigation in sync with the content.

## Why Doxer
We need a way to not only create documentation but to output it in a nice way for consumption.  I really, really, really like the way the documentation at [parse.com][pd] looks so I decided to make a tool that will let me and my team create documentation very similar to it.

Check back often for updates; I'm excited about working on this project so I'll probably be moving on it pretty fast.  If you see me doing something stupid please let me know at bilL@rawlinson.us

# Some External Dependencies
I am not really keen on including the external project dependencies within this repository so instead I'm going to point you to them.  As I am using PHP I am also using an mvc framework for php called F3 (or fat free framework).  I'm using version 2.09.  You can get it at [sourceforge][f3].  To help control the layout I'm using bootstrap.  Our copy is a little customized for some specific stuff within our organization but you should be able to use [stock boostrap from twitter][bs]; we are using version 2.01.

# Getting Setup
In order for the project to work on your server you need to be able to support mod_rewrite of some kind becuase everything runs through a single index.php file.  Secondly, you'll need [f3][f3] and [bootstrap][bs].  I have both of those in my webroot alongside the doxer directory.  Then, within the doxer site you will need to edit config.cfg to point out where bootstrap is and you'll need to edit index.php to point out where f3 is.

You'll also need [mongodb][mongo] installed and the [php mongo extension][phpdriver] installed.

Finally, because F3 uses some caching you need to create a temp and a cache directory in your doxer root and chmod 777 those two directories.

# Getting Setup on Windows
... lots to write here; but this is important since our prod environment will be windows and IIS.

# Data Format
Does this really belong here? No, but c'est la vie.  As each project is basically a book of documentation the docs will be stored in the following format within mongodb:

```javascript
{
	_id: mongodb generatedId
	name: "project name",
	description_md: "summary description in markdown",
	description_html: "summary description in html"
}
{
	_id: mongodb generatedId
	parent_id: string value of project or section that is parent to this section.
	name: "section name",
	body_md: "the markdown version of the sections content",
	body_html: "the html version of the sections content"
	order_ind: "some number indicating how to order the sections at this level"
}

```

# Setting Up Your Development Environment
If you are going to fork this then you'd probably like to know what php libraries the "build" proces is dependant on.  I don't know, maybe this is de rigueur for most PHP developers but it was all new to me.

You'll need twitter bootstrap; download it and put it in a sibling directory to the main "doxer" directory.   Everything else you may need to install will be done via PEAR.

I use jenkins as my Continuous Integration Server and I based my initial efforts and organizing the code on the stuff at http://jenkins-php.org; however, please note that not everything on that site is exactly right.  I'll try to point you in the right direction for getting things working on your dev machine - sans Jenkins forthwith.

1. Install Xdebug - http://xdebug.org/
1. Install PHP_CodeCoverage - https://github.com/sebastianbergmann/php-code-coverage
1. Install php-timer - https://github.com/sebastianbergmann/php-timer
1. Install PHPUNIT from https://github.com/sebastianbergmann/phpunit - the installation instructions are in that github's readme.
1. Install phploc -  https://github.com/sebastianbergmann/phploc
1. Install phpcpd - https://github.com/sebastianbergmann/phpcpd
1. Install php mess detector - http://phpmd.org/download/index.html
1. Install phpdepend - http://pdepend.org/documentation/getting-started.html
1. Install php-timer - https://github.com/sebastianbergmann/php-timer
1. Install php code sniffer - http://pear.php.net/package/PHP_CodeSniffer/download
1. install php code browser - http://blog.mayflower.de/archives/464-PHP_CodeBrowser-Release-version-0.1.0.html
1. install php dox - https://github.com/theseer/phpdox

I know, that's a lot of stuff.  But it is useful for a lot of projects other than this one (well, PHP projects at least).   If you don't want to install it all then just grab PHP Unit and when you build specify `ant phpunit` and it will just run the unit tests during the build process.

1. install phpab (Autoload) - https://github.com/theseer/Autoload

phpab is something I can not recommend highly enough.  It will automatically generate your autoload.php files which are absolutely required when using php namespaces.  I've included an autoload.sh file (and .bat) which you should be able to use to generate your autoload files (it creates two, one in the src/ directory and one in the tests/ directrory).

Please remember all of this is just for your dev environment.  You'll only be deploying the contents of the src/ directory and you won't need any of these extra php libraries on your production server.

If you run into any problems getting things setup and running please let me know.  I have not figured out how to get all of the unit testing libraries to work in windows so windows folks you may want to pare down your stuff to just the unit testing and phpab.

# Code Organization
There are quite a few directories in the src/ directory (and the f3 directory if you don't already have the Fat Free Framework [F3] in production) but, for the most part, you should be able to ignore them and just focus on the /plugins directory if you want to change or extend the behavior of the application.   

* /cache  - this directory is used by the F3 (fat free framework) and only if you turn on caching in the config.cfg; make sure to chmod 777 if you use it.
* /core - these are some core components I am using across a variety of projects.  For the most part you shouldn't add things to this directory unless the class is generic enough to use in other projects that use the same structure/framework as this one.  Since I havent' really released my "boilerplate" application yet there shouldn't be any need for you to add classes to this directory
* /db - F3 actually provides a vareity of db abstraction mechanisms including one for mongo.  However, wanted to roll my own for this project.  I intentionally went genericish here so that other persistence mechanisms could be used via the toggle of a config setting.
* /f3_utility - this is just something I use to autoload all of the routes into F3.
* /img - any images we are using.  I use twitter bootstrap and this is where I put the glyphicons.  I should probably just have this in the boostrap directory and let you use the ones that come with bootstrap.
* /lib - the only external js libraries I'm using go in here.   Right now that is MarkdownDeep - http://www.toptensoftware.com/markdowndeep/  I should probably include jquery here as well but I don't. I have jquery in a subdirectory under my boostrap directory as I share the bootstrap directory across many projects.
* /phplib - external php libraries.  This is just the php markdown library.
* /plugins - See the section on PLUGINS later.
* /temp - also used by F3 - this NEEDS to be there and needs to be CHMOD 777 - if you don't have this directory nothing will show up in the browser.
* .htaccess - required to get routing to work
* autoload.php - you should autogenerate this with phpab - https://github.com/theseer/Autoload
* config.cfg - all of the configuration information you could ever want
* index.php - entry point to the application.  At most you should have to edit line 6 but you shouldn't have to edit this file at all. 


## PLUGINS

I've attempted to make this all work in a somewhat modular way.  I'm sure there is room for improvement here.  Basically each directory under the /plugins directoy represents a subset of application functionality.   The /plugins/core directory is specific to layout and look and feel for the most part.   Each of the others is logically organized based on what part of the application you are in.

Each plugin MUST have the following files:

* _routes.php - defines what actions within the application this plugin is responsible for.
* _plugin.php - defines the plugin and how, if at all, it should integrate with the main navigation bar.

Both _routes.php and _plugin.php are called before the F3 subsystem does it's magic so you can do a little bit of pre-execution logic in the _plugin.php file if you need to.  It is advised you minimize this however.






[pd]:https://www.parse.com/docs/ios_guide
[f3]:http://bcosca.github.com/fatfree/
[bs]:https://github.com/twitter/bootstrap/tags
[mongo]:http://www.mongodb.org/
[phpdriver]:http://www.mongodb.org/display/DOCS/PHP+Language+Center
[waypoints]:http://imakewebthings.com/jquery-waypoints/