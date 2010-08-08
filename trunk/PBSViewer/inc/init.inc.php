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
if(!isset($key)) die('Acces denied!');

if($key==md5($_SERVER['SERVER_SIGNATURE'].' '.php_uname()))
{
	if(eregi("init.inc.php", $_SERVER["PHP_SELF"])) die('Acces denied!');
	
	//change argument separator to &amp instead of &, because & is not valid
	ini_set('arg_separator.output','&amp;'); 
	
	
	// default values
	$notify_update		= '';
	$private_password	= '';	
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
	
	// gather data
	$sql_select = "SELECT `name`,`value` FROM `settings`";
	$sql = mysql_query($sql_select) or die(mysql_error());
	while ($row = mysql_fetch_object($sql))
	{
		if ($row->name=='private_password')
		{
			$private_password	=	$row->value;
		}
		elseif($row->name=='notify_update') 
		{
			$notify_update	=	$row->value;
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
	
	//---------------------]	REQUIRED	[---------------------\ 
	define('PBDIR',$pb_dir);									//	Directory of punkbuster.
	//	update settings (required)
	//	If 'CUSTOM_UPDATE' is true then the admin or a cron job should run the 'update.php' which is located in in map 'update'.
	//	If option is false, then it will update after x seconds which can can be configured with 'UPDATE_TIME' see below.
	//	You still have the possibility to force an update manually by running 'update.php' if you want.
	if ($custom_update==1)
	{define('CUSTOM_UPDATE',true);}
	else 
	{define('CUSTOM_UPDATE',false);}
	
	define('UPDATE_TIME',$update_time) ;						//	Update every 3600*24 s, every day. Use a small update time if gameserver is crowded (since a lot of new screens are captured), for example a public gameserver. However keep in mind that bandwith will also increase if UPDATE_TIME is smaller.
	

	//	used for making PBSViewer private
	define('PRIVATE_PASSWORD',$private_password);
	
	//	when true, user will receive mail notification about this
	define('NOTIFY_UPDATE',$notify_update);
	
	//	parser settings (required) (IMPORTANT!)
	//	If you do not set this correct then,
	//	one can get wrong results.
	define('pb_sv_SsCeiling',$pb_sv_ssceiling);					//	To find your number open this file 'pbsv.cfg' and look for 'pb_sv_SsCeiling'. The file should be located in your 'pb' directory on your ftp of your gameserver. 
																//	It is recommended to have a small amount as possible to save some bandwith and space. NB both values of 'pb_sv_SsCeiling' as in 'pbsv.cfg' and this config file should be the same 
																//	If you are not sure please take a large number like 10000 or contact me ;)
																//	Game-violations has set this number to 10000
																//	PB default is 100

	//	SEO options (required)
	define('CLAN_NAME',$clan_name);								//	What is your full clan name?
	define('CLAN_TAG',$clan_tag);								//	Your clantag ingame?
	define('CLAN_GAME',$clan_game);								//	Which game are you playing. So what is your gameserver running?
	define('CLAN_GAME_SHORT',$clan_game_short);					//	What is your game name in short?

	//---------------------]	OPTIONAL	[---------------------\

	
	//	gather more info about screens, like md5 check
	//	or ip address of players, with help of logs
	if ($pb_log==1)
	{
		define('PB_log',true);									//	Default	=	false, If you don't want logging use false		
	}
	else 
	{
		define('PB_log',true);									//	Default	=	false, If you don't want logging use false
	}
	
	if ($auto_del_count==-1)
	{
		define('auto_del_logs',false);							//	Default	=	true, this option will automatically delete logs downloaded from your webserver.		
	}
	else 
	{
		define('auto_del_logs',true);							//	Default	=	true, this option will automatically delete logs downloaded from your webserver.		
		define('auto_del_count',$auto_del_count);				//	Default	=	4, auto_del_count has to be lower than PB_SV_LogCeiling. Otherwise there won't be an auto-delete. This is the number of logs stored on your webserver
																//	If you choose 0, then log files are deleted immediately after updating
																//	If you don't want to delete the logs from your webserver leave this filed empty
	}
	
	
	


	
		define('PBSViewer_download',$pbsv_download_dir);		//	If you connect to your webserver through FTP, what is the location of the download folder of PBSViewer? copy past or type your path directly after login

	if ($reset==1)	
	{
		define('RESET',true);									//	Default	=	false. Reset feature allows you to delete all screens and log files from your webserver and gameserver
	}
	else 
	{
		define('RESET',false);									//	Default	=	false. Reset feature allows you to delete all screens and log files from your webserver and gameserver
	}
	

	//	template settings (optional)
	define('nr_screens_main',$nr_screens_main);					//	Default=10, on the main page the latest x screens are shown to save some bandwith
	define('NR',$screens_per_row);								//	Amount of pictures you want to have on each row
	define('IMG_W',$width);										//	Thumbnail image width
	define('IMG_H',$height);									//	Thumbnail image height
	define('LANGUAGE',$language);
	define('CBGAMEID',$CB_game);

	// (optional)
	if ($pbsvss_updater==1)
	{
	define('pbsvss_updater',true);								//	Default=false. pb keeps logging screenshots data to pbsvss.htm, it places the newest entries at the end of this file. However pb does not remove old data, so this file will keep on growing in size. If you choose true, then old entries will be removed. This will keep the filesize at a constant size.
	}
	else 
	{
	define('pbsvss_updater',false);								//	Default=false. pb keeps logging screenshots data to pbsvss.htm, it places the newest entries at the end of this file. However pb does not remove old data, so this file will keep on growing in size. If you choose true, then old entries will be removed. This will keep the filesize at a constant size.
	}
		
	//	script load time (optional)
	define('script_load_time',$script_load_time);				//	Default=600 seconds or 10 minutes, after 600 Maximum execution time error will be shown.

	//	guid length (optional)
	define('guidlength',32);									//	Default should be 32
	define('guidlength_short',8);								//	Default = 8
	
	//	advance settings (optional)
	if ($debug==1)
	{
		define('DEBUG',true);									//	Default is false;		
	}
	else 
	{
		define('DEBUG',false);									//	Default is false;
	}
	
	define("MIN_SCREEN_SIZE",$min_screen_size);					//	Screens with a size smaller than the 'Minimal screen download size' are not downloaded, the size is in bytes.

	define('L_FILE','download/pbsvss.htm');						//	Local File to save remote data to. Only change this if you know what you are doing
	define('L_FILE_TEMP','download/pbsvss_temp.htm'); 			//	Local file to temporary save remote data to. Only change this if you know what you are doing
	define('R_FILE','pbsvss.htm');								//	Remote file, only change this if you know what you are doing
	define('weblogs_dir',$weblog_dir);							//	directory where the log files are stored

}
else
{
	die('Acces denied!');
}


?>