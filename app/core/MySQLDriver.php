<?php

class MySQLDriver implements DatabaseInterface
{
	private static $instance = null;
	private $error = false;
	private $query;
	private $result;
	private $pdo;

	public function __construct()
	{
		$this->connect();
	}

	public function __destruct()
	{
		$this->disconnect();
	}

	public function connect()
	{
		try {
			$dsn = 'mysql:host=' . Config::get('database/host') . ';dbname=' . Config::get('database/dbname') . ';charset=utf8';
			$this->pdo = new PDO($dsn, Config::get('database/user'), Config::get('database/password'));
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function disconnect()
	{
		$this->pdo = null;
	}

	public function executeQuery($sql, $params = [])
	{
		$this->error = false;
		if ($this->query = $this->pdo->prepare($sql)) {
			if (count($params)) {
				$index = 1;
				foreach ($params as $value) {
					$this->query->bindValue($index, $value, PDO::PARAM_STR);
					$index++;
				}
			}
			if ($this->query->execute()) {
				$this->result = $this->query->fetchAll(PDO::FETCH_ASSOC);
				return true;
			} else {
				$this->error = true;
				return false;
			}
		}
		return false;
	}

	public function getResults()
	{
		return $this->result;
	}

	public function getFirstResult()
	{
		return $this->result[0];
	}
}