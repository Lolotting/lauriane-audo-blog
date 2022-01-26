<?php
namespace Entities;
class Comment extends Entity
{
	private $_article;
	private $_author;
	private $_title;
	private $_content;
	private $_creation;
	private $_edition;
	private $_suppression;


	public function setArticle($article) {
		$this->_article=$article;
	}

	public function getArticle() {
		return $this->_article;
	}

	public function setAuthor($author) {
		$this->_author=$author;
	}

	public function getAuthor() {
		return $this->_author;
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
}

