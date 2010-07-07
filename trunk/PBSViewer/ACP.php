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
	
	// if PB_log = true, than check ftp weblogin details whether it works or not
	if ($_POST['pb_log']==1)
	{
		$check_ftp	=	check_ftp_web_connection(FTP_HOST_WEB,FTP_PORT_WEB,FTP_USER_WEB,FTP_PASS_WEB,$_POST['pbsv_download_dir']);
		//	check if connection is possible
		if($check_ftp[0])
		{
			//	check if we can login
			if($check_ftp[1])
			{
				//	check if PB directory does not exist
				if(!$check_ftp[2])
				{
					$error_msg .= "<li>In order to use the pb_log setting first the ftp login details needs to be correct (check config.inc.php). Can't find directory, please specify right directory</li>";
					$saving = false;
				}
			}
			else 
			{
				$error_msg .= "<li>In order to use the pb_log setting first the ftp login details needs to be correct (check config.inc.php). FTP login failed, check username and password please</li>";
				$saving = false;
			}
		}
		else 
		{
			$error_msg .= "<li>In order to use the pb_log setting first the ftp login details needs to be correct (check config.inc.php). Can't connect to ftp server, please check ip and port</li>";
			$saving = false;
		}
	}
	
	if ($_POST['reset']==1)
	{
		$check_ftp	=	check_ftp_web_connection(FTP_HOST_WEB,FTP_PORT_WEB,FTP_USER_WEB,FTP_PASS_WEB,$_POST['pbsv_download_dir']);
		//	check if connection is possible
		if($check_ftp[0])
		{
			//	check if we can login
			if($check_ftp[1])
			{
				//	check if PB directory does not exist
				if(!$check_ftp[2])
				{
					$error_msg .= "<li>In order to use the reset option first the ftp login details needs to be correct (check config.inc.php). Can't find directory, please specify right directory</li>";
					$saving = false;
				}
			}
			else 
			{
				$error_msg .= "<li>In order to use the reset option first the ftp login details needs to be correct (check config.inc.php). FTP login failed, check username and password please</li>";
				$saving = false;
			}
		}
		else 
		{
			$error_msg .= "<li>In order to use the reset option first the ftp login details needs to be correct (check config.inc.php). Can't connect to ftp server, please check ip and port</li>";
			$saving = false;
		}
	}
	
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
		
		$sql_update = "UPDATE `settings` SET `value`='".addslashes($_POST['language'])."' WHERE `name`='language'";
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
	
	// default values
	$admin_mail			= '';
	$clan_name			= '';
	$clan_tag			= '';
	$clan_game			= '';
	$clan_game_short 	= '';
	$pb_dir 			= '';
	$custom_update 		= 0;
	$update_time 		= 86400;
	$pb_sv_ssceiling 	= 10000;
	$pbsv_download_dir	= '';
	$reset				= 1;
	$pbsvss_updater		= 1;
	$pb_log				= 1;
	$auto_del_count 	= -1;
	$nr_screens_main 	= 10;
	$screens_per_row	= 4;
	$width 				= 200;
	$height 			= 200;
	$CB_game			= 'none';
	$min_screen_size 	= 10000;
	$script_load_time	= 600;
	$weblog_dir 		= 'download';
	$debug				= 0;
	$language			= 'english';
	
	// gather data
	$sql_select = "SELECT `name`,`value` FROM `settings`";
	$sql = mysql_query($sql_select) or die(mysql_error());
	while ($row = mysql_fetch_object($sql))
	{
		if ($row->name=='admin_mail')
		{
			$admin_mail = $row->value;
		}
		elseif ($row->name=='clan_name')
		{
			$clan_name = $row->value;
		}
		elseif ($row->name=='clan_tag')
		{
			$clan_tag = $row->value;
		}
		elseif ($row->name=='clan_game')
		{
			$clan_game = $row->value;
		}
		elseif ($row->name=='clan_game_short')
		{
			$clan_game_short = $row->value;
		}
		elseif ($row->name=='pb_dir')
		{
			$pb_dir = $row->value;
		}
		elseif ($row->name=='custom_update')
		{
			$custom_update = $row->value;
		}
		elseif ($row->name=='update_time')
		{
			$update_time = $row->value;
		}
		elseif ($row->name=='pb_sv_ssceiling')
		{
			$pb_sv_ssceiling = $row->value;
		}
		elseif ($row->name=='pbsv_download_dir')
		{
			$pbsv_download_dir = $row->value;
		}
		elseif ($row->name=='reset')
		{
			$reset = $row->value;
		}
		elseif ($row->name=='pbsvss_updater')
		{
			$pbsvss_updater = $row->value;
		}
		elseif ($row->name=='pb_log')
		{
			$pb_log	 = $row->value;
		}
		elseif ($row->name=='auto_del_count')
		{
			$auto_del_count	 = $row->value;
		}
		elseif ($row->name=='nr_screens_main')
		{
			$nr_screens_main	 = $row->value;
		}
		elseif ($row->name=='screens_per_row')
		{
			$screens_per_row	 = $row->value;
		}
		elseif ($row->name=='width')
		{
			$width	 = $row->value;
		}
		elseif ($row->name=='height')
		{
			$height	 = $row->value;
		}
		elseif ($row->name=='CB_game')
		{
			$CB_game	 = $row->value;
		}
		elseif ($row->name=='min_screen_size')
		{
			$min_screen_size	 = $row->value;
		}
		elseif ($row->name=='script_load_time')
		{
			$script_load_time	 = $row->value;
		}
		elseif ($row->name=='weblog_dir')
		{
			$weblog_dir = $row->value;
		}
		elseif ($row->name=='debug')
		{
			$debug	 = $row->value;
		}
		elseif ($row->name=='language')
		{
			$language	 = $row->value;
		}
	}

	
	//	this is needed to make automatic class(css) altering of rows
	$row_nr		=	1;		//	odd nr get different class then even nr
	
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
	<table width="100%" border="0" align="center">
  <tr>
    <td align="center"><a href="http://www.beesar.com/work/php/pbsviewer/" target="_blank"><img src="style/img/header.png" alt="free php script" width="400" height="100" border="0"></a></td>
  </tr>
