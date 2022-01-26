<?php
namespace Entities;
class Article extends Entity
{
	private $_author;
	private $_category;
	private $_title;
	private $_content;
	private $_creation;
	private $_edition;
	private $_suppression;
	private $_chapo;

	
	public function setAuthor($author) {
		$this->_author=$author;
	}

	public function getAuthor() {
		return $this->_author;
	}

	public function setCategory($category) {
		$this->_category=$category;
	}

	public function getCategory() {
		return $this->_category;
	}

	public function setTitle($title) {
		$this->_title=$title;
	}

	public function getTitle() {
		return $this->_title;
	}

	public function setContent($content) {
		$this->_content=$content;
	}

	public function getContent() {
		return $this->_content;
	}

	public function setCreation($creation) {
		$this->_creation=$creation;
	}

	public function getCreation() {
		return $this->_creation;
	}

	public function setEdition($edition) {
		$this->_edition=$edition;
	}

	public function getEdition() {
		return $this->_edition;
	}

	public function setSuppression($suppression) {
		$this->_suppression=$suppression;
	}

	public function getSuppression() {
		return $this->_suppression;
	}

	public function setChapo($chapo) {
		$this->_chapo=$chapo;
	}

	public function getChapo() {
		return $this->_chapo;
	}
}

