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

//	check if install is deleted
function check_install_del()
{

	$install	=	false;
	//	check if dir exists
	!is_dir('install') ? $install=true: $install=false;
	return $install;

}

// new since version 2.0.0.0
// check if inc dir is chmodded to 755
function is_CHMOD_755($file='inc')
{
	$result	=	true;
	if(is_writable($file))		$result=false;

	return $result;
}

//	check if update is needed
function update_check($fileLastUpdate)
{

	$fp	=	fopen($fileLastUpdate,'r');
	if($fp)
	{
		$lastUpdate	=	fread($fp,filesize($fileLastUpdate));
		return $lastUpdate;
	}
	else
	{
		fclose($fp);
		die('Cannot read file lastUpdate');
	}

	fclose($fp);

}



//	get available pbscreens
function get_list_pbscreens ($ftp_host,$ftp_port,$ftp_user,$ftp_pass,$ssdir)
{
	//	ftp connect
	$connect	=	ftp_connect($ftp_host,$ftp_port);
	$login		=	ftp_login($connect,$ftp_user,$ftp_pass);

	if($connect && $login)
	{

		//	return array of files from ssdir
		$fileList	=	ftp_nlist($connect,$ssdir);
		$i	=	0;
		
		if (DEBUG==true)
		{
			echo date('H:i:s] ')."<li>Retreiving file list from directory: ".$ssdir."</li><br>";
		}

		//	before updating table dl_screens, first truncate old data
		$sql_del	=	"TRUNCATE TABLE `dl_screens`";
		mysql_query($sql_del);
		
		$debugCount = 0;

		foreach ($fileList as $i_nr=>$content)
		{
			//	find all the .png files
			if(eregi('.png',$content))
			{
				
				// dirty fix, for those who are running windows gameserver, windows provides backwards slashes (\) instead of forward (/)
				$content	=	str_replace("\\","/",$content);
				
				// new in version 1.2.2.3
				// if .png file is smaller than 10 kB then do not include it in download list
				// first check if ftp_size is supported by hosting
				if (ftp_size($connect,$content)!=-1)
				{
					// no errors have been occurred, so continue with using ftp_size function
					// this feature will save some bandwith
					if (ftp_size($connect,$content)>MIN_SCREEN_SIZE)
					{
						
						
						if (DEBUG==true)
						{
							if ($debugCount<2)
							{
								echo date('H:i:s] ')."<li>Current file (\$content): ".$content."</li><br>";
								$debugCount++;
								
								if ($debugCount==2)
								{
									echo date('H:i:s] ')."<li>And some more files...</li><br>";
								}
							}
						}
						
						//	alter png index url
						$pos	=	strrpos($content,"/");
						$length	=	strlen($content);
						$content		=	substr($content,$pos+1,$length-$pos);


						//	store png file into array and in DB
						//	those are the png files that can be downloaded
						//	if they are downloaded extra information can be obtained from parser_screens
						$png_files[$i]	=	$content;

						//	store in file names without extension in DB
						$posStart	=	strpos($content,'.');
						$fileID		=	substr($content,0,$posStart);

						$sql_insert	=	"INSERT INTO `dl_screens` (`fid`) VALUES ('".$fileID."')";
						$sql 		=	mysql_query($sql_insert);

						$i++;
					}
				}
				// error has occurred, stop using ftp_size and just store all .png images
				else 
				{
					// dirty fix, for those who are running windows gameserver, windows provides backwards slashes (\) instead of forward (/)
					$content	=	str_replace("\\","/",$content);
					
					if (DEBUG==true)
					{
						if ($debugCount<2)
						{
							echo date('H:i:s] ')."<li>Current file (\$content): ".$content."</li><br>";
							$debugCount++;
								
							if ($debugCount==2)
							{
								echo date('H:i:s] ')."<li>And some more files...</li><br>";
							}
						}
					}
					
					//	alter png index url
					$pos	=	strrpos($content,"/");
					$length	=	strlen($content);
					$content		=	substr($content,$pos+1,$length-$pos);


					//	store png file into array and in DB
					//	those are the png files that can be downloaded
					//	if they are downloaded extra information can be obtained from parser_screens
					$png_files[$i]	=	$content;

					//	store in file names without extension in DB
					$posStart	=	strpos($content,'.');
					$fileID		=	substr($content,0,$posStart);

					$sql_insert	=	"INSERT INTO `dl_screens` (`fid`) VALUES ('".$fileID."')";
					$sql 		=	mysql_query($sql_insert);

					$i++;
				}
			}


		}
	}

	//	close connections
	ftp_close($connect);

	return $png_files;

}


//	new function since 1.1.2.1
//	get list of fids of downloaded screens, needed for showing detailed screen info on a seperate page
function get_fids()
{
	$i	=	0;

	$sql_select	=	"SELECT `fid` FROM `dl_screens`";
	$sql 		=	mysql_query($sql_select);
	//	if there is any result
	if(mysql_num_rows($sql)>=1)
	{
		while($row	=	mysql_fetch_object($sql))
		{
			$fid[$i]	=	$row->fid;
			$i++;
		}

		return $fid;
	}
	else
	{
		return false;
	}
}

//	new function since 1.1.2.1
//	it will gather information by looking at fid
function get_detailed_screen_info($fid)
{
	//	get information
	$sql_select	=	"SELECT * FROM `screens` WHERE `fid`='".$fid."' ORDER BY `date` DESC LIMIT 0,1";
	$sql 		=	mysql_query($sql_select);
	if(mysql_num_rows($sql)>=1)
	{
		while($row	=	mysql_fetch_object($sql))
		{
			$name	=	htmlentities($row->name,ENT_QUOTES);
			$date	=	$row->date;
			$guid	=	$row->guid;

		}

		//	put data in array
		$data	=	array($name,$guid,$date);
		return $data;

	}
	else
	{
		return false;
	}
}


//	function needed to update the file
//	and update pbsvss.htm (if needed) from preventing the file keep on growing for ever
function update_file($ftp_host,$ftp_port,$ftp_user,$ftp_pass,$ssdir,$L_FILE_TEMP,$fileLastUpdate,$SsCeiling,$debug)
{
	#####################
	//	steps:
	//	1]	first download the main file
	//	2]	change downloaded file if needed
	//	3]	upload changed downloaded file(user option see 'pbsvss_updater' in config file)
	//	4]	parse main file
	//	5]	download png files

	//	ftp connect
	$connect	=	ftp_connect($ftp_host,$ftp_port,script_load_time);
	$login		=	ftp_login($connect,$ftp_user,$ftp_pass);

	//	check connection
	if($connect && $login)
	{
		if($debug==true)
		{
			echo date('H:i:s] ').'<li> Connected to: '.$ftp_host.':'.$ftp_port.'</li><br>';
		}

		//	change dir
		if(ftp_chdir($connect,$ssdir))
		{

			if($debug==true)
			{
				echo date('H:i:s] ')."<li> Directory changed to: ".ftp_pwd($connect).'</li><br>';
			}

			//	first get main file 'pbsvss.htm' which contains all the data about players
			if($get	=	ftp_get($connect,L_FILE,R_FILE,FTP_BINARY));
			{

				if($debug==true)
				{
					echo date('H:i:s] ').'<li> Downloaded file:'.R_FILE.'</li><br>';
				}

				//	check if update is needed
				$fp 	=	file(L_FILE);

				//	check if there are to many lines of old data
				if(count($fp)>$SsCeiling)
				{
					//	download/create second file which is used for adding changes
					if($get	=	ftp_get($connect,$L_FILE_TEMP,R_FILE,FTP_BINARY))
					{
						//	step 2:
						#####################
						//	if everything went O.K., then change downloaded file
						edit_pbsvss(L_FILE,$L_FILE_TEMP,$SsCeiling);

						if($debug==true)
						{
							echo date('H:i:s] ').'<li> Editing file: '.R_FILE.'</li><br>';
						}
					}

					//	step 3:
					#####################
					//	if true then changed/updated (smaller) pbsvss.htm file will be uploaded
					if(pbsvss_updater==true)
					{
						if($put	=	ftp_put($connect,R_FILE,L_FILE,FTP_BINARY))
						{
							if($debug==true) echo date('H:i:s] ')."<li> pbsvss.htm on your gameserver(".$ftp_host.':'.$ftp_port.") is updated!</li><br>";
						}
					}

				}


				//	step 4:
				#####################
				//	if main file is downloaded (and updated) then store info in DB

				//	before updating, make copy of table `screens` to `screens_old`
				copy_screens_to_old();


				//	debug feature is new since 1.1.2.1
				if($debug==true)
				{
					parser_screens(L_FILE,true);
					echo date('H:i:s] ').'<li> Made a copy of old DB table containing date of pbsvss.htm data</li><br>';
					echo date('H:i:s] ').'<li> Data from '.R_FILE.' is stored in DB</li><br>';
				}
				else
				{
					parser_screens(L_FILE);
				}

				//	step 5:
				#####################
				//	get the png files that are available
				$pbsslist	=	get_list_pbscreens($ftp_host,$ftp_port,$ftp_user,$ftp_pass,$ssdir);


				//	needed for check after download if there is an inconsistency
				$DownloadCount		=	0;
				$download 			=	true;

				$reqDownloadCount	=	count($pbsslist);


				$debugCount = 0;
				foreach ($pbsslist as $i_nr=>$content)
				{
					//	since version 1.2.2.1 this function also looks if the files were already downloaded
					if(!is_same($content,$connect))
					{
						if($debug==true)
						{
							if ($debugCount<2)
							{						
								echo date('H:i:s] ').'<li>Local file path: download/'.$content.'</li><br>';
								echo date('H:i:s] ').'<li>Remote file path: '.ftp_pwd($connect).'/'.$content.'</li><br>';
								$debugCount++;
								
								if ($debugCount==2)
								{
									echo date('H:i:s] ').'<li>And some more Local files and Remote files...</li><br>';
								}
							}
						}
						
						if($get2	=	ftp_get($connect,"download/".$content,$content,FTP_BINARY))
						{
							$DownloadCount++;
						}
						else
						{

							$download	=	false;
						}
					}

				}
				

				if($download!=false)
				{
					if($reqDownloadCount==$DownloadCount)
					{
						if($debug==true)
						{
							echo date('H:i:s] ').'<li> All PNG files ('.$DownloadCount.') were downloaded succesfully!</li><br>';
						}
					}
					else
					{
						if($DownloadCount==0)
						{
							if($debug==true)
							{
								echo date('H:i:s] ').'<li>No PNG files were downloaded, same PNG files were already located on your website</li><br>';
							}
						}
						elseif ($DownloadCount==1)
						{
							if($debug==true)
							{
								echo date('H:i:s] ').'<li> Only '.$DownloadCount.' PNG file was downloaded</li><br>';
							}
						}
						else
						{
							if($debug==true)
							{
								echo date('H:i:s] ').'<li> Only '.$DownloadCount.' PNG files were downloaded</li><br>';
							}
						}
					}

					//	this is new in version 1.2.2.1
					//	if files are downloaded, then also store their filesize
					foreach ($pbsslist	as $file_id)
					{
						$size	=	filesize('download/'.$file_id);

						//	get file name without extension
						$posStart	=	strpos($file_id,'.');
						$fid		=	substr($file_id,0,$posStart);
						$sql_insert	=	"UPDATE `screens` SET `filesize`='".$size."' WHERE `fid`='".$fid."'";
						$sql 		=	mysql_query($sql_insert);
					}
					
					//	this option can be triggered in config
					//	it will download the log files and parse them to DB
					if(PB_log==true)
					{
						get_logs($debug,PB_log);
					}

					//	if file is downloaded, update local file lastUpdate
					if($fp2	=	fopen($fileLastUpdate,'w+'))
					{
						fwrite($fp2,time());
						fclose($fp2);
					}
					else
					{
						fclose($fp2);
						die('cannot write file lastUpdate, please CHMOD \'lastUpdate.txt\' to 666');
					}


					//	if everything went fine then set request_update back to false
					//	When this is set to false, someone can request an update
					set_request_false();
				}
				else
				{
					die('Not all .png files were downloaded...');
				}
			}



		}
		//	cdir failed
		else
		{
			//	close ftp connection
			ftp_close($connect);
			die('directory change failed');

		}
	}
	//	connection failed
	else
	{
		//	close ftp connection
		ftp_close($connect);
		die('connection failed');

	}



	//	close ftp connection
	ftp_close($connect);

}

