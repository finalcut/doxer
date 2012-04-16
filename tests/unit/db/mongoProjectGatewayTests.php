<?php

use \doxer\db\MongoProjectsGateway as MongoProjectsGateway;
use \doxer\plugins\project\model\Project as Project;
use \doxer\plugins\project\model\Section as Section;
use \Mongo as Mongo;

class mongoProjectGatewayTest extends PHPUnit_Framework_TestCase
{

	private $config;
	private $db;
	private $coll;
	private $gw;
	private $p;
	private $s;

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

	private function createProject(){
		$this->p = array();
		$this->p["name"] = "temp project";
		$this->p["description_md"] = "*hi there guys*";
		$this->p["description_html"] = "<em>hi there guys</em>";
		$this->p["sections"] = array();

		$project = new Project();
		$project->initPropertiesFromArray($this->p);


		$project = $this->gw->saveProject($project);
		$this->p["_id"] = $project->_id;
		return $project;
	}

	private function compareProject($project, $prj){
		$this->assertEquals($project->name, $prj->name, "project name");
		$this->assertEquals($project->description_md, $prj->description_md, "project desc md");
		$this->assertEquals($project->description_html, $prj->description_html, "project desc html");
		$this->assertEquals(count($project->sections), count($prj->sections), "total number of sections");
	}

	private function createSection($parentID){
		$this->s = array();
		$this->s["parent_id"] = $parentID;
		$this->s["name"] = "section 1 test";
		$this->s["body_md"] = "hello, mr magoo";
		$this->s["body_html"] = "hello, mr magoo";
		$this->s["order_ind"] = "10";
		$this->s["sections"] = array();

		$section = new Section();
		$section->initPropertiesFromArray($this->s);
		$section = $this->gw->saveSection($section);
		$this->s["_id"] = $section->_id;
		return $section;
	}


	private function compareSection($section, $sec){
		$this->assertEquals($section->name, $sec->name, "project name");
		$this->assertEquals($section->body_md, $sec->body_md, "project desc md");
		$this->assertEquals($section->body_html, $sec->body_html, "project desc html");
		$this->assertEquals(count($section->sections), count($sec->sections), "total number of sections");
	}


	public function testWriteProject(){
		$project = $this->createProject();
		$prj = $this->gw->getProject($project->_id);

		$this->compareProject($project, $prj);
	}

	public function testWriteProjectWithSection(){
		$project = $this->createProject();
		$section = $this->createSection($project->_id);

		$project->addSection($section);

		$prj = $this->gw->getProject($project->_id);
		$this->compareProject($project, $prj);

		$sec = $prj->sections[0];
		$this->compareSection($section, $sec);
	}


	/**
	* @expectedException doxer\plugins\project\exceptions\OrphanedSectionException
	**/
	public function testWriteSectionWithNoParentID(){
		$section = $this->createSection("");
	}

	public function testWriteSection(){
		$section = $this->createSection("1234");
		$sec = $this->gw->getSection($section->_id);

		$this->compareSection($section, $sec);


	}

	public function tearDown(){
		$this->db->dropCollection($this->config['library']);
	}

}
?>