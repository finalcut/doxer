<?php
	require_once 'src/model/user.php';

	class userTest extends PHPUnit_Framework_TestCase
	{

		public function testUserConstructor(){
			$libraryName = "marshall";
			$user = new User($libraryName);
			$this->assertEquals($libraryName, $user->libraryName, "library name init");
		}

	}
?>