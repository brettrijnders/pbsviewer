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
require_once('inc/init.inc.php');
require_once('inc/functions.inc.php');
require_once('inc/templates.inc.php');



//load correct language
include("inc/load_language.inc.php");

if (is_admin()==true)
{
	header("LOCATION: ./");
}
else 
{
	if(isset($_GET['reset']))
	{
		if($_GET['reset']==1)
		{
			//	open reset page
			if(isset($_POST['submit']))
			{
				if($_POST['mail_reset']!='')
				{
					if (is_valid_admin_mail($_POST['mail_reset']))
					{
						$to			= $_POST['mail_reset'];
						$subj		= "PBSViewer: Reset password";
						$msg 		= "Hi ".get_username_by_mail($_POST['mail_reset']).",\n\n";
						$msg 		.=	"You have requested a reset for your password.\n";
						$msg		.=	"Click on the following link below to reset your password:\n";
						
						$special_link	=	create_Ukey_pass_reset($_POST['mail_reset']);
						
						$msg     	.=	$_SERVER["SERVER_NAME"].dirname($_SERVER['PHP_SELF'])."/login.php?reset=".$special_link."\n\n";
						$msg  		.=	"By clicking on this link a new password will be created for you.";
						$msg		.=	"It is recommended to change this new password in your ACP once you are logged in again.\n";
						$msg 		.= "\n";
						$msg 		.= "In case you did not request a password reset, just ignore this mail. Password reset was requested by user with ip: ".$_SERVER['REMOTE_ADDR']."\n";
						$msg 		.= "\n";
						$msg 		.= "---------------------------------";
						$msg 		.= "\n\nThis message was generated automatically, please do not reply to this mail";
						
						//	send mail
						$headers 	= 'From: PBSViewer@'.substr($_SERVER['SERVER_NAME'],4).' ' . "\r\n" .
    					'Reply-To: PBSViewer@'.substr($_SERVER['SERVER_NAME'],4).' ' . "\r\n" .
				    	'X-Mailer: PHP/' . phpversion();
						
						template_reset_correct_mail($_POST['mail_reset']);
						
						mail($to,$subj,$msg,$headers);
					}
					else 
					{
						template_reset_invalid_mail();
					}
				}
				else 
				{
					template_reset_invalid_mail();
				}
			}
			else 
			{
				template_reset_password();
			}
		}
		else 
		{		
			if(is_password_resetter($_GET['reset'])==true)
			{
				//	is user who requested to reset password, so lets do that
				$password	=	generate_new_pass($_GET['reset']);
				$user		=	get_name_user($_GET['reset']);
								
				template_reset_password_succesfully($user,$password);
				
				//	Make field 'ResetCode' empty. This prevents that user can refresh page and create a new password.
				empty_ResetCode($_GET['reset']);
				
			}
			else 
			{
				template_login();
			}
		}	
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
	
}
?>