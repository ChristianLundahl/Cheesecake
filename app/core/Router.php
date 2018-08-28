<?php
	/**
	 * Created by PhpStorm.
	 * User: chris
	 * Date: 2018-08-20
	 * Time: 11:09 AM
	 */
	
	class Router {
		
		private       $uri;
		private       $route;
		public        $class;
		public        $method;
		public        $args;
		private       $defaultClass;
		private       $defaultMethod;
		private       $controller;
		public static $RTR_CLASS_INDEX      = 0;
		public static $RTR_METHOD_INDEX     = 1;
		public static $RTR_ARGS_START_INDEX = 2;
		
		public function __construct() {
			$host                = $GLOBALS['config']['app']['domain'];
			$basePath            = $GLOBALS['config']['app']['basePath'];
			$this->defaultClass  = $GLOBALS['config']['defaults']['class'];
			$this->defaultMethod = $GLOBALS['config']['defaults']['method'];
			$this->uri           = str_replace($basePath, '', $_SERVER['REQUEST_URI']);
			$this->createRoute();
			$this->load();
		}
		
		private function load() {
			$isConfigured     = $GLOBALS['config']['app']['isConfigured'];
			$configWizard     = $GLOBALS['config']['uri']['configWizard'];
			$this->class      = ($isConfigured) ? $this->getClass() : explode('/', $configWizard)[0];
			$this->method     = ($isConfigured) ? $this->getMethod() : explode('/', $configWizard)[1];
			$this->controller = new $this->class();
			$this->controller->{$this->method}();
		}
		
		private function createRoute() {
			$this->route  = explode('/', trim($this->uri, '/'), self::$RTR_ARGS_START_INDEX + 1);
			$this->class  = isset($this->route[self::$RTR_CLASS_INDEX]) ? $this->route[self::$RTR_CLASS_INDEX] : null;
			$this->method = isset($this->route[self::$RTR_METHOD_INDEX]) ? $this->route[self::$RTR_METHOD_INDEX] : null;
			$this->args   = isset($this->route[self::$RTR_ARGS_START_INDEX]) ? explode('/', $this->route[self::$RTR_ARGS_START_INDEX]) : null;
		}
		
		private function getClass() {
			if(isset($this->class) && !empty($this->class)) {
				if(class_exists($this->class)) {
					return $this->class;
				} else {
					header("HTTP/1.0 404 Not Found");
					die;
				}
			} else {
				return $this->defaultClass;
			}
		}
		
		private function getMethod() {
			if(isset($this->method) && method_exists($this->getClass(), $this->method)) {
				return $this->method;
			} else {
				$this->route['method'] = $this->route[1] = $this->method = $this->defaultMethod;
				return $this->defaultMethod;
			}
		}
		
		public static function redirect($url) {
			header("location: $url");
		}
		
		public function debug() {
			debug::dump($this);
		}
		
	}