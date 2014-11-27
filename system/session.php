<?php
namespace system;

class Session {

	private static $_sessionStarted = false;

	public static function init()
	{
		if(self::$_sessionStarted == false){
			session_start();
			self::$_sessionStarted = true;
		}
	}

	public static function set($key,$value)
	{
		$_SESSION[$key] = $value;
	}

	public static function get($key)
	{

		if(isset($_SESSION[$key]))
		{
			return $_SESSION[$key];
		}
		return false;
	}

	public static function display()
	{
		return $_SESSION;
	}

	public static function destroy()
	{
		if(self::$_sessionStarted == true)
		{
			session_unset();
			session_destroy();
		}
	}

	public static function setFlash($value, $type = 'info')
	{
		if(isset($_SESSION['flash']))
			array_push($_SESSION['flash'],array($value, $type));
		else{
			$_SESSION['flash'] = array();
			array_push($_SESSION['flash'],array($value, $type));
		}
	}

	public static function getFlash()
	{

		if(isset($_SESSION['flash']))
		{
			$tmp = $_SESSION['flash'];
			unset($_SESSION['flash']);
			foreach ($tmp as $messages => $message) {
				echo '<div class="alert alert-'.$message[1].' alert-dismissable">
					  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					  '.$message[0].'
				</div>';
			}

		}
	}
}