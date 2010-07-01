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
require_once('inc/templates.inc.php');
$ACP=false;

//	check if user's ip is on the list
foreach ($admin_ip as $ip)
{
	if($ip==$_SERVER['REMOTE_ADDR']) $ACP=true;
}

if(isset($_POST['ACP'])&&$ACP==true)
{

//	connect to DB
connect_DB();
	

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Admin Control Panel (ACP)</title>
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

if($ACP==true) 
{
	?>
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Admin Control Panel (ACP)</title>
<link href="style/style.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="style/img/favicon.ico"> 
</head>

<body>
<p>&nbsp;</p>
<table width="80%" border="0" align="center">
  <tr>
    <td align="center" class="bg_reset_table_row1"><span class="txt_light">:: Admin Control Panel ::</span></td>
  </tr>
  <tr>
    <td class="bg_reset_table_row2"><form name="form1" method="post" action=""><table width="90%" border="0" align="center">
      <tr>
        <td colspan="3"><strong>Welcome Admin, in this control panel you can configure most options. To change login details for ftp gameserver or ftp webhosting  please edit 'config.inc.php' manually<br>
          <br>
        </strong></td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong>User</strong></span></td>
      </tr>
      <tr>
        <td width="20%">Admin mail</td>
        <td width="45%"><label>
          <input type="text" name="admin_mail" id="admin_mail">
        </label></td>
        <td>Only fill in  if you want notified when someone has requested an update</td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong>Clan</strong></span></td>
      </tr>
      <tr>
        <td width="20%">Clan name</td>
        <td><label>
          <input type="text" name="clan_name" id="clan_name">
        </label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="20%">Clan Tag</td>
        <td><label>
          <input type="text" name="clan_tag" id="clan_tag">
        </label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="20%">Clan Game</td>
        <td><label>
          <input type="text" name="clan_game" id="clan_game">
        </label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="20%">Clan Game short</td>
        <td width="45%"><label>
          <input type="text" name="clan_game_short" id="clan_game_short">
        </label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong>Update</strong></span></td>
      </tr>
      <tr>
        <td>PB directory</td>
        <td><label>
          <input type="text" name="pb_dir" id="pb_dir">
        </label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Custom update</td>
        <td><label>
          <select name="custom_update" id="custom_update">
            <option value="1">True</option>
            <option value="0">False</option>
          </select>
        </label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>pb_sv_SsCeiling</td>
        <td><label>
          <input type="text" name="pb_sv_ssceiling" id="pb_sv_ssceiling">
        </label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>PBSV download dir</td>
        <td><label>
          <input type="text" name="pbsv_download_dir" id="pbsv_download_dir">
        </label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Reset</td>
        <td><label>
          <select name="reset2" id="reset2">
            <option value="1">True</option>
            <option value="0">False</option>
          </select>
        </label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="20%">pbsvss_updater</td>
        <td width="45%"><label>
          <select name="pbsvss_updater" id="pbsvss_updater">
            <option value="1">True</option>
            <option value="0">False</option>
          </select>
        </label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong>Template</strong></span></td>
      </tr>
      <tr>
        <td>screens per row</td>
        <td><label>
          <select name="screens_per_row" id="screens_per_row">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
          </select>
        </label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Image width</td>
        <td><label>
          <input type="text" name="width" id="width">
        </label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Image height</td>
        <td><label>
          <input type="text" name="height" id="height">
        </label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="20%">CB game</td>
        <td width="45%"><label>
          <select name="CB_game" id="CB_game">
            <option value="1">none</option>
          </select>
        </label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong>Advanced</strong></span></td>
      </tr>
      <tr>
        <td align="left">minimal screen size</td>
        <td align="left"><label>
          <input type="text" name="min_screen_size" id="min_screen_size">
        </label></td>
        <td align="center"></td>
      </tr>
      <tr>
        <td align="left">web log dir</td>
        <td align="left"><label>
          <input type="text" name="weblog_dir" id="weblog_dir">
        </label></td>
        <td align="center"></td>
      </tr>
      <tr>
        <td width="20%" align="left">Debug</td>
        <td width="45%" align="left"><label>
          <select name="debug" id="debug">
            <option value="1">True</option>
            <option value="0">False</option>
          </select>
        </label></td>
        <td align="center"></td>
      </tr>
      <tr>
        <td colspan="3"><table width="100%" border="0">
              <tr>
                <td align="center">          
            <label>              </label>            <label>
              <input type="submit" name="reset" id="reset" value="Save settings" >
            </label>
            </td>
              </tr>
          </table></td>
      </tr>
    </table>
    
    </form></td>
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