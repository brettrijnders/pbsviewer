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
session_start();
$key	=	$_SERVER['SERVER_SIGNATURE'].' '.php_uname();
$key=md5($key);

if (!file_exists("inc/config.inc.php"))	die("Please first read the <a href=\"http://www.beesar.com/download/PBSViewer/readme.html\" target=\"_blank\">readme.html</a> file to install PBSViewer");

require_once('inc/config.inc.php');
require_once('inc/init.inc.php');
require_once('inc/functions.inc.php');

//load correct language
include("inc/load_language.inc.php");

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

$access = false;

//	check if admin set PBSViewer to private
if(is_private())
{
	//	If PBSViewer is private than you can only use PBSViewer 
	//	if you are admin or allowed visitor, ie you logged in with valid login details
	if(is_admin()||is_allowed_visitor())
	{
		$access=true;
	}
}
else 
{
	$access=true;
}

if($access==true)
{
//	this is new in version 1.1.2.1
//	it will show a detailed screen info on a seperate page
	if(isset($_GET['fid']))
	{
		$requestedFID	=	$_GET['fid'];		
		if (get_magic_quotes_gpc())
  		{
  			$requestedFID	=	stripslashes($requestedFID);
  		}
  		
  		$requestedFID	=	mysql_real_escape_string($requestedFID);
		
		//	get file ids aka fids
		$fids	=	get_fids();
		$fid_valid	=	false;
		
		if($fids)
		{
			//	create a unique page for each fid, so for each screen
			//	go find if screen is availabe
			foreach ($fids	as $id)	
			{
				if($requestedFID==$id)
				{
					$fid_valid	=true;
				}	
			}
			
			if($fid_valid==true)
			{
			
					template_header_detailed_page($requestedFID);
					template_detailed_screen($requestedFID);
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
	//	don't show messages about updating ($main=true)
	update_file(FTP_HOST,FTP_PORT,FTP_USER,FTP_PASS,PBDIR.'/svss',L_FILE_TEMP,$fileLastUpdate,pb_sv_SsCeiling,false,true);
}


//	FIX: for getting correct time info about update status in footer, if this is not used old information will be used from '$lastUpdate' after update
//	get time when last update took place, this info can be put into footer.
$lastUpdateTime	=	update_check($fileLastUpdate);
}

template_header();

	if(isset($_GET['search']))
	{
		//	security against sql injection
		$input	=	$_GET['input'];
		if (get_magic_quotes_gpc())
  		{
  			$input	=	stripslashes($input);	
  		}
		
		$input	=	mysql_real_escape_string($input);
		
		if($_GET['sID']=='filename')
		{
			template_show_fid(NR,$input,1);
			template_footer(UPDATE_TIME,$lastUpdateTime,$startTime);
			
		}
		else if($_GET['sID']=='name')
		{
			$nr_results	=	get_nr_screens_by_name($input);
			$input_var_get	=	(urlencode($input));
			
			if(isset($_GET['page']) && $_GET['page']>0 && is_numeric($_GET['page']))
			{				
				
				if (is_valid_page($_GET['page'],$nr_results))
				{			
					
					template_show_name(NR,$_GET['page'],$input,get_nr_screens_by_name($input));
					template_footer(UPDATE_TIME,$lastUpdateTime,$startTime,$_GET['page'],$nr_results,'sID=name&search=1&input='.$input_var_get);
				}
				else 
				{
					template_error_msg('Invalid page number','Can not find any results for this page','Try another page number please');
				}
			}
			else 
			{
				template_show_name(NR,1,$input,get_nr_screens_by_name($input));
				template_footer(UPDATE_TIME,$lastUpdateTime,$startTime,1,$nr_results,'sID=name&search=1&input='.$input_var_get);
			}
		}
		else if($_GET['sID']=='guid') 
		{
			$nr_results	=	get_nr_screens_by_guid($input);
		
			
			if(isset($_GET['page']) && $_GET['page']>0 && is_numeric($_GET['page']))
			{				
				
				if (is_valid_page($_GET['page'],$nr_results))
				{
					template_show_guid(NR,$_GET['page'],$input,get_nr_screens_by_guid($input));
					template_footer(UPDATE_TIME,$lastUpdateTime,$startTime,$_GET['page'],$nr_results,'sID=guid&search=1&input='.$input);					
				}
				else 
				{
					template_error_msg('Invalid page number','Can not find any results for this page','Try another page number please');
				}				
			}
			else 
			{
				template_show_guid(NR,1,$input,get_nr_screens_by_guid($input));
				template_footer(UPDATE_TIME,$lastUpdateTime,$startTime,1,$nr_results,'sID=guid&search=1&input='.$input);						
			}
			
		}
		else 
		{
			template_show_main(NR);
			template_footer(UPDATE_TIME,$lastUpdateTime,$startTime);
		}
		
	}
	elseif (isset($_GET['show_all']))
	{
		if(isset($_GET['page']) && $_GET['page']>0 && is_numeric($_GET['page']))
		{
			$nr_results	=	get_total_nr_screens();
			
			if (is_valid_page($_GET['page'],$nr_results))
			{
				template_show_all(NR,$_GET['page'],get_total_nr_screens());
				template_footer(UPDATE_TIME,$lastUpdateTime,$startTime,$_GET['page'],$nr_results,'show_all=1');
			}
			else 
			{
				template_error_msg('Invalid page number','Can not find any results for this page','Try another page number please');
			}
		}
		else 
		//	if page is not set, then assume page is set to 1
		{
			template_show_all(NR,1,get_total_nr_screens());
			$nr_results	=	get_total_nr_screens();
			template_footer(UPDATE_TIME,$lastUpdateTime,$startTime,1,$nr_results,'show_all=1');
		}
	}
	elseif (isset($_GET['show_available']))
	{
		if(isset($_GET['page']) && $_GET['page']>0 && is_numeric($_GET['page']))
		{
			$nr_results	=	get_nr_complete_screens();
			if (is_valid_page($_GET['page'],$nr_results))
			{			
				template_show_available(NR,$_GET['page'],get_total_nr_screens());
				template_footer(UPDATE_TIME,$lastUpdateTime,$startTime,$_GET['page'],$nr_results,'show_available=1');			
			}
			else 
			{
				template_error_msg('Invalid page number','Can not find any results for this page','Try another page number please');
					
			}
		}
		else 
		{
			template_show_available(NR,1,get_total_nr_screens());
			$nr_results	=	get_nr_complete_screens();
			template_footer(UPDATE_TIME,$lastUpdateTime,$startTime,1,$nr_results,'show_available=1');
		}
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
		
		//	added to prevent sql injection
		if (get_magic_quotes_gpc())
  		{
  			$year	=	stripslashes($year);
  			$month	=	stripslashes($month);
  			$day	=	stripslashes($day);
  			$hour	=	stripslashes($hour);	
  		}
  		
  		$year	=	mysql_real_escape_string($year);
  		$month	=	mysql_real_escape_string($month);
  		$day	=	mysql_real_escape_string($day);
  		$hour	=	mysql_real_escape_string($hour);
		
		//	put dates in array
		$data	=	array($year,$month,$day,$hour);
		
		$nr_results	=	get_nr_screens_by_date($data);
		$get_var_date	=	'select=1&year='.$_GET['year'].'&month='.$_GET['month'].'&day='.$_GET['day'].'&hour='.$_GET['hour'];
		
		if(isset($_GET['page']) && $_GET['page']>0 && is_numeric($_GET['page']))
		{				
				
			if (is_valid_page($_GET['page'],$nr_results))
			{
				template_show_date_selection(NR,$_GET['page'],$data,get_nr_screens_by_date($data));
				template_footer(UPDATE_TIME,$lastUpdateTime,$startTime,$_GET['page'],$nr_results,$get_var_date);
			}
			else 
			{
				template_error_msg('Invalid page number','Can not find any results for this page','Try another page number please');
			}
			
		}
		else 
		{
			template_show_date_selection(NR,1,$data,get_nr_screens_by_date($data));
			template_footer(UPDATE_TIME,$lastUpdateTime,$startTime,1,$nr_results,$get_var_date);			
		}
		
		
		
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
	elseif (isset($_GET['Update']) && is_admin())
	{
		echo "<meta http-equiv='refresh' content='0;URL=update.php' />";
	}
	elseif (isset($_GET['reset']) && is_admin())
	{
		echo "<meta http-equiv='refresh' content='0;URL=reset.php' />";
	}	
	elseif (isset($_GET['ACP']) && is_admin())
	{
		echo "<meta http-equiv='refresh' content='0;URL=ACP.php' />";
	}
	else 
	{
		//	show all pics with 4 pics per row
		//	templated on main page has changed since v 1.2.2.1
		//	now it only will show x latest screens. Number of screens can be configured in config
		template_show_main(NR);
		template_footer(UPDATE_TIME,$lastUpdateTime,$startTime);
	}

}
}
else 
{
	if(isset($_POST['login']))
	{
		if($_POST['password']!='')
		{
			$visPass	=	$_POST['password'];
			if (get_magic_quotes_gpc())
  			{
  				$visPass	=	stripslashes($visPass);
  			}
			
  			$visPass	=	mysql_real_escape_string($visPass);
  			
			if(check_login_visitor($visPass))
			{
				echo "<meta http-equiv='refresh' content='0;URL=./' />";
			}
			else 
			{
				template_login_visitor_failed();
			}
		}
		else 
		{
			template_login_visitor_failed();
		}
	}
	else 
	{
		template_denied_private();
	}
}

?>