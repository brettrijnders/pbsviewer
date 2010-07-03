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

//	connect to DB
connect_DB();

if(isset($_POST['save'])&&$ACP==true)
{

	// keep track of saving status, if something goes wrong than saving will be false
	$saving = true;
	$error_msg = "";
	
	if ($_POST['pb_dir']=='')
	{
		$error_msg .= "<li>PB directory field is empty</li>";
		$saving = false;
	}
	if($_POST['update_time']<60 && $_POST['update_time']=='')
	{
		$error_msg .= "<li>update time should be larger than 60 seconds</li>";
		$saving = false;
	}
	if ($_POST['pb_sv_ssceiling']<=0 && $_POST['pb_sv_ssceiling']=='')
	{
		// something for feature release:
		// a check should be done to check if ceiling number is correct
		$error_msg .= "<li>pb_sv_ssceiling should be positive and larger than 0</li>";
		$saving = false;
	}
	if ($_POST['pbsv_download_dir']=='')				
	{
		// something for feature release:
		// a check should be done to check if download dir is correct		
		$error_msg .= "<li>PBSV download dir field is empty</li>";
		$saving = false;
	}
	if ($_POST['auto_del_count']!=-1 || $_POST['auto_del_count']<-1)
	{
		$error_msg .= "<li>Valid values for field 'max logs on webserver' are -1 or 0 and larger</li>";
		$saving = false;
	}
	if ($_POST['nr_screens_main']<=0 && $_POST['nr_screens_main']=='')
	{
		$error_msg .= "<li>nr of screens on main should be larger than 0</li>";
		$saving = false;
	}
	if ($_POST['width']=='')
	{
		$error_msg .= "<li>width field in template is empty</li>";
		$saving = false;
	}
	if ($_POST['height']=='')
	{
		$error_msg .= "<li>Height field in template is empty</li>";
		$saving = false;
	}
	if ($_POST['min_screen_size']=='' && $_POST['min_screen_size']<=0)
	{
		$error_msg .= "<li>field 'Minimal screen download size' is empty or has a negative value</li>";
		$saving = false;
	}
	if ($_POST['script_load_time']<30 && $_POST['script_load_time']=='')
	{
		$error_msg .= "<li>The script load time should be 30 seconds or larger</li>";
		$saving = false;
	}
	if ($_POST['weblog_dir']=='')
	{
		$error_msg .= "<li>The weblog directory is empty</li>";
		$saving = false;
	}
	
	// something for feature release:
	// if PB_log = true, than check ftp weblogin details whether it works or not
	
	if ($saving==true)
	{
		
		// update one by one
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['admin_mail'])."' WHERE `name`='admin_mail'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['clan_name'])."' WHERE `name`='clan_name'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['clan_tag'])."' WHERE `name`='clan_tag'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['clan_game'])."' WHERE `name`='clan_game';";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['clan_game_short'])."' WHERE `name`='clan_game_short'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['pb_dir'])."' WHERE `name`='pb_dir'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['custom_update'])."' WHERE `name`='custom_update'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['update_time'])."' WHERE `name`='update_time'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['pb_sv_ssceiling'])."' WHERE `name`='pb_sv_ssceiling'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['pbsv_download_dir'])."' WHERE `name`='pbsv_download_dir'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['reset'])."' WHERE `name`='reset'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['pbsvss_updater'])."' WHERE `name`='pbsvss_updater';";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['pb_log'])."' WHERE `name`='pb_log';";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['auto_del_count'])."' WHERE `name`='auto_del_count'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['nr_screens_main'])."' WHERE `name`='nr_screens_main'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['screens_per_row'])."' WHERE `name`='screens_per_row'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['width'])."' WHERE `name`='width'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['height'])."' WHERE `name`='height'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['CB_game'])."' WHERE `name`='CB_game'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['min_screen_size'])."' WHERE `name`='min_screen_size'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['script_load_time'])."' WHERE `name`='script_load_time'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['weblog_dir'])."' WHERE `name`='weblog_dir'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['debug'])."' WHERE `name`='debug'";
		$sql     	=	mysql_query($sql_update);
		
		//save data
		template_saved();
	}
	else 
	{
		//show error(s)
		template_error($error_msg);
	}
	


}
else 
{

if($ACP==true) 
{
	
	// gather data
	$i=0;	
	$sql_select = "SELECT * FROM `settings`";
	$sql = mysql_query($sql_select) or die(mysql_error());
	while ($row = mysql_fetch_object($sql))
	{
		$data[$i]	= $row->value;
		$i++;
	}
	
	$admin_mail			= $data[0];
	$clan_name			= $data[1];
	$clan_tag			= $data[2];
	$clan_game			= $data[3];
	$clan_game_short 	= $data[4];
	$pb_dir 			= $data[5];
	$custom_update 		= $data[6];
	$update_time 		= $data[7];
	$pb_sv_ssceiling 	= $data[8];
	$pbsv_download_dir	= $data[9];
	$reset				= $data[10];
	$pbsvss_updater		= $data[11];
	$pb_log				= $data[12];
	$auto_del_count 	= $data[13];
	$nr_screens_main 	= $data[14];
	$screens_per_row	= $data[15];
	$width 				= $data[16];
	$height 			= $data[17];
	$CB_game			= $data[18];
	$min_screen_size 	= $data[19];
	$script_load_time	= $data[20];
	$weblog_dir 		= $data[21];
	$debug				= $data[22];
	
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
          <input type="text" name="admin_mail" id="admin_mail" value="<?php echo $admin_mail;?>">
        </label></td>
        <td>Only fill in  if you want to be notified when someone has requested an update</td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong>Clan</strong></span></td>
      </tr>
      <tr>
        <td width="20%">Clan name</td>
        <td><label>
          <input type="text" name="clan_name" id="clan_name" value="<?php echo $clan_game;?>">
        </label></td>
        <td>What is your full clan name?</td>
      </tr>
      <tr>
        <td width="20%">Clan Tag</td>
        <td><label>
          <input type="text" name="clan_tag" id="clan_tag" value="<?php echo $clan_tag;?>">
        </label></td>
        <td>Your clantag ingame?</td>
      </tr>
      <tr>
        <td width="20%">Clan Game</td>
        <td><label>
          <input type="text" name="clan_game" id="clan_game" value="<?php echo $clan_game;?>">
        </label></td>
        <td>Which game are you playing. So what is your gameserver running?</td>
      </tr>
      <tr>
        <td width="20%">Clan Game short</td>
        <td width="45%"><label>
          <input type="text" name="clan_game_short" id="clan_game_short" value="<?php echo $clan_game_short;?>">
        </label></td>
        <td>What is your game name in short?</td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong>Update</strong></span></td>
      </tr>
      <tr>
        <td>PB directory</td>
        <td><label>
          <input type="text" name="pb_dir" id="pb_dir" value="<?php echo $pb_dir;?>">
        </label></td>
        <td><p>Directory of punkbuster on your ftp gameserver.</p>
          <p>Use '/' and don't use 'pb/' with a trailing slash.</p></td>
      </tr>
      <tr>
        <td>Custom update</td>
        <td><label>
          <select name="custom_update" id="custom_update">
          <option value="1" <?php if($custom_update=='1') echo "selected"; ?>>True</option>
          <option value="0" <?php if($custom_update=='0') echo "selected"; ?>>False</option>  
          
            
          </select>
        </label></td>
        <td> If 'custom' is true then the admin or a cron job should run the 'update.php' which is located in in map 'update'.<br>
If option is false, then it will update after x seconds which can can be configured with 'Update time' see below.<br>
You still have the possibility to force an update manually by running 'update.php' if you want.</td>
      </tr>
      <tr>
        <td>Update time</td>
        <td><label>
          <input type="text" name="update_time" id="update_time" value="<?php echo $update_time;?>">
        </label></td>
        <td>The update time is in seconds. Use a small update time if gameserver is crowded (since a lot of new screens are captured), for example a public gameserver. However keep in mind that bandwith will also increase if update time is smaller. Recommended: 86400 seconds</td>
      </tr>
      <tr>
        <td>pb_sv_SsCeiling</td>
        <td><label>
          <input type="text" name="pb_sv_ssceiling" id="pb_sv_ssceiling" value="<?php echo $pb_sv_ssceiling;?>">
        </label></td>
        <td><p>To find your number open this file 'pbsv.cfg' and look for 'pb_sv_SsCeiling'. The file should be located in your 'pb' directory on your ftp of your gameserver. <br>
          It is recommended to have a small amount as possible to save some bandwith and space. NB both values of 'pb_sv_SsCeiling' as in 'pbsv.cfg' and this config file should be the same <br>
          If you are not sure please take a large number like 10000 or contact me ;)<br>
          </p>
          <p>Game-violations has set this number to 10000<br>
            PB default is 100</p></td>
      </tr>
      <tr>
        <td>PBSV download dir</td>
        <td><label>
          <input type="text" name="pbsv_download_dir" id="pbsv_download_dir" value="<?php echo $pbsv_download_dir;?>">
        </label></td>
        <td><p>If you connect to your webserver through FTP, what is the location of the download folder of PBSViewer? copy past or type your path directly after login</p>
          <p>omit trailing slash /</p></td>
      </tr>
      <tr>
        <td>Reset</td>
        <td><label>
          <select name="reset" id="reset">
            <option value="1" <?php if($reset=='1') echo "selected"; ?>>True</option>
            <option value="0" <?php if($reset=='0') echo "selected"; ?>>False</option>
          </select>
        </label></td>
        <td>Default	=	false. Reset feature allows admins to delete all screens and log files from your webserver and gameserver</td>
      </tr>
      <tr>
        <td width="20%">pbsvss_updater</td>
        <td width="45%"><label>
          <select name="pbsvss_updater" id="pbsvss_updater">
            <option value="1" <?php if($pbsvss_updater=='1') echo "selected"; ?>>True</option>
            <option value="0" <?php if($pbsvss_updater=='0') echo "selected"; ?>>False</option>
          </select>
        </label></td>
        <td>Default=false. pb keeps logging screenshots data to pbsvss.htm, it places the newest entries at the end of this file. However pb does not remove old data, so this file will keep on growing in size. If you choose true, then old entries will be removed automatically. This will keep the filesize at a small size.</td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong>Logging</strong></span></td>
      </tr>
      <tr>
        <td width="20%" align="left">PB_log</td>
        <td width="45%" align="left"><label>
          <select name="pb_log" id="pb_log">
            <option value="1" <?php if($pb_log=='1') echo "selected"; ?>>True</option>
            <option value="0" <?php if($pb_log=='0') echo "selected"; ?>>False</option>
          </select>
        </label></td>
        <td align="left"><p>gather more info about screens, like md5 check or ip address of players, with help of logs</p>
          <p>Default	=	false, If you don't want logging use false</p>
          <p>Note that the FTP webhost (not your gameserver) login details needs to be configured correctly in 'config.inc.php' if you want to use logging.</p></td>
      </tr>
      <tr>
        <td width="20%" align="left">max logs on webserver</td>
        <td width="45%" align="left"><label>
          <input type="text" name="auto_del_count" id="auto_del_count" value="<?php echo $auto_del_count;?>">
          </label></td>
        <td align="left"><p>Default	=	4, 'max logs on webserver' has to be lower than PB_SV_LogCeiling. Otherwise there won't be an auto-delete. This is the number of logs stored on your webserver<br>
          If you choose 0, then log files are deleted immediately after updating<br>
          </p>
          <p>If you don't want to delete the logs from your webserver leave this filed empty</p></td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong>Template</strong></span></td>
      </tr>
      <tr>
        <td>Screens on main page</td>
        <td><label>
          <input type="text" name="nr_screens_main" id="nr_screens_main" value="<?php echo $nr_screens_main;?>">
        </label></td>
        <td>Default=10, on the main page the latest x screens are shown to save some bandwith</td>
      </tr>
      <tr>
        <td>Screens per row</td>
        <td><label>
          <select name="screens_per_row" id="screens_per_row">
            <option value="1" <?php if($screens_per_row=='1') echo "selected"; ?>>1</option>
            <option value="2" <?php if($screens_per_row=='2') echo "selected"; ?>>2</option>
            <option value="3" <?php if($screens_per_row=='3') echo "selected"; ?>>3</option>
            <option value="4" <?php if($screens_per_row=='4') echo "selected"; ?>>4</option>
            <option value="5" <?php if($screens_per_row=='5') echo "selected"; ?>>5</option>
            <option value="6" <?php if($screens_per_row=='6') echo "selected"; ?>>6</option>
          </select>
        </label></td>
        <td>Amount of screens you want to have on each row</td>
      </tr>
      <tr>
        <td>Image width</td>
        <td><label>
          <input type="text" name="width" id="width" value="<?php echo $width;?>">
        </label></td>
        <td>Thumbnail image width</td>
      </tr>
      <tr>
        <td>Image height</td>
        <td><label>
          <input type="text" name="height" id="height" value="<?php echo $height;?>">
        </label></td>
        <td>Thumbnail image height</td>
      </tr>
      <tr>
        <td width="20%">CB game</td>
        <td width="45%"><label>
          <select name="CB_game" id="CB_game">
          <option value="1" <?php if($CB_game=='none') echo "selected"; ?>>none</option>
          <?
          include("inc/CB_guidID.inc.php");
          foreach ($CBGUIDID as $CBdata)
          {
          	if ($CB_game==$CBdata[1])
          	{
          		echo "<option value=\"".$CBdata[1]."\" selected>".$CBdata[0]."</option>\n";
          	}
          	else 
          	{
          		echo "<option value=\"".$CBdata[1]."\">".$CBdata[0]."</option>\n";
          	}
          }
          ?>
            
          </select>
        </label></td>
        <td>The games in this list are supported by clanbase, please select the game that is running on your gameserver. This information will be used to automatically find clanbase players (only if he/she has joined cb) for each pb screenshot. select none if you don't want this extra information.</td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong>Advanced</strong></span></td>
      </tr>
      <tr>
        <td align="left">Minimal screen download size</td>
        <td align="left"><label>
          <input type="text" name="min_screen_size" id="min_screen_size" value="<?php echo $min_screen_size;?>">
        </label></td>
        <td align="left">Screens with a size smaller than the 'Minimal screen download size' are not downloaded.</td>
      </tr>
      <tr>
        <td align="left">Script load time</td>
        <td align="left"><label>
          <input type="text" name="script_load_time" id="script_load_time" value="<?php echo $script_load_time;?>">
        </label></td>
        <td align="left">After this time the script does stop running, if you for instance need   to download a lot of screens then it is recommended to have a high   script load time. If you are not sure, then use default setting. Default=600 seconds or 10 minutes, after 600 Maximum execution time error will be shown.</td>
      </tr>
      <tr>
        <td align="left">Web log dir</td>
        <td align="left"><label>
          <input type="text" name="weblog_dir" id="weblog_dir" value="<?php echo $weblog_dir;?>">
        </label></td>
        <td align="left">directory where the log files are stored. The directory should be CHMODDED to 777.</td>
      </tr>
      <tr>
        <td width="20%" align="left">Debug</td>
        <td width="45%" align="left"><label>
          <select name="debug" id="debug">
            <option value="1" <?php if($debug=='1') echo "selected"; ?>>True</option>
            <option value="0" <?php if($debug=='0') echo "selected"; ?>>False</option>
          </select>
        </label></td>
        <td align="left">Default is false</td>
      </tr>
      <tr>
        <td colspan="3"><table width="100%" border="0">
              <tr>
                <td align="center">          
            <label>              </label>            <label>
              <input type="submit" name="save" id="save" value="Save settings" >
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

function template_error($msg,$back_page='ACP.php')
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
    <td align="center" class="bg_reset_table_row1"><span class="txt_light">:: Error ::</span></td>
  </tr>
  <tr>
    <td class="bg_reset_table_row2"><table width="90%" border="0" align="center">
      <tr>
        <td align="center"><p>Something went wrong, see below for more details:</p>
          <p><br>
          <?echo $msg;?>
          <br>
          <span class="txt_light"><?echo "<a href=".$back_page." target=\"_parent\">Click here to go back</a>";?></span></p></td>
      </tr>
    </table>
      <br>
      <table width="50%" border="0" align="center">
        <tr>
          <td align="center"></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td class="bg_reset_table_row3" align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>
	
	<?
}

function template_saved()
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

<meta http-equiv="refresh" content="3;URL=./" />

<body>
<p>&nbsp;</p>
<table width="80%" border="0" align="center">
  <tr>
    <td align="center" class="bg_reset_table_row1"><span class="txt_light">:: Saving settings ::</span></td>
  </tr>
  <tr>
    <td class="bg_reset_table_row2"><table width="90%" border="0" align="center">
      <tr>
        <td align="center">Settings have been saved, you will now be redirected to main page in a couple of seconds<br><span class="txt_light"><?echo '<a href="./" target="_parent">Click here to go back</a>';?></span></td>
      </tr>
    </table>
      <br>
      <table width="50%" border="0" align="center">
        <tr>
          <td align="center"></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td class="bg_reset_table_row3" align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>
	
	<?
}
?>