<?php
	/**
	 * Created by PhpStorm.
	 * User: chris
	 * Date: 2018-08-22
	 * Time: 2:04 AM
	 */
	
	class StringX {
	
		private $str;
		
		public function __construct($str) {
			$this->str = $str;
			return $this;
		}
		
		public function __toString() {
			return $this->str;
		}
		
		public function replace($s, $r) {
			$this->str = str_replace($s, $r, $this->str);
			return $this;
		}
		
		public function preg_replace($p, $r) {
			$this->str = preg_replace($p, $r, $this->str);
			return $this;
		}
		
		public function toUpper() {
			$this->str = strtoupper($this->str);
			return $this;
		}
		
		public function toLower() {
			$this->str = strtolower($this->str);
			return $this;
		}
		
		public function split($d, $l=null) {
			return explode($d, $this->str, $l);
		}
		
		public static function with($str) {
			return new self($str);
		}
		
	}