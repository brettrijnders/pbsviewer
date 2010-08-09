<?php
/*
    This program 'PBSViewer' also known as Punkbuster Screenshot Viewer, 
    will download pb screens. Those downloaded screens are published on
    your website.
    
    Copyright (C) 2010  B.S. Rijnders aka BandAhr

    PBSViewer is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    PBSViewer is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with PBSViewer.  If not, see <http://www.gnu.org/licenses/>.
    
    ____________________
    contact information:
    --------------------
    mail:		brettrijnders@gmail.com
    website:	http://www.beesar.com       

*/
session_start();
$key=md5(($_SERVER['SERVER_SIGNATURE'].' '.php_uname()));
require_once('inc/config.inc.php');
require_once('inc/init.inc.php');

require_once('inc/functions.inc.php');

//load correct language
include("inc/load_language.inc.php");
$update=false;

//	maximum script load time
ini_set('max_execution_time',script_load_time);



//	get time wrt to Unix
$startTime	=	get_microtime();

//	check if user is admin
if (is_admin()==true) $update=true;

$fileLastUpdate	=	'lastUpdate.txt';
if($update==true) 
{
	?>
	
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $str["UPD8_TITLE"];?></title>
<link href="style/style.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="style/img/favicon.ico"> 
</head>

<body>
		<table width="100%" border="0" align="center">
  <tr>
    <td align="center"><a href="http://www.beesar.com/work/php/pbsviewer/" target="_blank"><img src="style/img/header.png" alt="free php script" width="400" height="100" border="0"></a></td>
  </tr>
</table>
<br>
<table width="80%" border="0" align="center">
  <tr>
    <td align="center" class="bg_update_table_row1"><span class="txt_light">:: <?php echo $str["UPD8_TITLE_MENU"];?> ::</span></td>
  </tr>
  <tr>
    <td class="bg_update_table_row2"><table width="90%" border="0" align="center">
      <tr>
        <td><br><?update_file(FTP_HOST,FTP_PORT,FTP_USER,FTP_PASS,PBDIR.'/svss',L_FILE_TEMP,$fileLastUpdate,pb_sv_SsCeiling,true);?></td>
      </tr>
    </table>
      <br>
      <table width="50%" border="0" align="center">
        <tr>
          <td align="center"><?echo '<br>'.$str["UPD8_FINISHED"].'<br>';
	echo $str["UPD8_DURATION"].' '.get_loadTime($startTime,4).' '.$str["UPD8_DURATION_2"].'<br>';?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td class="bg_update_table_row3" align="center"><span class="txt_light"><?echo '<a href="./" target="_parent">'.$str["UPD8_BACK"].'</a>';?></span></td>
  </tr>
</table>
</body>
</html>

	
	<?
	
	
}
else 
{
	require_once('inc/templates.inc.php');
	die(template_denied());
}

?>