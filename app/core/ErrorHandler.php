<?php
	/**
	 * Created by PhpStorm.
	 * User: chris
	 * Date: 2018-08-23
	 * Time: 12:31 PM
	 */
	
	class ErrorHandler {
		
		public static function displayAndExit($msg) {
			echo '<p><strong>EXIT: </strong>'.$msg.'</p>';
			exit;
		}
		
		public static function displayAndContinue($msg) {
			echo '<p><strong>EXIT: </strong>'.$msg.'</p>';
		}
		
	}