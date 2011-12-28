<?php
/*
    This program 'PBSViewer' also known as Punkbuster Screenshot Viewer, 
    will download pb screens. Those downloaded screens are published on
    your website.
    
    Copyright (C) 2011  B.S. Rijnders aka BandAhr

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
$key	=	$_SERVER['SERVER_SIGNATURE'].' '.php_uname();
$key=md5($key);

if (!file_exists("../inc/config.inc.php"))	die("Please first read the <a href=\"http://www.beesar.com/download/PBSViewer/readme.html\" target=\"_blank\">readme.html</a> file to install PBSViewer");

require_once('../inc/config.inc.php');

//	old and new versions
$version_old = "2.2.0.4";
$version_new = "2.3.0.0";

//	connect with db
connect_DB();


if(isset($_POST['update_db']))
{	
	if(needs_update($version_new)==true)
	{
		do_update($version_new);
		template_final();	
	}
	else 
	{
		template_already_updated();
	}
}
else 
{
	template_install_DB($version_old,$version_new);
}

//	update procedure
function do_update($version_new)
{

	if(mysql_num_rows(mysql_query("SELECT `name`,`value` FROM `settings` WHERE `name`='version'"))<1)
	{
		$sql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('version','".$version_new."');";
		mysql_query($sql_insert) or die(mysql_error());
	}
	else 
	{	
		$sql_update = "UPDATE `settings` SET `value`='".$version_new."' WHERE `name`='version'";
		mysql_query($sql_update) or die(mysql_error());
	}	
	
	if(mysql_num_rows(mysql_query("SELECT `name`,`value` FROM `settings` WHERE `name`='svss_dir'"))==0)
	{
		$sql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('svss_dir','svss');";
		mysql_query($sql_insert) or die(mysql_error());
	}
		
	if(mysql_num_rows(mysql_query("SELECT `name`,`value` FROM `settings` WHERE `name`='svlogs_dir'"))==0)
	{	
		$sql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('svlogs_dir','svlogs');";
		mysql_query($sql_insert) or die(mysql_error());
	}

	if(mysql_num_rows(mysql_query("SELECT `name`,`value` FROM `settings` WHERE `name`='auto_del_log_gameserver'"))==0)
	{	
		$sql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('auto_del_log_gameserver','0');";
		mysql_query($sql_insert) or die(mysql_error());
	}

	if(mysql_num_rows(mysql_query("SELECT `name`,`value` FROM `settings` WHERE `name`='incremental_update'"))==0)
	{	
		$sql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('incremental_update','0');";
		mysql_query($sql_insert) or die(mysql_error());
	}
	
	if(mysql_num_rows(mysql_query("SELECT `name`,`value` FROM `settings` WHERE `name`='iu_nr_screens'"))==0)
	{	
		$sql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('iu_nr_screens','20');";
		mysql_query($sql_insert) or die(mysql_error());
	}

	if(mysql_num_rows(mysql_query("SELECT `name`,`value` FROM `settings` WHERE `name`='iu_nr_logs'"))==0)
	{	
		$sql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('iu_nr_logs','2');";
		mysql_query($sql_insert) or die(mysql_error());
	}
	
	if(mysql_num_rows(mysql_query("SELECT `name`,`value` FROM `settings` WHERE `name`='iu_update_time'"))==0)
	{	
		$sql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('iu_update_time','30');";
		mysql_query($sql_insert) or die(mysql_error());
	}
	
	if(mysql_num_rows(mysql_query("SELECT `name`,`value` FROM `settings` WHERE `name`='iu_wait_time'"))==0)
	{	
		$sql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('iu_wait_time','3');";
		mysql_query($sql_insert) or die(mysql_error());
	}
	
	if(mysql_num_rows(mysql_query("SELECT `name`,`value` FROM `settings` WHERE `name`='theme'"))==0)
	{	
		$sql_insert = "INSERT INTO `settings` (`name`,`value`) VALUES ('theme','default');";
		mysql_query($sql_insert) or die(mysql_error());
	}
	
	if(!table_exists('dfiles'))
	{
		$sql_create = "CREATE TABLE `dfiles`
(
`id` INT(8) NOT NULL AUTO_INCREMENT,
`file` TEXT NOT NULL,
`type` INT(1),
PRIMARY KEY(`id`)
);";
		
		mysql_query($sql_create);
	}

}

function table_exists ($table) 
{
	$sql = mysql_query("SHOW TABLES LIKE \"".$table."\"");
	if (mysql_num_rows($sql)>0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

//	check if pbsviewer is being updated or not
function needs_update($version_new)
{
	$version_current = get_current_version();
	
	if($version_current!=0)
	{		
		if($version_current==$version_new)
		{
			//	pbsviewer does not need an update
			return false;
		}
		else 
		{
			return true;
		}
	}
	//	`name`='version' does not exist
	else 
	{
		return true;
	}
}

function get_current_version()
{
	$version_current = 0;
	
	$sql_select = "SELECT `name`,`value` FROM `settings` WHERE `name`='version'";
	$sql = mysql_query($sql_select);
	if(mysql_num_rows($sql)==1)
	{
		while($result = mysql_fetch_object($sql))
		{
			$version_current = $result->value; 
		}
	}
	
	return $version_current;
}

function connect_DB()
{	
	$connect	=	mysql_connect(DB_HOST,DB_USER,DB_PASS);
	mysql_select_db(DB_NAME,$connect) or die('Cannot connect to db');

}

function template_install_DB($version_old,$version_new)
{
	?>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Updating PBSViewer from version <?php echo $version_old." to ".$version_new;?></title>
<link href="install.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_table_main">
  <tr>
    <td><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center"><strong><span class="txt_light">Updating PBSViewer from version <?php echo $version_old." to ".$version_new;?></span></strong></td>
      </tr>
    </table>
    <form id="update_form_DB" name="update_form_DB" method="post" action="update.php">
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="3" align="center" class="bg_table_body"><input type="submit" name="update_db" id="update_db" value="Click here to update" /></td>
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
            <p align="left">PBSViewer has been updated correctly. However don't forget to<strong> remove your install map first!</strong><br />
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

function template_already_updated()
{
	?>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PBSViewer already updated!</title>
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
            PBSViewer already updated!</strong></p>
            <p align="left">PBSViewer has already been updated! Don't forget to<strong> remove your install map first!</strong><br />
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

?>