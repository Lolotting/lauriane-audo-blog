<?php

namespace Controllers;

use Entities\Category;
use Managers\CategoryManager;
use App\Session;

class CategoryController extends Controller
{
	private $categoryManager;

	public function __construct()
	{
		parent::__construct();
		$this->categoryManager = new CategoryManager();
	}

	public function createCategory()
	{
		$this->view('category_creation_form');

	}

	public function storeCategory()
	{
		$errors = 0;
		// Je vérifie que le champ existe et n'est pas vide
		if(!(isset($_POST['name']) and mb_strlen($_POST['name']) > 2 and mb_strlen($_POST['name']) < 100)) {
			$errors++;
			Session::setFlash('name', 'Veuillez renseigner un nom de catégorie.');
		}

		if($errors === 0) {
			// SI je n'ai pas d'erreur
			$category = new Category(
				[
					'name'=>$_POST['name']
				]);

			$this->categoryManager->storeCategory($category);

			header('Location: index.php');
			exit;
		} else {
			header('Location: index.php?action=create_category');
			exit;
		}	
	}

	public function editCategory($id)
	{
		$category = $this->categoryManager->getCategory($id);
		$this->view('category_edition_form', compact('category'));
	}

	public function updateCategory($id)
	{
		$errors = 0;
		$category = $this->categoryManager->getCategory($id);
		// Je vérifie que les champs existent et ne sont pas vides
		if(empty($_POST['name'])) {
			$errors++;
			Session::setFlash('name', 'Veuillez renseigner un nom de catégorie.');
		}

		if($errors === 0) {
			// SI je n'ai pas d'erreurs
			$category -> setName($_POST['name']);
			$this->categoryManager->updateCategory($category);

			header('Location: index.php');
			exit;
		} else {
			header('Location: index.php?action=edit_category&postId=' . $id);
			exit;
		}
	}

	public function deleteCategory($id)
	{
		$this->categoryManager->deleteCategory($id);

		header('Location: index.php');
		exit;
	}

	public function listCategories()
	{
		$this->categoryManager->getAllCategories();
		$this->view('categories_list');
	}
}