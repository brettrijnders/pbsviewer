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

// English language
$language								=	"English";

//----------------PAGE INFO-------------------
$str["TITLE"] 							=	"Punkbuster (PB) Screenshot Viewer (PBSViewer) of ".CLAN_TAG." capturing screens of ".CLAN_GAME;
$str["META_DESC"] 						=	"See captured punkbuster screenshots online with PBsViewer. Those screens are captured on gameserver of ".CLAN_NAME." which runs ".CLAN_GAME;

//----------------LOGIN-------------------
$str["LOGIN_WELCOME"]					=	"Welcome";
$str["LOGOUT_HEADER_MAIN"]				=	"Logout";
$str["LOGIN_HEADER_MAIN"]				=	"Login";
$str["LOGIN_MENU_TITLE"]				=	"Login";
$str["LOGIN_MENU_USERNAME"]				=	"Username";
$str["LOGIN_MENU_PASSWORD"]				=	"Password";
$str["LOGIN_MENU_BUTTON"]				=	"Login";
$str["LOGIN_MENU_FORGOT"]				=	"Forgot password or name?";
$str["LOGIN_FAIL_TITLE"]				=	"Login failed";
$str["LOGIN_FAIL_MSG"]					=	"Failed to login, please check your username and/or password.";
$str["LOGIN_GO_BACK"]					=	"Click here to go back.";
$str["LOGOUT_TITLE"]					=	"Logged out";
$str["LOGOUT_MSG"]						=	"You are logged out successfully, you will be redirected to the main page.";
$str["LOGOUT_MSG_2"]					=	"If you can not wait then click here to go to the main page.";
$str["LOGIN_RESET_TITLE"]				=	"Reset password";
$str["LOGIN_RESET_MSG"]					=	"Fill in your mail address in case you forgot your username and/or password. This mail will contain your username and a link that can be used to reset your password";
$str["LOGIN_RESET_SUBMIT"]				=	"Submit";
$str["LOGIN_CORRECT_MAIL_TITLE"]		=	"Reset";
$str["LOGIN_CORRECT_MAIL_MSG"]			=	"Mail has been sent to";
$str["LOGIN_CORRECT_MAIL_MSG_2"]		=	"Click on the link in your mail to reset your password.";
$str["LOGIN_INVALID_MAIL_TITLE"]		=	"Reset - Invalid mail";
$str["LOGIN_INVALID_MAIL_MSG"]			=	"Sorry could not find your mail, please check if you used the correct mail address.";
$str["LOGIN_RESET_SUCC_TITLE"]			=	"Password Resetted";
$str["LOGIN_RESET_SUCC_MSG"]			=	"Your password have been resetted succesfully.";
$str["LOGIN_RESET_SUCC_MSG_2"]			=	"Please";
$str["LOGIN_RESET_SUCC_MSG_3"]			=	"login";
$str["LOGIN_RESET_SUCC_MSG_4"]			=	"with the following username and password";
$str["LOGIN_RESET_SUCC_MSG_5"]			=	"Once you are logged in please change your password in the ACP.";
$str["LOGIN_VISITOR_TITLE"]				=	"Access Denied - Private PBSViewer";
$str["LOGIN_VISITOR_INVALID_MSG"]		=	"Password is invalid, please check your password.";
$str["LOGIN_SUCCESS_TITLE"]				=	"Logged in";
$str["LOGIN_SUCCESS_MSG"]				=	"You are now logged in successfully, you will be redirected to the main page.";
$str["LOGIN_SUCCESS_MSG_2"]				=	"If you can not wait then click here to go to the main page.";


//----------------SEARCH MENU-------------------
$str["SM_NAME"] 						=	"name";
$str["SM_FILENAME"] 					=	"filename";
$str["SM_GUID"] 						=	"guid";
$str["SM_SEARCH"] 						=	"Search";
$str["SM_WILDCARD"]						=	"for wildcard use *";
$str["SM_SHOW_ALL"] 					=	"Show all";
$str["SM_SELECT"] 						=	"Select";
$str["SM_SHOW_ALL_AVAILABLE"] 			=	"Show all available";
$str["SM_ALL_YEARS"] 					=	"All years";
$str["SM_ALL_MONTHS"]					=	"All months";
$str["SM_ALL_DAYS"] 					=	"All days";
$str["SM_ALL_HOURS"] 					= 	"All hours";

