<?php
namespace Controllers;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\TwigFunction;
use App\Session;
abstract class Controller
{
	private $twig;

	public function __construct() {

		$loader=new FilesystemLoader('../views');
		$this->twig=new Environment($loader, ['cache'=>false]);
		$function = new TwigFunction('flash', function($name) {
			return Session::hasFlash($name) ? Session::getFlash($name) : null;
		});
		$this->twig->addFunction($function);

		$routeFunction = new TwigFunction('route', function($name, $params = null) {
			$baseRoute = sprintf('%spublic/index.php?action=%s',$_SERVER['APP_URL'], $name);
			$getParams = '';
			if($params != null and is_array($params)) {
				foreach($params as $key=>$value) {
					$getParams = sprintf('%s=%s&', $key, $value);
				}
			}
			return sprintf('%s%s',$baseRoute, $getParams=== '' ? '' : '&'.$getParams);
		});
		$this->twig->addFunction($routeFunction);

	}

	protected function view($path, $data = [])
	{
		echo $this->twig->render($path . '.html.twig', $data);
	}
}