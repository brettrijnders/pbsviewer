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

if(isset($_POST['install']))
{	
//	first check CHMOD

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
	if(eregi(\"config.inc.php\", \$_SERVER[\"PHP_SELF\"])) die('Acces denied!');

	//---------------------]	REQUIRED	[---------------------\\ \n";
	
	write_config($pre_data);
		
	//	go to next page
	refresh_page('?p=step_1');
				}
}
else 
{
	if((isset($_GET['p'])))
	{			
		if($_GET['p']=='step_1')
			{	
					if(isset($_POST['next_db']))
					{			
						if($_POST['db_host']!=''&&$_POST['username']!=''&&$_POST['password']!=''&&$_POST['db_name']!='')
						{
							if($_POST['password']=='-') $_POST['password']='';					
							
							//	check if connection with db is possible and if we can select our db
							$check_db	=	check_db_connection($_POST['db_host'],$_POST['username'],$_POST['password'],$_POST['db_name']);
							
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
			define('DB_NAME','".$_POST['db_name']."');\n";
									
									append_config($data_app);
									
									refresh_page('?p=step_2');
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
						
					}
					else 
					{
						template_install_DB();		
					}

			
			
		}
		elseif($_GET['p']=='step_2')
		{

				if(isset($_POST['next_ftp']))
				{
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
				define('FTP_PASS','".$_POST['ftp_password']."');
				
				define('PBDIR','".$_POST['pb_dir']."');								//	Directory of punkbuster.\n";
										
										append_config($data_app);
																
										
										refresh_page('?p=step_3');		
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
						
				}
				else 
				{
					template_ftp_settings();
				}
			
		}
		elseif ($_GET['p']=='step_3')
		{
			
			if(isset($_POST['next_custom_update']))
			{
				if($_POST['custom_update']!='')
				{
					if($_POST['update_time']!=''||$_POST['update_time']<0)
					{
						if($_POST['admin']!='')
						{
							$admins	=	$_POST['admin'];
							$admin_ip	=	explode(',',$admins);
							
							//	everything is correct
							$data_app	=	"	//	update settings (required)
	//	If 'CUSTOM_UPDATE' is true then the admin or a cron job should run the 'update.php' which is located in in map 'update'.
	//	If option is false, then it will update after x seconds which can can be configured with 'UPDATE_TIME' see below.
	//	You still have the possibility to force an update manually by running 'update.php' if you want.
	define('CUSTOM_UPDATE',".$_POST['custom_update'].");
	define('UPDATE_TIME',".$_POST['update_time'].") ;								//	Update every 3600*24 s, every day. Use a small update time if gameserver is crowded (since a lot of new screens are captured), for example a public gameserver. However keep in mind that bandwith will also increase if UPDATE_TIME is smaller.
	
	//	Fill in your ip, to find your ip one can use www.cmyip.com, you can have more than one ip if your want. With your ip, this program knows wether you are an admin or not.\n";
							
							for ($i=0;$i<count($admin_ip);$i++)
							{
								//	user can give an empty ip if they use default input
								if($admin_ip[$i]!='')
								{
									$data_app.="\$admin_ip[".$i."]	=	'".$admin_ip[$i]."';\n";
								}
							}
							
							$data_app.=	"\n\n";
							
							append_config($data_app);						
							
							refresh_page('?p=step_4');
						}	
						else 
						{
							template_error('<li>You need at least one admin</li>');
						}			
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
				
				
			}
			else 
			{
				template_update_settings();
				
			}
				
		}
		elseif ($_GET['p']=='step_4')
		{
			if(isset($_POST['next_pb']))
			{
				if($_POST['pb_ss_ceiling']>0)
				{
					$data_app	=	"	//	parser settings (required) (IMPORTANT!)
	//	If you do not set this correct then,
	//	one can get wrong results.
	define('pb_sv_SsCeiling',".$_POST['pb_ss_ceiling'].");							//	To find your number open this file 'pbsv.cfg' and look for 'pb_sv_SsCeiling'. The file should be located in your 'pb' directory on your ftp of your gameserver. 
																//	It is recommended to have a small amount as possible to save some bandwith and space. NB both values of 'pb_sv_SsCeiling' as in 'pbsv.cfg' and this config file should be the same 
																//	If you are not sure please take a large number like 10000 or contact me ;)
																//	Game-violations has set this number to 10000
																//	PB default is 100";
					
					$data_app	.="\n\n";
					
					append_config($data_app);
					
					refresh_page('?p=step_5');
				}
				else 
				{
					template_error('<li>Please use a larger value for your pb_sv_SsCeiling</li>');
				}
			}
			else 
			{
				template_pb_settings();
			}

		}		
		elseif ($_GET['p']=='step_5')
		{

			if(isset($_POST['next_seo']))
			{
			
				if($_POST['clan_name']!=''||$_POST['clan_tag']!=''||$_POST['clan_game_short']!=''||$_POST['clan_game_full']!='')
				{
					$data_app	=	"	//	SEO options (required)
	define('CLAN_NAME','".$_POST['clan_name']."');					//	What is your full clan name?
	define('CLAN_TAG','".$_POST['clan_tag']."');									//	Your clantag ingame?
	define('CLAN_GAME','".$_POST['clan_game_full']."');						//	Which game are you playing. So what is your gameserver running?
	define('CLAN_GAME_SHORT','".$_POST['clan_game_short']."');				//	What is your game name in short?";
					
					$data_app	.=	"\n\n";
					
					append_config($data_app);
					
					refresh_page('?p=step_6');
				}
				else 
				{
					template_error('<li>Not all fields were filled in</li>');
				}
			}
			else 
			{
				template_seo_settings();
			}

		}
		elseif ($_GET['p']=='step_6')
		{

			if(isset($_POST['next_pb_log']))
			{
				if($_POST['pb_log']=='true')
				{
					$data_app	=	"	//---------------------]	OPTIONAL	[---------------------\\

	//	gather more info about screens, like md5 check
	//	or ip address of players, with help of logs
	define('PB_log',".$_POST['pb_log'].");										//	Default	=	false, If you don't want logging use false";
					
					$data_app	.=	"\n";
					
					append_config($data_app);
					
					refresh_page('?p=step_7');
				}
				//	or other page if log option is false
				else 
				{
					$data_app	=	"	//---------------------]	OPTIONAL	[---------------------\\

	//	gather more info about screens, like md5 check
	//	or ip address of players, with help of logs
	define('PB_log',false);										//	Default	=	false, If you don't want logging use false
	define('auto_del_logs',true);								//	Default	=	true, this option will automatically delete logs downloaded from your webserver.
	define('auto_del_count',4);		 							//	Default	=	4, auto_del_count has to be lower than PB_SV_LogCeiling. Otherwise there won't be an auto-delete. This is the number of logs stored on your webserver
																//	If you choose 0, then log files are deleted immediately after updating
																//	If you don't want to delete the logs from your webserver leave this filed empty";
					
					$data_app	.=	"\n\n";
					
					append_config($data_app);

					$_SESSION['p']=9;				
					
					refresh_page('?p=step_9');
				}
			}
			else 
			{
				template_log_option();
			}
		}
		elseif ($_GET['p']=='step_7')
		{
			if(isset($_POST['next_pb_log_2']))
			{
				if($_POST['auto_del_count']>=0)
				{
					$data_app	=	"	define('auto_del_logs',".$_POST['auto_del_logs'].");								//	Default	=	true, this option will automatically delete logs downloaded from your webserver.
	define('auto_del_count',".$_POST['auto_del_count'].");		 							//	Default	=	4, auto_del_count has to be lower than PB_SV_LogCeiling. Otherwise there won't be an auto-delete. This is the number of logs stored on your webserver
																//	If you choose 0, then log files are deleted immediately after updating
																//	If you don't want to delete the logs from your webserver leave this filed empty";
					
					$data_app	.=	"\n\n";
					
					append_config($data_app);
					
					refresh_page('?p=step_8');
				}
				else 
				{
					template_error('<li>You can\'t use negative values</li>');
				}
			}
			else 
			{
				template_log_settings();
			}
		}
		elseif ($_GET['p']=='step_8')
		{
			if(isset($_POST['next_ftp_web']))
			{
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
	
		define('PBSViewer_download','".$_POST['pbsv_download']."');	//	If you connect to your webserver through FTP, what is the location of the download folder of PBSViewer? copy past or type your path directly after login";
								$data_app	.=	"\n\n";
								
								$data_app	.= "	define('RESET',true);										//	Default	=	false. Reset feature allows you to delete all screens and log files from your webserver and gameserver";
					
								$data_app	.= "\n\n";
								
								append_config($data_app);
								

								
								refresh_page('?p=step_10');
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
			}
			else 
			{
				template_ftp_web_log();
			}
		}
		elseif ($_GET['p']=='step_9')
		{
			if(isset($_POST['next_reset_option']))
			{
				if($_POST['pb_reset_option']=='true')
				{
					$data_app	= "	define('RESET',".$_POST['pb_reset_option'].");										//	Default	=	false. Reset feature allows you to delete all screens and log files from your webserver and gameserver";
						
					$data_app	.= "\n\n";
					
					append_config($data_app);
					
					refresh_page('?p=step_8');
				}
				else 
				{
					$data_app	= "	define('RESET',false);										//	Default	=	false. Reset feature allows you to delete all screens and log files from your webserver and gameserver";
						
					$data_app	.= "\n\n";
					
					append_config($data_app);
					
					refresh_page('?p=step_10');
				}
			}
			else 
			{
				template_reset_option();
			}
		}
		elseif ($_GET['p']=='step_10')
		{
			if(isset($_POST['next_template']))
			{
				if($_POST['nr_screens_main']>0)
				{
					if($_POST['NR']>0)
					{
						if($_POST['IMG_H']>0&&$_POST['IMG_W']>0)
						{
							$data_app	=	"	//	template settings (optional)
	define('nr_screens_main',".$_POST['nr_screens_main'].");								//	Default=10, on the main page the latest x screens are shown to save some bandwith
	define('NR',".$_POST['NR'].");												//	Amount of pictures you want to have on each row
	define('IMG_W',".$_POST['IMG_W'].");										//	Thumbnail image width
	define('IMG_H',".$_POST['IMG_H'].");										//	Thumbnail image height";
							$data_app	.=	"\n\n";
							
							append_config($data_app);
							
							refresh_page('?p=step_11');
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
			}
			else 
			{
				template_template_settings();
			}

		}
		elseif ($_GET['p']=='step_11')
		{
			if(isset($_POST['next_addit']))
			{
				if($_POST['script_load_time']>30)
				{
					$data_app	=	"	// (optional)
	define('pbsvss_updater',".$_POST['pbsvss_updater'].");								//	Default=false. pb keeps logging screenshots data to pbsvss.htm, it places the newest entries at the end of this file. However pb does not remove old data, so this file will keep on growing in size. If you choose true, then old entries will be removed. This will keep the filesize at a constant size.
	
	//	script load time (optional)
	define('script_load_time',".$_POST['script_load_time'].");							//	Default=600 seconds or 10 minutes, after 600 Maximum execution time error will be shown.";
					$data_app	.=	"\n\n";
					
					//	write additional data
					$data_app	.=	"	//	guid length (optional)
	define('guidlength',32);									//	Default should be 32
	define('guidlength_short',8);								//	Default = 8
	
	//	advance settings (optional)
	define('DEBUG',false);										//	Default is false;
	define('L_FILE','download/pbsvss.htm');						//	Local File to save remote data to. Only change this if you know what you are doing
	define('L_FILE_TEMP','download/pbsvss_temp.htm'); 			//	Local file to temporary save remote data to. Only change this if you know what you are doing
	define('R_FILE','pbsvss.htm');								//	Remote file, only change this if you know what you are doing
	define('weblogs_dir','download');							//	directory where the log files are stored

}
else
{
	die('Acces denied!');
}


?>";
					append_config($data_app);
					
					refresh_page('?p=step_12');				
				}
				else 
				{
					template_error('<li>It is recommended to have a script load time larger than 30</li>');
				}
				
				
			}
			else 
			{
				template_additional_settings();
			}
		}
		//	create tables
		elseif ($_GET['p']=='step_12')
		{
			if(isset($_POST['next_create_db']))
			{
				$key	=	md5($_SERVER['SERVER_SIGNATURE'].' '.php_uname());
				include("../inc/config.inc.php");
				
				//	connect to DB
				connect_DB();
				
				
				$sql_create	=	"
CREATE TABLE `screens` 
(
`id` INT(8) NOT NULL AUTO_INCREMENT,
`fid` TEXT NOT NULL,
`name` TEXT NOT NULL,
`guid` TEXT NOT NULL,
`filesize` INT(8) NOT NULL,
`date` datetime,
PRIMARY KEY(`id`)
);
";
				mysql_query($sql_create);
				
								$sql_create	=	"
CREATE TABLE `screens_old` 
(
`id` INT(8) NOT NULL AUTO_INCREMENT,
`fid` TEXT NOT NULL,
`name` TEXT NOT NULL,
`guid` TEXT NOT NULL,
`filesize` INT(8) NOT NULL,
`date` datetime,
PRIMARY KEY(`id`)
);
";
				mysql_query($sql_create);
				
								$sql_create	=	"
CREATE TABLE `admin` 
(
`request_update` boolean DEFAULT '0'
);
";								
				mysql_query($sql_create);

				$sql_create	=	"INSERT INTO `admin` (`request_update`) VALUES('0')";							
				mysql_query($sql_create);
					

				$sql_create	=	"
CREATE TABLE `dl_screens`
(
`id` INT(8) NOT NULL AUTO_INCREMENT,
`fid` TEXT NOT NULL,
PRIMARY KEY(`id`)
);
";
								mysql_query($sql_create);
				
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

				
				refresh_page('?p=final');
			}
			else 
			{
				template_create_db();
			}
		}
		elseif ($_GET['p']=='final')										
		{
				template_final();			
		}

	
	}
	else 
	{
		template_start();
	}
	
}


function template_start()
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
        <td align="center"><span class="txt_light">Welcome, you are going to install  pbsviewer</span></td>
      </tr>
    </table>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="bg_table_body"><p>This is a step-by-step installer, it will take you 5 minutes to install this script<br />
            Please check the following  first:
              </p>
            <ol>
              <li>Did you CHMOD <em>'download'</em> to '<strong>777</strong>', '<em>lastUpdate.txt</em>' to '<strong>666</strong>' and <em>'inc'</em> to <strong>777</strong>? If your don't know what it is, it is just changing the properties/permissions of a file through ftp for example</li>
            </ol>
            <p align="center">If you are sure everything is correct, please click on install<br />
            </p>
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_install">
              <tr>
                <td align="center"><form id="Install" name="Install" method="post" action="">
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
	
	<?
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
    <form id="Install_DB" name="Install_DB" method="post" action="">
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
	
	<?
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
    <form id="Install_DB" name="Install_DB" method="post" action="">
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
          <td class="bg_table_body"><em>Use '/' and don't use 'pb/' with a trailing slash.</em></td>
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
	
	<?
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
    <form id="Install_DB" name="Install_DB" method="post" action="">
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" class="bg_table_body"><p> If 'custom update' is <em>true</em> then the admin or a cron job should run the '<em><strong>update.php</strong></em>' which is located in in map <em><strong>'update'</strong></em>. If option is <em>false</em>, then it will update after x seconds which can can be configured with 'UPDATE_TIME' see below.You still have the possibility to force an update manually by running 'update.php' if you want.</p>
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
          <td colspan="3" class="bg_table_body"><p>&nbsp;</p>
            <p>Fill in your ip, to find your ip one can use <a href="www.cmyip.com" title="ip adres of user" target="_blank">www.cmyip.com</a>, you can have more than one ip if your want. Separate with comma for multiple admins. The first ip address is your ip address. With your ip the program knows wether you are an admin or not.</p></td>
          </tr>
        <tr>
          <td class="bg_table_body">admin(s)</td>
          <td class="bg_table_body"><label>
            <textarea name="admin" id="admin" cols="45" rows="5"><?echo $_SERVER['REMOTE_ADDR'];?>,</textarea>
          </label></td>
          <td class="bg_table_body">&nbsp;</td>
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
	
	<?
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
    <form id="Install_DB" name="Install_DB" method="post" action="">
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" class="bg_table_body"><p>&nbsp;</p>
            <p>If you do not set this correct then, 
            one can get wrong results. To find your number open this file 'pbsv.cfg' and look for 'pb_sv_SsCeiling'. The file should be located in your 'pb' directory on your ftp of your gameserver. <br />
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
	
	<?
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
    <form id="Install_DB" name="Install_DB" method="post" action="">
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
	
	<?
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
    <form id="Install_DB" name="Install_DB" method="post" action="">
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
	
	<?
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
    <form id="Install_DB" name="Install_DB" method="post" action="">
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
	
	<?
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
    <form id="Install_DB" name="Install_DB" method="post" action="">
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" class="bg_table_body"><p> Gather more info about screens. With those logs you have the ability to check if screens you have download are the original ones. This is done with help of md5 check. From those logs also the or ip addresses of players can be found. If you set this option to true, then the gameserver logs are <strong>automatically deleted</strong> and partially stored on your webserver.<br />
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
	
	<?
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
    <form id="Install_DB" name="Install_DB" method="post" action="">
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
If you choose 0, then log files are deleted immediately after updating<br />
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
	
	<?
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
    <form id="Install_DB" name="Install_DB" method="post" action="">
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
	
	<?
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
    <form id="Install_DB" name="Install_DB" method="post" action="">
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
	
	<?	
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
        <td align="center"><strong>Create the database tables</strong></td>
      </tr>
    </table>
    <form id="Install_DB" name="Install_DB" method="post" action="">
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
	
	<?
}

function template_error($msg,$back_page='./')
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
                <td><em><?echo $msg?></em></td>
              </tr>
            </table>
            <p align="center"><a href="<?echo $back_page;?>" target="_self">click here to go back</a></p></td>
        </tr>
      </table>
      <br /></td>
  </tr>
</table>
</body>
</html>	


<?
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
	
	<?
}

function refresh_page($page,$seconds=0)
{
echo "<meta http-equiv='refresh' content='".$seconds.";URL=".$page."' />";	
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

function connect_DB()
{
	$connect	=	mysql_connect(DB_HOST,DB_USER,DB_PASS);
	if(DEBUG==true)
	{
		mysql_select_db(DB_NAME,$connect) or die('cannot connect to db');
	}
	else
	{
		mysql_select_db(DB_NAME,$connect) or die();
	}
}

?>