//----------------STATS MENU-------------------
// below search menu
$str["STAT_UNIQUE_PLAYERS"] 			= 	"Unique players";
$str["STAT_MOST_SCREENS"] 				= 	"Player with most pb screens";
$str["STAT_MOST_INC_SCREENS"] 			= 	"Player with most incomplete screens";
$str["STAT_TOTAL_COMPLETE"] 			= 	"Total complete screens";
$str["STAT_TOTAL_INCOMPLETE"]			= 	"Total incomplete screens";
$str["STAT_CURRENT_WIN_SCREENS"]		= 	"Screens shown in current window";

//----------------POPUP SCREEN INFO-------------------
$str["POP_FILE"] 						= 	"File";
$str["POP_PLAYER"] 						= 	"Player";
$str["POP_GUID"] 						= 	"GUID";
$str["POP_TAKEN"] 						= 	"Taken";
$str['POP_IP']							=	"IP";
$str["POP_MD5_VALID"]					=	"MD5 hash (VALID)";
$str["POP_MD5_INVALID"]					=	"MD5 hash mismatch!";
$str["POP_MD5_SCREEN"]					=	"MD5 hash screen";
$str["POP_MD5_LOG"]						=	"md5 hash log";
$str["POP_MD5_HASH"] 					= 	"MD5 hash";
$str["POP_NOT_AVAILABLE"] 				= 	"n/a";

//----------------DETAILED SCREEN INFO-------------------
$str["DETSCRN_FILE"]					=	$str["POP_FILE"];
$str["DETSCRN_PLAYER"]					=	$str["POP_PLAYER"];
$str["DETSCRN_CB"]						=	"CB link";
$str["DETSCRN_GGC"]						=	"GGC-stream";
$str["DETSCRN_ALIASES"]					=	"Aliases";
$str["DETSCRN_ALIASES_2"]				=	"This player has";
$str["DETSCRN_ALIASES_3"]				=	"other name(s)";
$str["DETSCRN_TAKEN"]					=	$str["POP_TAKEN"];
$str["DETSCRN_GUID"]					=	$str["POP_GUID"];
$str["DETSCRN_GUID_SHORT"]				=	"GUID_short";
$str["DETSCRN_IP"]						=	"IP player";
$str["DETSCRN_MD5_VALID"]				=	$str["POP_MD5_VALID"];
$str["DETSCRN_MD5_INVALID"]				=	$str["POP_MD5_INVALID"];
$str["DETSCRN_MD5_SCREEN"]				=	$str["POP_MD5_SCREEN"];
$str["DETSCRN_MD5_LOG"]					=	$str["POP_MD5_LOG"];
$str["DETSCRN_MD5_HASH"]				=	$str["POP_MD5_HASH"];
$str["DETSCRN_MORE_INFO"]				=	"Search player";
$str["DETSCRN_MORE_INFO_GOOGLE"]		=	"Google";
$str["DETSCRN_MORE_INFO_XFIRE"]			=	"Xfire";
$str["DETSCRN_SHOW_MORE"]				=	"Show more screens of this player";
$str["DETSCRN_BACK"]					=	"Go back";

//----------------DETAILED SCREEN INFO TOOLS-------------------
$str["DETSCRN_TOOLS_PREV_COMMENT"]		=	"Go to previous screenshot";
$str["DETSCRN_TOOLS_SAVE_COMMENT"]		=	"Save original screen.";
$str["DETSCRN_TOOLS_ZOOM_TITLE"]		=	"Enable/Disable Zoom";
$str["DETSCRN_TOOLS_ZOOM_COMMENT"]		=	"Increase zoom ratio by dragging mouse upwards.";
$str["DETSCRN_TOOLS_ZOOM_COMMENT_2"]	=	"Decrease zoom ratio by dragging mouse downwards.";
$str["DETSCRN_TOOLS_ZOOM_COMMENT_3"]	=	"Increase zoom window by dragging mouse to the right.";
$str["DETSCRN_TOOLS_ZOOM_COMMENT_4"]	=	"Decrease zoom window by dragging mouse to the left.";
$str["DETSCRN_TOOLS_ZOOM_COMMENT_5"]	=	"You are using Opera, probably this zoom fuction will not work when you activate it.";
$str["DETSCRN_TOOLS_GAMMA_PLUS"]		=	"Apply gamma correction, by clicking on this button you can increase the amount of gamma.";
$str["DETSCRN_TOOLS_GAMMA_MIN"]			=	"Apply gamma correction, by clicking on this button you can decrease the amount of gamma.";
$str["DETSCRN_TOOLS_GAMMA_NEGATIVE"]	=	"Reverse all the colours of the image, get a negative of the screen.";
$str["DETSCRN_TOOLS_NEXT_COMMENT"]		=	"Go to next screenshot";


