<?php
/*
    This program 'PBSViewer' also known as Punkbuster Screenshot Viewer, 
    will download pb screens. Those downloaded screens are published on
    your website.
    
    Copyright (C) 2009  B.S. Rijnders aka BandAhr

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

$key=md5(($_SERVER['SERVER_SIGNATURE'].' '.php_uname()));
require_once('inc/config.inc.php');
require_once('inc/functions.inc.php');

//	connect to DB
connect_DB();
require_once('inc/init.inc.php');
$reset=false;

//	check if user's ip is on the list
foreach ($admin_ip as $ip)
{
	if($ip==$_SERVER['REMOTE_ADDR']) $reset=true;
}

if(isset($_POST['reset'])&&$reset==true&&RESET==true)
{
	//	maximum script load time
ini_set('max_execution_time',script_load_time);
	
//	get time wrt to Unix
$startTime	=	get_microtime();


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Resetting Page</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="style/img/favicon.ico"> 
</head>

<body>
<p>&nbsp;</p>
<table width="80%" border="0" align="center">
  <tr>
    <td align="center" class="bg_reset_table_row1"><span class="txt_light">:: Resetting ::</span></td>
  </tr>
  <tr>
    <td class="bg_reset_table_row2"><table width="90%" border="0" align="center">
      <tr>
        <td><br><?reset_pbsviewer(true);?></td>
      </tr>
    </table>
      <br>
      <table width="50%" border="0" align="center">
        <tr>
          <td align="center"><?echo '<br>RESET FINISHED<br>';
	echo 'Reset took '.get_loadTime($startTime,4).' seconds<br>';?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td class="bg_reset_table_row3" align="center"><span class="txt_light"><?echo '<a href="./" target="_parent">Click here to go back</a>';?></span></td>
  </tr>
</table>
</body>
</html>


<?

}
else 
{

if($reset==true&&RESET==true) 
{
	?>
	
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Reset Page</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="style/img/favicon.ico"> 
</head>

<body>
<p>&nbsp;</p>
<table width="80%" border="0" align="center">
  <tr>
    <td align="center" class="bg_reset_table_row1"><span class="txt_light">:: resetting ::</span></td>
  </tr>
  <tr>
    <td class="bg_reset_table_row2"><table width="90%" border="0" align="center">
      <tr>
        <td><strong><p><span class="txt_reset_warning">If you are experiencing long load times for your website, then a reset may help. Are you sure you want to delete all data?<br>
          If you click on Reset, the following will happen:</p>
          <ul>
            <li>All screens are removed from you download folder on your webserver</li>
            <li>All logs and screens on your gameserver will be removed</li>
            <li>The database will be cleaned</li>
            </ul></span></strong>

            <table width="100%" border="0">
              <tr>
                <td align="center">          <form name="form1" method="post" action="">
            <label>              </label>            <label>
              <input type="submit" name="reset" id="reset" value="Reset" >
            </label>
          </form></td>
              </tr>
            </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="bg_reset_table_row3" align="center"><span class="txt_light"><?echo '<a href="./" target="_parent">Click here to go back</a>';?></span></td>
  </tr>
</table>
</body>
</html>

	
	<?
	
	
}
else 
{
	echo "ACCES DENIED!";
}
}
?>