<?php
require_once 'src/db/mongoProjectsGateway.php';
require_once 'src/model/project.php';
require_once 'src/model/section.php';

class mongoGatewayTest extends PHPUnit_Framework_TestCase
{

	private $db;
	private $coll;
	private $gw;

	protected function setUp(){
			$mongoDB = new Mongo();
			$this->db = $mongoDB->selectDB("doxertest");

			$this->db->dropCollection('projects');

			$this->coll = $this->db->createCollection('projects');

		$config = array();
		$config['type'] = "mongo";
		$config['name'] = "doxertest";
		$config['collection'] = "projects";


		$this->gw = new MongoProjectsGateway($config);


	}


	public function testWriteProject(){
		$this->db->dropCollection('projects');
		$coll = $this->db->createCollection('projects');


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



/*
	public function testGetProjects(){

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
*/

	private function getProjectTestHelper($baseProjectArray){
		$prjs = $this->gw->getProjects();
		$prj = $prjs[0];

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


	public function tearDown(){
		$this->db->dropCollection("projects");
	}

}
?>