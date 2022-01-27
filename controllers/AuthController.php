<?php

namespace Controllers;

use Entities\User;
use Managers\UserManager;
use App\Session;

class AuthController extends Controller
{
	public function __construct(userManager)
	{
		parent::__construct();
		$this->userManager = userManager //new UserManager();
	}

	public function register()
	{
		$errors = 0;
		// Je vérifie que les champs existent et ne sont pas vides
		if(!(isset($_POST['last_name']) and mb_strlen($_POST['last_name']) > 2 and mb_strlen($_POST['last_name']) < 100)) {
			$errors++;
			Session::setFlash('last_name', 'Veuillez renseigner un nom valide.');
		}
		if(!(isset($_POST['first_name']) and mb_strlen($_POST['first_name']) > 2 and mb_strlen($_POST['first_name']) < 100)) {
			$errors++;
			Session::setFlash('first_name', 'Veuillez renseigner un prénom valide.');
		}
		if(!(isset($_POST['mail']) and filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL) and mb_strlen($_POST['mail']) < 100)) {
			$errors++;
			Session::setFlash('mail', 'Veuillez renseigner une adresse mail valide.');
		}
		if(!(isset($_POST['password']) and mb_strlen($_POST['password'])>=8)) {
			$errors++;
			Session::setFlash('password','Le mot de passe est trop court');
		}
		
		if($errors === 0) {
			// SI je n'ai pas d'erreurs
			$password=password_hash($_POST['password'], PASSWORD_DEFAULT);
			$user=new User(
				[
					'last_name'=>$_POST['last_name'],
					'first_name'=>$_POST['first_name'],
					'email'=>$_POST['mail'],
					'password'=>$password,
					'role'=>'user',
				]);

			$this->userManager->store($user);
			// Il a été enregistré, on peut le rediriger vers la page de connexion
			header("Location: index.php?action=login");
			exit;
		} else {
			header("Location: index.php?action=register");
			exit;
		}

	}

	public function showRegisterForm()
	{
		$this->view('register');
	}

	public function login()
	{
		$errors=0;
		// Je vérifie que les champs existent et ne sont pas vides

		if(!(isset($_POST['mail']) and filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL) and mb_strlen($_POST['mail']) < 100)) {
			$errors++;
			Session::setFlash('mail', 'Veuillez renseigner une adresse mail valide.');
		}
		if(!(isset($_POST['password']) and mb_strlen($_POST['password'])>=8)) {
			$errors++;
			Session::setFlash('password','Le mot de passe est trop court');
		}

		if($errors === 0) {
			// Si je n'ai pas d'erreurs, je vais chercher dans la BDD l'entrée correspondant à l'adresse mail et je compare les mots de passe
			$user = $this->userManager->getUser($_POST['mail']);
			if(password_verify($_POST['password'], $user->getPassword())) {
				Session::set('id', $user->getId());
				Session::set('auth', true);
				Session::set('username', $user->getFirst_name().' '.$user->getLast_name());
				Session::set('role',$user->getRole());
				header("Location: index.php");
				exit;
				// Password ok
				// Connecter la personne
			}

		}	
	}

	public function showLoginForm()
	{
		$this->view('login');
	}

	public function logout()
	{
		// Si on clique sur le bouton "Déconnexion", alors on détruit la session
		$_SESSION = array(); /* Détruit toutes les variables de session */
		unset($_SESSION);
		session_destroy(); /* Détruit la session */
		header("Location: index.php");


	}

}