//----------------FOOTER-------------------
$str["FOOTER_GO_UP"] 					= 	"^^^ go up ^^^";
$str["FOOTER_REQUEST_UPDATE"] 			= 	"Request update";
$str["FOOTER_PAGE_GENERATED"] 			= 	"Page generated in";
$str["FOOTER_SECONDS"] 					= 	"seconds";
$str["FOOTER_FILE_UPDATED"] 			= 	"File updated";
$str["FOOTER_FILE_UPDATED_2_SECONDS"] 	= 	"seconds ago";
$str["FOOTER_FILE_UPDATED_2_MINUTES"] 	= 	"minutes ago";
$str["FOOTER_FILE_UPDATED_2_HOURS"] 	= 	"hours ago";
$str["FOOTER_FILE_UPDATED_2_DAYS"] 		= 	"hours ago";
$str["FOOTER_DAYS"] 					=	 "days";
$str["FOOTER_HOURS"] 					= 	"hours";
$str["FOOTER_MINUTES"] 					= 	"minutes";
$str["FOOTER_SECONDS"] 					= 	"seconds";
$str["FOOTER_NEW_UPDATE"] 				= 	"The file will or can be updated after";
$str["FOOTER_CUSTOM_UPDATE"]			=	"Ask admin of this website to update the screens if they are old";

//---------------------------------------------
//ADMIN FUNCTIONS
//---------------------------------------------

//----------------ADMIN MENU-------------------
$str["ADM_ADMIN"] 						= 	"Admin";
$str["ADM_UPDATE"] 						= 	"Update";
$str["ADM_RESET"] 						= 	"Reset";
$str["ADM_ACP"] 						= 	"ACP";
$str["ADM_NEW_MSG"] 					= 	"New message";
$str["ADM_UPDATE_REQ"] 					= 	"An user has requested an update, you can update by clicking on update below";

//----------------RESET PAGE-------------------
$str["RESET_TITLE"]						=	"Resetting Page";
$str["RESET_TITLE_MENU"]				=	"Resetting";
$str["RESET_FINISHED"]					=	"RESET FINISHED";
$str["RESET_DURATION"]					=	"Reset took";
$str["RESET_DURATION_2"]				=	"seconds";
$str["RESET_GO_BACK"]					=	"Click here to go back";
$str["RESET_BUTTON"]					=	"Reset";
$str["RESET_WARNING_QUESTION"]			=	"If you are experiencing long load times for your website, then a reset may help. Are you sure you want to delete all data?";
$str["RESET_WARNING_RESULT"]			=	"If you click on Reset, the following will happen";
$str["RESET_RESULT_1"]					=	"All screens are removed from you download folder on your webserver";
$str["RESET_RESULT_2"]					=	"All logs and screens on your gameserver will be removed";
$str["RESET_RESULT_3"]					=	"The database will be cleaned";

//----------------UPDATE PAGE-------------------
$str["UPD8_TITLE"]						=	"Update Page";
$str["UPD8_TITLE_MENU"]					=	"UPDATING";
$str["UPD8_FINISHED"]					=	"UPDATE FINISHED";
$str["UPD8_DURATION"]					=	"Updating took";
$str["UPD8_DURATION_2"]					=	"seconds";
$str["UPD8_BACK"]						=	$str["RESET_GO_BACK"];


