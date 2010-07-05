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

function template_header()
{
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="description" content="See captured punkbuster screenshots online with PBsViewer. Those screens are captured on gameserver of <?echo CLAN_NAME.' which runs '.CLAN_GAME;?>">
<meta name="keywords" content="pb, view, viewer, punkbuster, php, parser, screens, capture, gaming, <?echo CLAN_NAME.', '.CLAN_TAG.', '.CLAN_GAME;?>">
<meta name="robot" content="index,follow">
<meta name="copyright" content="Copyright &copy; 2009 B.S. Rijnders aka BandAhr. All rights reserved">
<meta name="author" content="B.S. Rijnders">
<meta name="revisit-after" content="7">
<title><?echo 'PBsViewer of '.CLAN_TAG.' capturing screens of '.CLAN_GAME;?></title>

<link href="style/style.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="style/img/favicon.ico"> 
</head>

<body onload="document.search_form.input.focus(); document.search_form.input.select();">
<a name="start"></a>
	<?

	
	
//	first check if install map is gone
if(!check_install_del()) template_install_del();
	
	if(check_version())
	{
		?>
		
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_new_version">
  <tr>
    <td align="center"><strong>There is a new version available, check <a href="www.beesar.com" target="_blank"><em>www.beesar.com</em></a> for more info! </strong></td>
  </tr>
</table>
<br>
		<?
	}
	
template_logo_header();
}

// new since version 2.0.0.0
function template_logo_header()
{
	?>
	
		<table width="100%" border="0" align="center">
  <tr>
    <td align="center"><a href="http://www.beesar.com/work/php/pbsviewer/" target="_blank"><img src="style/img/header.png" alt="free php script" width="400" height="100" border="0"></a></td>
  </tr>
</table>
<br>
	
	<?
}

//	new header added since version 1.1.2.1
function template_header_detailed_page()
{
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="description" content="See captured punkbuster screenshots online with PBsViewer. Those screens are captured on gameserver of <?echo CLAN_NAME.' which runs '.CLAN_GAME;?>">
<meta name="keywords" content="pb, view, viewer, punkbuster, php, parser, screens, capture, gaming, <?echo CLAN_NAME.', '.CLAN_TAG.', '.CLAN_GAME;?>">
<meta name="robot" content="index,follow">
<meta name="copyright" content="Copyright &copy; 2009 B.S. Rijnders aka BandAhr. All rights reserved">
<meta name="author" content="B.S. Rijnders">
<meta name="revisit-after" content="7">
<title><?echo 'PBsViewer of '.CLAN_TAG.' capturing screens of '.CLAN_GAME;?></title>

<link href="style/style.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="style/img/favicon.ico"> 
</head>

<body>
<a name="start"></a>
	
	<?
	
//	first check if install map is gone
if(!check_install_del()) template_install_del();
	
	if(check_version())
	{
		?>
		
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_new_version">
  <tr>
    <td align="center"><strong>There is a new version available, check <a href="www.beesar.com" target="_blank"><em>www.beesar.com</em></a> for more info! </strong></td>
  </tr>
</table>
<br>
		
		<?
	}

	?>
	
	<table width="100%" border="0" align="center">
  <tr>
    <td align="center"><a href="http://www.beesar.com/work/php/pbsviewer/" target="_blank"><img src="style/img/header.png" alt="free php script" width="400" height="100" border="0"></a></td>
  </tr>
</table>
<br>
	
	<?
}

//	templated appears when map install does exist
function template_install_del()
{
	?>
	
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class=".bg_install_del_warning">
  <tr>
    <td align="center"><span class="txt_warning"><strong>Please delete '<em> install </em>' directory to avoid security problems!</strong></span></td>
  </tr>
</table>
<br>
	
	<?
}

