<?php
namespace Entities;
class User extends Entity
{
	private $_last_name;
	private $_first_name;
	private $_email;
	private $_password;
	private $_role;


	public function setLast_name($last_name) {
		$this->_last_name=$last_name;
	}

	public function getLast_name() {
		return $this->_last_name;
	}

	public function setFirst_name($first_name) {
		$this->_first_name=$first_name;
	}

	public function getFirst_name() {
		return $this->_first_name;
	}

	public function setEmail($mail) {
		$this->_email=$mail;
	}

	public function getEmail() {
		return $this->_email;
	}

	public function setPassword($password) {
		$this->_password=$password;
	}

	public function getPassword() {
		return $this->_password;
	}

	public function setRole($role) {
		$this->_role=$role;
	}

	public function getRole() {
		return $this->_role;
	}
}