//----------------ACP PAGE-------------------
$str["ACP_TITLE"]						=	"Admin Control Panel (ACP)";
$str["ACP_TITLE_MENU"]					=	"Admin Control Panel";
$str["ACP_TITLE_MENU_SAVED"]			=	"Saving settings";
$str["ACP_SAVED"]						=	"Settings have been saved, you will now be redirected to main page in a couple of seconds";
$str["ACP_WELCOME"]						=	"Welcome Admin, in this control panel you can configure most options. To change login details for ftp gameserver or ftp webhosting  please edit 'config.inc.php' manually";
$str["ACP_BACK"]						=	"Click here to go back";
$str["ACP_USER"]						=	"User";
$str["ACP_USERNAME"]					=	"username";
$str["ACP_PASS"]						=	"password";
$str["ACP_PASS_COMMENT"]				=	"Only fill in if you want to change your password.";
$str["ACP_PRIV_PASS"]					=	"Private password";
$str["ACP_PRIV_PASS_COMMENT"]			=	"Only fill in if you want to make PBSViewer private. Only users who enter the correct password can use PBSViewer, however they do not have admin rights.";
$str["ACP_ADMIN_MAIL"]					=	"Admin mail";
$str["ACP_ADMIN_MAIL_COMMENT"]			=	"Mail address is required, will be used in case you lost your password.";
$str["ACP_NOTIFY_UPDATE"]				=	"Notify on update request";
$str["ACP_NOTIFY_UPDATE_COMMENT"]		=	"Only check if you want to be notified when someone has requested an update, you will receive a notification mail.";
$str["ACP_CRON_KEY"]					=	"Cron user key";
$str["ACP_CRON_COMMENT"]				=	"Use this key if you want to update through cronjob. You should use the key as follows (including the space): <br>";
$str["ACP_CLAN"]						=	"Clan";
$str["ACP_CLAN_NAME"]					=	"Clan name";
$str["ACP_CLAN_NAME_COMMENT"]			=	"What is your full clan name?";
$str["ACP_CLAN_TAG"]					=	"Clan Tag";
$str["ACP_CLAN_COMMENT"]				=	"Your clantag ingame?";
$str["ACP_CLAN_GAME"]					=	"Clan Game";
$str["ACP_CLAN_GAME_CONTENT"]			=	"Which game are you playing. So what is your gameserver running?";
$str["ACP_CLAN_GAME_SHORT"]				=	"Clan Game short";
$str["ACP_CLAN_GAME_SHORT_COMMENT"]		=	"What is your game name in short?";
$str["ACP_UPDATE"]						=	"Update";
$str["ACP_PB_DIR"]						=	"PB directory";
$str["ACP_PB_DIR_COMMENT"]				=	"Directory of punkbuster on your ftp gameserver.";
$str["ACP_PB_DIR_COMMENT_2"]			=	"Use '/' and don't use 'pb/' with a trailing slash.";
$str["ACP_PB_SS_DIR"]					=	"PB screenshot directory name";
$str["ACP_PB_SS_DIR_COMMENT"]			=	"Default = svss. The name of your PB screenshot directory";
$str["ACP_PB_LOG_DIR"]					=	"PB log directory name";
$str["ACP_PB_LOG_DIR_COMMENT"]			=	"Default = svlogs. The name of your PB log directory";
$str["ACP_CUSTOM_UPDATE"]				=	"Custom update";
$str["ACP_CUSTOM_UPDATE_COMMENT_1"]		=	"If 'custom update' is true then the admin or a cron job should run 'update.php'.";
$str["ACP_CUSTOM_UPDATE_COMMENT_2"]		=	"If option is false, then it will update after x seconds, this can be configured with 'Update time' see below.";
$str["ACP_CUSTOM_UPDATE_COMMENT_3"]		=	"You still have the possibility to force an update manually by running 'update.php' if you want.";
$str["ACP_UPDATE_TIME"]					=	"Update time";
$str["ACP_UPDATE_TIME_COMMENT"]			=	"The update time is in seconds. Use a small update time if gameserver is crowded (since a lot of new screens are captured), for example a public gameserver. However keep in mind that bandwith will also increase if update time is smaller. Recommended: 86400 seconds";
$str["ACP_PB_SSCEILING"]				=	"pb_sv_SsCeiling";
$str["ACP_PB_SSCEILING_COMMENT_1"]		=	"To find your number open this file 'pbsv.cfg' and look for 'pb_sv_SsCeiling'. The file should be located in your 'pb' directory on your ftp of your gameserver.";
$str["ACP_PB_SSCEILING_COMMENT_2"]		=	"It is recommended to have a small amount as possible to save some bandwith and space. NB both values of 'pb_sv_SsCeiling' as in 'pbsv.cfg' and here should be the same";
$str["ACP_PB_SSCEILING_COMMENT_3"]		=	"If you are not sure please take a large number like 10000 or ask help";
$str["ACP_PB_SSCEILING_COMMENT_4"]		=	"Game-violations has set this number to 10000";
$str["ACP_PB_SSCEILING_COMMENT_5"]		=	"PB default is 100";
$str["ACP_PBSV_DOWNLOAD_DIR"]			=	"PBSV download dir";
$str["ACP_PBSV_DOWNLOAD_DIR_COMMENT"]	=	"If you connect to your webserver through FTP, what is the location of the download folder of PBSViewer? copy past or type your path directly after login";
$str["ACP_PBSV_DOWNLOAD_DIR_COMMENT_2"]	=	"omit trailing slash /";
$str["ACP_RESET"]						=	"Reset";
$str["ACP_RESET_COMMENT_1"]				=	"Default	=	false. Reset feature allows admins to delete all screens and log files from your webserver and gameserver.";
$str["ACP_RESET_COMMENT_2"]				=	"In order to use this function you need to configure the login details of your ftp webhosting in config.inc.php.";
$str["ACP_PBSVSS_UPDATER"]				=	"pbsvss_updater";
$str["ACP_PBSVSS_UPDATER_COMMENT"]		=	"Default=false. pb keeps logging screenshots data to pbsvss.htm, it places the newest entries at the end of this file. However pb does not remove old data, so this file will keep on growing in size. If you choose true, then old entries will be removed automatically. This will keep the filesize at a small size.";
$str["ACP_PBSVSS_IU"]					=	"Incremental update";
$str["ACP_PBSVSS_IU_COMMENT"]			=	"Default=false. If true, PBSViewer will use incremental update. It will update the files step by step using multiple update cycles. This might solve the issue when execution time of the update method is exceeding the maximum specified execution time. Next to this it prevents server overload or getting internal 500 server errors when doing an update.";
$str["ACP_PBSVSS_IU_NR_SCREENS"]		=	"Number of screens (IU)";
$str["ACP_PBSVSS_IU_NR_SCREENS_COMMENT"]=	"Number of screens to download with Incremental Update (IU) during each update cycle.";
$str["ACP_PBSVSS_IU_NR_LOGS"]			=	"Number of logs (IU)";
$str["ACP_PBSVSS_IU_NR_LOGS_COMMENT"]	=	"Number of log files to download with Incremental Update (IU) during each update cycle.";
$str["ACP_PBSVSS_IU_UPDATE_TIME"]		=	"Update time (IU)";
$str["ACP_PBSVSS_IU_UPDATE_TIME_COMMENT"]=	"Maximum time for each update cycle for Incremental update.";
$str["ACP_PBSVSS_IU_WAIT_TIME"]			=	"Wait time (IU)";
$str["ACP_PBSVSS_IU_WAIT_TIME_COMMENT"]	=	"Time to wait before continuing with next update cycle.";
$str["ACP_LOGGING"]						=	"Logging";
$str["ACP_PB_LOG"]						=	"PB_log";
$str["ACP_PB_LOG_COMMENT_1"]			=	"Gather more info about screens, like md5 check or ip address of players, with help of logs";
$str["ACP_PB_LOG_COMMENT_2"]			=	"Default	=	false, If you don't want logging select false.";
$str["ACP_PB_LOG_COMMENT_3"]			=	"Note that the FTP webhost (not your gameserver) login details needs to be configured correctly in 'config.inc.php' if you want to use logging.";
$str["ACP_MAX_LOGS"]					=	"max logs on webserver";
$str["ACP_MAX_LOGS_COMMENT_1"]			=	"Default	=	4, 'max logs on webserver' needs to be lower than PB_SV_LogCeiling. Otherwise there won't be an auto-delete. This is the number of logs stored on your webserver";
$str["ACP_MAX_LOGS_COMMENT_2"]			=	"If you choose 0, then log files are deleted immediately after updating";
$str["ACP_MAX_LOGS_COMMENT_3"]			=	"If you don't want to delete the logs from your webserver then enter -1";
$str["ACP_AUTO_DEL_LOG_GS"] 			=	"Auto del log gameserver";
$str["ACP_AUTO_DEL_LOG_GS_COMMENT"]		=	"Default	=	false, automatically delete log files from your gameserver. A good reason to delete your log files is that it saves space and it reduces your bandwidth drastically when downloading your log files.";
$str["ACP_TEMPLATE"]					=	"Template";
$str["ACP_SCREENS_MAIN"]				=	"Screens on main page";
$str["ACP_SCREENS_MAIN_COMMENT"]		=	"Default=10, on the main page the latest x screens are shown to save some bandwith.";
$str["ACP_SCREENS_SEARCH"]				=	"Show nr of screens per page";
$str["ACP_SCREENS_SEARCH_COMMENT"]		=	"Enter the number of screens you want to show on each page for each search result.";
$str["ACP_SCREENS_PER_ROW"]				=	"Screens per row";
$str["ACP_SCREENS_PER_ROW_COMMENT"]		=	"Amount of screens you want to have on each row";
$str["ACP_IMG_W"]						=	"Image width";
$str["ACP_IMG_W_COMMENT"]				=	"Thumbnail image width";
$str["ACP_IMG_H"]						=	"Image height";
$str["ACP_IMG_H_COMMENT"]				=	"Thumbnail image height";
$str["ACP_LANGUAGE"]					=	"Default language";
$str["ACP_CB_GAME"]						=	"CB game";
$str["ACP_THEME"]						=	"PBSViewer theme";
$str["ACP_CB_GAME_COMMENT"]				=	"The games in this list are supported by clanbase, please select the game that is running on your gameserver. This information will be used to automatically find clanbase players (only if he/she has joined cb) for each pb screenshot. select none if you don't want this extra information.";
$str["ACP_CB_NONE"]						=	"none";
$str["ACP_ADVANCED"]					=	"Advanced";
$str["ACP_MIN_SCRN_SIZE"]				=	"Minimal screen download size";
$str["ACP_MIN_SCRN_SIZE_COMMENT"]		=	"Screens with a size smaller than the 'Minimal screen download size' are not downloaded, the size is in bytes.";
$str["ACP_CookieExpTime"]				=	"Cookie experiment time";
$str["ACP_CookieExpTime_COMMENT"]		=	"Sensitive encrypted information for login are stored in cookies. In this field you can specify after how many seconds the cookies should be automatically removed from client's PC. Default is 1 week: 3600*24*7 = 604800 seconds.";
$str["ACP_SCRIPT_LOAD"]					=	"Script load time";
$str["ACP_SCRIPT_LOAD_COMMENT"]			=	"After this the script stops running, if you for instance need to download a lot of screens then it is recommended to have a high script load time. If you are not sure, then use default setting. Default=600 seconds or 10 minutes, after 600 Maximum execution time error will be shown.";
$str["ACP_WEB_LOG_DIR"]					=	"Web log dir";
$str["ACP_WEB_LOG_DIR_COMMENT"]			=	"Relative directory where the log files and screenshots are stored. The directory should be CHMODDED to 777. Only change this if you have moved the download folder to another location.";
$str["ACP_FTP_PASS"]					=	"FTP passive mode";
$str["ACP_FTP_PASS_COMMENT"]			=	"Default=false, ie. non-passive mode. Sometimes it is needed to turn on passive mode to make PBSViewer work. If you are receiving errors related to FTP then you can try if it works with passive mode.";
$str["ACP_DEBUG"]						=	"Debug";
$str["ACP_DEBUG_COMMENT"]				=	"Default is false";
$str["ACP_SAVE"]						=	"Save settings";
$str["ACP_TRUE"]						=	"True";
$str["ACP_FALSE"]						=	"False";

