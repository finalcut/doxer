<?php

	use \doxer\plugins\user\model\User as User;

	class userTest extends PHPUnit_Framework_TestCase
	{

		public function testUserConstructor(){
			$libraryName = "marshall";
			$user = new User($libraryName);
			$this->assertEquals($libraryName, $user->libraryName, "library name init");
		}

	}
?>