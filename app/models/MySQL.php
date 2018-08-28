<?php
	/**
	 * Created by PhpStorm.
	 * User: chris
	 * Date: 2018-08-27
	 * Time: 11:48 PM
	 */
	
	class MySQL extends Model {
		
		private $dbh;
		private $stmt;
		private $host;
		private $port;
		private $usr;
		private $pwd;
		private $db;
		private $table;
		private $dsn = '';
		
		private function __construct($table = '') {
			$this->host = $GLOBALS['config']['database']['host'];
			$this->port = $GLOBALS['config']['database']['port'];
			$this->usr  = $GLOBALS['config']['database']['username'];
			$this->pwd  = $GLOBALS['config']['database']['password'];
			$this->db   = $GLOBALS['config']['database']['database'];
			$this->dsn  .= 'mysql:';
			$this->dsn  .= 'dbname='.$this->db.';';
			$this->dsn  .= 'host='.$this->host.';';
			if(!empty($this->port)) {
				$this->dsn .= 'port='.$this->port.';';
			}
			try {
				$this->dbh = new PDO($this->dsn, $this->usr, $this->pwd);
				return $this;
			} catch(PDOException $e) {
				echo '<span class="errorMessage">'.$e->getMessage().' (DSN: '.$this->dsn.')</span>';
				return false;
			}
		}
		
		public static function testConnect() {
			new self;
		}
		
		public static function run($sql, $params = []) {
			$obj       = new MySQL();
			$obj->stmt = $obj->dbh->prepare($sql);
			if(!is_array($params)) {
				$params = [$params];
			}
			foreach($params as $key => $val) {
				$obj->stmt->bindParam($key + 1, $val);
			}
			try {
				$obj->stmt->execute();
			} catch(PDOException $e) {
				echo $e->getMessage();
				return false;
			}
			return $obj->stmt->fetchAll();
		}
		
		public static function getLinks() {
			// Testmetod!!!
			//return getData("SELECT * FROM links");
			return (new MySQL())->dbh->query("SELECT * FROM links")->fetchAll();
		}
		
		public static function tableTest($table) {
			// Testmetod!!!
			return (new MySQL($table))->dbh->query('DESCRIBE links')->fetchAll();
		}
		
	}