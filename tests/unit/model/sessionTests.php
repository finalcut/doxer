<?php
session_start();

	use \doxer\model\Session as Session;
	use \doxer\model\User as User;

	class sessionTest extends PHPUnit_Framework_TestCase
	{


		protected function setUp(){
			
		}
		protected function tearDown(){
			
		}

		public function testSetSimpleValue(){
			$session = new Session();
			$val = "testSetSimpleValue";
			$key = "FOO";
			$session->set($key, $val);

			$this->assertEquals($val, $_SESSION[$key]);
		}

		public function testSetObject(){
			$libraryName = "marshall";
			$val = new User($libraryName);
			$session = new Session();
			$key = "testSetObject";
			$session->set($key, $val);

			$this->assertEquals($val->libraryName, $_SESSION[$key]->libraryName);
		}

		public function testGetNonExistantValue(){
			$session = new Session();

			$this->assertFalse($session->get("testGetNonExistantValue"));
		}

		public function testGetExistentSimpleValue(){
			$session = new Session();
			$val = "BAR";
			$key = "testGetExistentSimpleValue";
			$_SESSION[$key] = $val;

			$this->assertEquals($val, $session->get($key));
		}

		public function testGetExistentObject(){
			$session = new Session();
			$libraryName = "marshall";
			$val = new User($libraryName);
			$key = "testGetExistentObject";
			$_SESSION[$key] = $val;

			$this->assertEquals($val->libraryName, $session->get($key)->libraryName);
		}

	}
?>