function template_admin_tools($admin_ip)
{
	if(is_admin($admin_ip))
	{
	?>
	
<?if(get_request_status()==1)
{?>
                                <table width="100%" border="0" class="header_menu_bg_admin">
                                  <tr>
                                    <td width="20%"><span class="txt_light"><strong>New message:</strong></span></td>
                                    <td><span class="txt_admin_message"><strong>An user has requested an update, you can update by clicking on update below</strong></span></td>
                                  </tr>
                                </table>
<?}?>                                
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="header_menu_bg_admin" align="center">
                                  
                                <tr>
                                    <td width="20%" align="left"><br><span class="txt_light"><strong>Admin:</strong></span></td>
                                  <td align="left"><br><input type="submit" name="Update" id="Update" value="Update" class="buttons" onmouseover="this.className='buttons_hover'" onmouseout="this.className='buttons'">
                                  <? if (RESET){?>
                                  &nbsp;
                                  
                                    <input type="submit" name="reset" id="reset" value="Reset" class="buttons" onmouseover="this.className='buttons_hover'" onmouseout="this.className='buttons'">
                                  
                                  <?}?>
                                  &nbsp;
                                  <input type="submit" name="ACP" id="ACP" value="ACP" class="buttons" onmouseover="this.className='buttons_hover'" onmouseout="this.className='buttons'">
                                  </td>
                                  </tr>
                                  
</table>
	
	<?
	}	
}

function template_search($admin_ip,$current_scrn_nr)
{
	?>
	    
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="bg_main_table">
  <tr>
    <td>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" class="header_main_bg"><form action="" method="get" name="search_form">
                 <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center" class="header_menu_bg"><span class="txt_light">for wildcard use *</span></td>
            </tr>
          </table>
                 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="header_menu_bg">
            <tr>
              <td width="20%" align="center"><select name="sID" id="sID" class="option_search_bg">
                <option value="filename">filename</option>  
                <option value="name" selected>name</option>
                <option value="guid">guid</option>
                </select>              </td>
              <td width="50%" align="center"><input name="input" type="text" id="input" value="" onclick="this.focus();" size="70" class= "search_field_bg" onmouseover="this.className='search_field_hover';" onmouseout="this.className='search_field_bg';"></td>
                <td width="10%" align="left">&nbsp;<input type="submit" name="search" id="search" value="Search" class="buttons" onmouseover="this.className='buttons_hover'" onmouseout="this.className='buttons'"></td>
                <td align="left"><input type="submit" name="show_all" id="show_all" value="Show all" class="buttons" onmouseover="this.className='buttons_hover'" onmouseout="this.className='buttons'"></td>
                <td align="left"> 
                </td>
              </tr>
            <tr>
              <td width="20%" align="center">&nbsp;</td>
              <td width="50%" align="center"><select name="year" id="year">
                <option value="all_years">all years</option>
                <?
                $dates	=	get_dates();
                foreach ($dates[0] as $year)
                {
                	echo "<option value=".$year.">".$year."</option>";
                }
                ?>
              </select>
                -
                <select name="month" id="month">
                  <option value="all_months" selected>all months</option>
                  <?
                  foreach ($dates[1] as $month)
                  {
                  	//	seperate the month names and numbers
                  	$month_data	=	explode(',',$month);
                  	
                  	echo "<option value=".$month_data[1].">".$month_data[0]."</option>";
                  }
                  ?>
                </select>
                -
                <select name="day" id="day">
                  <option value="all_days">all days</option>
                  <?
                  foreach ($dates[2] as $day)
                  {
                  	echo "<option value=".$day.">".$day."</option>";
                  }
                  ?>
                </select>
                -
                <select name="hour" id="hour">
                  <option value="all_hours">all hours</option>
                  <?
                  foreach ($dates[3] as $hour)
                  {
                  	echo "<option value=".$hour.">".$hour."</option>";
                  }
                  ?>                  
                </select></td>
              <td width="10%" align="left">&nbsp;<input type="submit" name="select" id="select" value="Select" class="buttons" onmouseover="this.className='buttons_hover'" onmouseout="this.className='buttons'"></td>
              <td align="left"><input type="submit" name="show_available" id="show_available" value="Show available all" class="buttons" onmouseover="this.className='buttons_hover'" onmouseout="this.className='buttons'"></td>
              <td align="left">&nbsp;</td>
            </tr>
            </table>
       <br>
       <?template_info_screens($current_scrn_nr);?>
       <br>       
	             <?template_admin_tools($admin_ip);?>
          </form>        </td>
      </tr>
    </table>
    
	<?
}

