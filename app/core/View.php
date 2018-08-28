<?php
	/**
	 * Created by PhpStorm.
	 * User: chris
	 * Date: 2018-08-23
	 * Time: 12:11 PM
	 */
	
	class View {
		
		private $file;
		private $fileTitle;
		private $handlebars;
		private $data = '';
		private $headerFile;
		private $footerFile;
		private $baseTitle;
		private $templatesPath;
		private $titleDelimiter;
		private $title;
		private $baseTitleFirst;
		
		public function __construct($file, $handlebars = [], $headerFile = '', $footerFile = '') {
			$this->file           = $GLOBALS['config']['path']['views'].$file;
			$this->fileTitle      = $file;
			$this->handlebars     = $handlebars;
			$this->baseTitle      = $GLOBALS['config']['app']['title'];
			$this->titleDelimiter = $GLOBALS['config']['app']['titleDelimiter'];
			$this->baseTitleFirst = $GLOBALS['config']['app']['baseTitleFirst'];
			$this->templatesPath  = $GLOBALS['config']['path']['templates'];
			if(!file_exists($this->file)) {
				ErrorHandler::displayAndExit('File \''.$this->file.'\' does not exist or cannot be read.');
			}
			$this->setHeaderFile($headerFile);
			$this->setFooterFile($footerFile);
			$this->setTitle();
			$this->setStylesheets();
			return $this;
		}
		
		public function setHeaderFile($headerFile) {
			if(empty($headerFile)) {
				$headerFile = $GLOBALS['config']['defaults']['headerFile'];
			}
			if(file_exists($this->templatesPath.$headerFile)) {
				$this->headerFile = $this->templatesPath.$headerFile;
			} else {
				$this->headerFile = $this->templatesPath.$GLOBALS['config']['defaults']['headerFile'];
				ErrorHandler::displayAndContinue('File \''.$this->templatesPath.$headerFile.'\' does not exist or cannot be read.');
			}
			return $this;
		}
		
		public function setFooterFile($footerFile) {
			if(empty($footerFile)) {
				$footerFile = $GLOBALS['config']['defaults']['footerFile'];
			}
			if(file_exists($this->templatesPath.$footerFile)) {
				$this->footerFile = $this->templatesPath.$footerFile;
			} else {
				$this->footerFile = $this->templatesPath.$GLOBALS['config']['defaults']['footerFile'];
				ErrorHandler::displayAndContinue('File \''.$this->templatesPath.$footerFile.'\' does not exist or cannot be read.');
			}
			return $this;
		}
		
		private function setTitle() {
			if(isset($this->handlebars[':title']) && !empty($this->handlebars[':title'])) {
				if($this->handlebars[':title'] == ':none') {
					$this->title = $this->baseTitle;
				} else {
					if($this->baseTitleFirst) {
						$this->title = $this->baseTitle.$this->titleDelimiter.$this->handlebars[':title'];
					} else {
						$this->title = $this->handlebars[':title'].$this->titleDelimiter.$this->baseTitle;
					}
				}
			} else {
				$this->title = $this->fileTitle;
			}
			$this->handlebars[':title'] = $this->title;
			return $this;
		}
		
		private function setStylesheets() {
			if(isset($this->handlebars[':stylesheets']) && !empty($this->handlebars[':stylesheets'])) {
				if(is_array($this->handlebars[':stylesheets'])) {
					// :stylesheets is an array
					foreach($this->handlebars[':stylesheets'] as $key => $val) {
						$this->handlebars[':stylesheets'][$key] = $GLOBALS['config']['path']['stylesheets'].$val;
					}
				} else {
					// :stylesheets is a string
					$this->handlebars[':stylesheets'][] = $this->handlebars[':stylesheets'];
				}
			} else {
				// no stylesheet(s) given
				$this->handlebars[':stylesheets'][] = $GLOBALS['config']['path']['stylesheets'].$GLOBALS['config']['defaults']['stylesheet'];
			}
		}
		
		private function loadContents() {
			$this->data .= file_get_contents($this->headerFile);
			$this->data .= file_get_contents($this->file);
			$this->data .= file_get_contents($this->footerFile);
		}
		
		public static function load($file, $handlebars = []) {
			(new View($file, $handlebars))->display();
		}
		
		public function display() {
			$this->loadContents();
			echo Handlebars::execute($this->data, $this->handlebars);
		}
		
	}