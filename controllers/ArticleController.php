<?php

namespace Controllers;

use Entities\Article;
use Managers\ArticleManager;
use Managers\CategoryManager;
use App\Session;

class ArticleController extends Controller
{
	private $articleManager;
	private $categoryManager;

	public function __construct(articleManager, categoryManager)
{
	parent::__construct();
	$this->articleManager = articleManager // new ArticleManager();
	$this->categoryManager = categoryManager // new CategoryManager();
}

	public function createArticle()
	{
		$categories = $this->categoryManager->getAllCategories();
		$this->view('article_creation_form', compact('categories'));

	}

	public function storeArticle()
	{
		$errors = 0;
		// Je vérifie que les champs existent et ne sont pas vides
		if(!(isset($_POST['category']) and is_numeric($_POST['category']) and $_POST['category'] > 0)) {
			$errors++;
			Session::setFlash('category', 'Veuillez renseigner une catégorie.');
		}
		if(!(isset($_POST['title']) and mb_strlen($_POST['title']) > 2 and mb_strlen($_POST['title']) < 100)) {
			$errors++;
			Session::setFlash('title', 'Veuillez renseigner un titre.');
		}
		if(!(isset($_POST['content']))) {
			$errors++;
			Session::setFlash('content', 'Veuillez renseigner un contenu.');
		}
		if(!(isset($_POST['chapo']) and mb_strlen($_POST['chapo']) > 2 and mb_strlen($_POST['chapo']) < 100)) {
			$errors++;
			Session::setFlash('chapo', 'Veuillez renseigner un châpo.');
		}

		if($errors === 0) {
			// Si je n'ai pas d'erreurs
			$article = new Article(
				[
					'author'=>Session::id(),
					'category'=>$_POST['category'],
					'title'=>$_POST['title'],
					'content'=>$_POST['content'],
					'chapo'=>$_POST['chapo']
				]);

			$this->articleManager->storeArticle($article);

			header('Location: index.php');
			exit;
		} else {
			header('Location: index.php?action=create_article');
			exit;
		}
			
	}

	public function editArticle($id)
	{
		$article = $this->articleManager->getArticle($id);
		$categories = $this->categoryManager->getAllCategories();
		$this->view('article_edition_form', compact('article'));
	}

	public function updateArticle($id)
	{
		$errors = 0;
		$article = $this->articleManager->getArticle($_POST['id']);
		// Je vérifie que les champs existent et ne sont pas vides
		if(!(isset($_POST['category']) and is_numeric($_POST['category']) and $_POST['category'] > 0)) {
			$errors++;
			Session::setFlash('category', 'Veuillez renseigner une catégorie.');
		}
		if(!(isset($_POST['title']) and mb_strlen($_POST['title']) > 2 and mb_strlen($_POST['title']) < 100)) {
			$errors++;
			Session::setFlash('title', 'Veuillez renseigner un titre.');
		}
		if(!(isset($_POST['content']))) {
			$errors++;
			Session::setFlash('content', 'Veuillez renseigner un contenu.');
		}
		if(!(isset($_POST['chapo']) and mb_strlen($_POST['chapo']) > 2 and mb_strlen($_POST['chapo']) < 100)) {
			$errors++;
			Session::setFlash('chapo', 'Veuillez renseigner un châpo.');
		}

		if($errors === 0) {
			// SI je n'ai pas d'erreurs
			$category -> setCategory($_POST['category']);
			$category -> setTitle($_POST['title']);
			$category -> setContent($_POST['content']);
			$category -> setChapo($_POST['chapo']);
			
			$this->articleManager->updateArticle($article);

			header('Location: index.php');
			exit;
		} else {
			header('Location: index.php?action=create_article&postId=' . $id);
			exit;
		}
	}

	public function deleteArticle($id)
	{
		$this->articleManager->deleteArticle($id);

		header('Location: index.php');
		exit;
	}

	public function showArticle($id)
	{
		$article = $this->articleManager->getArticle($id);
		$this->view('article', compact('article'));
	}

	public function listArticles()
	{
		$article = $this->articleManager->getAllArticles($id);
		$this->view('articles_list');
	}

}