//	info about the gathered screens
//	this template is new since 1.2.2.1
function template_info_screens($current_scrn_nr)
{
	?>
	
<table width="100%" border="0" align="center" class="header_info_screen_bg">
  <tr>
    <td class="header_info_screen_row1"><span class="txt_light"><strong>Unique players:</strong></span></td>
    <td class="header_info_screen_row1"><span class="txt_light"><?echo get_nr_unique_players();?></span></td>
    <td class="header_info_screen_row1"><span class="txt_light"><strong>Total complete screens:</strong></span></td>
    <td class="header_info_screen_row1"><span class="txt_light"><?echo get_nr_complete_screens();?></span></td>
  </tr>
  <tr>
    <td width="25%" class="header_info_screen_row2"><span class="txt_light"><strong>Player with most pb screens:</strong></span></td>
    <td width="25%" class="header_info_screen_row2"><span class="txt_light"><?
    
    $guid	=	get_player_most_complete_screens();
    $name	=	get_player_name_by_guid($guid);
    echo "<a href='?sID=guid&amp;input=".$guid."&amp;search=Search&amp;year=all_years&amp;month=all_months&amp;day=all_days&amp;hour=all_hours' target='_self'>".$name."</a>";
    
    ?></span></td>
    <td width="25%" class="header_info_screen_row2"><span class="txt_light"><strong>Total incomplete screens:</strong></span></td>
    <td width="25%" class="header_info_screen_row2"><span class="txt_light"><?echo get_nr_incomplete_screens();?></span></td>
  </tr>
  <tr>
    <td class="header_info_screen_row1"><span class="txt_light"><strong>Player with most incomplete screens:</strong></span></td>
    <td class="header_info_screen_row1"><span class="txt_light"><?
    
    $guid	=	get_player_most_incomplete_screens();
    $name	=	get_player_name_by_guid($guid);
    echo "<a href='?sID=guid&amp;input=".$guid."&amp;search=Search&amp;year=all_years&amp;month=all_months&amp;day=all_days&amp;hour=all_hours' target='_self'>".$name."</a>";
    
    ?></span></td>
    <td class="header_info_screen_row1"><span class="txt_light"><strong>Screens shown in current window:</strong></span></td>
    <td class="header_info_screen_row1"><span class="txt_light"><?echo $current_scrn_nr;?></span></td>
  </tr>
</table>

	
	
	<?
}


