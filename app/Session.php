<?php
namespace App;
class Session 
{
	public static function set(string $key, $value) : void {
		$_SESSION[$key] = $value;
	}

	public static function __callStatic($name, $arguments)
	{
		if(isset($_SESSION[$name])) {
			return $_SESSION[$name];
		}
	}

	public static function getFlash(string $key) 
	{
		return $_SESSION['flash'][$key];
	}

	public static function setFlash(string $key, $value) : void {
		$_SESSION['flash'][$key] = $value;
	}

	public static function deleteFlash()
	{
		unset($_SESSION['flash']);
	}

	public static function has(string $key) : bool {
		return isset($_SESSION[$key]);
	}

	public static function hasFlash(string $key) : bool {
		return (isset($_SESSION['flash']) and isset($_SESSION['flash'][$key]));
	}
}