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
//	start session to make sure admin stays logged in
session_start();

$key=md5(($_SERVER['SERVER_SIGNATURE'].' '.php_uname()));
require_once('inc/config.inc.php');
require_once('inc/functions.inc.php');
require_once('inc/templates.inc.php');

//	connect to DB
connect_DB();
require_once('inc/init.inc.php');

//load correct language
include("inc/load_language.inc.php");

if (is_admin()==true)
{
	header("LOCATION: ./");
}
else 
{
	if (isset($_POST['login']))
	{		
		if ($_POST['name']!='' && $_POST['password']!='')
		{
			if (check_login($_POST['name'],$_POST['password']))
			{				
				template_login_success();
			}
			else 
			{
				template_login_failed();
			}
		}	
		else 
		{
			template_login_failed();
		}
	}
	else 
	{
		template_login();
	}
}
?>