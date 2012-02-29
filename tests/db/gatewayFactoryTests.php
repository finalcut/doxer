<?php
require_once 'src/db/gatewayFactory.php';
class GatewayFactoryTest extends PHPUnit_Framework_TestCase
{

	public function testGetProjectGateway(){
		$factory = new GatewayFactory();

		$config = array();
		$config['type'] = "mongo";
		$config['name'] = "doxertest";
		$config['collection'] = "projects";

		$gw = $factory->GetProjectGateway($config);

		$this->assertEquals('MongoProjectsGateway', get_class($gw));

	}

	public function testGetProjectGatewayNoTypeProvided(){
		$factory = new GatewayFactory();

		$config = array();
		$config['name'] = "doxertest";
		$config['collection'] = "projects";

		$gw = $factory->GetProjectGateway($config);
		$this->assertEquals('MongoProjectsGateway', get_class($gw));

	}
}
?>