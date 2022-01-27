<?php

namespace Controllers;

use Entities\Comment;
use Managers\CommentManager;
use App\Session;

class CommentController extends Controller
{
	private $commentManager;

	public function __construct(commentManager)
	{
		parent::__construct();
		$this->commentManager = commentManager // new CommentManager();
	}

	public function createComment($id)
	{
		$this->view('comment_creation_form', compact('id'));
	}

	public function storeComment()
	{
		$errors = 0;
		// Je vérifie que les champs existent et ne sont pas vides
		if(!(isset($_POST['title']) and mb_strlen($_POST['title']) > 2 and mb_strlen($_POST['title']) < 100)) {
			$errors++;
			Session::setFlash('title', 'Veuillez renseigner un titre.');
		}
		if(!(isset($_POST['content']))) {
			$errors++;
			Session::setFlash('content', 'Veuillez renseigner un contenu.');
		}

		if($errors === 0) {
			// Si je n'ai pas d'erreurs
			$comment = new Comment(
				[
					'article'=> $_POST['article'],
					'author'=>Session::id(),
					'title'=>$_POST['title'],
					'content'=>$_POST['content']
				]);

			$this->commentManager->storeComment($comment);

			header('Location: index.php');
			exit;
		} else {
			header('Location: index.php?action=create_comment&postId=' . $id);
			exit;
		}
			
	}

	public function editComment($id)
	{
		
		$comment = $this->commentManager->getComment($id);
		if($comment->getAuthor() == Session::id() or Session::role() === 'admin'){
			$this->view('comment_edition_form', compact('comment'));
		}
		else {
			header('Location: index.php');
			exit;
		}
	}

	public function updateComment($id)
	{
		$errors = 0;
		$comment = $this->commentManager->getComment($_POST['id']);
		// Je vérifie que les champs existent et ne sont pas vides
		if($comment->getAuthor() == Session::id() or Session::role() === 'admin'){
			if(empty($_POST['title']) and mb_strlen($_POST['title']) > 2 and mb_strlen($_POST['title']) < 100) {
				$errors++;
				Session::setFlash('title', 'Veuillez renseigner un titre.');
			}
			if(empty($_POST['content'])) {
				$errors++;
				Session::setFlash('content', 'Veuillez renseigner un contenu.');
			}

			if($errors === 0) {
				// SI je n'ai pas d'erreurs
				$comment -> setTitle($_POST['title']);
				$comment -> setContent($_POST['content']);
				
				$this->commentManager->updateComment($comment);

				header('Location: index.php');
				exit;
			} else {
				header('Location: index.php?action=edit_comment&postId=' . $id);
				exit;
			}

		}else {
			header('Location: index.php');
			exit;
		}
		
	}

	public function deleteComment($id)
	{
		$this->commentManager->deleteComment($id);

		header('Location: index.php');
		exit;
	}

	public function showComment($id)
	{
		$comment = $this->commentManager->getComment($id);
		$this->view('comment', compact('comment'));
	}

	public function listComments()
	{
		$comment = $this->commentManager->getAllComments($id);
		$this->view('comments_list');
	}

}