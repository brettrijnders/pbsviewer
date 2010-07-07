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
//	prepare unique key
$key	=	$_SERVER['SERVER_SIGNATURE'].' '.php_uname();
$key=md5($key);

require_once('inc/config.inc.php');
require_once('inc/functions.inc.php');

//	connect to DB
connect_DB();
require_once('inc/init.inc.php');

// load correct language file
	$available	=	false;
	$lang_file	=	get_current_lang().".inc.php";
		
	// check if this file is available
	if ($available_files = get_langs())
	{
		foreach ($available_files as $file)
		{
			if($lang_file==$file.'.inc.php')
			{
				$available	=	true;
			}
		}
	}

	if ($available==true)
	{
		include("inc/languages/".$lang_file);
	}
	else 
	{
		// include default language
		include("inc/languages/English.inc.php");
	}
	
	

require_once('inc/templates.inc.php');

//	maximum script load time
ini_set('max_execution_time',script_load_time);

//	get time wrt to Unix
$startTime	=	get_microtime();


if(DEBUG==false)
{
	// turn of errors:
	error_reporting(0);
}



//	this is new in version 1.1.2.1
//	it will show a detailed screen info on a seperate page
	if(isset($_GET['fid']))
	{
		//	get file ids aka fids
		$fids	=	get_fids();
		$fid_valid	=	false;
		
		if($fids)
		{
			//	create a unique page for each fid, so for each screen
			//	go find if screen is availabe
			foreach ($fids	as $id)	
			{
				if($_GET['fid']==$id)
				{
					$fid_valid	=true;
				}	
			}
			
			if($fid_valid==true)
			{
			
					template_header_detailed_page();
					template_detailed_screen($_GET['fid']);
					template_footer_detailed_page();
			}
			else 
			//	if fid is not in fids
			{
				template_header_detailed_page();
				template_detailed_screen_error('Screen does not exist','Can\'t find information about screen','Try to use another filename(=fid)');	
				template_footer_detailed_page();
			}
			
			
			
		}
		else 
		{
			template_header_detailed_page();
			template_detailed_screen_error('Screens are not downloaded yet','Can\'t find any screen in database','Ask admin for an update to download new screens');
			template_footer_detailed_page();
		}
		
	}
	else 
	{

if(CUSTOM_UPDATE!=true)
{
//	check if update time elapsed?
//	if update_time has passed then update.
//	This is used to reduce the download bandwith
$fileLastUpdate	=	'lastUpdate.txt';
$lastUpdate		=	update_check($fileLastUpdate);


if(time()>$lastUpdate+UPDATE_TIME)
{	
	update_file(FTP_HOST,FTP_PORT,FTP_USER,FTP_PASS,PBDIR.'/svss',L_FILE_TEMP,$fileLastUpdate,pb_sv_SsCeiling,DEBUG);
}


//	FIX: for getting correct time info about update status in footer, if this is not used old information will be used from '$lastUpdate' after update
//	get time when last update took place, this info can be put into footer.
$lastUpdateTime	=	update_check($fileLastUpdate);
}

template_header();

	if(isset($_GET['search']))
	{
		//	security against sql injection
		$input	=	addslashes($_GET['input']);
		
		if($_GET['sID']=='filename')
		{
			template_show_fid(NR,$input,$admin_ip,1);
			template_footer(UPDATE_TIME,$lastUpdateTime,$startTime);
			
		}
		else if($_GET['sID']=='name')
		{
			template_show_name(NR,$input,$admin_ip,get_nr_screens_by_name($input));
			template_footer(UPDATE_TIME,$lastUpdateTime,$startTime);
		}
		else if($_GET['sID']=='guid') 
		{
			template_show_guid(NR,$input,$admin_ip,get_nr_screens_by_guid($input));
			template_footer(UPDATE_TIME,$lastUpdateTime,$startTime);
		}
		else 
		{
			template_show_all(NR,$admin_ip,get_total_nr_screens());
			template_footer(UPDATE_TIME,$lastUpdateTime,$startTime);
		}
		
	}
	elseif (isset($_GET['show_all']))
	{
		template_show_all(NR,$admin_ip,get_total_nr_screens());
		template_footer(UPDATE_TIME,$lastUpdateTime,$startTime);
	}
	elseif (isset($_GET['show_available']))
	{
		template_show_available(NR,$admin_ip,get_total_nr_screens());
		template_footer(UPDATE_TIME,$lastUpdateTime,$startTime);
	}
	//	this select option is new since 1.2.2.1
	elseif (isset($_GET['select']))
	{
		//	as default it will select all
		$year	=	"%";
		$month	=	"%";
		$day	=	"__";
		$hour	=	"__";
		
		if(isset($_GET['year'])) $year=$_GET['year'];
		if(isset($_GET['month'])) $month=$_GET['month'];
		if(isset($_GET['day']) && $_GET['day']<=9)
		{
			$day='0'.$_GET['day'];
		}
		else 
		{
			$day=$_GET['day'];
		}
		if(isset($_GET['hour'])) $hour=$_GET['hour'];
		
		//	if all is selected
		if(isset($_GET['year']) && $_GET['year']=='all_years') $year="%";
		if(isset($_GET['month']) && $_GET['month']=='all_months') $month="%";
		if(isset($_GET['day']) && $_GET['day']=='all_days') $day="__";
		if(isset($_GET['hour']) && $_GET['hour']=='all_hours') $hour="__";
		
		//	put dates in array
		$data	=	array($year,$month,$day,$hour);
		
		template_show_date_selection(NR,$admin_ip,$data,get_nr_screens_by_date($data));
		template_footer(UPDATE_TIME,$lastUpdateTime,$startTime);
		
	}
	//	since version 1.2.2.1 people can make a request for an update
	elseif (isset($_GET['request_update']))
	{
		if(get_request_status()==0)
		{
			//	let the admin notify of an users request
			set_request();
			template_custom_msg('Admin has been notified','Thank you for requesting an update. A private message was sent to an admin<br>You will be redirected in a couple of seconds');
			echo "<meta http-equiv='refresh' content='5;URL=./' />";
		}
		else 
		{
			template_custom_msg('Request for an update has failed','Someone else has already requested an update<br>You will be redirected in a couple of seconds');
			echo "<meta http-equiv='refresh' content='5;URL=./' />";			
		}
		
		
	}
	elseif (isset($_GET['Update']) && is_admin($admin_ip))
	{
		echo "<meta http-equiv='refresh' content='0;URL=update.php' />";
	}
	elseif (isset($_GET['reset']) && is_admin($admin_ip))
	{
		echo "<meta http-equiv='refresh' content='0;URL=reset.php' />";
	}	
	elseif (isset($_GET['ACP']) && is_admin($admin_ip))
	{
		echo "<meta http-equiv='refresh' content='0;URL=ACP.php' />";
	}
	else 
	{
		//	show all pics with 4 pics per row
		//	templated on main page has changed since v 1.2.2.1
		//	now it only will show x latest screens. Number of screens can be configured in config
		template_show_main(NR,$admin_ip);
		template_footer(UPDATE_TIME,$lastUpdateTime,$startTime);
	}

}
?>