//	this template is new since 1.1.2.1
//	It is used to show detailed screen information
function template_detailed_screen($fid)
{
	$guidlength=guidlength;
	$guidlength_short=guidlength_short;
	
	//	this is needed to make automatic class(css) altering of rows
	$row_nr		=	1;		//	odd nr get different class then even nr
	
	if($data	=	get_detailed_screen_info($fid))
	{

		$name	=	$data[0];
		$guid	=	$data[1];
		$date	=	$data[2];

	//	get aliases of player
	$alias	=	get_alias($guid,addslashes($name));
		
	?>
	
	
<table width="90%" border="0" align="center">
  <tr>
    <td align="center" valign="top" class="body_bg_detailed_screen"><img src="<?echo 'download/'.$fid.'.png';?>" alt="<?echo $fid.'png';?>"></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" align="center">
      <tr>
        <td width="15%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><strong>File:</strong></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?echo $fid.'.png';?></td>
      </tr>
      <tr>
        <td width="15%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><strong>Player:</strong></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?echo $name;?></td>
      </tr>
      <tr>
        <td width="15%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><strong>CB link:</strong></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?echo "<a href=\"http://clanbase.ggl.com/personlist.php?guidid=".CBGAMEID."&amp;guidvalue=".substr($guid,$guidlength-8)."\" target=\"_blank\">".$name."</a>";?></td>
      </tr>
      <?
	
      if($alias)
      {
      	
      ?>
      <tr>
        <td width="15%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><strong>Aliases:</strong></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">
        <?

        echo "<p>This player has ".count($alias)." other names:</p>";
        
        echo "<ul>";
        foreach ($alias	as $name)
        {
        	 echo "<li>".$name."</li>";
        }
        echo "</ul>
             </td>
      </tr>";
 
      }
      ?>
      <tr>
        <td width="15%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><strong>Taken:</strong></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><?echo $date;?></td>
      </tr>
      <tr>
        <td width="15%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><strong>GUID:</strong></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><label>
          <input type="text" name="GUID" id="GUID" size="100" value="<?echo $guid;?>" onclick="this.select();">
        </label></td>
      </tr>
      <tr>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><strong>GUID_short:</strong></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><label>
          <input type="text" name="GUID_short" id="GUID_short" size="100" value="<?echo substr($guid,$guidlength-8);?>" onclick="this.select();">
        </label></td>
      </tr>
      <?
      
      			$md5_valid	=	false;
				$logged		=	false;
				
				//	get info from log data
				if($log_data	=	get_extra_log_data($fid))
				{
					$logged		=	true;
					$md5_screen	=	$log_data[0];
					$ip_player	=	$log_data[1];
					
					if($md5_screen==get_md5("download/".$fid.".png")) $md5_valid=true;
				}
				
				if($logged)
				{
					if($md5_valid)
					{
						
						?>
						
											      <tr>
        <td width="15%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><strong>IP player:</strong></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><label>
          <input type="text" name="IP" id="IP" size="100" value="<?echo $ip_player;?>" onclick="this.select();">
        </label></td>
      </tr>
						
											      <tr>
        <td width="15%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><strong><span class="md5_valid">MD5 hash (VALID):</span></strong></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><label>
          <input type="text" name="MD5" id="MD5" size="100" value="<?echo get_md5('download/'.$fid.'.png')?>" onclick="this.select();">
        </label></td>
      </tr>
						
						<?
						
					}
					//	mismatch!
					else 
					{
					?>
																      <tr>
        <td width="15%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><strong>IP player:</strong></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><label>
          <input type="text" name="IP" id="IP" size="100" value="<?echo $ip_player;?>" onclick="this.select();">
        </label></td>
      </tr>
					
					      <tr>
        <td width="15%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><strong><span class="md5_mismatch">MD5 hash mismatch!</span></strong></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>">
        </td>
      </tr>
					
					
					      <tr>
        <td width="15%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><strong>MD5 hash screen:</strong></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><label>
          <input type="text" name="MD5" id="MD5" size="100" value="<?echo get_md5('download/'.$fid.'.png')?>" onclick="this.select();">
        </label></td>
      </tr>
      
            <tr>
        <td width="15%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><strong>MD5 hash log:</strong></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><label>
          <input type="text" name="MD5" id="MD5" size="100" value="<?echo $md5_screen;?>" onclick="this.select();">
        </label></td>
      </tr>
					
					<?
							
						
					}
				}
				else 
				{
					//	show without extra info
					?>
					
					      <tr>
        <td width="15%" align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';}?>"><strong>MD5 hash:</strong></td>
        <td align="left" class="<?if($row_nr %2 == 0) {echo 'first_row_detailed_screen';}else{echo'second_row_detailed_screen';} $row_nr++;?>"><label>
          <input type="text" name="MD5" id="MD5" size="100" value="<?echo get_md5('download/'.$fid.'.png')?>" onclick="this.select();">
        </label></td>
      </tr>
					<?
				}
      
      ?>

    </table>
      <table width="100%" border="0">
        <tr>
        <td align="center" class="bg_detailed_screen_back_table"><a href="./" title="Go back" target="_self">Go back</a></td>
        </tr>
    </table></td>
  </tr>
  </table>

<br>
<table width="80%" border="0" align="center">
  <tr>
    <td align="center" class="footer_main_bg_2"><span class="txt_light"><?template_copyright();?></span></td>
  </tr>
</table>


	<?
	}
	//	show error msg if screen does not exist
	else 
	{

	template_detailed_screen_error('Screen does not exist','Can\'t find information about screen','Try to use another filename(=fid)');	
		
	}
	
	
}

