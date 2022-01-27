<?php
namespace Managers;
use Entities\User;
use PDO;

class UserManager extends Manager
{	
	public function store(User $user)
	{ 
		$sql = 'INSERT INTO user (last_name, first_name, email, password, role) VALUES (?, ?, ?, ?, ?)';
		$req = $this->db->prepare($sql);
		$req->execute([$user->getLast_name(), $user->getFirst_name(), $user->getEmail(), $user->getPassword(), $user->getRole()]);
	}

	public function getUser($email)
	{
		$req = $this->db->prepare('SELECT * FROM user WHERE email = ?');
		$req->execute(array($email));
		$req->setFetchMode(PDO::FETCH_ASSOC);
		$userData = $req->fetch();
		$user = new User($userData);
		return $user;

	}
}





