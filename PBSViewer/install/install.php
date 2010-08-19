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
$step = isset( $_GET['step'] ) ? $_GET['step'] : 0;

switch($step)
{
	//step 0
	case 0:

	// initialization
	$_SESSION['ftp_host_web_configured'] = false;
	$_SESSION['pb_reset_option_configured'] = false;
	
	// config initialization
	$_SESSION['pb_dir'] 			=	'';
	$_SESSION['custom_update'] 		=	0;
	$_SESSION['update_time'] 		=	86400;
	$_SESSION['pb_sv_ssceiling']	=	10000;
	$_SESSION['clan_name']			=	'';
	$_SESSION['clan_tag']			=	'';
	$_SESSION['clan_game']			=	'';
	$_SESSION['clan_game_short']	=	'';
	$_SESSION['pb_log'] 			= 	0;
	$_SESSION['auto_del_count'] 	= 	-1;
	$_SESSION['pbsv_download_dir']	= 	'';
	$_SESSION['reset']				=	0;
	$_SESSION['screens_per_row']	=	4;
	$_SESSION['nr_screens_main']	=	10;
	$_SESSION['width']				=	200;
	$_SESSION['height']				=	200;
	$_SESSION['pbsvss_updater']		=	1;
	$_SESSION['script_load_time']	=	600;
	$_SESSION['debug']				=	0;
	$_SESSION['weblog_dir']			=	'download';
	
	
	
	template_start();
	
	break;
	
	case 1:
	
			$CHMOD	=	check_CHMOD('../download','../lastUpdate.txt','../inc');
			if($CHMOD[0]!=true)
			{
				//	chmod won't work most of the time, since you are not the real owner/admin of your webserver
				if(!chmod('../download',0777))
				{
					$error_msg	.='<li>Please CHMOD folder \'download\' to 777</li>';
					template_error($error_msg);
				}
			}

			elseif($CHMOD[1]!=true)
			{
				if(!chmod('lastUpdate.txt',0666))
				{
					$error_msg	.='<li>Please CHMOD \'lastUpdate.txt\' to 666</li>';
					template_error($error_msg);
				}
			}
			elseif ($CHMOD[2]!=true)
			{
				if(!chmod('../inc',0777))
				{
					$error_msg	.='<li>Please CHMOD \'inc\' to 777</li>';
					template_error($error_msg);
				}
			}
			else 
			{
			
			
	
	$pre_data	=	"<?php
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
if(!isset(\$key)) die('Acces denied!');

if(\$key==md5(\$_SERVER['SERVER_SIGNATURE'].' '.php_uname()))
{
	if(preg_match(\"~config.inc.php~\", \$_SERVER[\"PHP_SELF\"])) die('Acces denied!');

	//---------------------]	REQUIRED	[---------------------\\ \n";
	
	write_config($pre_data);
	
	template_install_DB();
		
				}
	
				
	
				
	break;
	
	case 2:

						if($_POST['db_host']!=''&&$_POST['username']!=''&&$_POST['password']!=''&&$_POST['db_name']!='')
						{
							if($_POST['password']=='-') $_POST['password']='';					
							
							//	check if connection with db is possible and if we can select our db
							$check_db	=	check_db_connection($_POST['db_host'],$_POST['username'],$_POST['password'],$_POST['db_name']);
							
							$_SESSION['db_host']	=	$_POST['db_host'];
							$_SESSION['username']	=	$_POST['username'];
							$_SESSION['password']	=	$_POST['password'];
							$_SESSION['db_name']	=	$_POST['db_name'];
							
							//	connection and login possible?
							if($check_db[0])
							{
								//	selection of db name possible?
								if($check_db[1])
								{
									//	append new data to file
									$data_app	=	"	//	mysql settings (required)
	define('DB_HOST','".$_POST['db_host']."');								//	Default=localhost
	define('DB_USER','".$_POST['username']."');
	define('DB_PASS','".$_POST['password']."');
	define('DB_NAME','".$_POST['db_name']."');\n\n";
									
									append_config($data_app);
									
									
								template_ftp_settings();
				
								}	
								else 
								{
									template_error('<li>db name does not exist, please check it.</li>');
								}			
							}
							else 
							{
								template_error('<li>Can\'t connect to database, check db host, username and password.</li>');
							}
						}
						else 
						{
							template_error('<li>You did not fill in all fields.</li>');
						}	
	
	
	
	break;
	
	case 3:

					if($_POST['ftp_ip']!=''&&$_POST['ftp_port']!=''&&$_POST['ftp_user']!=''&&$_POST['ftp_password']!=''&&$_POST['pb_dir']!='')
					{
						$check_ftp	=	check_ftp_connection($_POST['ftp_ip'],$_POST['ftp_port'],$_POST['ftp_user'],$_POST['ftp_password'],$_POST['pb_dir']);

							//	check if connection is possible
							if($check_ftp[0])
							{
								//	check if we can login
								if($check_ftp[1])
								{
									//	check if PB directory exist
									if($check_ftp[2])
									{
										//	append new data to file
										$data_app	=	"	//	ftp settings of your gameserver (required)
	define('FTP_HOST','".$_POST['ftp_ip']."');
	define('FTP_PORT','".$_POST['ftp_port']."');									//	Default=21
	define('FTP_USER','".$_POST['ftp_user']."');
	define('FTP_PASS','".$_POST['ftp_password']."');\n
				
				";
										
										$_SESSION['pb_dir']	=	addslashes($_POST['pb_dir']);
																				
										
										append_config($data_app);
																
										
										template_update_settings();		
									}				
									else 
									{
										template_error('<li>Can\'t find directory, please specify right directory</li>');
									}
								}
								else 
								{
									template_error('<li>ftp login failed, check username and password please</li>');
								}
							}
							else 
							{
								template_error('<li>Can\'t connect to ftp server, please check ip and port</li>');
							}
							
						

					}
					else 
					{
						template_error('<li>Not all fields were filled in</li>');
					}
	
	break;
	
	case 4:
	
	if($_POST['custom_update']!='')
				{
					if($_POST['update_time']!=''||$_POST['update_time']<0)
					{
							$_POST['custom_update']=='true' ? $_SESSION['custom_update'] = 1: $_SESSION['custom_update'] = 0;
							$_SESSION['update_time']	=	addslashes($_POST['update_time']);
							

							
							template_pb_settings();
					
					}
					else 
					{
						template_error('<li>Something is wrong with your update time, please check it');
					}
				}
				else 
				{
					template_error('<li>Custom update field is empty</li>');
				}
	
	break;
	
	case 5:
	
				if($_POST['pb_ss_ceiling']>0)
				{
					
					$_SESSION['pb_sv_ssceiling']	=	addslashes($_POST['pb_ss_ceiling']);
									
					
					template_seo_settings();
				}
				else 
				{
					template_error('<li>Please use a larger value for your pb_sv_SsCeiling</li>');
				}

	
	
	break;
	
	case 6:
	
				if($_POST['clan_name']!=''||$_POST['clan_tag']!=''||$_POST['clan_game_short']!=''||$_POST['clan_game_full']!='')
				{
					$_SESSION['clan_name']	=	addslashes($_POST['clan_name']);
					$_SESSION['clan_tag']	=	addslashes($_POST['clan_tag']);
					$_SESSION['clan_game']	=	addslashes($_POST['clan_game_full']);
					$_SESSION['clan_game_short']	=	addslashes($_POST['clan_game_short']);
					
					template_log_option();
				}
				else 
				{
					template_error('<li>Not all fields were filled in</li>');
				}
	
	break;
	
	case 7:
	
				if($_POST['pb_log']=='true')
				{
					$_SESSION['pb_log'] = 1;					
					
					// show template for step 8
					template_log_settings();
				}
				//	or other page if log option is false
				else 
				{
					$_SESSION['pb_log'] = 0;
					$_SESSION['auto_del_count'] = -1;
								
					// show template for step 10
					template_reset_option();
				}
	
	break;
	
	case 8:
	
				if($_POST['auto_del_count']>=0)
				{
					$_SESSION['auto_del_count'] = addslashes($_POST['auto_del_count']);
									
					template_ftp_web_log();
				}
				else 
				{
					template_error('<li>You can\'t use negative values</li>');
				}
	
	break;
	
	case 9:	
	
				if($_POST['ftp_host_web']!=''&&$_POST['ftp_port_web']!=''&&$_POST['ftp_user_web']!=''&&$_POST['ftp_password_web']!=''&&$_POST['pbsv_download']!='')
				{
					$check_ftp	=	check_ftp_web_connection($_POST['ftp_host_web'],$_POST['ftp_port_web'],$_POST['ftp_user_web'],$_POST['ftp_password_web'],$_POST['pbsv_download']);
					
					//	check if connection is possible
					if($check_ftp[0])
					{
						//	check if we can login
						if($check_ftp[1])
						{
							//	check if PB directory exist
							if($check_ftp[2])
							{
								$data_app	=	"	//	ftp settings of your webserver (optional)
	//	only fill in if you are going to use logging option PB_log
	define('FTP_HOST_WEB','".$_POST['ftp_host_web']."');
	define('FTP_PORT_WEB','".$_POST['ftp_port_web']."');								//	Default=21
	define('FTP_USER_WEB','".$_POST['ftp_user_web']."');
	define('FTP_PASS_WEB','".$_POST['ftp_password_web']."');
	
";
								$data_app	.= "\n\n";
								
								append_config($data_app);
								
								$_SESSION['pbsv_download_dir']	= 	addslashes($_POST['pbsv_download']);
								
								
								//$mysql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('reset','1');";
								//mysql_query($mysql_insert) or die(mysql_error());;						
								
								$_SESSION['ftp_host_web_configured'] = true;
								
								//	if reset option already was configured then go directly to template options
								if (isset($_SESSION['pb_reset_option_configured']))
								{
									if ($_SESSION['pb_reset_option_configured']==true)
									{
										template_template_settings();
									}
									else 
									{
										template_reset_option();
									}
								}
								else 
								{
									template_reset_option();
								}
							}
							else 
							{
								template_error('<li>Can\'t find directory, please specify right directory</li>');
							}
						}
						else 
						{
							template_error('<li>ftp login failed, check username and password please</li>');
						}
					}
					else 
					{
						template_error('<li>Can\'t connect to ftp server, check ip and port please</li>');
					}
				}
				else 
				{
					template_error('<li>Not all fields were filled in</li>');
				}
	
	break;
	
	case 10:
	
				if($_POST['pb_reset_option']=='true')
				{
					
					$_SESSION['reset']	=	1;
						
										
					if(isset($_SESSION['ftp_host_web_configured']))
					{					
						if ($_SESSION['ftp_host_web_configured']==true)
						{
							template_template_settings();
						}
						else 
						{
							//	used to prevent that user is being redirected to this page again
							$_SESSION['pb_reset_option_configured'] = true;
							template_ftp_web_log();
						}
					}
					else 
					{
						//	used to prevent that user is being redirected to this page again
						$_SESSION['pb_reset_option_configured'] = true;
						template_ftp_web_log();
					}					
					
				}
				else 
				{
					$data_app	=	"	//	ftp settings of your webserver (optional)
	//	only fill in if you are going to use logging option PB_log
	define('FTP_HOST_WEB','Your ftp');
	define('FTP_PORT_WEB','FTP port');							//	Default=21
	define('FTP_USER_WEB','username');
	define('FTP_PASS_WEB','password');
	
";
								$data_app	.= "\n\n";
								
								append_config($data_app);
					
					$_SESSION['reset']	=	0;								
				
					
					template_template_settings();
				}
	
	break;
	
	case 11:
		
				if($_POST['nr_screens_main']>0)
				{
					if($_POST['NR']>0)
					{
						if($_POST['IMG_H']>0&&$_POST['IMG_W']>0)
						{
							
							
							$_SESSION['screens_per_row']	=	addslashes($_POST['NR']);
							$_SESSION['nr_screens_main']	=	addslashes($_POST['nr_screens_main']);
							$_SESSION['width']	=	addslashes($_POST['IMG_W']);
							$_SESSION['height']	=	addslashes($_POST['IMG_H']);
							
				
							
							template_additional_settings();
						}
						else 
						{
							template_error('<li>screen size has to be larger than 0</li>');
						}
					}
					else 
					{
						template_error('<li>Number of screens for each row has to be larger than 0</li>');
					}
				}
				else 
				{
					template_error('<li>You can\'t have an a negative or a zero value for nr screens on main page</li>');
				}
	
	break;

	//	place the admin creation near end, because then the user can easily remember his/her username and password after the installation
	case 12:
				if($_POST['script_load_time']>30)
				{
					$_SESSION['pbsvss_updater']	=	addslashes($_POST['pbsvss_updater']);									
					$_SESSION['script_load_time']	=	addslashes($_POST['script_load_time']);
					$_SESSION['debug']	=	0;
					$_SESSION['weblog_dir']	=	'download';
					
					$data_app	=	"
}
else
{
	die('Acces denied!');
}


?>";
					append_config($data_app);
					
					template_admin_setting();
	
				}
				else 
				{
					template_error('<li>It is recommended to have a script load time larger than 30</li>');
				}
	
	break;	
	
	case 13:
	
if ($_POST['admin_username']!='' && $_POST['admin_password']!='' && $_POST['admin_mail']!='')
{					
					$_SESSION['admin_username']	=	$_POST['admin_username'];
					$_SESSION['admin_password']	=	md5($_POST['admin_password']);
					$_SESSION['admin_mail']		=	$_POST['admin_mail'];
										
					template_create_db();				
}
else 
{
	template_error('<li>All fields should be filled in, please fill in all fields.</li>');
}
	
	break;
	
	
	case 14:
	
					$key	=	md5($_SERVER['SERVER_SIGNATURE'].' '.php_uname());
				include("../inc/config.inc.php");
				
				//echo DB_HOST."<br>".DB_USER."<br>".DB_PASS."<br>".DB_NAME;
				
				//	connect to DB
				connect_DB_config();
				
				
				$sql_create	=	"
CREATE TABLE `screens` 
(
`id` INT(8) NOT NULL AUTO_INCREMENT,
`fid` TEXT NOT NULL,
`name` TEXT NOT NULL,
`guid` TEXT NOT NULL,
`filesize` INT(8) DEFAULT '0',
`date` datetime,
PRIMARY KEY(`id`)
);
";
				mysql_query($sql_create) or die(mysql_error());;
				
								$sql_create	=	"
CREATE TABLE `screens_old` 
(
`id` INT(8) NOT NULL AUTO_INCREMENT,
`fid` TEXT NOT NULL,
`name` TEXT NOT NULL,
`guid` TEXT NOT NULL,
`filesize` INT(8) DEFAULT '0',
`date` datetime,
PRIMARY KEY(`id`)
);
";
				mysql_query($sql_create) or die(mysql_error());;
				
								$sql_create	=	"
CREATE TABLE `admin` 
(
`request_update` boolean DEFAULT '0'
);
";								
				mysql_query($sql_create);

				$sql_create	=	"INSERT INTO `admin` (`request_update`) VALUES('0')";							
				mysql_query($sql_create) or die(mysql_error());;
					

				$sql_create	=	"
CREATE TABLE `dl_screens`
(
`id` INT(8) NOT NULL AUTO_INCREMENT,
`fid` TEXT NOT NULL,
PRIMARY KEY(`id`)
);
";
								mysql_query($sql_create) or die(mysql_error());;
				
				$sql_create	=	"
				CREATE TABLE `logs`
				(
				`id` INT(8) NOT NULL AUTO_INCREMENT,
				`logid` TEXT NOT NULL,
				`fid` TEXT NOT NULL,
				`md5` TEXT NOT NULL,
				`guid` TEXT NOT NULL,
				`ip` TEXT NOT NULL,
				`date` datetime,
				PRIMARY KEY(`id`)				
				);
				";
				
				mysql_query($sql_create);
				
				//	create access table for admin
				$sql_create	=	"CREATE TABLE `access` 
(
`memberID` INT(3) NOT NULL AUTO_INCREMENT,
`name` varchar(20) NOT NULL,
`mail` TEXT NOT NULL,
`pass` varchar(32) NOT NULL,
`level` INT(1) NOT NULL,
`ResetCode` varchar(32),
PRIMARY KEY(`memberID`)
);";
				
				mysql_query($sql_create) or die (mysql_error());
				
				$mysql_insert	=	"INSERT INTO `access` (`name`,`mail`,`pass`,`level`) VALUES ('".$_SESSION['admin_username']."','".$_SESSION['admin_mail']."','".$_SESSION['admin_password']."','1')";
				mysql_query($mysql_insert) or die(mysql_error());				

				//	create mysql table to insert values that are being configured during install
				$sql_create	=	"CREATE TABLE `settings`
(
`optionID` INT(2) NOT NULL AUTO_INCREMENT,
`name` TEXT NOT NULL, 
`value` TEXT,
PRIMARY KEY(`optionID`)
);";
				mysql_query($sql_create) or die(mysql_error());
				
				$mysql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('pb_dir','".$_SESSION['pb_dir']."');";
				mysql_query($mysql_insert) or die(mysql_error());
				
				$mysql_insert	=	"INSERT INTO `settings` (`name`,`value`) VALUES ('update_time','".$_SESSION['update_time']."');";					
				mysql_query($mysql_insert) or die(mysql_error());
							
				$mysql_insert	=	"INSERT INTO `settings` (`name`,`value`) VALUES ('custom_update','".$_SESSION['custom_update']."');";	
				mysql_query($mysql_insert) or die(mysql_error());
										
				$mysql_insert	=	"INSERT INTO `settings` (`name`,`value`) VALUES ('pb_sv_ssceiling','".$_SESSION['pb_sv_ssceiling']."');";
				mysql_query($mysql_insert) or die(mysql_error());
				
				$mysql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('clan_name','".$_SESSION['clan_name']."');";
				mysql_query($mysql_insert) or die(mysql_error());
					
				$mysql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('clan_tag','".$_SESSION['clan_tag']."');";
				mysql_query($mysql_insert) or die(mysql_error());
					
				$mysql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('clan_game','".$_SESSION['clan_game']."');";
				mysql_query($mysql_insert) or die(mysql_error());
					
				$mysql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('clan_game_short','".$_SESSION['clan_game_short']."');";
				mysql_query($mysql_insert) or die(mysql_error());
				
				$mysql_insert	=	"INSERT INTO `settings` (`name`,`value`) VALUES ('pb_log','".$_SESSION['pb_log']."');";
				mysql_query($mysql_insert) or die(mysql_error());
				
				$mysql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('auto_del_count','".$_SESSION['auto_del_count']."');";
				mysql_query($mysql_insert) or die(mysql_error());
				
				$mysql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('pbsv_download_dir','".$_SESSION['pbsv_download_dir']."');";
				mysql_query($mysql_insert) or die(mysql_error());
				
				$mysql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('reset','".$_SESSION['reset']."');";
				mysql_query($mysql_insert) or die(mysql_error());
				
				$mysql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('screens_per_row','".$_SESSION['screens_per_row']."');";
				mysql_query($mysql_insert) or die(mysql_error());
				
				$mysql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('nr_screens_main','".$_SESSION['nr_screens_main']."');";
				mysql_query($mysql_insert) or die(mysql_error());
				
				$mysql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('width','".$_SESSION['width']."');";
				mysql_query($mysql_insert) or die(mysql_error());
				
				$mysql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('height','".$_SESSION['height']."');";					
				mysql_query($mysql_insert) or die(mysql_error());
				
				$mysql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('pbsvss_updater','".$_SESSION['pbsvss_updater']."');";
				mysql_query($mysql_insert) or die(mysql_error());
				
				$mysql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('script_load_time','".$_SESSION['script_load_time']."');";
				mysql_query($mysql_insert) or die(mysql_error());
				
				$mysql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('debug','".$_SESSION['debug']."');";
				mysql_query($mysql_insert) or die(mysql_error());
				
				$mysql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('weblog_dir','".$_SESSION['weblog_dir']."');";
				mysql_query($mysql_insert) or die(mysql_error());
										
				$sql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('CB_game','none');";
				mysql_query($sql_insert) or die(mysql_error());
							
				$sql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('min_screen_size','10000');";
				mysql_query($sql_insert) or die(mysql_error());

				$sql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('language','English');";
				mysql_query($sql_insert) or die(mysql_error());
				
				$sql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('notify_update','0');";
				mysql_query($sql_insert) or die(mysql_error());
				
				$sql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('private_password','');";
				mysql_query($sql_insert) or die(mysql_error());
				
				$sql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('cookieExpTime','604800');";
				mysql_query($sql_insert) or die(mysql_error());

				session_destroy();
				template_final();
	
	break;
	
}

	

	




function template_start()
{
	
$phpversion	=	phpversion();
$versions	=	explode('.',$phpversion);
$requiredVersion	=	5;

//	check if GD is supported on server
if (function_exists("gd_info"))
{
	$gd 	=	true;
}
else 
{
	$gd 	=	false;
}
	
	?>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation of pbsviewer</title>
<link href="install.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_main">
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><span class="txt_light">Welcome, you are going to install  pbsviewer</span></td>
      </tr>
    </table>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="bg_table_body"><p>This is a step-by-step installer, it will take you 5 minutes to install this script<br />
            Please check the following  first:
              </p>
            <ol>
              <li>Did you CHMOD <em>'download'</em> to '<strong>777</strong>', '<em>lastUpdate.txt</em>' to '<strong>666</strong>' and <em>'inc'</em> to <strong>777</strong>? If your don't know what it is, it is just changing the properties/permissions of a file through ftp for example. If you still don't know how to CHMOD, please visit the <a href="http://code.google.com/p/pbsviewer/wiki/FAQ#What_do_you_mean_with_CHMOD?" target="_blank">FAQ page</a>. There you will find more info about how to CHMOD.</li>
              <li>Please check below if your server is able to run PBSViewer:</li>
            </ol>
            <p><fieldset id="set1"><legend style="font-weight:bold;">Server information</legend>
                     
           <?php 
           
           if($versions[0]>=$requiredVersion)
			{
				echo "<p><span style=\"font-size: 130%;font-weight: bold;\">PHP version:</span><span style=\"position:absolute; left:40%;\">".$phpversion."</span></p>";
				echo "<p><span style=\"color: green\">Correct PHP version</span></p>";
			}
			else 
			{
				echo "<p><span style=\"font-size: 130%;font-weight: bold;\">PHP version:</span><span style=\"position:absolute; left:40%;\">".$phpversion."</span></p>";
				echo "<p><span style=\"color: red\">PBSViewer requires php version ".$requiredVersion." or higher</p>";
			}
           
           ?>
                  
           <br>
            
           <p style="font-size: 130%; font-weight: bold;">GD is <?php
           if($gd==true) 
           {
           echo "<span style=\"color: green;\">supported</span>";
           }
           else 
           {
           echo "<span style=\"color: red;\">not supported</span>";
           }
           	?> by your server</p>

           <?php 
           
           if($gd==true)
           {
           		$gd_data	=	gd_info();
	
				foreach ($gd_data as $key=>$value)
				{
					if (is_string($value))
					{
						echo "<p<span style=\"font-weight: bold;\">".$key.":</span><span style=\"position:absolute; left:40%;\">".$value."</span></p>";
					}
					else 
					{
		
						if ($value==true)
						{
							echo "<p<span style=\"font-weight: bold;\">".$key.":</span><span style=\"position:absolute; left:40%; color: green;\">True</span></p>";
						}
						else
						{
							echo "<p<span style=\"font-weight: bold;\">".$key.":</span><span style=\"position:absolute; left:40%; color: red;\">False</span></p>";
						}
					}	
				}
           }
           
           
           ?>
           <span style="position:absolute; left:60%;">+</span>
           <div style="width: 59%; border-bottom: 1px solid black; padding: 10px;">           
           </div>
           
           <?php 
           
           if ($versions[0]>=$requiredVersion)
           {
				echo "<p><span style=\"font-size: 140%; font-weight: bold;\">Verdict: </span><span style=\"color: green;font-size: 140%;\">Your server is able to run PBSViewer!</span></p>";           	
           }
           elseif ($versions[0]>=$requiredVersion && $gd==true)
           {
           		echo "<p><span style=\"font-size: 140%; font-weight: bold;\">Verdict: </span><span style=\"color: green;font-size: 140%;\">Your server is able to run PBSViewer!</span></p>";           	
           }
           else 
           {
           		echo "<p><span style=\"font-size: 140%; font-weight: bold;\">Verdict: </span><span style=\"color: red;font-size: 140%;\">Your server is NOT able to run PBSViewer!</span></p>";           	
           }
           
           ?>
           
           
           
           </fieldset></p>
            <p align="center">If you are sure everything is correct, please click on install.<br />
            </p>
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_install">
              <tr>
                <td align="center"><form id="Install" name="Install" method="post" action="install.php?step=1">
                  <input type="submit" name="install" id="install" value="Install" />
                                                                </form>                </td>
              </tr>
          </table></td>
        </tr>
      </table>
      <br /></td>
  </tr>
</table>
</body>
</html>
	
	<?php 
}

function template_install_DB()
{
	?>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation of pbsviewer</title>
<link href="install.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_main">
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><strong><span class="txt_light">Settings for database connection</span></strong></td>
      </tr>
    </table>
    <form id="Install_DB" name="Install_DB" method="post" action="install.php?step=2">
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="25%" class="bg_table_body"><p><strong>Database host
          </strong></p></td>
          <td width="50%" class="bg_table_body"><label>
            <input name="db_host" type="text" id="db_host" value="localhost" size="40" />
          </label></td>
          <td class="bg_table_body"><em>Default is localhost</em></td>
        </tr>
        <tr>
          <td class="bg_table_body"><strong>Username</strong></td>
          <td class="bg_table_body"><label>
            <input name="username" type="text" id="username" size="40" />
          </label></td>
          <td class="bg_table_body">&nbsp;</td>
        </tr>
        <tr>
          <td class="bg_table_body"><strong>Password</strong></td>
          <td class="bg_table_body"><label>
            <input name="password" type="txt" id="password" value="-" size="40" />
          </label></td>
          <td class="bg_table_body"><em>If you don't have a password fill in '-'</em></td>
        </tr>
        <tr>
          <td class="bg_table_body"><strong>Database name</strong></td>
          <td class="bg_table_body"><label>
            <input name="db name" type="text" id="db_name" size="40" />
          </label></td>
          <td class="bg_table_body">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="bg_table_body"><input type="submit" name="next_db" id="next_db" value="Next" /></td>
        </tr>
      </table>
      </form>
      <br /></td>
  </tr>
</table>
</body>
</html>
	
	<?php 
}

function template_ftp_settings()
{
	?>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation of pbsviewer</title>
<link href="install.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_main">
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><strong><span class="txt_light">Settings for FTP connection</span></strong></td>
      </tr>
    </table>
    <form id="Install_DB" name="Install_DB" method="post" action="install.php?step=3">
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="25%" class="bg_table_body"><p><strong>FTP gameserver</strong></p></td>
          <td width="50%" class="bg_table_body"><label>
            <input name="ftp_ip" type="text" id="ftp_ip" size="40" />
          </label></td>
          <td class="bg_table_body"><em>Fill in ip of ftp server</em></td>
        </tr>
        <tr>
          <td class="bg_table_body"><strong>FTP port</strong></td>
          <td class="bg_table_body"><label>
            <input name="ftp_port" type="text" id="ftp_port" value="21" size="40" />
          </label></td>
          <td class="bg_table_body"><em>Default is 21</em></td>
        </tr>
        <tr>
          <td class="bg_table_body"><strong>FTP Username</strong></td>
          <td class="bg_table_body"><label>
            <input name="ftp_user" type="text" id="ftp_user" size="40" />
          </label></td>
          <td class="bg_table_body">&nbsp;</td>
        </tr>
        <tr>
          <td class="bg_table_body"><strong>FTP Password</strong></td>
          <td class="bg_table_body"><label>
            <input name="ftp_password" type="text" id="ftp_password" size="40" />
          </label></td>
          <td class="bg_table_body">&nbsp;</td>
        </tr>
        <tr>
          <td class="bg_table_body"><strong>Punkbuster directory</strong></td>
          <td class="bg_table_body"><input name="pb_dir" type="text" id="pb_dir" value="games/pb" size="40" /></td>
          <td class="bg_table_body"><em>Use '/' and don't use 'pb/' with a trailing slash. This is your punkbuster directory on your gameserver.</em></td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="bg_table_body"><input type="submit" name="next_ftp" id="next_ftp" value="Next" /></td>
        </tr>
      </table>
      </form>
      <br /></td>
  </tr>
</table>
</body>
</html>	
	
	<?php 
}

function template_update_settings()
{
	?>
	
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation of pbsviewer</title>
<link href="install.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_main">
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><strong><span class="txt_light">Update settings</span></strong></td>
      </tr>
    </table>
    <form id="Install_DB" name="Install_DB" method="post" action="install.php?step=4">
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" class="bg_table_body"><p> If 'custom update' is <em>true</em> then the admin or a cron job should run '<em><strong>update.php</strong></em>'. If option is <em>false</em>, then it will update after x seconds which can can be configured with 'Update time' see below.You still have the possibility to force an update manually by running 'update.php' if you want.</p>
            <p>&nbsp;</p></td>
          </tr>
        <tr>
          <td width="25%" class="bg_table_body"><strong>Custom update?</strong></td>
          <td width="50%" class="bg_table_body"><label>
            <select name="custom_update" id="custom_update">
              <option value="true">true</option>
              <option value="false" selected>false</option>
            </select>
          </label></td>
          <td class="bg_table_body"><em>Default is false</em></td>
        </tr>
        <tr>
          <td colspan="3" class="bg_table_body"><p>&nbsp;</p>
            <p>Update every 3600*24=<em>86400</em> s, every day. Use a small update time if gameserver is crowded (since a lot of new screens are captured), for example a public gameserver. However keep in mind that bandwidth will also increase if update time is smaller. <br />
            </p></td>
          </tr>
        <tr>
          <td class="bg_table_body"><strong>Update time</strong></td>
          <td class="bg_table_body"><input name="update_time" type="text" id="update_time" value="86400" size="40" /></td>
          <td class="bg_table_body"><em>Default is 86400 seconds, which is equal to 1 day</em></td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="bg_table_body"><input type="submit" name="next_custom_update" id="next_custom_update" value="Next" /></td>
        </tr>
      </table>
      </form>
      <br /></td>
  </tr>
</table>
</body>
</html>
	
	<?php 
}

function template_pb_settings()
{
	?>
	
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation of pbsviewer</title>
<link href="install.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_main">
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><strong><span class="txt_light">PB gameserver settings</span></strong></td>
      </tr>
    </table>
    <form id="Install_DB" name="Install_DB" method="post" action="install.php?step=5">
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" class="bg_table_body"><p>&nbsp;</p>
            <p>If you do not set this correct then one can get wrong results. To find your number, open this file 'pbsv.cfg' and look for 'pb_sv_SsCeiling'. The file should be located in your 'pb' directory on your ftp of your gameserver. <br />
It is recommended to have a small amount as possible to save some bandwidth and space. NB both values of '<em>pb_sv_SsCeiling</em>' as in '<em>pbsv.cfg</em>' and here should be the same <br />
If you are not sure please take a large number like 10000 or contact me ;)<br />
            </p></td>
          </tr>
        <tr>
          <td class="bg_table_body"><strong>pb_sv_SsCeiling</strong></td>
          <td class="bg_table_body"><input name="pb_ss_ceiling" type="text" id="pb_ss_ceiling" value="10000" size="40" /></td>
          <td class="bg_table_body"><em>Game-violations has set this number to 10000<br />
PB default is 100</em></td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="bg_table_body"><input type="submit" name="next_pb" id="next_pb" value="Next" /></td>
        </tr>
      </table>
      </form>
      <br /></td>
  </tr>
</table>
</body>
</html>
	
	<?php 
}

function template_seo_settings()
{
	?>
	
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation of pbsviewer</title>
<link href="install.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_main">
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><strong><span class="txt_light">Script SEO settings</span></strong></td>
      </tr>
    </table>
    <form id="Install_DB" name="Install_DB" method="post" action="install.php?step=6">
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" class="bg_table_body"><p>&nbsp;</p></td>
          </tr>
        <tr>
          <td width="25%" class="bg_table_body"><strong>Clan name</strong></td>
          <td width="50%" class="bg_table_body"><input name="clan_name" type="text" id="clan_name" size="40" /></td>
          <td class="bg_table_body"><em>What is your full clan name</em></td>
        </tr>
        <tr>
          <td class="bg_table_body"><strong>Clan tag</strong></td>
          <td class="bg_table_body"><input name="clan_tag" type="text" id="clan_tag" size="40" /></td>
          <td class="bg_table_body"><em>Your clantag ingame?</em></td>
        </tr>
        <tr>
          <td class="bg_table_body"><strong>Full game name</strong></td>
          <td class="bg_table_body"><input name="clan_game_full" type="text" id="clan_game_full" size="40" /></td>
          <td class="bg_table_body">&nbsp;</td>
        </tr>
        <tr>
          <td class="bg_table_body"><strong>Game name short</strong></td>
          <td class="bg_table_body"><input name="clan_game_short" type="text" id="clan_game_short" size="40" /></td>
          <td class="bg_table_body">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="bg_table_body"><input type="submit" name="next_seo" id="next_seo" value="Next" /></td>
        </tr>
      </table>
      </form>
      <br /></td>
  </tr>
</table>
</body>
</html>
	
	<?php 
}

function template_ftp_web_log()
{
	?>
	
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation of pbsviewer</title>
<link href="install.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_main">
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><strong><span class="txt_light">FTP webserver settings</span></strong></td>
      </tr>
    </table>
    <form id="Install_DB" name="Install_DB" method="post" action="install.php?step=9">
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" class="bg_table_body"><p> FTP settings of your webserver.<br />
Only fill in if you are going to use logging option</p></td>
          </tr>
        <tr>
          <td class="bg_table_body"><strong>FTP webserver</strong></td>
          <td class="bg_table_body"><input name="ftp_host_web" type="text" id="ftp_host_web" size="40" /></td>
          <td class="bg_table_body"><em>Fill in ftp adres</em></td>
        </tr>
        <tr>
          <td class="bg_table_body"><strong>FTP webserver port</strong></td>
          <td class="bg_table_body"><input name="ftp_port_web" type="text" id="ftp_port_web" value="21" size="40" /></td>
          <td class="bg_table_body"><em>Default is 21</em></td>
        </tr>
        <tr>
          <td class="bg_table_body"><strong>FTP username webserver</strong></td>
          <td class="bg_table_body"><input name="ftp_user_web" type="text" id="ftp_user_web" size="40" /></td>
          <td class="bg_table_body">&nbsp;</td>
        </tr>
        <tr>
          <td class="bg_table_body"><strong>FTP password webserver</strong></td>
          <td class="bg_table_body"><input name="ftp_password_web" type="text" id="ftp_password_web" size="40" /></td>
          <td class="bg_table_body">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" class="bg_table_body"><p>&nbsp;</p>
            <p>If you connect to your webserver through FTP, what is the location of the <em><strong>download</strong></em> folder of PBSViewer? copy past or type your path directly after login</p></td>
          </tr>
        <tr>
          <td width="25%" class="bg_table_body"><strong>PBSViewer download path</strong></td>
          <td width="50%" class="bg_table_body"><input name="pbsv_download" type="text" id="pbsv_download" value="httpdocs/somepath/download" size="40" /></td>
          <td class="bg_table_body"><em>omit trailing slash /</em></td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="bg_table_body"><input type="submit" name="next_ftp_web" id="next_ftp_web" value="Next" /></td>
        </tr>
      </table>
      </form>
      <br /></td>
  </tr>
</table>
</body>
</html>
	
	<?php 
}

function template_template_settings()
{
	?>
	
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation of pbsviewer</title>
<link href="install.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_main">
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><strong><span class="txt_light">Template settings</span></strong></td>
      </tr>
    </table>
    <form id="Install_DB" name="Install_DB" method="post" action="install.php?step=11">
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" class="bg_table_body"><p>On the main page the latest x screens are shown to save some bandwith</p></td>
          </tr>
        <tr>
          <td class="bg_table_body"><strong>nr screens on main page</strong></td>
          <td class="bg_table_body"><input name="nr_screens_main" type="text" id="nr_screens_main" value="10" size="40" /></td>
          <td class="bg_table_body"><em>Default is 10</em></td>
        </tr>
        <tr>
          <td colspan="3" class="bg_table_body"><p>&nbsp;</p>
            <p>Amount of pictures you want to have on each row</p></td>
          </tr>
        <tr>
          <td class="bg_table_body"><strong>number of screens/row</strong></td>
          <td class="bg_table_body"><input name="NR" type="text" id="NR" value="4" size="40" /></td>
          <td class="bg_table_body"><em>Default is 4</em></td>
        </tr>
        <tr>
          <td colspan="3" class="bg_table_body"><p>&nbsp;</p>
            <p>Thumbnail image </p></td>
          </tr>
        <tr>
          <td class="bg_table_body"><strong>Image height</strong></td>
          <td class="bg_table_body"><input name="IMG_H" type="text" id="IMG_H" value="200" size="40" /></td>
          <td class="bg_table_body"><em>Default is 200</em></td>
        </tr>
        <tr>
          <td colspan="3" class="bg_table_body"><p>&nbsp;</p>
            <p>Thumbnail image width</p></td>
          </tr>
        <tr>
          <td width="25%" class="bg_table_body"><strong>Image width</strong></td>
          <td width="50%" class="bg_table_body"><input name="IMG_W" type="text" id="IMG_W" value="200" size="40" /></td>
          <td class="bg_table_body"><em>Default is 200</em></td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="bg_table_body"><input type="submit" name="next_template" id="next_template" value="Next" /></td>
        </tr>
      </table>
      </form>
      <br /></td>
  </tr>
</table>
</body>
</html>
	
	<?php 
}

function template_log_option()
{
	?>
	
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation of pbsviewer</title>
<link href="install.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_main">
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><strong><span class="txt_light">Log settings</span></strong></td>
      </tr>
    </table>
    <form id="Install_DB" name="Install_DB" method="post" action="install.php?step=7">
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" class="bg_table_body"><p> Gather more info about screens. With those logs you have the ability to check if screens you have download are the original ones. This is done with help of md5 check. From those logs also the ip addresses of players can be found. If you set this option to true, then the gameserver logs are <strong>automatically deleted</strong> and partially stored on your webserver.<br />
            Another feature that becomes possible when you choose to use pb logs is the reset feature. As admin you will have an extra button on the main page. This button enables you to delete all the logs and screens from your gameserver and webserver automatically. Also the database will be cleaned automatically. It is recommended to use this button to save some space and/or when the script becomes to slow to load all those screens.</p>
            <p>If you don't want logging use false</p></td>
          </tr>
        <tr>
          <td width="25%" class="bg_table_body"><strong>use pb logs?</strong></td>
          <td width="50%" class="bg_table_body"><label>
            <select name="pb_log" id="pb_log">
<option value="false">false</option>
<option value="true">true</option>
            </select>
          </label></td>
          <td class="bg_table_body"><em>Default	is	false</em></td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="bg_table_body"><input type="submit" name="next_pb_log" id="next_pb_log" value="Next" /></td>
        </tr>
      </table>
      </form>
      <br /></td>
  </tr>
</table>
</body>
</html>
	
	<?php 
}

function template_log_settings()
{
	?>
	
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation of pbsviewer</title>
<link href="install.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_main">
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><strong><span class="txt_light">Log settings (2)</span></strong></td>
      </tr>
    </table>
    <form id="Install_DB" name="Install_DB" method="post" action="install.php?step=8">
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" class="bg_table_body"><p>This option will automatically delete logs downloaded from your webserver.</p></td>
          </tr>
        <tr>
          <td width="25%" class="bg_table_body"><strong>auto deletion of logs?</strong></td>
          <td width="50%" class="bg_table_body"><label>
            <select name="auto_del_logs" id="auto_del_logs">
<option value="true">true</option>
<option value="false">false</option>
            </select>
          </label></td>
          <td class="bg_table_body"><em>Default	is	true</em></td>
        </tr>
        <tr>
          <td colspan="3" class="bg_table_body"><p>&nbsp;</p>
            <p>amount of logs  has to be lower than <em>'PB_SV_LogCeiling'</em>. Otherwise there won't be an auto-delete. This is the number of logs stored on your webserver<br />
If you choose 0, then log files are deleted immediately after updating.<br />
If you don't want to delete the logs from your webserver leave this field empty</p></td>
          </tr>
        <tr>
          <td class="bg_table_body"><strong>amount of logs</strong></td>
          <td class="bg_table_body"><label>
            <input name="auto_del_count" type="text" id="auto_del_count" value="4" />
          </label></td>
          <td class="bg_table_body"><em>Default	is	4</em></td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="bg_table_body"><input type="submit" name="next_pb_log_2" id="next_pb_log_2" value="Next" /></td>
        </tr>
      </table>
      </form>
      <br /></td>
  </tr>
</table>
</body>
</html>
	
	<?php 
}

function template_additional_settings()
{
	?>
	
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation of pbsviewer</title>
<link href="install.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_main">
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><strong><span class="txt_light">Additional settings</span></strong></td>
      </tr>
    </table>
    <form id="Install_DB" name="Install_DB" method="post" action="install.php?step=12">
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" class="bg_table_body"><p>pb keeps logging screenshots data to pbsvss.htm, it places the newest entries at the end of this file. However pb does not remove old data, so this file will keep on growing in size. If you choose true, then old entries will be removed. This will keep the filesize at a constant size.</p></td>
          </tr>
        <tr>
          <td width="25%" class="bg_table_body"><strong>Auto update pbsvss? </strong></td>
          <td width="50%" class="bg_table_body"><label>
            <select name="pbsvss_updater" id="pbsvss_updater">
<option value="false">false</option>
<option value="true">true</option>
            </select>
          </label></td>
          <td class="bg_table_body"><em>Default	is	false</em></td>
        </tr>
        <tr>
          <td colspan="3" class="bg_table_body"><p>&nbsp;</p>
            <p>After this time the script does stop running, if you for instance need to download a lot of screens then it is recommended to have a high script load time. If you are not sure, then use default setting.</p></td>
          </tr>
        <tr>
          <td class="bg_table_body"><strong>Maximum script load time? </strong></td>
          <td class="bg_table_body"><label>
            <input name="script_load_time" type="text" id="script_load_time" value="600" />
          </label></td>
          <td class="bg_table_body"><em>Default is 600 seconds</em></td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="bg_table_body"><input type="submit" name="next_addit" id="next_addit" value="Next" /></td>
        </tr>
      </table>
      </form>
      <br /></td>
  </tr>
</table>
</body>
</html>
	
	<?php 
}

function template_reset_option()
{
	?>
	
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation of pbsviewer</title>
<link href="install.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_main">
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><strong><span class="txt_light">Reset settings</span></strong></td>
      </tr>
    </table>
    <form id="Install_DB" name="Install_DB" method="post" action="install.php?step=10">
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" class="bg_table_body"><p> Do you want to use the reset feature? As admin you will have an extra button on the main page. This button enables you to delete all the logs and screens from your gameserver and webserver automatically. Also the database will be cleaned automatically. It is recommended to use this button to save some space and/or when the script becomes to slow to load all those screens.</p>
            <p>If you don't want this reset feature choose false</p></td>
          </tr>
        <tr>
          <td width="25%" class="bg_table_body"><strong>enable reset?</strong></td>
          <td width="50%" class="bg_table_body"><label>
            <select name="pb_reset_option" id="pb_reset_option">
<option value="false">false</option>
<option value="true">true</option>
            </select>
          </label></td>
          <td class="bg_table_body"><em>Default	is	false</em></td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="bg_table_body"><input type="submit" name="next_reset_option" id="next_reset_option" value="Next" /></td>
        </tr>
      </table>
      </form>
      <br /></td>
  </tr>
</table>
</body>
</html>
	
	<?php 	
}

function template_admin_setting()
{
	?>
	
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation of pbsviewer</title>
<link href="install.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_main">
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><strong><span class="txt_light">Admin account setting</span></strong></td>
      </tr>
    </table>
    <form id="admin_setting" name="admin_setting" method="post" action="install.php?step=13">
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" class="bg_table_body">Please specify the username and password you want for login. All fields are required to fill in.</td>
          </tr>
        <tr>
          <td width="25%" class="bg_table_body"><strong>Username?</strong></td>
          <td width="50%" class="bg_table_body"><input name="admin_username" type="text" id="admin_username" value="admin" size="40" /></td>
          <td class="bg_table_body"><em>Default is admin</em></td>
        </tr>
        <tr>
          <td colspan="3" class="bg_table_body">&nbsp;</td>
          </tr>
        <tr>
          <td class="bg_table_body"><strong>Password</strong></td>
          <td class="bg_table_body"><input name="admin_password" type="password" id="admin_password2" size="40" /></td>
          <td class="bg_table_body"><em>Please use a strong complex password that you can easily remember</em></td>
        </tr>
        <tr>
          <td colspan="3" class="bg_table_body"><p><br />
            Mail will be used for resetting your password if needed (in case you forgot your password or username). Your mail will also be used for notification messages. After installation you can turn notification on or off in ACP.</p></td>
          </tr>
        <tr>
          <td class="bg_table_body"><strong>Mail</strong></td>
          <td class="bg_table_body"><input name="admin_mail" type="text" id="admin_mail" size="40" /></td>
          <td class="bg_table_body">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="center" class="bg_table_body"><input type="submit" name="next_admin_account" id="next_admin_account" value="Next" /></td>
        </tr>
      </table>
      </form>
      <br /></td>
  </tr>
</table>
</body>
</html>
	
	<?php
}

function template_create_db()
{
	?>
	
					<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation of pbsviewer</title>
<link href="install.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_main">
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><strong>Create the remaining database tables</strong></td>
      </tr>
    </table>
    <form id="Install_DB" name="Install_DB" method="post" action="install.php?step=14">
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" class="bg_table_body"><p>Everything is configured now. Please press on next button to create the database tables</p></td>
          </tr>
        <tr>
          <td align="center" class="bg_table_body"><input type="submit" name="next_create_db" id="next_create_db" value="Next" /></td>
        </tr>
      </table>
      </form>
      <br /></td>
  </tr>
</table>
</body>
</html>
	
	<?php 
}

function template_error($msg)
{
?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation of pbsviewer</title>
<link href="install.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_main">
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><span class="txt_light">:: Error ::</span></td>
      </tr>
    </table>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="bg_table_body"><p align="center"><br />
            Something went wrong, see below what went wrong:<br />
                </p>
            <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_error">
              <tr>
                <td><em><?php echo $msg?></em></td>
              </tr>
            </table>
            <p align="center"><a href="javascript:history.go(-1)" target="_self">click here to go back</a></p></td>
        </tr>
      </table>
      <br /></td>
  </tr>
</table>
</body>
</html>	


<?php 
}

function template_final()
{
	?>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Installation of pbsviewer</title>
<link href="install.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_main">
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><span class="style1">Installation finished!</span></td>
      </tr>
    </table>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="bg_table_body"><p align="center"><strong><br />
            Congratulations!</strong></p>
            <p align="left">              You are now ready to use pbsviewer. However don't forget to<strong> remove your install map first!</strong><br />
            <a href="../" target="_self">Click here to check to go to the main page of pbsviewer</a></p></td>
        </tr>
      </table>
      <br /></td>
  </tr>
</table>
</body>
</html>	
	
	<?php 
}

function append_config($data)
{
		$fp		=	fopen('../inc/config.inc.php','a');
		
		fwrite($fp,$data);
	
		fclose($fp);
	
}

function write_config($data)
{
		$fp		=	fopen('../inc/config.inc.php','w');
		
		fwrite($fp,$data);
	
		fclose($fp);
}

function check_db_connection($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME)
{
	$error	=	array('','');
	if($connect	=	@mysql_connect($DB_HOST,$DB_USER,$DB_PASS))
	{$connection1=true;}
	else
	{
		$connection1=false;
	}

	if(@mysql_select_db($DB_NAME,$connect))
	{$connection2=true;}
	else
	{
		$connection2=false;
	}

	$error	=	array($connection1,$connection2);
	return $error;
}

function check_CHMOD($file1,$file2,$file3)
{
	$error	=	array(false,false,false);
	if(is_writable($file1))		$write_1=true;
	if(is_writeable($file2))	$write_2=true;
	if(is_writeable($file3))	$write_3=true;

	$error	=	array($write_1,$write_2,$write_3);
	return $error;
}

function check_ftp_connection($FTP_HOST,$FTP_PORT,$FTP_USER,$FTP_PASS,$PBDIR)
{
	$error	=	array(false,false,false);

	//	ftp connect
	if($connect	=	@ftp_connect($FTP_HOST,$FTP_PORT)) $connection=true;

	//	check login
	if($login		=	@ftp_login($connect,$FTP_USER,$FTP_PASS)) $loggedIn=true;

	if($connect && $login)
	{
		//	check if directory exists
		if(ftp_chdir($connect,$PBDIR))	$dir=true;
	}

	ftp_close($connect);

	$error	=	array($connection,$loggedIn,$dir);
	return $error;
}

function check_ftp_web_connection($FTP_HOST,$FTP_PORT,$FTP_USER,$FTP_PASS,$DIR)
{
	$error	=	array(false,false,false);

	//	ftp connect
	if($connect	=	@ftp_connect($FTP_HOST,$FTP_PORT)) $connection=true;

	//	check login
	if($login		=	@ftp_login($connect,$FTP_USER,$FTP_PASS)) $loggedIn=true;

	if($connect && $login)
	{
		//	check if directory exists
		if(ftp_chdir($connect,$DIR))	$dir=true;
	}

	ftp_close($connect);

	$error	=	array($connection,$loggedIn,$dir);
	return $error;
}

function connect_DB_config()
{
	$connect	=	mysql_connect(DB_HOST,DB_USER,DB_PASS) or die ('invalid login details');
	if(DEBUG==true)
	{
		mysql_select_db(DB_NAME,$connect) or die('cannot connect to db');
	}
	else
	{
		mysql_select_db(DB_NAME,$connect) or die();
	}
}

function connect_DB($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME)
{
	$connect	=	mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
	mysql_select_db($DB_NAME,$connect) or die();
}



?>