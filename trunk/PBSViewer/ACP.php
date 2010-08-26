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
require_once('inc/templates.inc.php');
$ACP=false;



//	check if user's ip is on the list
if (is_admin()==true) $ACP=true;

//load correct language
include("inc/load_language.inc.php");

if(isset($_POST['save'])&&$ACP==true)
{

	// keep track of saving status, if something goes wrong than saving will be false
	$saving = true;
	$error_msg = "";
	
	//	get member ID
	if(isset($_SESSION['ADMIN_ID'])) $memberID = $_SESSION['ADMIN_ID'];
	if(isset($_COOKIE['IDCookie'])) $memberID = $_COOKIE['IDCookie'];
	
	if ($_POST['name']=='')
	{
		$error_msg .= "<li>name field is empty, please enter a valid username.</li>";
		$saving = false;
	}
	if ($_POST['mail']=='')
	{
		$error_msg .= "<li>mail field is empty, you need to fill in your mail.</li>";
		$saving = false;
	}
	if ($_POST['pb_dir']=='')
	{
		$error_msg .= "<li>PB directory field is empty.</li>";
		$saving = false;
	}
	if($_POST['update_time']<60 || $_POST['update_time']=='')
	{
		$error_msg .= "<li>update time should be larger than 60 seconds.</li>";
		$saving = false;
	}
	if ($_POST['pb_sv_ssceiling']<=0 || $_POST['pb_sv_ssceiling']=='')
	{
		// something for feature release:
		// a check should be done to check if ceiling number is correct
		$error_msg .= "<li>pb_sv_ssceiling should be positive and larger than 0.</li>";
		$saving = false;
	}
	if ($_POST['pbsv_download_dir']=='')				
	{
		// something for feature release:
		// a check should be done to check if download dir is correct		
		$error_msg .= "<li>PBSV download dir field is empty.</li>";
		$saving = false;
	}
	if (!($_POST['auto_del_count']==-1 || $_POST['auto_del_count']>=0))
	{
		$error_msg .= "<li>Valid values for field 'max logs on webserver' are -1 or 0 and larger.</li>";
		$saving = false;
	}
	if ($_POST['nr_screens_main']<=0 || $_POST['nr_screens_main']=='')
	{
		$error_msg .= "<li>nr of screens on main should be larger than 0.</li>";
		$saving = false;
	}
	if($_POST['search_limit']<=0 || $_POST['search_limit']=='')
	{
		$error_msg	.=	"<li>The search limit should be larger than 0.</li>";
		$saving	=	false;
	}
	if ($_POST['width']=='')
	{
		$error_msg .= "<li>width field in template is empty.</li>";
		$saving = false;
	}
	if ($_POST['height']=='')
	{
		$error_msg .= "<li>Height field in template is empty.</li>";
		$saving = false;
	}
	if ($_POST['min_screen_size']=='' || $_POST['min_screen_size']<=0)
	{
		$error_msg .= "<li>field 'Minimal screen download size' is empty or has a negative value.</li>";
		$saving = false;
	}
	if ($_POST['cookieExpTime']<0||$_POST['cookieExpTime']=='')
	{
		$error_msg .= "<li>Please use a valid value for the field Cookie experiment time. It should be positive and not empty.</li>";
		$saving = false;
	}
	if ($_POST['script_load_time']<30 || $_POST['script_load_time']=='')
	{
		$error_msg .= "<li>The script load time should be 30 seconds or larger.</li>";
		$saving = false;
	}
	if ($_POST['weblog_dir']=='')
	{
		$error_msg .= "<li>The weblog directory is empty.</li>";
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
					$error_msg .= "<li>In order to use the pb_log setting first the ftp login details needs to be correct (check config.inc.php). Can't find directory, please specify right directory.</li>";
					$saving = false;
				}
			}
			else 
			{
				$error_msg .= "<li>In order to use the pb_log setting first the ftp login details needs to be correct (check config.inc.php). FTP login failed, check username and password please.</li>";
				$saving = false;
			}
		}
		else 
		{
			$error_msg .= "<li>In order to use the pb_log setting first the ftp login details needs to be correct (check config.inc.php). Can't connect to ftp server, please check ip and port.</li>";
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
					$error_msg .= "<li>In order to use the reset option first the ftp login details needs to be correct (check config.inc.php). Can't find directory, please specify right directory.</li>";
					$saving = false;
				}
			}
			else 
			{
				$error_msg .= "<li>In order to use the reset option first the ftp login details needs to be correct (check config.inc.php). FTP login failed, check username and password please.</li>";
				$saving = false;
			}
		}
		else 
		{
			$error_msg .= "<li>In order to use the reset option first the ftp login details needs to be correct (check config.inc.php). Can't connect to ftp server, please check ip and port.</li>";
			$saving = false;
		}
	}
	
	if ($saving==true)
	{
		
		// update one by one
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['admin_mail'])."' WHERE `name`='admin_mail'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['clan_name'])."' WHERE `name`='clan_name'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['clan_tag'])."' WHERE `name`='clan_tag'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['clan_game'])."' WHERE `name`='clan_game';";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['clan_game_short'])."' WHERE `name`='clan_game_short'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['pb_dir'])."' WHERE `name`='pb_dir'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['custom_update'])."' WHERE `name`='custom_update'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['update_time'])."' WHERE `name`='update_time'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['pb_sv_ssceiling'])."' WHERE `name`='pb_sv_ssceiling'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['pbsv_download_dir'])."' WHERE `name`='pbsv_download_dir'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['reset'])."' WHERE `name`='reset'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['pbsvss_updater'])."' WHERE `name`='pbsvss_updater';";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['pb_log'])."' WHERE `name`='pb_log';";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['auto_del_count'])."' WHERE `name`='auto_del_count'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['nr_screens_main'])."' WHERE `name`='nr_screens_main'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['search_limit'])."' WHERE `name`='search_limit'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['screens_per_row'])."' WHERE `name`='screens_per_row'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['width'])."' WHERE `name`='width'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['height'])."' WHERE `name`='height'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['language'])."' WHERE `name`='language'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['CB_game'])."' WHERE `name`='CB_game'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['min_screen_size'])."' WHERE `name`='min_screen_size'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['cookieExpTime'])."' WHERE `name`='cookieExpTime'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['script_load_time'])."' WHERE `name`='script_load_time'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['weblog_dir'])."' WHERE `name`='weblog_dir'";
		$sql     	=	mysql_query($sql_update);

		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['ftp_passive'])."' WHERE `name`='ftp_passive'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['debug'])."' WHERE `name`='debug'";
		$sql     	=	mysql_query($sql_update);
				
		$sql_update = "UPDATE `access` SET `name`='".mysql_real_escape_string($_POST['name'])."' WHERE md5(`memberID`)='".$memberID."'";
		$sql     	=	mysql_query($sql_update);
		
		$sql_update = "UPDATE `access` SET `mail`='".mysql_real_escape_string($_POST['mail'])."' WHERE md5(`memberID`)='".$memberID."'";
		$sql     	=	mysql_query($sql_update);
		
		if($_POST['password']!='')
		{
			$sql_update = "UPDATE `access` SET `pass`='".mysql_real_escape_string(md5($_POST['password']))."' WHERE md5(`memberID`)='".$memberID."'";
			$sql     	=	mysql_query($sql_update);
		}
		
		$sql_update = "UPDATE `settings` SET `value`='".mysql_real_escape_string($_POST['private_password'])."' WHERE `name`='private_password'";
		$sql     	=	mysql_query($sql_update);
		
		if(isset($_POST['notify_update']))
		{
			$sql_update = "UPDATE `settings` SET `value`='1' WHERE `name`='notify_update'";
			$sql     	=	mysql_query($sql_update);
		}
		else 
		{
			$sql_update = "UPDATE `settings` SET `value`='0' WHERE `name`='notify_update'";
			$sql     	=	mysql_query($sql_update);
		}
				
		
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
		
	//	this is needed to make automatic class(css) altering of rows
	$row_nr		=	1;		//	odd nr get different class then even nr
	
	?>
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $str["ACP_TITLE"];?></title>
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
    <td align="center" class="bg_reset_table_row1"><span class="txt_light">:: <?php echo $str["ACP_TITLE_MENU"];?> ::</span></td>
  </tr>
  <tr>
    <td class="bg_reset_table_row2"><form name="ACPForm" method="post" action="" autocomplete="off"><table width="90%" border="0" align="center">
      <tr>
        <td colspan="3" align="center"><strong><?php echo $str["ACP_WELCOME"];?><br>
            <br>
            <?php echo '<a href="./" target="_parent">'.$str["ACP_BACK"].'</a>';?>
            <br>
        </strong></td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong><?php echo $str["ACP_USER"];?></strong></span></td>
      </tr>
      <tr>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_USERNAME"];?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="name" id="name" value="<?php echo get_admin_name();?>" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">&nbsp;</td>
      </tr>
      <tr>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_ADMIN_MAIL"];?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="mail" id="mail" value="<?php echo get_admin_mail();?>" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_ADMIN_MAIL_COMMENT"];?></td>
      </tr>
      <tr>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_PASS"];
