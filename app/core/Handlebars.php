<?php
	/**
	 * Created by PhpStorm.
	 * User: chris
	 * Date: 2018-08-23
	 * Time: 12:06 PM
	 */
	
	class Handlebars {
		
		private static $stylesheetLink = '<link href="?" rel="stylesheet">';
		
		public static function execute($content, $handlebars = []) {
			if(!isset($handlebars[':imagesPath'])) {
				$handlebars[':imagesPath'] = $GLOBALS['config']['path']['images'];
			}
			if(!isset($handlebars[':baseHref'])) {
				$handlebars[':baseHref'] = $GLOBALS['config']['app']['basePath'];
			}
			foreach($handlebars as $key => $val) {
				if($key == ':stylesheets') {
					$stylesheets = '';
					foreach($val as $stylesheet) {
						$stylesheets .= str_replace('?', $stylesheet, self::$stylesheetLink);
					}
					$content = str_replace('{{'.$key.'}}', $stylesheets, $content);
					continue;
				}
				$content = str_replace('{{'.$key.'}}', $val, $content);
			}
			return $content;
		}
		
	}