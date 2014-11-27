<?php

namespace system\helper;

class String
{

	public static function truncate($chaine, $debut, $max, $url, $ponct=' [...]')
	{
		if (strlen($chaine) >= $max)
		{
			$chaine = substr($chaine, $debut, $max);
			$espace = strrpos($chaine, " ");
			$chaine = substr($chaine, $debut, $espace).' <a href="'.$url.'"> '.$ponct.'</a>';
		}
		return $chaine;
	}

	public static function tagUrl($chaine, $delimiter, $url)
	{

		$chaine = explode($delimiter, $chaine);
		foreach ($chaine as $key => $value) {
			$chaine[$key] = '<a href="'.$url.$value.'">'.$value.'</a>';
		}

		return implode(',', $chaine);
	}

	public static function parseCode($txt)
	{
		$ret = strip_tags($txt);
		$ret = preg_replace('#\[code\](.+)\[\/code\]#iUs', '<pre>$1</pre>', $ret);
		$ret = preg_replace('#\[youtube\](.+)\[\/youtube\]#iUs', '<iframe width="560" height="315" src="//www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>', $ret);
		$ret = preg_replace('#\[url\=(.+)\](.+)\[\/url\]#iUs', '<a href="$1">$2</a>', $ret);
		$ret = preg_replace('#\[br\]#iUs', '<br />', $ret);
		$ret = preg_replace('#\[img\=(.+)\.(.+)\](.+)\[\/img\]#iUs', '<img src="$3" width="$1" height="$2"  class="img-responsive" alt="Image" />', $ret);
		$ret = preg_replace('#\[img\](.+)\[\/img\]#iUs', '<img src="$1" class="img-responsive" alt="Image" />', $ret);

		$ret = preg_replace('#\[b\](.+)\[\/b\]#iUs', '<b>$1</b>', $ret);
		$ret = preg_replace('#\[i\](.+)\[\/i\]#iUs', '<em>$1</em>', $ret);
		$ret = preg_replace('#\[u\](.+)\[\/u\]#iUs', '<u>$1</u>', $ret);
		$ret = preg_replace('#\[p\](.+)\[\/p\]#iUs', '<p>$1</p>', $ret);

		return $ret;
	}

	public static function stripBBCode($txt)
	{
		$ret = strip_tags($txt);
		$ret = preg_replace('#\[code\](.+)\[\/code\]#iUs', '$1', $ret);
		$ret = preg_replace('#\[youtube\](.+)\[\/youtube\]#iUs', '$1', $ret);
		$ret = preg_replace('#\[url\=(.+)\](.+)\[\/url\]#iUs', '$2', $ret);
		$ret = preg_replace('#\[br\]#iUs', '', $ret);
		$ret = preg_replace('#\[img\=(.+)\.(.+)\](.+)\[\/img\]#iUs', '', $ret);
		$ret = preg_replace('#\[img\](.+)\[\/img\]#iUs', '', $ret);

		$ret = preg_replace('#\[b\](.+)\[\/b\]#iUs', '$1', $ret);
		$ret = preg_replace('#\[i\](.+)\[\/i\]#iUs', '$1', $ret);
		$ret = preg_replace('#\[u\](.+)\[\/u\]#iUs', '$1', $ret);
		$ret = preg_replace('#\[p\](.+)\[\/p\]#iUs', '$1', $ret);

		return $ret;
	}
}

 ?>