//	new template function since 1.1.2.1
function template_detailed_screen_error($error,$result,$hint)
{
	?>
		
		
		<table width="90%" border="0" align="center">
  <tr>
    <td align="center" valign="top" class="body_bg_detailed_screen">	<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="header_error_bg">
  <tr>
    
    <td align="center"><span class="txt_light">::</span> <span class="header_error_txt"> Error: <?echo $error;?></span> <span class="txt_light">::</span></td>

  </tr>
  <tr>
    <td colspan="3" class="body_error_bg"><?echo $result.'<br>'.$hint;?></td>
  </tr>
</table></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0">
        <tr>
        <td align="center" class="bg_detailed_screen_back_table"><a href="./" title="Go back" target="_self">Go back</a></td>
        </tr>
    </table></td>
  </tr>
  </table>

<br>
<table width="80%" border="0" align="center">
  <tr>
    <td align="center" class="footer_main_bg_2"><span class="txt_light"><?template_copyright();?></span></td>
  </tr>
</table>
		
	 
	<?
}

//	new template added since version 1.2.2.1
//	this one is used on main page
function template_show_main($nr,$admin_ip,$current_scrn_nr=nr_screens_main)
{

	template_search($admin_ip,$current_scrn_nr);
?>
	      <table width="100%" border="0" cellspacing="10" cellpadding="0" align="center">
	       
<?
show_main_screens($nr);
echo "</table>";

}

function template_show_all($nr,$admin_ip,$current_scrn_nr=nr_screens_main)
{

	template_search($admin_ip,$current_scrn_nr);
?>
	      <table width="100%" border="0" cellspacing="10" cellpadding="0" align="center">
	       
<?
show_all_screens($nr);
echo "</table>";

}

// this template is new since 1.2.2.3
// only show available screens
function template_show_available($nr,$admin_ip,$current_scrn_nr=nr_screens_main)
{

	template_search($admin_ip,$current_scrn_nr);
?>
	      <table width="100%" border="0" cellspacing="10" cellpadding="0" align="center">
	       
<?
// show all available screens by setting 2nd parameter to true
show_all_screens($nr,true);
echo "</table>";

}

//	this template is new since 1.2.2.1
function template_show_date_selection($nr,$admin_ip,$data,$current_scrn_nr)
{

	template_search($admin_ip,$current_scrn_nr);
?>
	      <table width="100%" border="0" cellspacing="10" cellpadding="0" align="center">
	       
<?
show_date_selection($nr,$data);
echo "</table>";

}

function template_show_fid($nr,$fileName,$admin_ip,$current_scrn_nr)
{
	template_search($admin_ip,$current_scrn_nr);

		?>
	      <table width="100%" border="0" cellspacing="10" cellpadding="0">
<?

show_fid_screens($nr,$fileName);
echo "</table>";
}

function template_show_guid($nr,$guid,$admin_ip,$current_scrn_nr)
{
	template_search($admin_ip,$current_scrn_nr);

		?>
	      <table width="100%" border="0" cellspacing="10" cellpadding="0">
<?

show_guid_screens($nr,$guid);
echo "</table>";
}


function template_show_name($nr,$name,$admin_ip,$current_scrn_nr)
{
	template_search($admin_ip,$current_scrn_nr);

		?>
	      <table width="100%" border="0" cellspacing="10" cellpadding="0">
<?

show_name_screens($nr,$name);
echo "</table>";
}

