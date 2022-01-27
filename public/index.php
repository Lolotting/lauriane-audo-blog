<?php

require '../vendor/autoload.php';

session_start();

use App\Session;
use Middlewares\AuthMiddleware;
use Middlewares\AdminMiddleware;
use Controllers\AuthController;
use Controllers\ArticleController;
use Controllers\CategoryController;
use Controllers\CommentController;

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
	case 'register':
		$controller = new AuthController();
		$controller->showRegisterForm();
	break;
	case 'signup':
		$controller = new AuthController();
		$controller->register();
	break;
	case 'login':
		$controller = new AuthController();
		$controller->showLoginForm();
	break;
	case 'signin':
		$controller = new AuthController();
		$controller->login();
	break;
	case 'signout':
		$controller = new AuthController();
		$controller->logout();
	break;

	case 'create_article':
		new AdminMiddleware();
		$controller = new ArticleController();
		$controller->createArticle();
	break;
	case 'store_article':
		new AdminMiddleware();
		$controller = new ArticleController();
		$controller->storeArticle();
	break;
	case 'edit_article':
		new AdminMiddleware();
		$id=$_GET['postId'];
		$controller = new ArticleController();
		$controller->editArticle($id);
	break;
	case 'update_article':
		new AdminMiddleware();
		$id=$_GET['articleId'];
		$controller = new ArticleController();
		$controller->updateArticle($id);
	break;
	case 'delete_article':
		new AdminMiddleware();
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
		new AdminMiddleware();
		$controller = new CategoryController();
		$controller->createCategory();
	break;
	case 'store_category':
		new AdminMiddleware();
		$controller = new CategoryController();
		$controller->storeCategory();
	break;
	case 'edit_category':
		new AdminMiddleware();
		$id=$_GET['postId'];
		$controller = new CategoryController();
		$controller->editCategory($id);
	break;
	case 'update_category':
		new AdminMiddleware();
		$id=$_GET['categoryId'];
		$controller = new CategoryController();
		$controller->updateCategory($id);
	break;
	case 'delete_category':
		new AdminMiddleware();
		$id=$_GET['postId'];
		$controller = new CategoryController();
		$controller->deleteCategory($id);
	break;
	case 'list_categories':
		$controller = new CategoryController();
		$controller->listCategories($id);
	break;

	case 'create_comment':
		new AuthMiddleware();
		$id=$_GET['postId'];
		$controller = new CommentController();
		$controller->createComment($id);
	break;
	case 'store_comment':
		new AuthMiddleware();
		$controller = new CommentController();
		$controller->storeComment();
	break;
	case 'edit_comment':
		new AuthMiddleware();
		$id=$_GET['postId'];
		$controller = new CommentController();
		$controller->editComment($id);
	break;
	case 'update_comment':
		new AuthMiddleware();
		$id=$_GET['commentId'];
		$controller = new CommentController();
		$controller->updateComment($id);
	break;
	case 'delete_comment':
		new AuthMiddleware();
		$id=$_GET['postId'];
		$controller = new CommentController();
		$controller->deleteComment($id);
	break;
	case 'show_comment':
		$id=$_GET['postId'];
		$controller = new CommentController();
		$controller->showComment($id);
	break;
	case 'list_comments':
		$id=$_GET['postId'];
		$controller = new CommentController();
		$controller->listComments($id);
	break;

}

/* FIN DU ROUTEUR */

Session::deleteFlash();