</table>
<br>
<table width="80%" border="0" align="center">
  <tr>
    <td align="center" class="bg_reset_table_row1"><span class="txt_light">:: Admin Control Panel ::</span></td>
  </tr>
  <tr>
    <td class="bg_reset_table_row2"><form name="form1" method="post" action=""><table width="90%" border="0" align="center">
      <tr>
        <td colspan="3" align="center"><strong>Welcome Admin, in this control panel you can configure most options. To change login details for ftp gameserver or ftp webhosting  please edit 'config.inc.php' manually<br>
            <br>
            <?echo '<a href="./" target="_parent">Click here to go back</a>';?>
            <br>
        </strong></td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong>User</strong></span></td>
      </tr>
      <tr>
        <td width="20%" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">Admin mail</td>
        <td width="45%" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="admin_mail" id="admin_mail" value="<?php echo $admin_mail;?>" onclick="this.focus();" size="40" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">Only fill in  if you want to be notified when someone has requested an update</td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong>Clan</strong></span></td>
      </tr>
      <tr>
        <td width="20%" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">Clan name</td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="clan_name" id="clan_name" value="<?php echo $clan_name;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">What is your full clan name?</td>
      </tr>
      <tr>
        <td width="20%" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">Clan Tag</td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="clan_tag" id="clan_tag" value="<?php echo $clan_tag;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">Your clantag ingame?</td>
      </tr>
      <tr>
        <td width="20%" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">Clan Game</td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="clan_game" id="clan_game" value="<?php echo $clan_game;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">Which game are you playing. So what is your gameserver running?</td>
      </tr>
      <tr>
        <td width="20%" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">Clan Game short</td>
        <td width="45%" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="clan_game_short" id="clan_game_short" value="<?php echo $clan_game_short;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">What is your game name in short?</td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong>Update</strong></span></td>
      </tr>
      <tr>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">PB directory</td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="pb_dir" id="pb_dir" value="<?php echo $pb_dir;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><p>Directory of punkbuster on your ftp gameserver.</p>
          <p>Use '/' and don't use 'pb/' with a trailing slash.</p></td>
      </tr>
      <tr>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">Custom update</td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <select name="custom_update" id="custom_update">
          <option value="1" <?php if($custom_update=='1') echo "selected"; ?>>True</option>
          <option value="0" <?php if($custom_update=='0') echo "selected"; ?>>False</option>  
          
            
          </select>
        </label></td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"> If 'custom update' is true then the admin or a cron job should run 'update.php' which is located in map 'update'.<br>
