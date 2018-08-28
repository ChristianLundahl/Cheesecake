<?php
	/**
	 * Created by PhpStorm.
	 * User: chris
	 * Date: 2018-08-23
	 * Time: 1:57 AM
	 */
	
	class Config {
		
		private $remoteAddr;
		private $remoteAddrDelimiter;
		private $allowConfigFrom;
		private $isConfigured;
		private $usingIPv6;
		
		public function __construct() {
			$this->remoteAddr          = $_SERVER['REMOTE_ADDR'];
			$this->allowConfigFrom     = explode(',', $GLOBALS['config']['app']['allowConfigFrom']);
			$this->isConfigured        = $GLOBALS['config']['app']['isConfigured'];
			$this->usingIPv6           = substr_count($this->remoteAddr, ':') > 0;
			$this->remoteAddrDelimiter = ($this->usingIPv6) ? ':' : '.';
		}
		
		public function wizard() {
			if($this->isAllowed()) {
				View::load('config/wizard.html', ['title' => 'Configuration Wizard',]);
			} else {
				echo 'You do not have permission to configure this site.<br />Please edit your init.php file to allow your IP address.';
			}
		}
		
		private function isAllowed() {
			if(in_array('*', $this->allowConfigFrom)) {
				return true;
			}
			if(in_array($this->remoteAddr, $this->allowConfigFrom)) {
				return true;
			}
			$arrayRemoteAddr      = explode($this->remoteAddrDelimiter, $this->remoteAddr);
			foreach($this->allowConfigFrom as $pattern) {
				$allowed      = false;
				$arrayPattern = explode($this->remoteAddrDelimiter, $pattern);
				if(count($arrayRemoteAddr) != count($arrayPattern)) {
					continue;
				}
				for($i = 0; $i < count($arrayPattern); $i++) {
					if($arrayPattern[$i] != $arrayRemoteAddr[$i]) {
						$allowed = false;
						break;
					} else {
						$allowed = true;
					}
				}
				if($allowed) {
					break;
				}
			}
			return $allowed;
		}
		
	}