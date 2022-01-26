<?php
namespace Managers;

final class Database
{
	private $pdo;
	private static $instance = null;

	private function __construct()
	{
		try 
		{
			$this->pdo = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8', $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
			if($_ENV['ENV'] === 'local') {
				$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			} else {
				$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT);
			}
			
		} catch (\PDOException $error) {
			echo $error->getMessage();
		}
	}

	final public static function getInstance() 
	{
		if(!(self::$instance instanceof self)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __clone() {
		throw new LogicException('Interdit de cloner un singleton ! ');
	}

	public function __wakeup() {
		throw new LogicException('Interdit de faire des instances en désérialisant ! ');
	}

	public function __call(string $name, array $arguments)
	{
		if(count($arguments) === 1 and method_exists(\PDO::class, $name)) {
			return $this->pdo->$name($arguments[0]);
		}
	}
}