//----------------PRIVATE PBSViewer-------------------
$str['PRIVATE_TITLE']					=	"Access Denied - Private PBSViewer";
$str['PRIVATE_MSG']						=	"This is a private page, only those who know the private password can use PBSViewer. Admin can login by clicking on login (see 'Login' upper right)";
$str['PRIVATE_PASSWORD']				=	"Password";
$str['PRIVATE_LOGIN']					=	"Login";
$str['PRIVATE_CLICK_HERE']				=	"Click here to enter your password";

//---------------------------------------------
//REMAINING MESSAGES
//---------------------------------------------

//----------------ERROR MESSAGES-------------------
$str['ERROR_TITLE']						= 	"Error";
$str['ERROR_SEARCH_1']					= 	"Could not find screen";
$str['ERROR_SEARCH_2']					= 	"Could not find the screen you are looking for";
$str['ERROR_SEARCH_3']					= 	"Please try to search for something else or ask admin for an update if needed.";

//----------------DEBUG MESSAGES-------------------

//----------------MISC-------------------
$str['MISC_ACCESS_DENIED_ADMIN']			=	"You are not allowed to access this page, only admins are allowed to access this page. Please contact the webmaster for more information.";
$str['MISC_ACCESS_DENIED_ADMIN_TITLE']		=	"Access Denied!";
$str['MISC_ACCESS_DENIED_NO_PERM_TITLE']	=	"Access Denied!";
$str['MISC_ACCESS_DENIED_NO_PERM']			=	"You are not allowed to access this page. Please contact the webmaster if you want to access this page.";



?>