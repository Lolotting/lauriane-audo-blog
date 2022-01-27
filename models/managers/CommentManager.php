<?php
namespace Managers;
use Entities\Comment;
use PDO;

class CommentManager extends Manager
{	
	public function storeComment(Comment $comment)
	{ 
		$sql = 'INSERT INTO comment (article, author, title, content, creation, edit, suppression) VALUES (?, ?, ?, ?, NOW(), NULL, NULL)';
		$req = $this->db->prepare($sql);
		$req->execute([$comment->getArticle(), $comment->getAuthor(), $comment->getTitle(), $comment->getContent()]);
	}


	public function getComment($id)
	{
		$req = $this->db->prepare('SELECT * FROM comment WHERE id = ? AND suppression IS null');
		$req->execute(array($id));
		$req->setFetchMode(PDO::FETCH_ASSOC);
		$commentData = $req->fetch();
		$comment = new Comment($commentData);
		return $comment;

	}

		public function getAllComments()
	{
		$req = $this->db->query('SELECT * FROM comment WHERE suppression IS NULL');
		$req->setFetchMode(PDO::FETCH_ASSOC);
		$commentData = $req->fetchAll();
		$comments=[];
			foreach ($commentsData as $value) {
				$comments[]= new Comment($value);
			}
		return $comments;
	}

	public function updateComment($comment)
	{
		$req = $this->db->prepare('UPDATE comment SET title = ?, content = ?, edition = NOW()');
		$req->execute(array($comment->getTitle(), $comment->getContent(), $comment->getId()));
	}

	public function deleteComment($id)
	{
		$req = $this->db->prepare('UPDATE comment SET suppression = NOW() WHERE id = ?');
		$req->execute(array($id));
	}
}