<?php
namespace Managers;
use Entities\Category;
use PDO;

class CategoryManager extends Manager
{	
	public function storeCategory(Category $category)
	{ 
		$sql = 'INSERT INTO category (name) VALUES (?)';
		$req = $this->db->prepare($sql);
		$req->execute([$category->getName()]);
	}


	public function getAllCategories()
	{
		$req = $this->db->query('SELECT * FROM category');
		$req->setFetchMode(PDO::FETCH_ASSOC);
		$categoryData = $req->fetchAll();
		$categories=[];
			foreach ($categoryData as $value) {
				$categories[]= new Category($value);
			}
		return $categories;

	}

	public function getCategory($id)
	{
		$req = $this->db->prepare('SELECT * FROM category WHERE id = ?');
		$req->execute(array($id));
		$req->setFetchMode(PDO::FETCH_ASSOC);
		$categoryData = $req->fetch();
		$category = new Category($categoryData);
		return $category;
	}

	public function updateCategory($category)
	{
		$req = $this->db->prepare('UPDATE category SET name = ? WHERE id = ?');
		$req->execute(array($category->getName(), $category->getId()));
	}

	public function deleteCategory($id)
	{
		$req = $this->db->prepare('DELETE * FROM category WHERE id = ?');
		$req->execute(array($id));
	}
}