<?php
	/**
	 * Created by PhpStorm.
	 * User: chris
	 * Date: 2018-08-20
	 * Time: 11:29 AM
	 */
	
	class debug implements ControllerInterface {
		
		static function dump($var) {
			echo '<pre>';
			print_r($var);
			echo '</pre>';
		}
		
		public function index() {
		}
		
		public function phpinfo() {
			phpinfo();
		}
		
		public function pdo() {
			var_dump(MySQL::run('insert into links (href, meh) values (\'test\', \'test\')'));
		}
		
	}