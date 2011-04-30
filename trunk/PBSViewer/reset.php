<?php
/*
    This program 'PBSViewer' also known as Punkbuster Screenshot Viewer, 
    will download pb screens. Those downloaded screens are published on
    your website.
    
    Copyright (C) 2011  B.S. Rijnders aka BandAhr

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

$reset=false;

//	check if user's ip is on the list
if (is_admin()==true) $reset=true;

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
<title><?php echo $str['RESET_TITLE'];?></title>
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
    <td align="center" class="bg_reset_table_row1"><span class="txt_light">:: <?php echo $str["RESET_TITLE_MENU"];?> ::</span></td>
  </tr>
  <tr>
    <td class="bg_reset_table_row2"><table width="90%" border="0" align="center">
      <tr>
        <td><br><?php reset_pbsviewer(true);?></td>
      </tr>
    </table>
      <br>
      <table width="50%" border="0" align="center">
        <tr>
          <td align="center"><?php echo '<br>'.$str["RESET_FINISHED"].'<br>';
	echo $str["RESET_DURATION"].' '.get_loadTime($startTime,4).' '.$str["RESET_DURATION_2"].'<br>';?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td class="bg_reset_table_row3" align="center"><span class="txt_light"><?php echo '<a href="./" target="_parent">'.$str["RESET_GO_BACK"].'</a>';?></span></td>
  </tr>
</table>
</body>
</html>


<?php

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
<title><?php echo $str['RESET_TITLE'];?></title>
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
    <td align="center" class="bg_reset_table_row1"><span class="txt_light">:: <?php echo $str["RESET_TITLE_MENU"];?> ::</span></td>
  </tr>
  <tr>
    <td class="bg_reset_table_row2"><table width="90%" border="0" align="center">
      <tr>
        <td><strong><p><span class="txt_reset_warning"><?php echo $str["RESET_WARNING_QUESTION"];?><br>
          <?php echo $str["RESET_WARNING_RESULT"];?>:</p>
          <ul>
            <li><?php echo $str["RESET_RESULT_1"];?></li>
            <li><?php echo $str["RESET_RESULT_2"];?></li>
            <li><?php echo $str["RESET_RESULT_3"];?></li>
            </ul></span></strong>

            <table width="100%" border="0">
              <tr>
                <td align="center">          <form name="form1" method="post" action="">
            <label>              </label>            <label>
              <input type="submit" name="reset" id="reset" value="<?php echo $str["RESET_BUTTON"];?>" >
            </label>
          </form></td>
              </tr>
            </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="bg_reset_table_row3" align="center"><span class="txt_light"><?php echo '<a href="./" target="_parent">'.$str["RESET_GO_BACK"].'</a>';?></span></td>
  </tr>
</table>
</body>
</html>

	
	<?php 
	
	
}
else 
{
	require_once('inc/templates.inc.php');
	die(template_denied());
}
}
?>