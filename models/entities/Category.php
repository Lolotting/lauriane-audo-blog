<?php
namespace Entities;
class Category extends Entity
{
	private $_name;


	public function setName($name) {
		$this->_name=$name;
	}

	public function getName() {
		return $this->_name;
	}
}

