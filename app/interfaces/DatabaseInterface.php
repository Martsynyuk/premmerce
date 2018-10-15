<?php

interface DatabaseInterface
{
	public function connect();
	public function disconnect();
	public function executeQuery($sql, $params = []);
}