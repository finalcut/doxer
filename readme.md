# Doxer
Doxer is a project designed to make it sort of easy to write documentation about different projects.  At the moment it is just an idea.  However, it will use markdown on the composition end and mongodb as a repository.  It will be written in php as that is a platform that is regularly avaiable where I work.   Because of my inspiration it will also be using the waypoints.js Jquery plugin to help keep the navigation in sync with the content.

## Why Doxer
We need a way to not only create documentation but to output it in a nice way for consumption.  I really, really, really like the way the documentation at [parse.com][pd] looks so I decided to make a tool that will let me and my team create documentation very similar to it.

Check back often for updates; I'm excited about working on this project so I'll probably be moving on it pretty fast.  If you see me doing something stupid please let me know at bilL@rawlinson.us

# Some External Dependencies
I am not really keen on including the external project dependencies within this repository so instead I'm going to point you to them.  As I am using PHP I am also using an mvc framework for php called F3 (or fat free framework).  I'm using version 2.09.  You can get it at [sourceforge][f3].  To help control the layout I'm using bootstrap.  Our copy is a little customized for some specific stuff within our organization but you should be able to use [stock boostrap from twitter][bs]; we are using version 2.01.

# Getting Setup
In order for the project to work on your server you need to be able to support mod_rewrite of some kind becuase everything runs through a single index.php file.  Secondly, you'll need [f3][f3] and [bootstrap][bs].  I have both of those in my webroot alongside the doxer directory.  Then, within the doxer site you will need to edit config.cfg to point out where bootstrap is and you'll need to edit index.php to point out where f3 is.

You'll also need [mongodb][mongo] installed and the [php mongo extension][phpdriver] installed.

Finally, because F3 uses some caching you need to create a temp and a cache directory in your doxer root and chmod 777 those two directories.

# Data Format
Does this really belong here? No, but c'est la vie.  As each project is basically a book of documentation the docs will be stored in the following format within mongodb:

```javascript
{
	name: "project name",
	description_md: "summary description in markdown",
	description_html: "summary description in html"
	sections: [
			{
				name: "name",
				body_md: "the markdown version of the content",
				body_html: "the html version of the content"
				order_ind: "some number indicating how to order the sections at this level"
				children: [
						// array of section elements..
					]
		}
		]
}
```





[pd]:https://www.parse.com/docs/ios_guide
[f3]:http://sourceforge.net/projects/fatfree/files/
[bs]:https://github.com/twitter/bootstrap/tags
[mongo]:http://www.mongodb.org/
[phpdriver]:http://www.mongodb.org/display/DOCS/PHP+Language+Center