function get_latest_size_by_fid	($fid)
{
	//	new query is added since version 1.2.2.1
	//	it will search for latest filesize in db, there might be duplicates

	$sql_select	=	"SELECT `filesize` FROM `screens_old` WHERE `fid`='".$fid."' ORDER BY `date` DESC LIMIT 0,1";
	$sql 		=	mysql_query($sql_select);
	if(mysql_num_rows($sql)>=1)
	{
		while ($row	=	mysql_fetch_object($sql))
		{
			$size	=	$row->filesize;
		}

		return $size;
	}
}

function get_old_date_by_fid	($fid)
{
	//	new query is added since version 1.2.2.1
	//	it will search for latest old date in db, there might be duplicates
	$sql_select	=	"SELECT `date` FROM `screens_old` WHERE `fid`='".$fid."' ORDER BY `date` DESC LIMIT 0,1";
	$sql 		=	mysql_query($sql_select);
	if(mysql_num_rows($sql)>=1)
	{
		while ($row	=	mysql_fetch_object($sql))
		{
			$date	=	$row->date;
		}

		return $date;
	}
}


function get_new_date_by_fid	($fid)
{
	//	new query is added since version 1.2.2.1
	//	it will search for latest new date in db, there might be duplicates
	$sql_select	=	"SELECT `date` FROM `screens` WHERE `fid`='".$fid."' ORDER BY `date` DESC LIMIT 0,1";
	$sql 		=	mysql_query($sql_select);
	if(mysql_num_rows($sql)>=1)
	{
		while ($row	=	mysql_fetch_object($sql))
		{
			$date	=	$row->date;
		}

		return $date;
	}
}

