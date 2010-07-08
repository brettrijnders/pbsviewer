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

// English language
$language								=	"English";

//----------------PAGE INFO-------------------
$str["TITLE"] 							=	"PBsViewer of ".CLAN_TAG." capturing screens of ".CLAN_GAME;
$str["META_DESC"] 						=	"See captured punkbuster screenshots online with PBsViewer. Those screens are captured on gameserver of ".CLAN_NAME." which runs ".CLAN_GAME;


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
$str["DETSCRN_ALIASES"]					=	"Aliases";
$str["DETSCRN_ALIASES_2"]				=	"This player has";
$str["DETSCRN_ALIASES_3"]				=	"other names";
$str["DETSCRN_TAKEN"]					=	$str["POP_TAKEN"];
$str["DETSCRN_GUID"]					=	$str["POP_GUID"];
$str["DETSCRN_GUID_SHORT"]				=	"GUID_short";
$str["DETSCRN_IP"]						=	"IP player";
$str["DETSCRN_MD5_VALID"]				=	$str["POP_MD5_VALID"];
$str["DETSCRN_MD5_INVALID"]				=	$str["POP_MD5_INVALID"];
$str["DETSCRN_MD5_SCREEN"]				=	$str["POP_MD5_SCREEN"];
$str["DETSCRN_MD5_LOG"]					=	$str["POP_MD5_LOG"];
$str["DETSCRN_MD5_HASH"]				=	$str["POP_MD5_HASH"];
$str["DETSCRN_BACK"]					=	"Go back";

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
$str["UPD8_"]							=	"";

//----------------ACP PAGE-------------------


//---------------------------------------------
//REMAINING MESSAGES
//---------------------------------------------

//----------------ERROR MSG-------------------



//----------------MISC-------------------
$str["MISC_ACCESS_DENIED"] 				= 	"ACCES DENIED!";
$str[""] = "";


$str[""] = "";
$str[""] = "";
$str[""] = "";
$str[""] = "";

?>