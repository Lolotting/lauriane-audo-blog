<?php
namespace Managers;
use Entities\Article;
use PDO;

class ArticleManager extends Manager
{	
	public function storeArticle(Article $article)
	{ 
		$sql = 'INSERT INTO article (author, category, title, content, chapo, creation, edition, suppression) VALUES (?, ?, ?, ?, ?, NOW(), NULL, NULL)';
		$req = $this->db->prepare($sql);
		$req->execute([$article->getAuthor(), $article->getCategory(), $article->getTitle(), $article->getContent(), $article->getChapo()]);
	}


	public function getArticle($id)
	{
		$req = $this->db->prepare('SELECT * FROM article WHERE id = ? AND suppression IS null');
		$req->execute(array($id));
		$req->setFetchMode(PDO::FETCH_ASSOC);
		$articleData = $req->fetch();
		$article = new Article($articleData);
		return $article;
	}

		public function getAllArticles()
	{
		$req = $this->db->query('SELECT * FROM article WHERE suppression IS NULL');
		$req->setFetchMode(PDO::FETCH_ASSOC);
		$articleData = $req->fetchAll();
		$articles=[];
			foreach ($articlesData as $value) {
				$articles[]= new Article($value);
			}
		return $articles;
	}

	public function updateArticle($article)
	{
		$req = $this->db->prepare('UPDATE article SET category = ?, title = ?, content = ?, chapo = ?, edition = NOW()');
		$req->execute(array($article->getCategory(), $article->getTitle(), $article->getContent(), $article->getChapo(), $article->getId()));
	}

	public function deleteArticle($id)
	{
		$req = $this->db->prepare('UPDATE article SET suppression = NOW() WHERE id = ?');
		$req->execute(array($id));
	}
}