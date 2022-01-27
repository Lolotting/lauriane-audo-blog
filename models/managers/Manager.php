<?php
namespace Managers;

abstract class Manager
{
	protected $db;

	public function __construct() {
		$this->db = Database::getInstance();
	}
}