?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
        <input type="password" name="password" id="password" value="" class="search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_PASS_COMMENT"];?></td>
      </tr>
      <tr>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_PRIV_PASS"];
?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="private_password" id="private_password" value="<?php echo $private_password;?>" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_PRIV_PASS_COMMENT"];?></td>
      </tr>
      <tr>
        <td width="20%" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_NOTIFY_UPDATE"];?></td>
        <td width="45%" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <?php
          if ($notify_update==1)
          {
          	echo "<input type=\"checkbox\" name=\"notify_update\" id=\"notify_update\" checked>";
          }
          else 
          {
          	echo "<input type=\"checkbox\" name=\"notify_update\" id=\"notify_update\">";
          }
          ?>
          
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_NOTIFY_UPDATE_COMMENT"];?></td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong><?php echo $str["ACP_CLAN"];?></strong></span></td>
      </tr>
      <tr>
        <td width="20%" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_CLAN_NAME"];?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="clan_name" id="clan_name" value="<?php echo $clan_name;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_CLAN_NAME_COMMENT"];?></td>
      </tr>
      <tr>
        <td width="20%" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_CLAN_TAG"];?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="clan_tag" id="clan_tag" value="<?php echo $clan_tag;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_CLAN_COMMENT"];?></td>
      </tr>
      <tr>
        <td width="20%" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_CLAN_GAME"];?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="clan_game" id="clan_game" value="<?php echo $clan_game;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_CLAN_GAME_CONTENT"];?></td>
      </tr>
      <tr>
        <td width="20%" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_CLAN_GAME_SHORT"];?></td>
        <td width="45%" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="clan_game_short" id="clan_game_short" value="<?php echo $clan_game_short;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_CLAN_GAME_SHORT_COMMENT"];?></td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong><?php echo $str["ACP_UPDATE"];?></strong></span></td>
      </tr>
      <tr>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_PB_DIR"];?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="pb_dir" id="pb_dir" value="<?php echo $pb_dir;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><p><?php echo $str["ACP_PB_DIR_COMMENT"];?></p>
          <p><?php echo $str["ACP_PB_DIR_COMMENT_2"];?></p></td>
      </tr>
      <tr>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_CUSTOM_UPDATE"];?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <select name="custom_update" id="custom_update">
          <option value="1" <?php if($custom_update=='1') echo "selected"; ?>><?php echo $str["ACP_TRUE"];?></option>
          <option value="0" <?php if($custom_update=='0') echo "selected"; ?>><?php echo $str["ACP_FALSE"];?></option>  
          
            
          </select>
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_CUSTOM_UPDATE_COMMENT_1"];?><br>
<?php echo $str["ACP_CUSTOM_UPDATE_COMMENT_2"];?><br>
<?php echo $str["ACP_CUSTOM_UPDATE_COMMENT_3"];?></td>
      </tr>
      <tr>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_UPDATE_TIME"];?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="update_time" id="update_time" value="<?php echo $update_time;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_UPDATE_TIME_COMMENT"];?></td>
      </tr>
      <tr>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_PB_SSCEILING"];?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="pb_sv_ssceiling" id="pb_sv_ssceiling" value="<?php echo $pb_sv_ssceiling;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><p><?php echo $str["ACP_PB_SSCEILING_COMMENT_1"];?><br>
          <?php echo $str["ACP_PB_SSCEILING_COMMENT_2"];?><br>
          <?php echo $str["ACP_PB_SSCEILING_COMMENT_3"];?></a><br>
          </p>
          <p><?php echo $str["ACP_PB_SSCEILING_COMMENT_4"];?><br>
            <?php echo $str["ACP_PB_SSCEILING_COMMENT_5"];?></p></td>
      </tr>
      <tr>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_PBSV_DOWNLOAD_DIR"];?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="pbsv_download_dir" id="pbsv_download_dir" value="<?php echo $pbsv_download_dir;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><p><?php echo $str["ACP_PBSV_DOWNLOAD_DIR_COMMENT"];?></p>
          <p><?php echo $str["ACP_PBSV_DOWNLOAD_DIR_COMMENT_2"];?></p></td>
      </tr>
      <tr>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_RESET"];?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <select name="reset" id="reset">
            <option value="1" <?php if($reset=='1') echo "selected"; ?>><?php echo $str["ACP_TRUE"];?></option>
            <option value="0" <?php if($reset=='0') echo "selected"; ?>><?php echo $str["ACP_FALSE"];?></option>
          </select>
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_RESET_COMMENT_1"];?><br><br><?php echo $str["ACP_RESET_COMMENT_2"];?></td>
      </tr>
      <tr>
        <td width="20%" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_PBSVSS_UPDATER"];?></td>
        <td width="45%" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <select name="pbsvss_updater" id="pbsvss_updater">
            <option value="1" <?php if($pbsvss_updater=='1') echo "selected"; ?>><?php echo $str["ACP_TRUE"];?></option>
            <option value="0" <?php if($pbsvss_updater=='0') echo "selected"; ?>><?php echo $str["ACP_FALSE"];?></option>
          </select>
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_PBSVSS_UPDATER_COMMENT"];?></td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong><?php echo $str["ACP_LOGGING"];?></strong></span></td>
      </tr>
      <tr>
        <td width="20%" align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_PB_LOG"];?></td>
        <td width="45%" align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <select name="pb_log" id="pb_log">
            <option value="1" <?php if($pb_log=='1') echo "selected"; ?>><?php echo $str["ACP_TRUE"];?></option>
            <option value="0" <?php if($pb_log=='0') echo "selected"; ?>><?php echo $str["ACP_FALSE"];?></option>
          </select>
        </label></td>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><p><?php echo $str["ACP_PB_LOG_COMMENT_1"];?></p>
          <p><?php echo $str["ACP_PB_LOG_COMMENT_2"];?></p>
          <p><?php echo $str["ACP_PB_LOG_COMMENT_3"];?></p></td>
      </tr>
      <tr>
        <td width="20%" align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_MAX_LOGS"];?></td>
        <td width="45%" align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="auto_del_count" id="auto_del_count" value="<?php echo $auto_del_count;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
          </label></td>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><p><?php echo $str["ACP_MAX_LOGS_COMMENT_1"];?><br>
          <?php echo $str["ACP_MAX_LOGS_COMMENT_2"];?><br>
          </p>
          <p><?php echo $str["ACP_MAX_LOGS_COMMENT_3"];?></p></td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong><?php echo $str["ACP_TEMPLATE"];?></strong></span></td>
      </tr>
      <tr>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_SCREENS_MAIN"];?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="nr_screens_main" id="nr_screens_main" value="<?php echo $nr_screens_main;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_SCREENS_MAIN_COMMENT"];?></td>
      </tr>
      <tr>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_SCREENS_SEARCH"];?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input name="search_limit" type="text" id="search_limit" value="<?php echo $search_limit;?>">
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><span class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"></span><?php echo $str["ACP_SCREENS_SEARCH_COMMENT"];?></td>
      </tr>
      <tr>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_SCREENS_PER_ROW"];?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <select name="screens_per_row" id="screens_per_row">
            <option value="1" <?php if($screens_per_row=='1') echo "selected"; ?>>1</option>
            <option value="2" <?php if($screens_per_row=='2') echo "selected"; ?>>2</option>
            <option value="3" <?php if($screens_per_row=='3') echo "selected"; ?>>3</option>
            <option value="4" <?php if($screens_per_row=='4') echo "selected"; ?>>4</option>
            <option value="5" <?php if($screens_per_row=='5') echo "selected"; ?>>5</option>
            <option value="6" <?php if($screens_per_row=='6') echo "selected"; ?>>6</option>
          </select>
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_SCREENS_PER_ROW_COMMENT"];?></td>
      </tr>
      <tr>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_IMG_W"];?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="width" id="width" value="<?php echo $width;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_IMG_W_COMMENT"];?></td>
      </tr>
      <tr>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_IMG_H"];?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="height" id="height" value="<?php echo $height;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_IMG_H_COMMENT"];?></td>
      </tr>
      <tr>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_LANGUAGE"];?></td>
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>">
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
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">&nbsp;</td>
      </tr>
      <tr>
        <td width="20%" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_CB_GAME"];?></td>
        <td width="45%" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <select name="CB_game" id="CB_game">
          <option value="none" <?php if($CB_game=='none') echo "selected"; ?>><?php echo $str["ACP_CB_NONE"];?></option>
          <?php 
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
        <td class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_CB_GAME_COMMENT"];?></td>
      </tr>
      <tr>
        <td colspan="3" align="center" class="bg_reset_table_row3"><span class="txt_light"><strong><?php echo $str["ACP_ADVANCED"];?></strong></span></td>
      </tr>
      <tr>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_MIN_SCRN_SIZE"];?></td>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="min_screen_size" id="min_screen_size" value="<?php echo $min_screen_size;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_MIN_SCRN_SIZE_COMMENT"];?></td>
      </tr>
      <tr>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_CookieExpTime"];?></td>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input name="cookieExpTime" type="text" id="cookieExpTime" value="<?php echo $cookieExpTime;?>" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_CookieExpTime_COMMENT"];?></td>
      </tr>
      <tr>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_SCRIPT_LOAD"];?></td>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="script_load_time" id="script_load_time" value="<?php echo $script_load_time;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_SCRIPT_LOAD_COMMENT"];?></td>
      </tr>
      <tr>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_WEB_LOG_DIR"];?></td>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <input type="text" name="weblog_dir" id="weblog_dir" value="<?php echo $weblog_dir;?>" onclick="this.focus();" size="30" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';">
        </label></td>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_WEB_LOG_DIR_COMMENT"];?></td>
      </tr>
      <tr>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_FTP_PASS"];?></td>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <select name="ftp_passive" id="ftp_passive">
            <option value="1" <?php if($ftp_passive=='1') echo "selected";?>><?php echo $str["ACP_TRUE"];?></option>
            <option value="0" <?php if($ftp_passive=='0') echo "selected";?>><?php echo $str["ACP_FALSE"];?></option>
          </select>
        </label></td>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><span class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"></span><?php echo $str["ACP_FTP_PASS_COMMENT"];
