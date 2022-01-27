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

Session::deleteFlash();