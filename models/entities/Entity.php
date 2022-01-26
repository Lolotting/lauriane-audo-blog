<?php
namespace Entities;
abstract class Entity
{
	protected $_id;

	public function __construct(array $data = [])
	{
		if(count($data)) {
			foreach($data as $propertyName=>$value) {
				$method = 'set'.ucfirst($propertyName);
				//$method = sprintf("set%s", ucfirst($propertyName))
				if(method_exists($this, $method)) {
					$this->$method($value);
				}
			}

		}
	}

	public function setId($id) {
		$this->_id=$id;
	}

	public function getId() {
		return $this->_id;
	}
}

