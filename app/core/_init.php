<?php
	/**
	 * Created by PhpStorm.
	 * User: chris
	 * Date: 2018-08-20
	 * Time: 11:39 AM
	 */
	
	$GLOBALS['config'] = [
		'app'      => [
			'title'           => 'Stuff by Christian Lundahl',
			'titleDelimiter'  => ' - ',
			'baseTitleFirst'  => false,
			'domain'          => 'localhost',
			'port'            => 80,
			'basePath'        => 'chlu/',
			'localPath'       => '',
			'allowConfigFrom' => '192.168.10.23,::1',
			'isConfigured'    => true
		],
		'path'     => [
			'app'         => 'app/',
			'addons'      => 'app/addons/',
			'core'        => 'app/core/',
			'controllers' => 'app/controllers/',
			'interfaces'  => 'app/interfaces/',
			'models'      => 'app/models/',
			'views'       => 'app/views/',
			'templates'   => 'app/templates/',
			'assets'      => 'public/assets/',
			'images'      => 'public/assets/images/',
			'javascript'  => 'public/assets/javascript/',
			'stylesheets' => 'public/assets/stylesheets/'
		],
		'uri'      => [
			'configWizard' => 'config/wizard/'
		],
		'defaults' => [
			'class'      => 'home',
			'method'     => 'index',
			'headerFile' => 'defaultHeader.html',
			'footerFile' => 'defaultFooter.html',
			'stylesheet' => 'default.css'
		],
		'database' => [
			'host'     => 'localhost',
			'port'     => 3306,
			'username' => 'root',
			'password' => '',
			'database' => 'chlu'
		]
	];
	
	spl_autoload_register(function($class) {
		$fileName = $class.'.php';
		$path     = [
			$GLOBALS['config']['path']['addons'],
			$GLOBALS['config']['path']['controllers'],
			$GLOBALS['config']['path']['core'],
			$GLOBALS['config']['path']['interfaces'],
			$GLOBALS['config']['path']['models']
		];
		foreach($path as $dir) {
			if(file_exists($dir.$fileName)) {
				require_once $dir.$fileName;
				break;
			}
		};
	});
	
	$router = new Router();