<?php

namespace system\helper;

class Input
{

	public static function inject($string)
	{
		$autorises = "abcdefghijklmnopqrstuvxzwyABCDEFGHIJKLMNOPQRSTUVXZWY1234567890éèààôöâäïîçù, ©@.-_$^*!";

		if(is_array($string))
		{
			foreach ($string as $value)
			{
				for ($i=0; $i<strlen($value); $i++)
				{
					if (strpos($autorises, substr($value, $i, 1)) === FALSE)
						return TRUE;
				}
			}
		}
		else
		{
			for ($i=0; $i<strlen($string); $i++)
			{
				if (strpos($autorises, substr($string, $i, 1)) === FALSE)
					return TRUE;
			}
		}

		return FALSE;
	}

	function getAge($date_naissance){
		$arr1 = explode('-', $date_naissance);
		if(count($arr1 ) != 3)
			return false;
		$tmpannee = $arr1[0];
		$arr1[0] = $arr1[2];
		$arr1[2]= $tmpannee;
		$arr2 = explode('/', date('d/m/Y'));

		if(($arr1[1] < $arr2[1]) || (($arr1[1] == $arr2[1]) && ($arr1[0] <= $arr2[0])))
			return $arr2[2] - $arr1[2];

		return $arr2[2] - $arr1[2] - 1;
	}

	function getAvatar($path, $id){
		if(file_exists('public/upload/'.$id.'.png'))
			return $path.$id.'.png';
		return $path."empty.png";
	}
}