//	please don't remove this, thank you.
function template_copyright()
{
	$nfo_data	=	file('http://beesar.com/pbss_parser/nfo');
	$version	=	file('VERSION');
	if($nfo_data[1]!='')
	{
		echo $nfo_data[1].'<br>';
		echo 'V '.$version[0].' ';
		echo 'Powered by <a href="http://www.beesar.com/work/php/pbsviewer/" target="_blank">PBSViewer</a>';
	}
	else
	{
		echo 'Copyright &copy; '.date('Y').', BandAhr, <a href="http://www.beesar.com" target="_blank">www.beesar.com</a><br>';
		echo 'V '.$version[0].' ';
		echo 'Powered by <a href="http://www.beesar.com/work/php/pbsviewer/" target="_blank">PBSViewer</a>';
	}

}

function template_error_msg($error,$result,$hint='')
{

	?>
	 
                 <tr>
                  <td>
	<br>
	<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="header_error_bg">
  <tr>
    
    <td align="center"><span class="txt_light">::</span> <span class="header_error_txt"> Error: <?echo $error;?></span> <span class="txt_light">::</span></td>

  </tr>
  <tr>
    <td colspan="3" class="body_error_bg"><?echo $result.'<br>'.$hint;?></td>
  </tr>
</table>
	<br>
	</td>
                </tr>
	<?
	
}

//	new since version 1.2.2.1
//	is used to for request update for example
function template_custom_msg($title, $msg)
{
	?>
	
	
		<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="header_msg_bg">
  <tr>
    
    <td align="center"><span class="txt_light">::</span> <span class="header_msg_txt"><?echo $title;?></span> <span class="txt_light">::</span></td>

  </tr>
  <tr>
    <td colspan="3" class="body_msg_bg"><?echo $msg;?></td>
  </tr>
</table>

	</body>
</html>
	
	<?
	
}

//	new template since version 1.2.2.1
//	this will give a request button on page
function template_request()
{
?>

<form action="" method="get">                <?
                if(get_request_status()==0)
                {
                	?>
                	<label><input type="submit" name="request_update" id="request_update" value="Request update" class="req_button" onmouseover="this.className='buttons_hover'" onmouseout="this.className='req_button'">
                </label>
                	<?
                	
                }
                ?></form>

<?
}

function template_footer($update_time,$lastUpdate,$startTime)
{
	?>
	<div align="center"><a href="#start" target="_self"><strong>^^^ go up ^^^</strong></a>
</div>
    <br></td>
  </tr>
  <tr>
    <td align="center" class="footer_main_bg_1">
    <br>
    <?template_request();?>
    <br>
      <table width="40%" border="0" cellpadding="0" cellspacing="0" class="footer_main_bg_1_row_1">
        <tr>
          <td align="center"><?echo 'Page generated in '.get_loadTime($startTime,4).' seconds';?></td>
        </tr>
      </table>
      <table width="40%" border="0" cellpadding="0" cellspacing="0" class="footer_main_bg_1_row_2">
        <tr>
          <td align="center" class="bg_main_table"><? update_info($update_time,$lastUpdate);?></td>
        </tr>
      </table>
      
        <p>
    <a href="http://validator.w3.org/check?uri=referer" target="_blank"><img
        src="style/img/valid-html401-blue.png"
        alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a>
      <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank"><img src="style/img/gplv3-88x31.png" alt="Small GPLv3 logo" width="88" height="31" border="0"></a>
      <a href="https://code.google.com/p/pbsviewer/" target="_blank"><img
        src="style/img/google_code_project_hosting.gif"
        alt="Google Code project hosting" height="34" width="34" border="0"></a>
      
      
      </p>
  
      
        <br>
    </td>
    </tr>
  <tr>
    <td align="center" class="footer_main_bg_2"><span class="txt_light"><?template_copyright();?></span></td>
    </tr>
</table>
 
</body>
</html>
	
	<?

}

//	new footer added since version 1.1.2.1
function template_footer_detailed_page()
{
	?>
	
	</body>
</html>
	
	<?
}

?>