<?php

use \doxer\db\MongoLibraryGateway as MongoLibraryGateway;
use \Mongo as Mongo;

class mongoLibraryGatewayTest extends PHPUnit_Framework_TestCase
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

			$this->gw = new MongoLibraryGateway($this->config);


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