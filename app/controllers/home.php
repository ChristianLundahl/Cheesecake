<?php
	/**
	 * Created by PhpStorm.
	 * User: chris
	 * Date: 2018-08-20
	 * Time: 12:57 PM
	 */
	
	class home implements ControllerInterface {
		
		public function index() {
			View::load('home/index.html', [':title' => ':none']);
		}
		
	}