If option is false, then it will update after x seconds, this can be configured with 'Update time' see below.<br>
You still have the possibility to force an update manually by running 'update.php' if you want.</td>
      </tr>
      <tr>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">Update time</td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="update_time" id="update_time" value="<?php echo $update_time;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">The update time is in seconds. Use a small update time if gameserver is crowded (since a lot of new screens are captured), for example a public gameserver. However keep in mind that bandwith will also increase if update time is smaller. Recommended: 86400 seconds</td>
      </tr>
      <tr>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">pb_sv_SsCeiling</td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="pb_sv_ssceiling" id="pb_sv_ssceiling" value="<?php echo $pb_sv_ssceiling;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><p>To find your number open this file 'pbsv.cfg' and look for 'pb_sv_SsCeiling'. The file should be located in your 'pb' directory on your ftp of your gameserver. <br>
          It is recommended to have a small amount as possible to save some bandwith and space. NB both values of 'pb_sv_SsCeiling' as in 'pbsv.cfg' and here should be the same <br>
          If you are not sure please take a large number like 10000 or <a href="http://www.beesar.com/contact/">ask help</a><br>
          </p>
          <p>Game-violations has set this number to 10000<br>
            PB default is 100</p></td>
      </tr>
      <tr>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">PBSV download dir</td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="pbsv_download_dir" id="pbsv_download_dir" value="<?php echo $pbsv_download_dir;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><p>If you connect to your webserver through FTP, what is the location of the download folder of PBSViewer? copy past or type your path directly after login</p>
          <p>omit trailing slash /</p></td>
      </tr>
      <tr>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">Reset</td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <select name="reset" id="reset">
            <option value="1" <?php if($reset=='1') echo "selected"; ?>>True</option>
            <option value="0" <?php if($reset=='0') echo "selected"; ?>>False</option>
          </select>
        </label></td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">Default	=	false. Reset feature allows admins to delete all screens and log files from your webserver and gameserver. <br><br>In order to use this function you need to configure the login details of your ftp webhosting in config.inc.php.</td>
      </tr>
      <tr>
        <td width="20%" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">pbsvss_updater</td>
        <td width="45%" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <select name="pbsvss_updater" id="pbsvss_updater">
            <option value="1" <?php if($pbsvss_updater=='1') echo "selected"; ?>>True</option>
            <option value="0" <?php if($pbsvss_updater=='0') echo "selected"; ?>>False</option>
          </select>
        </label></td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">Default=false. pb keeps logging screenshots data to pbsvss.htm, it places the newest entries at the end of this file. However pb does not remove old data, so this file will keep on growing in size. If you choose true, then old entries will be removed automatically. This will keep the filesize at a small size.</td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong>Logging</strong></span></td>
      </tr>
      <tr>
        <td width="20%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">PB_log</td>
        <td width="45%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <select name="pb_log" id="pb_log">
            <option value="1" <?php if($pb_log=='1') echo "selected"; ?>>True</option>
            <option value="0" <?php if($pb_log=='0') echo "selected"; ?>>False</option>
          </select>
        </label></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><p>Gather more info about screens, like md5 check or ip address of players, with help of logs</p>
          <p>Default	=	false, If you don't want logging select false.</p>
          <p>Note that the FTP webhost (not your gameserver) login details needs to be configured correctly in 'config.inc.php' if you want to use logging.</p></td>
      </tr>
      <tr>
        <td width="20%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">max logs on webserver</td>
        <td width="45%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="auto_del_count" id="auto_del_count" value="<?php echo $auto_del_count;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
          </label></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><p>Default	=	4, 'max logs on webserver' has to be lower than PB_SV_LogCeiling. Otherwise there won't be an auto-delete. This is the number of logs stored on your webserver<br>
          If you choose 0, then log files are deleted immediately after updating<br>
          </p>
          <p>If you don't want to delete the logs from your webserver then enter -1</p></td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong>Template</strong></span></td>
      </tr>
      <tr>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">Screens on main page</td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="nr_screens_main" id="nr_screens_main" value="<?php echo $nr_screens_main;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">Default=10, on the main page the latest x screens are shown to save some bandwith</td>
      </tr>
      <tr>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">Screens per row</td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <select name="screens_per_row" id="screens_per_row">
            <option value="1" <?php if($screens_per_row=='1') echo "selected"; ?>>1</option>
            <option value="2" <?php if($screens_per_row=='2') echo "selected"; ?>>2</option>
            <option value="3" <?php if($screens_per_row=='3') echo "selected"; ?>>3</option>
            <option value="4" <?php if($screens_per_row=='4') echo "selected"; ?>>4</option>
            <option value="5" <?php if($screens_per_row=='5') echo "selected"; ?>>5</option>
            <option value="6" <?php if($screens_per_row=='6') echo "selected"; ?>>6</option>
          </select>
        </label></td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">Amount of screens you want to have on each row</td>
      </tr>
      <tr>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">Image width</td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="width" id="width" value="<?php echo $width;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">Thumbnail image width</td>
      </tr>
      <tr>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">Image height</td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="height" id="height" value="<?php echo $height;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">Thumbnail image height</td>
      </tr>
      <tr>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">Default language</td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">
        <?php
        // get all language files
        $lang_data	=	get_langs();
        if($lang_data)
        {
        	echo "<label><select name=\"language\" id=\"language\">";
        	
        	foreach ($lang_data as $lang_file)
        	{
        		if (get_current_lang()==$lang_file)
        		{
        			echo "<option value=\"".$lang_file."\" selected>".$lang_file."</option>\n";
        		}
        		else 
        		{
        			echo "<option value=\"".$lang_file."\">".$lang_file."</option>\n";
        		}
        	}
        	echo "            
          </select>
        </label>";
        }
        else
        {
        	echo "Please check your language directory, can't read/find language files";
        }
        
        ?>  
        
