<?php

namespace Middlewares;

use App\Session;

class AdminMiddleware
{
	public function __construct()
	{
		if (!$this->isAuth()) {
			header('Location: index.php');
			exit;
		}
	}

	private function isAuth()
	{
		return Session::has('auth') && Session::auth() && Session::role() === 'admin';
	}
}