<?php 
class Mysql{
	protected $conn = false;
	protected $sql;

	public function __construct($config=array()){
		$host = isset($config['host'])? $config['host'] : 'localhost';
        $user = isset($config['user'])? $config['user'] : 'root';
        $password = isset($config['password'])? $config['password'] : '';
        $dbname = isset($config['dbname'])? $config['dbname'] : '';
        $port = isset($config['port'])? $config['port'] : '3306';
        $charset = isset($config['charset'])? $config['charset'] : '3306'; 
		
		$this->conn = mysqli_connect("$host:$port", $user, $password, $dbname) or die('database connection error');
		$this->setChar($charset);
	}

	private function setChar($charset){
		$sql = 'set names '. $charset;
		$this->query($sql);
	}
}