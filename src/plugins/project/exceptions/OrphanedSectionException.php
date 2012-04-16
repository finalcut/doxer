<?php
	namespace doxer\plugins\project\exceptions;
	use \Exception as Exception;

		class OrphanedSectionException extends Exception {
			public function __construct(){
				$message = "Orphan Exception: orphaned section- section must have a defined parent_id";
				$code = 404; // parent not found.. *rimshot*
				$previous = null;
				parent::__construct($message, $code, $previous);
			}

		}
?>