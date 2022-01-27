<?php

require '../vendor/autoload.php';

session_start();


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

function dump($data) {
	echo '<pre>';
	var_dump($data);
	echo '</pre>';
}

require './../views/layout.html.twig';

//localhost/p5_blog/public/index.php?action=register

/* ROUTEUR */

$action = $_GET['action'] ?? null;
dump($action);
dump($_SESSION);

switch($action) {
	case 'create_article':
		$controller = new ArticleController();
		$controller->createArticle();
	break;
	case 'store_article':
		$controller = new ArticleController();
		$controller->storeArticle();
	break;
	case 'edit_article':
		$id=$_GET['postId'];
		$controller = new ArticleController();
		$controller->editArticle($id);
	break;
	case 'update_article':
		$id=$_GET['articleId'];
		$controller = new ArticleController();
		$controller->updateArticle($id);
	break;
	case 'delete_article':
		$id=$_GET['postId'];
		$controller = new ArticleController();
		$controller->deleteArticle($id);
	break;
	case 'article':
		$id=$_GET['postId'];
		$controller = new ArticleController();
		$controller->showArticle($id);
	break;
	case 'list_articles':
		$id=$_GET['postId'];
		$controller = new ArticleController();
		$controller->listArticles($id);
	break;

	case 'create_category':
		$controller = new CategoryController();
		$controller->createCategory();
	break;
	case 'store_category':
		$controller = new CategoryController();
		$controller->storeCategory();
	break;
	case 'edit_category':
		$id=$_GET['postId'];
		$controller = new CategoryController();
		$controller->editCategory($id);
	break;
	case 'update_category':
		$id=$_GET['categoryId'];
		$controller = new CategoryController();
		$controller->updateCategory($id);
	break;
	case 'delete_category':
		$id=$_GET['postId'];
		$controller = new CategoryController();
		$controller->deleteCategory($id);
	break;
	case 'list_categories':
		$controller = new CategoryController();
		$controller->listCategories($id);
	break;

}

/* FIN DU ROUTEUR */

Session::deleteFlash();