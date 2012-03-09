<?php
		class Session {

			public function get($key){
					if(isset($_SESSION)){
						if(isset($_SESSION[$key])){
							return $_SESSION[$key];
						} else {
							return false;
						}

					} else {
						die("you must use session_start to turn on sessions at the top of the entry page.");
					}

			}

			public function set($key, $value){
					if(isset($_SESSION)){
						return $_SESSION[$key] = $value;
					} else {
						die("you must use session_start to turn on sessions at the top of the entry page.");
					}
			}
		}
?>