?></td>
      </tr>
      <tr>
        <td width="20%" align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><?php echo $str["ACP_DEBUG"];?></td>
        <td width="45%" align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><label>
          <select name="debug" id="debug">
            <option value="1" <?php if($debug=='1') echo "selected"; ?>><?php echo $str["ACP_TRUE"];?></option>
            <option value="0" <?php if($debug=='0') echo "selected"; ?>><?php echo $str["ACP_FALSE"];?></option>
          </select>
        </label></td>
        <td align="left" class="<?php if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?php echo $str["ACP_DEBUG_COMMENT"];?></td>
      </tr>
      <tr>
        <td colspan="3"><table width="100%" border="0">
              <tr>
                <td align="center">          
            <label>              </label>            <label>
              <input type="submit" name="save" id="save" value="<?php echo $str["ACP_SAVE"];?>" >
            </label>
            </td>
              </tr>
          </table></td>
      </tr>
    </table>
    
    </form></td>
  </tr>
  <tr>
    <td class="bg_reset_table_row3" align="center"><span class="txt_light"><?php echo '<a href="./" target="_parent">'.$str["ACP_BACK"].'</a>';?></span></td>
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
          <?php echo $msg;?>
          <br>
          <span class="txt_light"><?php echo "<a href=".$back_page." target=\"_parent\">Click here to go back</a>";?></span></p></td>
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
	
	<?php 
}

function template_saved()
{
	global $str;
	?>
	
	
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $str["ACP_TITLE"];?></title>
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
    <td align="center" class="bg_reset_table_row1"><span class="txt_light">:: <?php echo $str["ACP_TITLE_MENU_SAVED"];?> ::</span></td>
  </tr>
  <tr>
    <td class="bg_reset_table_row2"><table width="90%" border="0" align="center">
      <tr>
        <td align="center"><?php echo $str["ACP_SAVED"];?><br><span class="txt_light"><?php echo '<a href="./" target="_parent">'.$str["ACP_BACK"].'</a>';?></span></td>
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
	
	<?php 
}
?>