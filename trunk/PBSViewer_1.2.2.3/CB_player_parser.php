<?php

$url 	=	'http://clanbase.ggl.com/personlist.php';
$file		=	file($url);

foreach ($file as $line)
{
	//	find line that has the guid ids
	if(preg_match("~id=\"guidid\"~",$line,$match))
	{
		if(preg_match("~Select\:[a-zA-Z0-9]*Value\:~",$line,$match))
		{
			echo $match[0].'<br>';
		}
	}
}


?>