//	this function is added since 1.2.2.1, to check if file already was downloaded
//	this saves a lot of bandwith
function is_same($file_id,$connect)
{
	//	there are 2 options here
	//	-	user has put a wrong pb_sv_SsCeiling in config
	//	-	user has used correct pb_sv_SsCeiling
	//	this function should work in both cases

	//	first check if file exist
	//	if not, then download the file
	if(file_exists('download/'.$file_id))
	{


		$check1	=	false;
		$check2	=	false;

		//	get file name without extension
		$posStart	=	strpos($file_id,'.');
		$fid		=	substr($file_id,0,$posStart);

		//	gather size info of latest screenshot
		//	from OLD screen table
		$size_local	=	get_latest_size_by_fid($fid);

		//	first check size if possible, compare between file and DB(=old entries)
		//	not all ftp server supports this feature according to PHP.net
		$size_remote	=	ftp_size($connect,$file_id);

		//	if ftp server supports ftp_size
		if($size_remote!=-1)
		{
			if($size_local==$size_remote)	$check1=true;

			//	to be sure do also a date check
			//	Therefore extra table is needed. This table `screens_old` has previous data
			$date_old	=	get_old_date_by_fid($fid);
			$date_new	=	get_new_date_by_fid($fid);


			if($date_old==$date_new)	$check2	=	true;


			if($check1==true&&$check2==true)
			{
				return true;
			}
			else
			{
				return false;
			}

		}
		else
		{
			//	only do a date check
			//	Therefore extra table is needed. This table `screens_old` has previous data
			$date_old	=	get_old_date_by_fid($fid);
			$date_new	=	get_new_date_by_fid($fid);

			if($date_old==$date_new)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	//	if file does not exist, then just download it
	else
	{
		return false;
	}

}

//	This function is new since 1.2.2.1
//	It will make a back-up of table `screens`
//	This will be needed for comparing .png files
function copy_screens_to_old()
{
	//	first drop table
	$sql_drop	=	"DROP TABLE `screens_old`";
	$sql		=	mysql_query($sql_drop);

	//	create back-up of table `screens`
	$sql_create	=	"CREATE TABLE `screens_old` SELECT * FROM `screens`";
	$sql 		=	mysql_query($sql_create);
}

//	new function since 1.2.2.1
//	get available unique years from DB, needed for search form to show them in option box

function get_dates()
{
	$i	=	0;

	$sql_select	=	"SELECT DISTINCT `date`,DATE_FORMAT(`date`,'%Y-%M-%e %k:%i:%s') as newdate FROM `screens` ORDER BY `date` DESC";
	$sql 		=	mysql_query($sql_select);
	if(mysql_num_rows($sql)>=1)
	{
		while ($row	=	mysql_fetch_object($sql))
		{
			$date	=	$row->newdate;
			//	this is only needed to get month in numbers
			$date_2	=	$row->date;

			//	conatins array of year, month, day, hour, minute, second
			//	after this loop it is an double array
			$data	=	parser_date($date);
			$data_2	=	parser_date($date_2);

			$year[$i]		=	$data[0];
			//	month also given in nr
			$month[$i]		=	$data[1].','.$data_2[1];
			$day[$i]		=	$data[2];

			//	bug fix: php tends to writ 01 as 1 and 00 as 0
			//	will give correct hours

			$hour[$i]		=	$data_2[3];


			$i++;

		}

		//	get unique indexes
		$result_year		=	array_unique($year);
		$result_month		=	array_unique($month);
		$result_day			=	array_unique($day);
		$result_hour		=	array_unique($hour);

		//	order array
		sort($result_month);
		sort($result_day);
		sort($result_hour);


		//	create double array
		$final_result	=	array($result_year,$result_month,$result_day,$result_hour);

		return $final_result;
	}
}

//	this function is added since, 1.2.2.1
//	it is used for getting the date from DB in an array
function parser_date($date)
{
	//	get $data[0]=(days-months-years)
	//	get $data[1]=(hours:minutes:seconds)
	$data	=	explode(' ',$date);

	//	get days, months, years seperately
	$data_1	=	explode('-',$data[0]);
	$year	=	$data_1[0];
	$month	=	$data_1[1];
	$day	=	$data_1[2];

	//	get hours, minuts, seconds
	$data_2		=	explode(':',$data[1]);
	$hours		=	$data_2[0];
	$minutes	=	$data_2[1];
	$seconds	=	$data_2[2];

	$final_data	=	array($year,$month,$day,$hours,$minutes,$seconds);
	return $final_data;


}

//	edit pbsvss.htm file
function edit_pbsvss($L_FILE,$L_FILE_TEMP,$SsCeiling)
{
	$fp 	=	file($L_FILE_TEMP);
	$i=0;

	//	if file is oversized, then resize it by removing(skipping) first lines
	if(count($fp)>$SsCeiling)
	{
		//	check how many old lines there are, those first lines are skipped when data is rewritten. info: pb writes newest data to the end of the file
		$old_lines	=	count($fp)-$SsCeiling;

		//	first copy valid data
		foreach ($fp as $line=>$data)
		{
			if($line+1>$old_lines)
			{
				//	now start copy
				$fp_new[$i]	=	$data;
				$i++;
			}
		}

		//	after everything is copied to $fp_new, start rewriting
		$fp2	=	fopen($L_FILE,'w+');
		foreach ($fp_new as $data)
		{
			fwrite($fp2,$data);
		}

		fclose($fp2);

	}

}

//	this function is new since 1.1.2.1
//	it tries to find other names of player by guid
//	$player is the one of the screenshot, this one will be excluded from sql search
function get_alias($guid,$player)
{
	$i=0;

	// v 2.1.0.0 Bug fix: html_entity_decode is added to do a correct comparison
	$sql_select	=	"SELECT DISTINCT `name` FROM `screens` WHERE `guid`='".$guid."' AND `name`!='".html_entity_decode($player)."'";
	$sql 		=	mysql_query($sql_select);


	//	if there other nicknames for this player then get them
	if(mysql_num_rows($sql)>=1)
	{
		//	return array
		while($row	=	mysql_fetch_object($sql))
		{
			$data[$i]	=	$row->name;
			$i++;
		}
		
		return $data;

	}
	else
	{
		return false;
	}
}

//	get screen info from pbsvss.htm
function parser_screens ($file,$debug=false)
{
	$lines	=	file($file);

	//	before updating table screens, first truncate old data
	$sql_del	=	"TRUNCATE TABLE `screens`";
	mysql_query($sql_del);

	//	parse each line
	foreach($lines as $line_nr=>$line)
	{
		
		//	get link
		//	get file name without extension
		preg_match("~<a href\=pb[0-9]+\.htm~",$line,$matches);
		$newMatch = $matches[0];
		preg_match("~pb[0-9]+~",$newMatch,$matches);
		$fileID	=	$matches[0];
		
		//	get name
		preg_match("~</a> \".*\" \(.*\) ~",$line,$matches);
		$newMatch = $matches[0];
		preg_match("~\".*\"~",$newMatch,$matches);
		$newMatch = $matches[0];
		$name = substr($newMatch,1,strlen($newMatch)-2);

		//	if user uses forbidden characters, this is new since version 1.1.2.1
		$name		=	addslashes($name);
		
			
		//	get guide
		preg_match("~GUID=[a-z0-9]{32}\(.*\)~",$line,$matches);
		$newMatch = $matches[0];
		preg_match("~[a-z0-9]{32}~",$newMatch,$matches);
		$guid = $matches[0];
				
		//	get date
		preg_match("~\[[0-9]+\.[0-9]{2}\.[0-9]{2}\ [0-9]{2}\:[0-9]{2}\:[0-9]{2}\]~",$line,$matches);
		$date = substr($matches[0],1,strlen($matches[0])-2);

		if($debug==false)
		{
			//	store in DB
			$sql_insert	=	"INSERT INTO `screens` (`fid`,`name`,`guid`,`date`) VALUES ('".$fileID."','".$name."','".$guid."','".$date."')";
			$sql 		=	mysql_query($sql_insert);
		}
		else
		{
			//	store in DB
			$sql_insert	=	"INSERT INTO `screens` (`fid`,`name`,`guid`,`date`) VALUES ('".$fileID."','".$name."','".$guid."','".$date."')";
			$sql 		=	mysql_query($sql_insert) or die(mysql_error());
		}

	}

}


function get_latest_fid	($fid)
{
	//	new query is added since version 1.2.2.1
	//	it will search for latest file in db, there might be duplicates
	$sql_select	=	"SELECT * FROM `screens` WHERE `fid`='".$fid."' ORDER BY `date` DESC LIMIT 0,1";
	$sql 		=	mysql_query($sql_select);
	if(mysql_num_rows($sql)>=1)
	{
		while ($row	=	mysql_fetch_object($sql))
		{
			$fid	=	$row->fid;
			//	get screen info
			$name	=	$row->name;
			$guid	=	$row->guid;
			$date	=	$row->date;
		}

		return $data=	array($fid,$name,$guid,$date);
	}
}

// if $available = true, then it will only show available screens
function show_all_screens($nr=4,$available=false)
{
	global $str;
	
	$nr_counter	=	0;

	//	only select unique fids
	$sql_select	=	"SELECT DISTINCT `fid` FROM `screens` ORDER BY `date` DESC";
	$sql 		=	mysql_query($sql_select);

	//	check if there are screens in DB
	if(mysql_num_rows($sql)>=1)
	{
		while($row	=	mysql_fetch_object($sql))
		{
			//	find which screens are available and which are not available
			//	also get latest files if there are duplicates
			$data	=	get_latest_fid($row->fid);
			$fid	=	$data[0];
			$name	=	htmlentities($data[1],ENT_QUOTES);
			$guid	=	$data[2];
			$date	=	$data[3];

			$sql_select2	=	"SELECT * FROM `dl_screens` WHERE `fid`='".$fid."'";
			$sql2			=	mysql_query($sql_select2);
			
			$sql_result = false;
			//	screen does exist, is downloaded
			if(mysql_num_rows($sql2)>=1)
			{
				
				$sql_result = true;
				$md5_valid	=	false;
				$logged		=	false;
				$ip_player = '';
				$md5_screen = '';
				
				//	get info from log data
				if($log_data	=	get_extra_log_data($fid))
				{
					$logged		=	true;
					$md5_screen	=	$log_data[0];
					$ip_player	=	$log_data[1];
					
					if($md5_screen==get_md5("download/".$fid.".png")) $md5_valid=true;
				}
								

			}
			
			show_screens_body($fid,$name,$guid,$date,$ip_player,$md5_screen,$nr,$sql_result,$nr_counter,$logged,$md5_valid,$available);
			
			// this is done, otherwise it counts the images that are not displayed as well
			if(!($available==true && $sql_result==false))
			{
				$nr_counter++;
			}
			
			if($nr_counter>=$nr)
			{
				$nr_counter=0;
			}
			


		}
	}
	else
	{
		template_error_msg('No screens in DB','No images are downloaded','Ask admin for an update. If this doesn\'t do the trick then probably something is not configured correctly');
	}

}

function show_date_selection ($nr=4,$data)
{
	
	global $str;

	$nr_counter	=	0;

	//	only select unique fids

	$sql_select	=	"SELECT DISTINCT `fid` FROM `screens` WHERE `date` LIKE '".$data[0]."-".$data[1]."-".$data[2]." ".$data[3].":%:%' ORDER BY `date` DESC";
	$sql 		=	mysql_query($sql_select);

	//	check if there are screens in DB
	if(mysql_num_rows($sql)>=1)
	{
		while($row	=	mysql_fetch_object($sql))
		{
			//	find which screens are available and which are not available
			//	also get latest files if there are duplicates
			$data	=	get_latest_fid($row->fid);
			$fid	=	$data[0];
			$name	=	htmlentities($data[1],ENT_QUOTES);
			$guid	=	$data[2];
			$date	=	$data[3];

			$sql_select2	=	"SELECT * FROM `dl_screens` WHERE `fid`='".$fid."'";
			$sql2			=	mysql_query($sql_select2);
			
			$sql_result = false;
			//	screen does exist, is downloaded
			if(mysql_num_rows($sql2)>=1)
			{

				$sql_result = true;
				$md5_valid	=	false;
				$logged		=	false;
				$ip_player = '';
				$md5_screen = '';
				
				//	get info from log data
				if($log_data	=	get_extra_log_data($fid))
				{
					$logged		=	true;
					$md5_screen	=	$log_data[0];
					$ip_player	=	$log_data[1];
					
					if($md5_screen==get_md5("download/".$fid.".png")) $md5_valid=true;
				}
				
				
			}
			
			show_screens_body($fid,$name,$guid,$date,$ip_player,$md5_screen,$nr,$sql_result,$nr_counter,$logged,$md5_valid);
				
			$nr_counter++;
			
			if($nr_counter>=$nr)
			{
				$nr_counter=0;
			}


		}
	}
	else
	{
		template_error_msg('No screens in DB','No images are downloaded','Ask admin for an update. If this doesn\'t do the trick then probably something is not configured correctly');
	}

}

function get_wildcard($search)
{
	$search	=	str_replace('*','%',$search);
	return $search;
}

function show_fid_screens($nr=4,$fileName)
{
	global $str;
	
	$nr_counter	=	0;

	//	check if added .png, which is not needed
	if(eregi('.png',$fileName))
	{
		//	get file name without extension
		$posStart	=	strpos($fileName,'.');
		$fileName		=	substr($fileName,0,$posStart);
	}


	$fileName		=	get_wildcard($fileName);

	//	only select unique fids
	$sql_select	=	"SELECT DISTINCT `fid` FROM `screens` where `fid` LIKE '".$fileName."'";
	$sql 		=	mysql_query($sql_select);


	if(mysql_num_rows($sql)>=1)
	{
		while($row	=	mysql_fetch_object($sql))
		{

			//	find which screens are available and which are not available
			//	also get latest files if there are duplicates
			$data	=	get_latest_fid($row->fid);
			$fid	=	$data[0];
			$name	=	htmlentities($data[1],ENT_QUOTES);
			$guid	=	$data[2];
			$date	=	$data[3];

			$sql_select2	=	"SELECT * FROM `dl_screens` WHERE `fid`='".$fid."'";
			$sql2			=	mysql_query($sql_select2);
			
			$sql_result = false;
			//	screen does exist, is downloaded
			if(mysql_num_rows($sql2)>=1)
			{

				$sql_result = true;
				$md5_valid	=	false;
				$logged		=	false;
				$ip_player = '';
				$md5_screen = '';
				
				//	get info from log data
				if($log_data	=	get_extra_log_data($fid))
				{
					$logged		=	true;
					$md5_screen	=	$log_data[0];
					$ip_player	=	$log_data[1];
					
					if($md5_screen==get_md5("download/".$fid.".png")) $md5_valid=true;
				}
				
			
			}
				
			show_screens_body($fid,$name,$guid,$date,$ip_player,$md5_screen,$nr,$sql_result,$nr_counter,$logged,$md5_valid);
				
			$nr_counter++;
			
			if($nr_counter>=$nr)
			{
				$nr_counter=0;
			}


		}
	}
	else
	{
		template_error_msg('No screens in DB','No images are downloaded','Ask admin for an update. If this doesn\'t do the trick then probably something is not configured correctly');
	}

}

function show_guid_screens($nr=4,$guid)
{
	global $str;
	
	$nr_counter	=	0;

	$guid		=	get_wildcard($guid);

	//	only select unique fids
	$sql_select	=	"SELECT DISTINCT `fid` FROM `screens` where `guid` LIKE '".$guid."' ORDER BY `date` DESC";
	$sql 		=	mysql_query($sql_select);

	if(mysql_num_rows($sql)>=1)
	{
		while($row	=	mysql_fetch_object($sql))
		{
			//	find which screens are available and which are not available
			//	also get latest files if there are duplicates
			$data	=	get_latest_fid($row->fid);
			$fid	=	$data[0];
			$name	=	htmlentities($data[1],ENT_QUOTES);
			$guid	=	$data[2];
			$date	=	$data[3];

			$sql_select2	=	"SELECT * FROM `dl_screens` WHERE `fid`='".$fid."'";
			$sql2			=	mysql_query($sql_select2);
			
			$sql_result = false;
			//	screen does exist, is downloaded
			if(mysql_num_rows($sql2)>=1)
			{
				
				$sql_result = true;
				$md5_valid	=	false;
				$logged		=	false;
				$ip_player = '';
				$md5_screen = '';
				
				//	get info from log data
				if($log_data	=	get_extra_log_data($fid))
				{
					$logged		=	true;
					$md5_screen	=	$log_data[0];
					$ip_player	=	$log_data[1];
					
					if($md5_screen==get_md5("download/".$fid.".png")) $md5_valid=true;
				}
								
			}	
		
			show_screens_body($fid,$name,$guid,$date,$ip_player,$md5_screen,$nr,$sql_result,$nr_counter,$logged,$md5_valid);
				
			$nr_counter++;
			
			if($nr_counter>=$nr)
			{
				$nr_counter=0;
			}
			
		}
	}
	else
	{
		template_error_msg('No screens in DB','No images are downloaded','Ask admin for an update. If this doesn\'t do the trick then probably something is not configured correctly');
	}

}

function show_name_screens($nr=4,$name)
{
	global $str;
	
	$nr_counter	=	0;

	$name		=	get_wildcard($name);

	//	only select unique fids
	$sql_select	=	"SELECT DISTINCT `fid` FROM `screens` where `name` LIKE '".$name."' ORDER BY `date` DESC";
	$sql 		=	mysql_query($sql_select);



	if(mysql_num_rows($sql)>=1)
	{
		while($row	=	mysql_fetch_object($sql))
		{
			//	find which screens are available and which are not available
			//	also get latest files if there are duplicates
			$data	=	get_latest_fid($row->fid);
			$fid	=	$data[0];
			$name	=	htmlentities($data[1],ENT_QUOTES);
			$guid	=	$data[2];
			$date	=	$data[3];

			$sql_select2	=	"SELECT * FROM `dl_screens` WHERE `fid`='".$fid."'";
			$sql2			=	mysql_query($sql_select2);
			
			$sql_result = false;
			//	screen does exist, is downloaded
			if(mysql_num_rows($sql2)>=1)
			{
				
				$sql_result = true;
				$md5_valid	=	false;
				$logged		=	false;
				$md5_screen = '';
				$ip_player = '';
				
				//	get info from log data
				if($log_data	=	get_extra_log_data($fid))
				{
					$logged		=	true;
					$md5_screen	=	$log_data[0];
					$ip_player	=	$log_data[1];
					
					if($md5_screen==get_md5("download/".$fid.".png")) $md5_valid=true;
				}
			}

			show_screens_body($fid,$name,$guid,$date,$ip_player,$md5_screen,$nr,$sql_result,$nr_counter,$logged,$md5_valid);
				
			$nr_counter++;
			
			if($nr_counter>=$nr)
			{
				$nr_counter=0;
			}

		}
		
	}
	else
	{
		template_error_msg('No screens in DB','No images are downloaded','Ask admin for an update. If this doesn\'t do the trick then probably something is not configured correctly');
	}

}

//	new functions added since version 1.2.2.1
//	this function will be used on main page and show x latest screens. This number can be configured in config.inc.php
function show_main_screens($nr=4)
{
	global $str;
	
	$nr_counter	=	0;

	//	only select unique fids
	$sql_select	=	"SELECT DISTINCT `fid` FROM `screens` ORDER BY `date` DESC LIMIT 0,".nr_screens_main;
	$sql 		=	mysql_query($sql_select);

	//	check if there are screens in DB
	if(mysql_num_rows($sql)>=1)
	{
		while($row	=	mysql_fetch_object($sql))
		{
			//	find which screens are available and which are not available
			//	also get latest files if there are duplicates
			$data	=	get_latest_fid($row->fid);
			$fid	=	$data[0];
			$name	=	htmlentities($data[1],ENT_QUOTES);
			$guid	=	$data[2];
			$date	=	$data[3];

			$sql_select2	=	"SELECT * FROM `dl_screens` WHERE `fid`='".$fid."'";
			$sql2			=	mysql_query($sql_select2);
			
			$sql_result = false;
			//	screen does exist, is downloaded
			if(mysql_num_rows($sql2)>=1)
			{
				$sql_result = true;
				
				$md5_valid	=	false;
				$logged		=	false;
				$ip_player = '';
				$md5_screen = '';
				
				
				//	get info from log data
				if($log_data	=	get_extra_log_data($fid))
				{
					$logged		=	true;
					$md5_screen	=	$log_data[0];
					$ip_player	=	$log_data[1];
					
					if($md5_screen==get_md5("download/".$fid.".png")) $md5_valid=true;
				}
			}

			show_screens_body($fid,$name,$guid,$date,$ip_player,$md5_screen,$nr,$sql_result,$nr_counter,$logged,$md5_valid);
				
			$nr_counter++;
			
			if($nr_counter>=$nr)
			{
				$nr_counter=0;
			}

		}
	}
	else
	{
		template_error_msg('No screens in DB','No images are downloaded','Ask admin for an update. If this doesn\'t do the trick then probably something is not configured correctly');
	}

}

//	new since version 2.0.0.0
//	function is more a template than a real function, it will show the screens
function show_screens_body($fid,$name,$guid,$date,$ip_player='',$md5_screen='',$nr=4,$sql_result=true,$nr_counter=0,$logged=false,$md5_valid=true,$available=false)
{
	global $str;
	
	if($sql_result==true)
	{
		if($nr_counter==0)
		{
			if($logged)
			{
				if($md5_valid)
				{
					echo "<tr>\n";
					echo "<td align='center'><br><a href='?fid=".$fid."' target='_self' class='popup'><span><strong>".$str['POP_FILE']."</strong>: ".$fid.".png<br><strong>".$str['POP_PLAYER']."</strong>: ".$name."<br><strong>".$str['POP_GUID']."</strong>: ".$guid."<br><strong>".$str['POP_TAKEN']."</strong>: ".$date."<br><strong>".$str['POP_IP']."</strong>: ".$ip_player."<br><strong>".$str["POP_MD5_VALID"]."</strong>: ".get_md5("download/".$fid.".png")."</span><img src='download/".$fid.".png' width='".IMG_W."' height='".IMG_H."' alt='player: ".$name.", taken on ".$date."' border='0'></a></td>\n";					
				}
				//	mismatch!
				else 
				{
					echo "<tr>\n";
					echo "<td align='center'><br><a href='?fid=".$fid."' target='_self' class='popup'><span><strong>".$str['POP_FILE']."</strong>: ".$fid.".png<br><strong>".$str['POP_PLAYER']."</strong>: ".$name."<br><strong>".$str['POP_GUID']."</strong>: ".$guid."<br><strong>".$str['POP_TAKEN']."</strong>: ".$date."<br><strong>".$str['POP_IP']."</strong>: ".$ip_player."<br><strong>".$str["POP_MD5_INVALID"]."</strong><br><strong>".$str["POP_MD5_SCREEN"]."</strong>:".get_md5("download/".$fid.".png")."<br><strong>md5 hash log</strong>: ".$md5_screen."</span><img src='download/".$fid.".png' width='".IMG_W."' height='".IMG_H."' alt='player: ".$name.", taken on ".$date."' class='md5_mismatch_border'></a></td>\n";
				}
			}
			else 
			{
				echo "<tr>\n";
				echo "<td align='center'><br><a href='?fid=".$fid."' target='_self' class='popup'><span><strong>".$str['POP_FILE']."</strong>: ".$fid.".png<br><strong>".$str['POP_PLAYER']."</strong>: ".$name."<br><strong>".$str['POP_GUID']."</strong>: ".$guid."<br><strong>".$str['POP_TAKEN']."</strong>: ".$date."<br><strong>".$str["POP_MD5_HASH"]."</strong>: ".get_md5("download/".$fid.".png")."</span><img src='download/".$fid.".png' width='".IMG_W."' height='".IMG_H."' alt='player: ".$name.", taken on ".$date."' border='0'></a></td>\n";					
			}
					


		}
		else
		{
			if($logged)
			{
				if($md5_valid)
				{
							
					echo "<td align='center'><br><a href='?fid=".$fid."' target='_self' class='popup'><span><strong>".$str['POP_FILE']."</strong>: ".$fid.".png<br><strong>".$str['POP_PLAYER']."</strong>: ".$name."<br><strong>".$str['POP_GUID']."</strong>: ".$guid."<br><strong>".$str['POP_TAKEN']."</strong>: ".$date."<br><strong>".$str['POP_IP']."</strong>: ".$ip_player."<br><strong>".$str["POP_MD5_VALID"]."</strong>: ".get_md5("download/".$fid.".png")."</span><img src='download/".$fid.".png' width='".IMG_W."' height='".IMG_H."' alt='player: ".$name.", taken on ".$date."' border='0'></a></td>\n";					
				}
				//	mismatch!
				else 
				{
							
					echo "<td align='center'><br><a href='?fid=".$fid."' target='_self' class='popup'><span><strong>".$str['POP_FILE']."</strong>: ".$fid.".png<br><strong>".$str['POP_PLAYER']."</strong>: ".$name."<br><strong>".$str['POP_GUID']."</strong>: ".$guid."<br><strong>".$str['POP_TAKEN']."</strong>: ".$date."<br><strong>".$str['POP_IP']."</strong>: ".$ip_player."<br><strong>".$str["POP_MD5_INVALID"]."</strong><br><strong>".$str["POP_MD5_SCREEN"]."</strong>:".get_md5("download/".$fid.".png")."<br><strong>md5 hash log</strong>: ".$md5_screen."</span><img src='download/".$fid.".png' width='".IMG_W."' height='".IMG_H."' alt='player: ".$name.", taken on ".$date."' class='md5_mismatch_border'></a></td>\n";					
				}
			}
			else 
			{
						
				echo "<td align='center'><br><a href='?fid=".$fid."' target='_self' class='popup'><span><strong>".$str['POP_FILE']."</strong>: ".$fid.".png<br><strong>".$str['POP_PLAYER']."</strong>: ".$name."<br><strong>".$str['POP_GUID']."</strong>: ".$guid."<br><strong>".$str['POP_TAKEN']."</strong>: ".$date."<br><strong>".$str["POP_MD5_HASH"]."</strong>: ".get_md5("download/".$fid.".png")."</span><img src='download/".$fid.".png' width='".IMG_W."' height='".IMG_H."' alt='player: ".$name.", taken on ".$date."' border='0'></a></td>\n";					
			}
					

		}

			if($nr_counter>=$nr)
			{
				echo "</tr>\n";
			}


		}
		else
		{
			if($available==false)
			{
				//	if there are no results, then there is no image available. So it is not downloaded
				//	can be edited with custum image

				if($nr_counter==0)
				{
					echo "<tr>\n";
					echo "<td align='center'><br><a href='#' target='_self' class='popup'><span><strong>".$str['POP_FILE']."</strong>: ".$str["POP_NOT_AVAILABLE"]."<br><strong>".$str['POP_PLAYER']."</strong>: ".$name."<br><strong>".$str['POP_GUID']."</strong>: ".$guid."<br><strong>".$str['POP_TAKEN']."</strong>: ".$date."</span><img src='style/img/na.png' width='".IMG_W."' height='".IMG_H."' alt='no image available' border='0'></a></td>\n";


				}
				else
				{
					echo "<td align='center'><br><a href='#' target='_self' class='popup'><span><strong>".$str['POP_FILE']."</strong>: ".$str["POP_NOT_AVAILABLE"]."<br><strong>".$str['POP_PLAYER']."</strong>: ".$name."<br><strong>".$str['POP_GUID']."</strong>: ".$guid."<br><strong>".$str['POP_TAKEN']."</strong>: ".$date."</span><img src='style/img/na.png' width='".IMG_W."' height='".IMG_H."' alt='no image available' border='0'></a></td>\n";

				}

				if($nr_counter>=$nr)
				{
					echo "</tr>\n";
				}
			}

		}			
			
}

//	give info in footer about update status
function update_info ($update_time,$lastUpdate)
{
	global $str;
	
	if(CUSTOM_UPDATE!=true)
	{

		$lastUpdated	=	(time()-$lastUpdate);

		//	give in seconds
		if($lastUpdated>=0 && $lastUpdated<60)	echo $str["FOOTER_FILE_UPDATED"]." ".$lastUpdated." ".$str["FOOTER_FILE_UPDATED_2_SECONDS"]."<br>";

		//	give in minutes
		if($lastUpdated>=60 && $lastUpdated<3600) echo $str["FOOTER_FILE_UPDATED"]." ".round(($lastUpdated/60),2)." ".$str["FOOTER_FILE_UPDATED_2_MINUTES"]."<br>";

		//	give in hours
		if($lastUpdated>=3600 && $lastUpdated<3600*24) echo $str["FOOTER_FILE_UPDATED"]." ".round(($lastUpdated/3600),2)." ".$str["FOOTER_FILE_UPDATED_2_HOURS"]."<br>";

		//	give in days
		if($lastUpdated>=3600*24) echo $str["FOOTER_FILE_UPDATED"]." ".round(($lastUpdated/3600*24),2)." ".$str["FOOTER_FILE_UPDATED_2_DAYS"]."<br>";



		$nexUpdate		=	($update_time-(time()-$lastUpdate));

		//	give in seconds
		if($nexUpdate>=0 && $nexUpdate<60) echo $str["FOOTER_NEW_UPDATE"]." ".$nexUpdate." ".$str["FOOTER_SECONDS"];

		//	give in minutes
		if($nexUpdate>=60 && $nexUpdate<3600) echo $str["FOOTER_NEW_UPDATE"]." ".round(($nexUpdate/60),2)." ".$str["FOOTER_MINUTES"];

		//	give in hours
		if($nexUpdate>=3600 && $nexUpdate<3600*24) echo $str["FOOTER_NEW_UPDATE"]." ".round(($nexUpdate/3600),2)." ".$str["FOOTER_HOURS"];

		//	give in days
		if($nexUpdate>=3600*24) echo $str["FOOTER_NEW_UPDATE"]." ".round(($nexUpdate/3600*24),2)." ".$str["FOOTER_DAYS"];
	}
	else
	{
		echo $str["FOOTER_CUSTOM_UPDATE"];
	}

}

//	used for getting script load time
function get_microtime()
{
	//	store the 2 values seperately
	list($msec,$sec)	=	explode(' ',microtime());
	return ($msec+$sec);
}

function get_loadTime($startTime,$precision)
{
	$endTime	=	get_microtime();
	return round($endTime-$startTime,$precision);
}

//	check if person is admin or not
function is_admin($admin_ip)
{
	$admin=false;

	foreach ($admin_ip as $ip)
	{
		if($_SERVER['REMOTE_ADDR']==$ip) $admin=true;
	}

	return $admin;
}

//	new since version 2.0.1.0
function is_user_on_allowed_list()
{
	$allowed=false;
	
	// get all ips from database if available
	if($ips	=	get_ips_allowedList())
	{	
		foreach ($ips as $ip)
		{
			if($ip==$_SERVER['REMOTE_ADDR']) $allowed=true;
		}
	}
	else 
	{
		$allowed=true;
	}
	
	return $allowed;
}

//	new since version 2.0.1.0
// 	get the ip addresses from database and return array
function get_ips_allowedList()
{
	$ipsData = '';
	$sql_select	=	"SELECT `value` FROM `settings` WHERE `name`='AllowedList'";
	$sql 		=	mysql_query($sql_select);
	while ($row = mysql_fetch_object($sql))
	{
		$ipsData	=	$row->value;	
	}
			
	if ($ipsData=='')
	{
		return false;	
	}
	else 
	{
		//	process this data
		$ips	=	explode(',',$ipsData);
		return $ips;		
	}

	
}

//	new since version 2.0.1.0
//	get ip addresses from database return in string
function get_ips_allowedList_string()
{
	$ipsData = '';
	$sql_select	=	"SELECT `value` FROM `settings` WHERE `name`='AllowedList'";
	$sql 		=	mysql_query($sql_select);
	while ($row = mysql_fetch_object($sql))
	{
		$ipsData	=	$row->value;	
	}
	
	return $ipsData;
}

//	new since version 2.0.1.0
//	check if entered IP addresses are correct
// 	if not return false
function check_ips_allowed_list($POST_IPS)
{
	if ($POST_IPS=='') 
	{
		return true;
	}
	else 
	{
		// apply trick, because then it is easy to use preg_match later on
		// the ',' sign is added to get same pattern all the time
		// 127.0.0.1,
		// 127.0.0.2,
		// 127.0.0.3,
		$POST_IPS = $POST_IPS.',';
		
		// the pattern of ips should look something like this
		// example input: 127.0.0.1,127.0.0.2,127.0.0.3,
		if (preg_match("~^((\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\,)+$~",$POST_IPS)==true)
		{
			return true;
		}
		else 
		{
			return false;
		}
	}

	

}

//	new since version 2.0.1.0
//	correct input if needed
function auto_correct_input_allowed_list($POST_IPS)
{
	if ($POST_IPS[strlen($POST_IPS)-1]==',')
	{
		return substr($POST_IPS,0,strlen($POST_IPS)-1);
	}
	else 
	{
		return $POST_IPS;
	}
}

// new since version 2.0.0.0
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

################################
//	new functions since 1.2.2.1
//	get screen info on header page
################################

function get_nr_unique_players()
{
	$sql_select		=	"SELECT DISTINCT `guid` FROM `screens`";
	$sql 			=	mysql_query($sql_select);
	if(($count	=	mysql_num_rows($sql))>=1)
	{
		return $count;
	}
	else
	{
		return $count=0;
	}
}

//	new function since 1.2.2.1
function get_nr_complete_screens()
{
	$sql_select		=	"SELECT DISTINCT `fid` FROM `dl_screens`";
	$sql 			=	mysql_query($sql_select);
	if(($count	=	mysql_num_rows($sql))>=1)
	{
		return $count;
	}
	else
	{
		return $count=0;
	}
}
//	new function since 1.2.2.1
function get_total_nr_screens()
{
	$sql_select		=	"SELECT DISTINCT `fid` FROM `screens`";
	$sql 			=	mysql_query($sql_select);
	if(($total	=	mysql_num_rows($sql))>=1)
	{

		$final	=	$total;

		return $final;
	}
	else
	{
		return $final=0;
	}
}
//	new function since 1.2.2.1
function get_nr_incomplete_screens()
{
	$sql_select		=	"SELECT DISTINCT `fid` FROM `screens`";
	$sql 			=	mysql_query($sql_select);
	if(($total	=	mysql_num_rows($sql))>=1)
	{

		$final	=	$total-get_nr_complete_screens();

		if($final<0)	$final=0;
		
		return $final;
	}
	else
	{
		return $final=0;
	}
}

//	look at player with most incomplete screens
//	filesize of incomplete screens are 0
function get_player_most_incomplete_screens()
{
	$number=0;
	$final_guid	=	'n/a';

	//	first make list of unique players
	$sql_select		=	"SELECT DISTINCT `guid` FROM `screens`";
	$sql 			=	mysql_query($sql_select);
	if(mysql_num_rows($sql)>=1)
	{
		while ($row	=	mysql_fetch_object($sql))
		{
			//	track number of incomplete screens for each guid
			$sql_select_2	=	"SELECT `filesize` FROM `screens` WHERE `guid`='".$row->guid."' AND `filesize`='0'";
			$sql2			=	mysql_query($sql_select_2);

			//	find player with max incomplete screens
			if(mysql_num_rows($sql2)>$number)
			{
				//	this will be the player guid we are looking for
				$final_guid=$row->guid;

				//	update new nr
				$number	=	mysql_num_rows($sql2);
			}
		}

		return $final_guid;
	}
	else
	{
		return 'n/a';
	}
}

//	look at player with most complete screens
//	filesize of complete screens are not 0
function get_player_most_complete_screens()
{
	$number=0;
	$final_guid	=	'n/a';

	//	first make list of unique players
	$sql_select		=	"SELECT DISTINCT `guid` FROM `screens`";
	$sql 			=	mysql_query($sql_select);
	if(mysql_num_rows($sql)>=1)
	{
		while ($row	=	mysql_fetch_object($sql))
		{
			//	track number of complete screens for each guid
			$sql_select_2	=	"SELECT `filesize` FROM `screens` WHERE `guid`='".$row->guid."' AND `filesize`!='0'";
			$sql2			=	mysql_query($sql_select_2);

			//	find player with max complete screens
			if(mysql_num_rows($sql2)>$number)
			{
				//	this will be the player guid we are looking for
				$final_guid=$row->guid;

				//	update new nr
				$number	=	mysql_num_rows($sql2);
			}
		}

		return $final_guid;
	}
	else
	{
		return 'n/a';
	}
}
//	new function since 1.2.2.1
function get_player_name_by_guid($guid)
{
	$sql_select	=	"SELECT `name` FROM `screens` WHERE `guid`='".$guid."' ORDER BY `date` DESC LIMIT 0,1";
	$sql 		=	mysql_query($sql_select);
	if(mysql_num_rows($sql)>=1)
	{
		while ($row	=	mysql_fetch_object($sql))
		{
			$name	=	$row->name;
		}

		return $name;
	}
	else
	{
		return 'n/a';
	}
}
//	new function since 1.2.2.1
function get_nr_screens_by_guid($guid)
{
	$count=0;

	$guid		=	get_wildcard($guid);

	//	only select unique fids
	$sql_select	=	"SELECT DISTINCT `fid` FROM `screens` where `guid` LIKE '".$guid."' ORDER BY `date` DESC";
	$sql 		=	mysql_query($sql_select);

	if(mysql_num_rows($sql)>=1)
	{
		while($row	=	mysql_fetch_object($sql))
		{
			//	find which screens are available and which are not available
			//	also get latest files if there are duplicates
			$data	=	get_latest_fid($row->fid);
			$fid	=	$data[0];

			$sql_select2	=	"SELECT * FROM `dl_screens` WHERE `fid`='".$fid."'";
			$sql2			=	mysql_query($sql_select2);
			//	screen does exist, is downloaded
			if(mysql_num_rows($sql2)>=1)
			{
				$count++;
			}


		}

		return $count;
	}
	else
	{
		return $count=0;
	}


}
//	new function since 1.2.2.1
function get_nr_screens_by_name($name)
{

	$count	=	0;

	$name		=	get_wildcard($name);

	//	only select unique fids
	$sql_select	=	"SELECT DISTINCT `fid` FROM `screens` where `name` LIKE '".$name."' ORDER BY `date` DESC";
	$sql 		=	mysql_query($sql_select);

	if(mysql_num_rows($sql)>=1)
	{
		while($row	=	mysql_fetch_object($sql))
		{
			//	find which screens are available and which are not available
			//	also get latest files if there are duplicates
			$data	=	get_latest_fid($row->fid);
			$fid	=	$data[0];

			$sql_select2	=	"SELECT * FROM `dl_screens` WHERE `fid`='".$fid."'";
			$sql2			=	mysql_query($sql_select2);
			//	screen does exist, is downloaded
			if(mysql_num_rows($sql2)>=1)
			{

				$count++;

			}
		}

		return $count;
	}
	else
	{
		return $count=0;
	}

}
//	new function since 1.2.2.1
function get_nr_screens_by_date($data)
{

	$count	=	0;

	//	only select unique fids

	$sql_select	=	"SELECT DISTINCT `fid` FROM `screens` WHERE `date` LIKE '".$data[0]."-".$data[1]."-".$data[2]." ".$data[3].":%:%' ORDER BY `date` DESC";
	$sql 		=	mysql_query($sql_select);

	//	check if there are screens in DB
	if(mysql_num_rows($sql)>=1)
	{
		while($row	=	mysql_fetch_object($sql))
		{
			//	find which screens are available and which are not available
			//	also get latest files if there are duplicates
			$data	=	get_latest_fid($row->fid);
			$fid	=	$data[0];

			$sql_select2	=	"SELECT * FROM `dl_screens` WHERE `fid`='".$fid."'";
			$sql2			=	mysql_query($sql_select2);
			//	screen does exist, is downloaded
			if(mysql_num_rows($sql2)>=1)
			{
				$count++;
			}


		}

		return $count;
	}
	else
	{
		return $count=0;
	}

}


//	get latest log files
//	this will download the log files and parse them to DB
//	after download delete old log files from both ftp server (webserver+gameserver)
//	delete all from gameserver
//	delete ''
//	new since version 1.2.2.1
function get_logs($debug=false,$log=false)
{
	if($log==true)
	{
		$dir	=	PBDIR.'/svlogs';

		$connect	=	ftp_connect(FTP_HOST,FTP_PORT,script_load_time);
		$login		=	ftp_login($connect,FTP_USER,FTP_PASS);

		//	change to log dir
		ftp_chdir($connect,$dir);

		//	dir changed to
if($debug==true)	
{
	echo date('H:i:s] ')."<li>Directory changed to: ".ftp_pwd($connect)."</li><br>";
}
		
		//	update, download the missing files
		//	first get list
		$fileList	=	ftp_nlist($connect,'.');
		
		$download_count	=	0;
		$parse_count	=	0;
		$del_count		=	0;
		
		//	total number of files on ftp server
		$req_count	=	count($fileList);
		
		foreach ($fileList	as $file)
		{
			//	only do something(parsing and deleting files) if files are downloaded
			if(ftp_get($connect,'download/'.$file,$file,FTP_BINARY))
			{

				$download_count++;
				
				//	parse each file and store it in DB
				if(!parse_log('download/'.$file)) $parse_count++;

				//	if downloaded and parsed then remove the file from gameserver
				if(ftp_delete($connect,$file))	$del_count++;
			}
		}
		
		if($req_count>0)
		{
			if($req_count==$download_count)	
			{
				if($debug==true)	
				{
					echo date('H:i:s] ')."<li>All(".$download_count.") log files were downloaded from your gameserver</li><br>";
				}
			}
			else
			{
				if($debug==true)
				{
					echo date('H:i:s] ')."<li>Something went wrong, not all log files were downloaded. Only downloaded ".$download_count." of ".$req_count." log files</li><br>";
				}
			}

			if($req_count==$parse_count)
			{
				if($debug==true)
				{
					echo date('H:i:s] ')."<li>Parsed all(".$parse_count.") log files</li><br>";
				}
			}
			else
			{
				if($debug==true)	
				{
						echo date('H:i:s] ')."<li>Not all log files were parsed correctly, only parsed ".$parse_count." of ".$req_count." log files</li><br>";
				}
			}
		
			if($req_count==$del_count)
			{
				if($debug==true)	
				{
				echo date('H:i:s] ')."<li>All(".$del_count.") log files were removed from your gamserver</li><br>";
				}
			}
			else 
			{
				if($debug==true)	
				{
					echo date('H:i:s] ')."<li>Did not remove the log files of your gameserver, only removed ".$del_count." of ".$req_count." log files</li><br>";
				}
			}
		}
		else 
		{
			if($debug==true)	
			{
				echo date('H:i:s] ')."<li>Did nothing with the log files</li><br>";
			}
		}



		ftp_close($connect);

		//	delete log files from webserver
		if(auto_del_logs==true)
		{
			//	delete logs inmediatly
			if(auto_del_count<=0)
			{
				if(del_logs_webserver(0,$debug))
				{
					
				}
				else 
				{
					if($debug==true)	
					{
						echo date('H:i:s] ')."<li>No log files were removed from your webserver</li><br>";
					}					
				}					
			}
			elseif(auto_del_count>0)
			{				
				if(del_logs_webserver(auto_del_count,$debug))
				{
					
				}
				else 
				{
					if($debug==true)	
					{
						echo date('H:i:s] ')."<li>No log files were removed from your webserver</li><br>";
					}					
				}
			}
			else
			{
				//	do nothing
				if($debug==true)	
				{
					echo date('H:i:s] ')."<li>No log files were removed from your webserver</li><br>";
				}
				
			}
		}

	}
	else
	{
		return false;
	}
}

//	delete log files from webserver
//	count is the number of logs the webserver needs to have before it is going to delete all the logs
function del_logs_webserver($count=0,$debug=false)
{
	if($connect	=	ftp_connect(FTP_HOST_WEB,FTP_PORT_WEB))
	{
		if($debug==true)	
		{
			echo date('H:i:s] ')."<li>Connected to ftp: ".FTP_HOST_WEB.":".FTP_PORT_WEB."</li><br>";
		}		
	}
	else 
	{
		if($debug==true)	
		{
			echo date('H:i:s] ')."<li>Can't connect to ftp: ".FTP_HOST_WEB.":".FTP_PORT_WEB."</li><br>";
		}		
	}
	
	if($login		=	ftp_login($connect,FTP_USER_WEB,FTP_PASS_WEB))
	{
		if($debug==true)	
		{
			echo date('H:i:s] ')."<li>Logged in on your ftp webserver</li><br>";
		}		
	}
	else 
	{
		if($debug==true)	
		{
			echo date('H:i:s] ')."<li>Can't log in on your ftp webserver, please check passs and username</li><br>";
		}		
	}

	//	change dir to log dir
	if(ftp_chdir($connect,PBSViewer_download))
	{
		if($debug==true)	
		{
			echo date('H:i:s] ')."<li>Directory changed to ".PBSViewer_download."</li><br>";
		}
	}
	else 
	{
		if($debug==true)	
		{
			echo date('H:i:s] ')."<li>Failed to change Directory to ".PBSViewer_download."</li><br>";
		}
		
		if($debug==true)	
		{
			if(check_PBSViewer_download($connect,PBSViewer_download))
			{
				echo date('H:i:s] ')."<li>However directory ".PBSViewer_download." seems to be correct</li><br>";
			}
			else 
			{
				echo date('H:i:s] ')."<li>Please check if directory ".PBSViewer_download." is correct</li><br>";
			}
		}

		return false;	
	}

	//	if changed then list all the files
	if($filelist	=	ftp_nlist($connect,'.'))
	{
	$nr_logs	=	0;

	//	first count number of logs
	foreach ($filelist	as $file)
	{
		//	if log file is found add up to $nr_logs
		if(preg_match("~^[0-9]+\.log~",$file))	$nr_logs++;
	}

	//	delete logs if there are to many
	if($nr_logs>=$count)
	{
		foreach ($filelist as $file)
		{
			//	find the log files and delete them
			if(preg_match("~^[0-9]+\.log~",$file,$matches)) ftp_delete($connect,$file);
		}
		
						if($debug==true)	
{
	echo date('H:i:s] ')."<li>number of log files was exceeded, log files were removed successfully from your webserver</li><br>";
}
	}
	}
}

//	tries to find the correct location
//	new function since 1.2.2.1
function find_PBSViewer_download($stream,$dir='.')
{	
if(ftp_chdir($stream,$dir))
{
			if($filelist	=	ftp_nlist($stream,'.'))
			{
				foreach ($filelist	as $file)
				{
					if($file==md5('here'))
					{
						echo 'found file: '.$file.'<br>';
						echo 'it is located in: '.$dir;
						return true;
					}
					else 
					{
						echo $file.'<br>';
						ftp_chdir($stream,'..');
						find_PBSViewer_download($stream,$file);
						
					}
					
					
				}
			}
}
else 
{
	return false;
}

	
}

//	checks if PBSViewer_download is correct
//	new function since 1.2.2.1
function check_PBSViewer_download($stream,$dir='.')
{	
if(ftp_chdir($stream,$dir))
{
			if($filelist	=	ftp_nlist($stream,'.'))
			{
				foreach ($filelist	as $file)
				{
					if($file==md5('here'))
					{
						echo 'Directory is correct<br>';
						echo 'found file: '.$file.'<br>';
						echo 'it is located in: '.$dir;
						return true;
					}
				}
			}
}
else 
{
	return false;
}

	
}

//	new function since 1.2.2.1
//	this will gather information from log files
function parse_log($logfile)
{
	//	if we can read file
	if($file	=	file($logfile))
	{
		
		//	get logid
		$logid	=	substr($logfile,9);
	
	for($i=0;$i<count($file);$i++)
	{
		$info	=	$file[$i];

		//	first check for fid, if no fid just do nothing
		//	get fid
		preg_match("~pb[0-9]+\.png~",$info,$matches);
		//	why not >0, because then something went wrong. You can't have multiple filenames for 1 screen
		if(count($matches)==1)
		{

			$new	=	 $matches[0];
			preg_match("~pb[0-9]+~",$new,$fid);
			//	current fid
			$c_fid	=	$fid[0];

			//	get MD5
			preg_match("~\(MD5=[A-Z0-9]+\)~",$info,$matches);
			//	sometimes an TIME OUT occurs when pb tries to capture a screen
			//	therefore we need to check if a MD5 is made of the screen
			//	why not >0, because then something went wrong. You can't have multipe md5 for 1 screen
			if(count($matches)==1)
			{
				$new	=	$matches[0];
				preg_match("~[A-Za-z0-9]{4,}~",$new,$MD5);
				//	current md5
				$c_md5	=	$MD5[0];
				$c_md5	=	strtolower($c_md5);

				//	get date
				preg_match("~[0-9]+\.[0-9]+\.[0-9]{4,} [0-9]+\:[0-9]+\:[0-9]+~",$info,$matches);
				//	current date
				$c_date	=	$matches[0];
				
				//	since pb is not very consistent, the dates are reversed in some way
				//	lets fix it
				$data	=	explode(' ',$c_date);
				//	second index of data array has correct order
				//	lets fix first index
				$data_2	=	explode('.',$data[0]);
				
				$new_date	=	$data_2[2].'.'.$data_2[0].'.'.$data_2[1].' '.$data[1];
				$c_date		=	$new_date;
								
				//	get guid
				preg_match("~[a-z0-9]{32}\([A-Za-z]*\)~",$info,$matches);
				$new	=	$matches[0];
				preg_match("~^[a-z0-9]{32}~",$new,$guid);
				//	current guid
				$c_guid	=	$guid[0];

				//	get ip
				preg_match("~\([a-zA-z]*\) [0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\:[0-9]*\]~",$info,$matches);
				$new	=	$matches[0];
				preg_match("~[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}~",$new,$ip);
				//	current ip
				$c_ip	=	$ip[0];
				

				
				if($c_fid!=''&&$c_md5!=''&&$c_guid!=''&&$c_ip!=''&&$c_date!='')
				{
				//	if everything went fine, then put them into DB
				//	first check if logid of png already exist
				$sql_select	=	"SELECT `id` FROM `logs` WHERE `logid`='".$logid."' AND `fid`='".$c_fid."'";
				$sql 		=	mysql_query($sql_select);
				if(mysql_num_rows($sql)>=1)
				{
					//	update data
					$sql_update	=	"UPDATE `logs` SET `md5`='".$c_md5."',`guid`='".$c_guid."',`ip`='".$c_ip."',`date`='".$c_date."' WHERE `logid`='".$logid."' AND `fid`='".$c_fid."' ";
					$sql_2		=	mysql_query($sql_update);
				}
				else
				{
					//	create data
					$sql_insert	=	"INSERT INTO `logs` (`logid`,`fid`,`md5`,`guid`,`ip`,`date`) VALUES ('".$logid."','".$c_fid."','".$c_md5."','".$c_guid."','".$c_ip."','".$c_date."')";
					$sql_2		=	mysql_query($sql_insert);
				}
				}


			}
		}
	}
	}
	else 
	{
		return false;
	}

}

//	get extra info from logs
//	new function since 1.2.2.1
function get_extra_log_data($fid)
{
	//	first get info from png file self
	$sql_select	=	"SELECT `guid` FROM `screens` WHERE `fid`='".$fid."' ORDER BY `date` DESC LIMIT 0,1";
	$sql		=	mysql_query($sql_select);
	if(mysql_numrows($sql)>=1)
	{
		while ($row	=	mysql_fetch_object($sql))
		{
			$guid	=	$row->guid;				
		}
		
		//	get info from log files
		$sql_select2	=	"SELECT `md5`,`ip` FROM `logs` WHERE `fid`='".$fid."' AND `guid`='".$guid."' ORDER BY `date` DESC LIMIT 0,1";
		$sql_2 			=	mysql_query($sql_select2);
		//	if there is match, then get md5 and ip
		if(mysql_num_rows($sql_2)>=1)
		{
			while ($row	=	mysql_fetch_object($sql_2))
			{
				$md5	=	$row->md5;
				$ip		=	$row->ip;	
			}
			
			$data	=	array($md5,$ip);
			return $data;
		}
		else 
		{
			return false;	
		}
	}
	else 
	{
		return false;	
	}
	
	
}

//	new feature since version 1.0.2.2
############################

function get_md5($file)
{
	return(md5_file($file));
}


//	new function (since 1.2.2.1) to place a request for an update
function set_request()
{

	// first check whether there already is an entry
	
	$sql_select = "SELECT `request_update` FROM `admin`";
	$sql		=	mysql_query($sql_select);
	if(mysql_num_rows($sql)>0)
	{
		$sql_update	=	"UPDATE `admin` SET `request_update`='1'";
		$sql 		=	mysql_query($sql_update);
	}
	else 
	{
		$sql_insert = "INSERT INTO `admin` (`request_update`) VALUES ('1')";
		$sql		=	mysql_query($sql_insert);
	}
	
	// send mail if someone requested an update
	if (ADMIN_MAIL!='')
	{
		$subj = "PBSViewer: Update Requested";
		$msg  = "Dear Admin,\n\n";
		$msg .= "An update for PBSViewer has been requested by an user.\n";
		$msg .= "Please update PBSViewer, use this link to update:\n";
		$msg .= $_SERVER["SERVER_NAME"].dirname($_SERVER['PHP_SELF'])."/update.php\n\n";
		$msg .= "User ip: ".$_SERVER['REMOTE_ADDR']."\n";
		$msg .= "User agent information: ".$_SERVER['HTTP_USER_AGENT']."\n";
		if (isset($_SERVER['HTTP_REFERER']))
		{
			$msg .= "User's previous page: ".$_SERVER['HTTP_REFERER']."\n";
		}
		
		$msg .= "\n";
		$msg .= "---------------------------------";
		$msg .= "\n\nThis message was generated automatically. If you do not wish to receive those notifications,\nplease go to your ACP and leave the 'admin mail' field empty.\n";
		$msg .= "Click on the link below to go directly to your ACP:\n";
		$msg .= $_SERVER["SERVER_NAME"].dirname($_SERVER['PHP_SELF'])."/ACP.php";
		
		$headers = 'From: PBSViewer@ '.substr($_SERVER['SERVER_NAME'],4).' ' . "\r\n" .
    	'Reply-To: '.ADMIN_MAIL.' ' . "\r\n" .
    	'X-Mailer: PHP/' . phpversion();
		
		send_mail($subj,$msg,$headers);
	}

}

function set_request_false()
{
	$sql_update	=	"UPDATE `admin` SET `request_update`='0'";
	$sql 		=	mysql_query($sql_update);
}


//	new function since 1.2.2.1 to check request status
function get_request_status()
{
	//	as default no request is placed
	//	if false request can take place
	$status	=	false;

	$sql_select	=	"SELECT `request_update` FROM `admin`";
	$sql 		=	mysql_query($sql_select);
	while ($row	=	mysql_fetch_object($sql))
	{
		$status	=	$row->request_update;
	}

	return $status;



}

//	new since version 1.2.2.2
//	this is used for reset button
function reset_pbsviewer($debug=false)
{
	//check if reset is possible
	if(is_reset())
	{
	
	//	first clear download folder
	reset_ftp_web($debug);
	
	//	clear logs on gameserver
	reset_ftp_gameserver_logs($debug);
	
	//	clear screens on gameserver
	reset_ftp_gameserver_screens($debug);
	
	//	truncate database
	reset_db($debug);
	}
}

//	reset db
//	new since version 1.2.2.2
function reset_db($debug)
{
	$db_reset	=	true;	
	
	$sql_del	=	"TRUNCATE TABLE `dl_screens`";
	if(!mysql_query($sql_del))	$db_reset	=	false;
		
	$sql_del	=	"TRUNCATE TABLE `screens`";
	if(!mysql_query($sql_del)) $db_reset	=	false;
		
	$sql_del	=	"TRUNCATE TABLE `screens_old`";
	if(!mysql_query($sql_del)) $db_reset	=	false;
		
	$sql_del	=	"TRUNCATE TABLE `logs`";
	if(!mysql_query($sql_del)) $db_reset	=	false;
		
	$sql_del	=	"TRUNCATE TABLE `admin`";
	if(!mysql_query($sql_del)) $db_reset	=	false;
		
	if($db_reset)
	{
		if($debug==true)
		{
			echo date('H:i:s] ').'<li>Cleaned database</li><br>';
		}
	}
	
}

//	new since version 1.2.2.2
//	general function to remove data
function reset_ftp_web($debug)
{
	$right_dir	=	false;
	$del_count	=	0;
	
	if($connect	=	ftp_connect(FTP_HOST_WEB,FTP_PORT_WEB))
	{
		if($login		=	ftp_login($connect,FTP_USER_WEB,FTP_PASS_WEB))
		{				
			//	change dir
			if(ftp_chdir($connect,PBSViewer_download))
			{
				if($list	=	ftp_nlist($connect,'.'))
				{
					//	first check if we are in the right dir
					foreach ($list	as $file)
					{
						if($file==md5('download_pbsviewer')) $right_dir=true;
					}
					
					if($right_dir)
					{
						//	get req number of files which need to be deleted
						//	don't take the md5 identifier file into account!
						$req_del_count	=	count($list)-1;
						
						//	now remove the files in it
						foreach ($list	as $file)
						{
							if($file!=md5('download_pbsviewer'))
							{
								if(ftp_delete($connect,$file)) $del_count++;
							}
						}
						if ($del_count==0)
						{
							if($debug==true)
							{
								echo date('H:i:s] ').'<li>No files were removed from your download folder</li><br>';
							}	
						}
						elseif($req_del_count==$del_count)
						{
							if($debug==true)
							{
								echo date('H:i:s] ').'<li>All('.$req_del_count.') files on your webserver in folder download were deleted</li><br>';
							}							
						}
						else
						{
							if($debug==true)
							{
								echo date('H:i:s] ').'<li>Not all files on your webserver in folder download were deleted, only '.$del_count.' files were deleted</li><br>';
							}
						}
						
					}
					else 
					{
						if($debug==true)
						{
							echo date('H:i:s] ').'<li>Directory '.PBSViewer_download.' seems to be the wrong directory, did not delete any files</li><br>';
						}
					}
				}
				else 
				{
					if($debug==true)
					{
						echo date('H:i:s] ').'<li>No files were removed from your download folder</li><br>';
					}
				}
			}
			else 
			{
				if($debug==true)
				{
					echo date('H:i:s] ').'<li>Failed to change directory to: '.PBSViewer_download.' </li><br>';
				}
			}
		}
		else 
		{
			if($debug==true)
			{
				echo date('H:i:s] ').'<li>Can\'t login on ftp webserver, please check username and password again in your config</li><br>';
			}
		}
	
	}
	else 
	{
		if($debug==true)
		{
			echo date('H:i:s] ').'<li>Can\'t connect to ftp webserver, please check ip and port in your config</li><br>';
		}
	}

	ftp_close($connect);
}

//	new since version 1.2.2.2
//	general function to remove data
//	$pb_dir_type=/svss 
//	or $pb_dir_type=/svlogs
function reset_ftp_gameserver_logs($debug)
{
	$del_count	=	0;
	
	$dir	=	PBDIR.'/svlogs';
	
	if($connect	=	ftp_connect(FTP_HOST,FTP_PORT))
	{
		if($login		=	ftp_login($connect,FTP_USER,FTP_PASS))
		{				
			//	change dir
			if(ftp_chdir($connect,$dir))
			{
				if($list	=	ftp_nlist($connect,'.'))
				{		
						//	get req number of files which need to be deleted
						$req_del_count	=	count($list);
						
						//	now remove the files in it
						foreach ($list	as $file)
						{
							if(preg_match("~^[0-9]+\.log$~",$file))
							{	
								if(ftp_delete($connect,$file)) $del_count++;
							}
						}
						
						if($req_del_count==$del_count)
						{
							if($debug==true)
							{
								echo date('H:i:s] ').'<li>All('.$req_del_count.') log files on your gameserver were deleted</li><br>';
							}							
						}
						elseif ($del_count==0)
						{
							if($debug==true)
							{
								echo date('H:i:s] ').'<li>No log files located on your gameserver</li><br>';
							}								
						}
						else
						{
							if($debug==true)
							{
								echo date('H:i:s] ').'<li>Not all log files on your gameserver were deleted, only '.$del_count.' log files were deleted</li><br>';
							}
						}
				}
				else 
				{
					if($debug==true)
					{
						echo date('H:i:s] ').'<li>No log files located on your gameserver</li><br>';
					}	
				}
			}
			else 
			{
				if($debug==true)
				{
					echo date('H:i:s] ').'<li>Failed to change directory to: '.$dir.' </li><br>';
				}
			}
		}
		else 
		{
			if($debug==true)
			{
				echo date('H:i:s] ').'<li>Can\'t login on ftp gameserver, please check username and password again in your config</li><br>';
			}
		}
	
	}
	else 
	{
		if($debug==true)
		{
			echo date('H:i:s] ').'<li>Can\'t connect to ftp gameserver, please check ip and port in your config</li><br>';
		}
	}

	ftp_close($connect);
}

//	new since version 1.2.2.2
//	general function to remove data
//	$pb_dir_type=/svss 
//	or $pb_dir_type=/svlogs
function reset_ftp_gameserver_screens($debug)
{
	$del_count	=	0;
	
	$dir	=	PBDIR.'/svss';
	
	if($connect	=	ftp_connect(FTP_HOST,FTP_PORT))
	{
		if($login		=	ftp_login($connect,FTP_USER,FTP_PASS))
		{				
			//	change dir
			if(ftp_chdir($connect,$dir))
			{
				if($list	=	ftp_nlist($connect,'.'))
				{		
						//	get req number of files which need to be deleted
						$req_del_count	=	count($list);
						
						//	now remove the files in it
						foreach ($list	as $file)
						{
							if(preg_match("~^pb[0-9]+\.htm$~",$file)||preg_match("~^pb[0-9]+\.png$~",$file)||$file=='pbsvss.htm')
							{	
								if(ftp_delete($connect,$file)) $del_count++;
							}
						}
						
						if($req_del_count==$del_count)
						{
							if($debug==true)
							{
								echo date('H:i:s] ').'<li>All('.$req_del_count.') files in your svss screenshots directory on your gameserver were deleted</li><br>';
							}							
						}
						elseif ($del_count==0)
						{
							if($debug==true)
							{
								echo date('H:i:s] ').'<li>No files on gameserver in your svss screenshots directory</li><br>';
							}								
						}						
						else
						{
							if($debug==true)
							{
								echo date('H:i:s] ').'<li>Not all files in your svss screenshots directory on your gameserver were deleted, only '.$del_count.' files in your svss screenshots directory were deleted</li><br>';
							}
						}
				}
				else 
				{
					if($debug==true)
					{
						echo date('H:i:s] ').'<li>No files on gameserver in your svss screenshots directory</li><br>';
					}	
				}
			}
			else 
			{
				if($debug==true)
				{
					echo date('H:i:s] ').'<li>Failed to change directory to: '.$dir.' </li><br>';
				}
			}
		}
		else 
		{
			if($debug==true)
			{
				echo date('H:i:s] ').'<li>Can\'t login on ftp gameserver, please check username and password again in your config</li><br>';
			}
		}
	
	}
	else 
	{
		if($debug==true)
		{
			echo date('H:i:s] ').'<li>Can\'t connect to ftp gameserver, please check ip and port in your config</li><br>';
		}
	}

	ftp_close($connect);
}

//	new since version 1.2.2.2
//	first check if reset button can be used
//	can only be used if web login details are known
function is_reset()
{
	if(RESET==true)
	{
		//	check ftp web data is not empty
		if(FTP_HOST_WEB!=''&&FTP_PORT_WEB!=''&&FTP_USER_WEB!=''&&FTP_PASS_WEB!=''&&PBSViewer_download!='')
		{
			return true;
		}
		else 
		{
			return false;
		}
		
	}
	else 
	{
		return false;
	}
}


//new in version 1.2.2.3
// get browser info
function get_browser_info()
{
	$browser = "unknown";
	
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if (eregi("firefox",$user_agent))
	{
		$browser = "firefox";
	}
	elseif (eregi("chrome",$user_agent))
	{
		$browser = "chrome";
	}
	elseif (eregi("MSIE",$user_agent))
	{
		$browser = "IE";
	}
	else 
	{
		$browser = "unknown";
	}
	
	return $browser;
}

// this function is new since version 2.0.0.0
function send_mail($subject,$msg,$headers)
{

	$to      = ADMIN_MAIL;
	mail($to, $subject, $msg,$headers);
}

// get languages
// new since version 2.0.0.0
function get_langs()
{
	$langDIR	=	"inc/languages";
	$i=0;
	if($files = @scandir($langDIR))
	{
		foreach ($files as $file)
		{
			if($file!='.' && $file!='..')
			{
				$language[$i]	=	substr($file,0,strlen($file)-8);
				$i++;
			}
		}
		
		//	if there are language files available
		if ($i>0)
		{			
			return $language;
		}
		else 
		{
			//	language directory is empty
			return false;
		}
	}
	else 
	{
		//no languages, can't read language directory
		return false;
	}
	
}

//	new since version 2.0.0.0
//	get current language
function get_current_lang()
{
	$sql_select	=	"SELECT `name`,`value` FROM `settings` WHERE `name`='language'";
	$sql 		=	mysql_query($sql_select);
	while ($row = mysql_fetch_object($sql))
	{
		$current_lang	=	$row->value;
	}
	
	return $current_lang;
}

// 	changed in version 2.0.0.0
//	see if there is a new version
function check_version()
{
	$new=1;

	$nfo_data	=	file('http://beesar.com/pbs_viewer/nfo');
	$version	=	file('VERSION');
	
	if($nfo_data[2]!='')
	{
		// check local version against version on beesar
		intval($version[1])>=intval($nfo_data[2]) ? $new=true : $new=false;
	}

	return $new;

}

?>