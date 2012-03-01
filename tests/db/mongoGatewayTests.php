<?php
require_once 'src/db/mongoProjectsGateway.php';
require_once 'src/model/project.php';
require_once 'src/model/section.php';

class mongoGatewayTest extends PHPUnit_Framework_TestCase
{

	private $config;
	private $db;
	private $coll;
	private $gw;

	protected function setUp(){
			$mongoDB = new Mongo();
			$this->config = array();
			$this->config['type'] = "mongo";
			$this->config['name'] = "doxertest";
			$this->config['library'] = "ea_projects";


			$this->db = $mongoDB->selectDB($this->config['name']);

			$this->db->dropCollection($this->config['library']);

			$this->coll = $this->db->createCollection($this->config['library']);



		$this->gw = new MongoProjectsGateway($this->config);


	}

	public function testWriteProject(){


		$p = array();
		$p["name"] = "temp project";
		$p["description_md"] = "*hi there guys*";
		$p["description_html"] = "<em>hi there guys</em>";
		$p["sections"] = array();

		$s = array();
		$s["name"] = "section 1 test";
		$s["body_md"] = "hello, mr magoo";
		$s["body_html"] = "hello, mr magoo";
		$s["order_ind"] = "10";
		$s["sections"] = array();

		array_push($p["sections"], $s);


		$project = new Project();
		$project->initPropertiesFromArray($p);


		$project = $this->gw->saveProject($project);

		$p["id"] = $project->id;


		$this->getProjectTestHelper($p);


	}

	public function testGetProjectsWithSingleProjectInStore(){

			$p = array();
			$p["name"] = "test project";
			$p["description_md"] = "*hi*";
			$p["description_html"] = "<em>hi</em>";
			$p["sections"] = array();

			$s = array();
			$s["name"] = "section 1";
			$s["body_md"] = "hello";
			$s["body_html"] = "hello";
			$s["order_ind"] = "1";
			$s["sections"] = array();

			array_push($p["sections"],$s);

			$this->coll->insert($p);

			$this->getProjectTestHelper($p);
	}


	public function testGetProjectsWithMultipleProjectsInStore(){
			$p1 = array();
			$p1["name"] = "test project";
			$p1["description_md"] = "*hi*";
			$p1["description_html"] = "<em>hi</em>";
			$p1["sections"] = array();

			$s1 = array();
			$s1["name"] = "section 1";
			$s1["body_md"] = "hello";
			$s1["body_html"] = "hello";
			$s1["order_ind"] = "1";
			$s1["sections"] = array();

			array_push($p1["sections"],$s1);

			$this->coll->insert($p1);




			$p = array();
			$p["name"] = "second project";
			$p["description_md"] = "*hi 2*";
			$p["description_html"] = "<em>hi 2</em>";
			$p["sections"] = array();

			$s = array();
			$s["name"] = "section 1 of project 2";
			$s["body_md"] = "hello 2";
			$s["body_html"] = "hello 2";
			$s["order_ind"] = "1";
			$s["sections"] = array();

			array_push($p["sections"],$s);

			$this->coll->insert($p);


			$this->getProjectTestHelper($p1, 0);
			$this->getProjectTestHelper($p, 1);
	}


	private function getProjectTestHelper($baseProjectArray, $idx=0){
		if(!$idx)
			$idx = 0;


		$prjs = $this->gw->getProjects();
		$prj = $prjs[$idx];

		$this->assertEquals($baseProjectArray["name"], $prj->name, "project name");
		$this->assertEquals($baseProjectArray["description_md"], $prj->description_md, "project desc md");
		$this->assertEquals($baseProjectArray["description_html"], $prj->description_html, "project desc html");


		$this->assertEquals(count($baseProjectArray["sections"]), count($prj->sections), "kids count");


		$this->assertEquals($baseProjectArray["sections"][0]["name"], $prj->sections[0]->name, "section name");
		$this->assertEquals($baseProjectArray["sections"][0]["body_md"], $prj->sections[0]->body_md, "section body md");
		$this->assertEquals($baseProjectArray["sections"][0]["body_html"], $prj->sections[0]->body_html, "seciton body html");
		$this->assertEquals($baseProjectArray["sections"][0]["order_ind"], $prj->sections[0]->order_ind, "section order ind");


		$this->assertEquals(count($baseProjectArray["sections"][0]["sections"]), count($prj->sections[0]->sections), "grandkids count");


	}

	public function testGetLibraries(){
		$altLibrary = "alternateReality"; // remember; collections can't have a period (.)  or a space in the name..
		$this->db->createCollection($altLibrary);

		$libs = $this->gw->getLibraries();

		// libs will come back sorted alphabetically by name so alternate reality will be our first library returned:
		$this->assertEquals($this->config['library'], $libs[1]->name);
		$this->assertEquals($altLibrary, $libs[0]->name);


		$this->db->dropCollection($altLibrary);

	}

	public function tearDown(){
		$this->db->dropCollection($this->config['library']);
	}

}
?>