</td>
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">&nbsp;</td>
      </tr>
      <tr>
        <td width="20%" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">CB game</td>
        <td width="45%" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
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
        <td class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">The games in this list are supported by clanbase, please select the game that is running on your gameserver. This information will be used to automatically find clanbase players (only if he/she has joined cb) for each pb screenshot. select none if you don't want this extra information.</td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong>Advanced</strong></span></td>
      </tr>
      <tr>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">Minimal screen download size</td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="min_screen_size" id="min_screen_size" value="<?php echo $min_screen_size;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">Screens with a size smaller than the 'Minimal screen download size' are not downloaded, the size is in bytes.</td>
      </tr>
      <tr>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">Script load time</td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="script_load_time" id="script_load_time" value="<?php echo $script_load_time;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">After this the script stops running, if you for instance need to download a lot of screens then it is recommended to have a high script load time. If you are not sure, then use default setting. Default=600 seconds or 10 minutes, after 600 Maximum execution time error will be shown.</td>
      </tr>
      <tr>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">Web log dir</td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="weblog_dir" id="weblog_dir" value="<?php echo $weblog_dir;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">Directory where the log files are stored. The directory should be CHMODDED to 777.</td>
      </tr>
      <tr>
        <td width="20%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">Debug</td>
        <td width="45%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <select name="debug" id="debug">
            <option value="1" <?php if($debug=='1') echo "selected"; ?>>True</option>
            <option value="0" <?php if($debug=='0') echo "selected"; ?>>False</option>
          </select>
        </label></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">Default is false</td>
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
	<table width="100%" border="0" align="center">
  <tr>
    <td align="center"><a href="http://www.beesar.com/work/php/pbsviewer/" target="_blank"><img src="style/img/header.png" alt="free php script" width="400" height="100" border="0"></a></td>
  </tr>
</table>
<br>
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
	<table width="100%" border="0" align="center">
  <tr>
    <td align="center"><a href="http://www.beesar.com/work/php/pbsviewer/" target="_blank"><img src="style/img/header.png" alt="free php script" width="400" height="100" border="0"></a></td>
  </tr>
</table>
<br>

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