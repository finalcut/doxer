<?php

	use \doxer\plugins\project\exceptions\OrphanedSectionException as OrphanedSectionException;

	class OrphanedSectionExceptionTests extends PHPUnit_Framework_TestCase
	{

		/**
		* @expectedException doxer\plugins\project\exceptions\OrphanedSectionException
		* @expectedExceptionMessage Orphan Exception: orphaned section- section must have a defined parent_id
		* @expectedExceptionCode 404
		**/
		public function testThrowOrphanException() {
			throw new OrphanedSectionException();
		}


		/**
		* @expectedException doxer\plugins\project\exceptions\OrphanedSectionException
		* @expectedExceptionMessage Orphan Exception: orphaned section- section must have a defined parent_id
		* @expectedExceptionCode 404
		**/
		public function testThrowOrphanExceptionWithBogusOverrides() {
			// the arguments passed in should be ignored
			throw new OrphanedSectionException("bogus",0);
		}


	}
?>