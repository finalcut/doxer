<?php
use \doxer\db\GatewayFactory as GatewayFactory;

class GatewayFactoryTest extends PHPUnit_Framework_TestCase
{

	public function testGetProjectGateway(){
		$factory = new GatewayFactory();

		$config = array();
		$config['type'] = "mongo";
		$config['name'] = "doxertest";
		$config['collection'] = "projects";

		$gw = $factory->GetProjectGateway($config);

		$this->assertEquals('doxer\db\MongoProjectsGateway', get_class($gw));

	}

	public function testGetProjectGatewayNoTypeProvided(){
		$factory = new GatewayFactory();

		$config = array();
		$config['name'] = "doxertest";
		$config['collection'] = "projects";

		$gw = $factory->GetProjectGateway($config);
		$this->assertEquals('doxer\db\MongoProjectsGateway', get_class($gw));

	}
}
?>