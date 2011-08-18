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

	Translation by *Sammygeuner* and *S.llegeuner*
				www.geuner.eu

*/

// German language
$language								=	"Deutsch";

//----------------PAGE INFO-------------------
$str["TITLE"] 							=	"Punkbuster (PB) Screenshot Viewer (PBSViewer) von ".CLAN_TAG." erfasst Bilder von ".CLAN_GAME;
$str["META_DESC"] 						=	"Betrachte erfasste Punkbuster-Screenshots Online mit dem PBsViewer. Diese Bilder wurden auf dem Gameserver von ".CLAN_NAME." erfasst, auf dem ".CLAN_GAME." l&auml;uft";

//----------------LOGIN-------------------
$str["LOGIN_WELCOME"]					=	"Willkommen";
$str["LOGOUT_HEADER_MAIN"]				=	"Abmelden";
$str["LOGIN_HEADER_MAIN"]				=	"Anmelden";
$str["LOGIN_MENU_TITLE"]				=	"Anmelden";
$str["LOGIN_MENU_USERNAME"]				=	"Benutzername";
$str["LOGIN_MENU_PASSWORD"]				=	"Passwort";
$str["LOGIN_MENU_BUTTON"]				=	"Anmelden";
$str["LOGIN_MENU_FORGOT"]				=	"Passwort oder Name vergessen?";
$str["LOGIN_FAIL_TITLE"]				=	"Login fehlgeschlagen";
$str["LOGIN_FAIL_MSG"]					=	"Fehler beim Login, bitte &uuml;berpr&uuml;fe deinen Benutzernamen und/oder dein Passwort.";
$str["LOGIN_GO_BACK"]					=	"Hier klicken, um zur&uuml;ckzugehen.";
$str["LOGOUT_TITLE"]					=	"Abgemeldet";
$str["LOGOUT_MSG"]						=	"Abmelden erfolgreich, du wirst zur Hauptseite weitergeleitet.";
$str["LOGOUT_MSG_2"]					=	"Wenn du nicht warten willst, klick hier um zur Hauptseite zu gehen.";
$str["LOGIN_RESET_TITLE"]				=	"Passwort zur&uuml;cksetzen";
$str["LOGIN_RESET_MSG"]					=	"Trage deine Mail-Adresse ein, wenn du deinen Benutzernamen und/oder dein Passwort vergessen hast. Diese E-Mail enth&auml;lt deinen Benutzernamen und einen Link der benutzt werden kann um dein Passwort zur&uuml;ckzusetzen.";
$str["LOGIN_RESET_SUBMIT"]				=	"Absenden";
$str["LOGIN_CORRECT_MAIL_TITLE"]		=	"Zur&uuml;cksetzen";
$str["LOGIN_CORRECT_MAIL_MSG"]			=	"E-Mail wurde gesendet an";
$str["LOGIN_CORRECT_MAIL_MSG_2"]		=	"Klick auf den Link in deiner E-Mail um das Passwort zur&uuml;ckzusetzen.";
$str["LOGIN_INVALID_MAIL_TITLE"]		=	"Zur&uuml;cksetzen - ung&uuml;ltige E-Mail";
$str["LOGIN_INVALID_MAIL_MSG"]			=	"Sorry, konnte deine E-Mail nicht finden, bitte &uuml;berpr&uuml;fe ob du die richtige E-Mail Adresse benutzt hast.";
$str["LOGIN_RESET_SUCC_TITLE"]			=	"Passwort zur&uuml;ckgesetzt";
$str["LOGIN_RESET_SUCC_MSG"]			=	"Dein Passwort wurde erfolgreich zur&uuml;ckgesetzt.";
$str["LOGIN_RESET_SUCC_MSG_2"]			=	"Bitte";
$str["LOGIN_RESET_SUCC_MSG_3"]			=	"anmelden";
$str["LOGIN_RESET_SUCC_MSG_4"]			=	"mit dem folgenden Benutzernamen und Passwort";
$str["LOGIN_RESET_SUCC_MSG_5"]			=	"Sobald du angemeldet bist &auml;ndere dein Passwort im ACP.";
$str["LOGIN_VISITOR_TITLE"]				=	"Zugriff verweigert - Privater PBSViewer";
$str["LOGIN_VISITOR_INVALID_MSG"]		=	"Passwort ung&uuml;ltig, bitte &uuml;berpr&uuml;fe dein Passwort.";
$str["LOGIN_SUCCESS_TITLE"]				=	"Angemeldet";
$str["LOGIN_SUCCESS_MSG"]				=	"Du hast dich erfolgreich angemeldet, du wirst zur Hauptseite weitergeleitet.";
$str["LOGIN_SUCCESS_MSG_2"]				=	"Wenn du nicht warten kannst, dann klick hier um zur Hauptseite zu gehen.";


//----------------SEARCH MENU-------------------
$str["SM_NAME"] 						=	"Name";
$str["SM_FILENAME"] 					=	"Dateiname";
$str["SM_GUID"] 						=	"GUID";
$str["SM_SEARCH"] 						=	"Suche";
$str["SM_WILDCARD"]						=	"als Wildcard benutze *";
$str["SM_SHOW_ALL"] 					=	"Zeige alle";
$str["SM_SELECT"] 						=	"Ausw&auml;hlen";
$str["SM_SHOW_ALL_AVAILABLE"] 			=	"Zeige alle verf&uuml;gbaren";
$str["SM_ALL_YEARS"] 					=	"Alle Jahre";
$str["SM_ALL_MONTHS"]					=	"Alle Monate";
$str["SM_ALL_DAYS"] 					=	"Alle Tage";
$str["SM_ALL_HOURS"] 					= 	"Alle Stunden";

//----------------STATS MENU-------------------
// below search menu
$str["STAT_UNIQUE_PLAYERS"] 			= 	"Einzelne Spieler";
$str["STAT_MOST_SCREENS"] 				= 	"Spieler mit den meisten PB Bildern";
$str["STAT_MOST_INC_SCREENS"] 			= 	"Spieler mit den meisten unvollst&auml;ndigen Bildern";
$str["STAT_TOTAL_COMPLETE"] 			= 	"Insgesamt vollst&auml;ndige Bilder";
$str["STAT_TOTAL_INCOMPLETE"]			= 	"Insgesamt unvollst&auml;ndige Bilder";
$str["STAT_CURRENT_WIN_SCREENS"]		= 	"Angezeigte Bilder im aktuellen Fenster";

//----------------POPUP SCREEN INFO-------------------
$str["POP_FILE"] 						= 	"Datei";
$str["POP_PLAYER"] 						= 	"Spieler";
$str["POP_GUID"] 						= 	"GUID";
$str["POP_TAKEN"] 						= 	"Erstellt";
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
$str["DETSCRN_CB"]						=	"CB Link";
$str["DETSCRN_ALIASES"]					=	"Aliases";
$str["DETSCRN_ALIASES_2"]				=	"Dieser Spieler hat";
$str["DETSCRN_ALIASES_3"]				=	"andere(n) Name(n)";
$str["DETSCRN_TAKEN"]					=	$str["POP_TAKEN"];
$str["DETSCRN_GUID"]					=	$str["POP_GUID"];
$str["DETSCRN_GUID_SHORT"]				=	"GUID kurz";
$str["DETSCRN_IP"]						=	"IP Spieler";
$str["DETSCRN_MD5_VALID"]				=	$str["POP_MD5_VALID"];
$str["DETSCRN_MD5_INVALID"]				=	$str["POP_MD5_INVALID"];
$str["DETSCRN_MD5_SCREEN"]				=	$str["POP_MD5_SCREEN"];
$str["DETSCRN_MD5_LOG"]					=	$str["POP_MD5_LOG"];
$str["DETSCRN_MD5_HASH"]				=	$str["POP_MD5_HASH"];
$str["DETSCRN_MORE_INFO"]				=	"Suche Spieler";
$str["DETSCRN_MORE_INFO_GOOGLE"]		=	"Google";
$str["DETSCRN_MORE_INFO_XFIRE"]			=	"Xfire";
$str["DETSCRN_SHOW_MORE"]				=	"Zeige mehr Bilder von diesem Spieler";
$str["DETSCRN_BACK"]					=	"Gehe zur&uuml;ck";

//----------------DETAILED SCREEN INFO TOOLS-------------------
$str["DETSCRN_TOOLS_SAVE_COMMENT"]		=	"Speichere original Bild.";
$str["DETSCRN_TOOLS_ZOOM_TITLE"]		=	"Aktiviere/Deaktiviere Zoom";
$str["DETSCRN_TOOLS_ZOOM_COMMENT"]		=	"Maus nach oben ziehen, um Zoom zu erh&ouml;hen.";
$str["DETSCRN_TOOLS_ZOOM_COMMENT_2"]	=	"Maus nach unten ziehen, um Zoom zu verringern.";
$str["DETSCRN_TOOLS_ZOOM_COMMENT_3"]	=	"Maus nach rechts ziehen, um Zoom-Fenster zu vergr&ouml;&szlig;ern.";
$str["DETSCRN_TOOLS_ZOOM_COMMENT_4"]	=	"Maus nach links ziehen, um Zoom-Fenster zu verkleinern.";
$str["DETSCRN_TOOLS_ZOOM_COMMENT_5"]	=	"Du benutzt Opera, wahrscheinlich funktioniert der Zoom nicht wenn du ihn aktivieren willst.";
$str["DETSCRN_TOOLS_GAMMA_PLUS"]		=	"Gamma-Korrektur. Gamma-Wert erh&ouml;hen.";
$str["DETSCRN_TOOLS_GAMMA_MIN"]			=	"Gamma_Korrektur. Gamma-Wert verringern.";
$str["DETSCRN_TOOLS_GAMMA_NEGATIVE"]	=	"Alle Farben des Bildes umkehren, Negativ-Bild erzeugen";


//----------------FOOTER-------------------
$str["FOOTER_GO_UP"] 					= 	"^^^ nach oben ^^^";
$str["FOOTER_REQUEST_UPDATE"] 			= 	"Aktualisierung anfordern";
$str["FOOTER_PAGE_GENERATED"] 			= 	"Seite erstellt in";
$str["FOOTER_SECONDS"] 					= 	"Sekunden";
$str["FOOTER_FILE_UPDATED"] 			= 	"Datei Aktualisierung vor";
$str["FOOTER_FILE_UPDATED_2_SECONDS"] 	= 	"Sekunden";
$str["FOOTER_FILE_UPDATED_2_MINUTES"] 	= 	"Minuten";
$str["FOOTER_FILE_UPDATED_2_HOURS"] 	= 	"Stunden";
$str["FOOTER_FILE_UPDATED_2_DAYS"] 		= 	"Tage";
$str["FOOTER_DAYS"] 					=	"Tage";
$str["FOOTER_HOURS"] 					= 	"Stunden";
$str["FOOTER_MINUTES"] 					= 	"Minuten";
$str["FOOTER_SECONDS"] 					= 	"Sekunden";
$str["FOOTER_NEW_UPDATE"] 				= 	"Die Datei wird oder kann Aktualisiert werden nach";
$str["FOOTER_CUSTOM_UPDATE"]			=	"Frage den Admin von dieser Seite nach einer Aktualisierung der Bilder, wenn sie alt sind.";

//---------------------------------------------
//ADMIN FUNCTIONS
//---------------------------------------------

//----------------ADMIN MENU-------------------
$str["ADM_ADMIN"] 						= 	"Admin";
$str["ADM_UPDATE"] 						= 	"Update";
$str["ADM_RESET"] 						= 	"Reset";
$str["ADM_ACP"] 						= 	"ACP";
$str["ADM_NEW_MSG"] 					= 	"Neue Nachricht";
$str["ADM_UPDATE_REQ"] 					= 	"Ein Benutzer hat nach einer Aktualisierung gefragt, du kannst Aktualisieren indem du unten Aktualisieren klickst.";

//----------------RESET PAGE-------------------
$str["RESET_TITLE"]						=	"Resetting Seite";
$str["RESET_TITLE_MENU"]				=	"Resetting";
$str["RESET_FINISHED"]					=	"RESET beendet";
$str["RESET_DURATION"]					=	"Reset dauerte";
$str["RESET_DURATION_2"]				=	"Sekunden";
$str["RESET_GO_BACK"]					=	"Klick hier um zur&uuml;ck zu gehen";
$str["RESET_BUTTON"]					=	"Reset";
$str["RESET_WARNING_QUESTION"]			=	"Wenn lange Ladezeiten f&uuml;r deine Website auftreten, kann ein Reset helfen. Bist du sicher, dass du alle Daten l&ouml;schen willst?";
$str["RESET_WARNING_RESULT"]			=	"Wenn du auf Reset klickst, wird das Folgende passieren";
$str["RESET_RESULT_1"]					=	"Alle Bilder aus dem Download-Ordner auf deinem Webserver werden gel&ouml;scht";
$str["RESET_RESULT_2"]					=	"Alle Logs und Bilder auf deinem Gameserver werden gel&ouml;scht";
$str["RESET_RESULT_3"]					=	"Die Datenbank wird ges&auml;ubert";

//----------------UPDATE PAGE-------------------
$str["UPD8_TITLE"]						=	"Update Seite";
$str["UPD8_TITLE_MENU"]					=	"UPDATING";
$str["UPD8_FINISHED"]					=	"UPDATE BEENDET";
$str["UPD8_DURATION"]					=	"Update dauerte";
$str["UPD8_DURATION_2"]					=	"Sekunden";
$str["UPD8_BACK"]						=	$str["RESET_GO_BACK"];


//----------------ACP PAGE-------------------
$str["ACP_TITLE"]						=	"Admin Control Panel (ACP)";
$str["ACP_TITLE_MENU"]					=	"Admin Control Panel";
$str["ACP_TITLE_MENU_SAVED"]			=	"Speichere Einstellungen";
$str["ACP_SAVED"]						=	"Einstellungen wurden gespeichert. Du wirst in ein paar Sekunden auf die Hauptseite weitergeleitet.";
$str["ACP_WELCOME"]						=	"Willkommen Admin, in diesem Control Panel k&ouml;nnen die meisten Optionen eingestellt werden. Um die Login-Daten f&uuml;r den FTP Gameserver oder das FTP Webhosting zu &auml;ndern, bitte 'config.inc.php' per Hand editieren.";
$str["ACP_BACK"]						=	"Hier klicken um zur&uuml;ckzugehen";
$str["ACP_USER"]						=	"Benutzer";
$str["ACP_USERNAME"]					=	"Benutzername";
$str["ACP_PASS"]						=	"Passwort";
$str["ACP_PASS_COMMENT"]				=	"Nur ausf&uuml;llen, wenn du das Passwort &auml;ndern willst.";
$str["ACP_PRIV_PASS"]					=	"Privates Passwort";
$str["ACP_PRIV_PASS_COMMENT"]			=	"Nur ausf&uuml;llen, wenn du den PBSViewer privat setzen willst. Nur Benutzer, die das richtige Passwort eingeben, k&ouml;nnen den PBSViewer benutzen. Diese haben aber trotzdem keine Admin-Rechte.";
$str["ACP_ADMIN_MAIL"]					=	"Admin Mail";
$str["ACP_ADMIN_MAIL_COMMENT"]			=	"Email-Adresse ben&ouml;tigt. Diese wird bei Passwort-Verlust verwendet.";
$str["ACP_NOTIFY_UPDATE"]				=	"Bei Update-Anfrage benachrichtigen";
$str["ACP_NOTIFY_UPDATE_COMMENT"]		=	"Nur ausw&auml;hlen, wenn du bei einer Update-Anfrage per Mail benachrichtigt werden m&ouml;chtest.";
$str["ACP_CRON_KEY"]					=	"Cron benutzer key";
$str["ACP_CRON_COMMENT"]				=	"Verwenden Sie diese Schlüssel, wenn Sie mit cronjob aktualisieren möchten. Sie sollten die Schlüssel wie folgt (mit Leertaste): <br>";
$str["ACP_CLAN"]						=	"Clan";
$str["ACP_CLAN_NAME"]					=	"Clan Name";
$str["ACP_CLAN_NAME_COMMENT"]			=	"Wie lautet dein voller Clan Name?";
$str["ACP_CLAN_TAG"]					=	"Clan Tag";
$str["ACP_CLAN_COMMENT"]				=	"Dein Clantag im Spiel?";
$str["ACP_CLAN_GAME"]					=	"Clan Spiel";
$str["ACP_CLAN_GAME_CONTENT"]			=	"Welches Spiel spielst du, d.h. was l&auml;uft auf deinem Gameserver?";
$str["ACP_CLAN_GAME_SHORT"]				=	"Clan Spiel kurz";
$str["ACP_CLAN_GAME_SHORT_COMMENT"]		=	"Was ist die Abk&uuml;rzung f&uuml;r den Spielnamen?";
$str["ACP_UPDATE"]						=	"Update";
$str["ACP_PB_DIR"]						=	"PB Verzeichnis";
$str["ACP_PB_DIR_COMMENT"]				=	"Verzeichnis von PunkBuster auf deinem FTP Gameserver";
$str["ACP_PB_DIR_COMMENT_2"]			=	"Benutze '/' und benutze 'pb/' nicht mit einem abschlie&szlig;enden Schr&auml;gstrich.";
$str["ACP_CUSTOM_UPDATE"]				=	"Benutzerdefiniertes Update";
$str["ACP_CUSTOM_UPDATE_COMMENT_1"]		=	"Wenn dieser Wert 'true' ist, sollte ein Admin oder Cron-Job die Datei 'update.php' ausf&uuml;hren.";
$str["ACP_CUSTOM_UPDATE_COMMENT_2"]		=	"Wenn die Option 'false' ist, wird das Update nach x Sekunden gestartet. Die Zeit kann unter 'Update Zeit' angepasst werden, siehe unten";
$str["ACP_CUSTOM_UPDATE_COMMENT_3"]		=	"Du hast immernoch die M&ouml;glichkeit, ein Update durch das Ausf&uuml;hren von 'update.php' manuell zu erzwingen.";
$str["ACP_UPDATE_TIME"]					=	"Update Zeit";
$str["ACP_UPDATE_TIME_COMMENT"]			=	"Die Update Zeit ist in Sekunden. Benutze einen kleinen Wert, wenn der Gameserver gut besucht ist (da viele neue Bilder gemacht werden), zum Beispiel bei einem Public Server. Beachte aber, dass der Traffic bei einer kleineren Update Zeit steigt. Empfohlen: 86400 Sekunden";
$str["ACP_PB_SSCEILING"]				=	"pb_sv_SsCeiling";
$str["ACP_PB_SSCEILING_COMMENT_1"]		=	"Um deinen Wert zu finden, &ouml;ffne die Datei 'pbsv.cfg' und suche nach 'pb_sv_SsCeiling'. Die Datei sollte im 'pb' Ordner auf dem FTP deines Gameservers zu finden sein.";
$str["ACP_PB_SSCEILING_COMMENT_2"]		=	"Der Wert sollte so klein wie m&ouml;glich sein, um Bandbreite zu sparen. Diese Einstellung und 'pb_sv_SsCeiling' in 'pbsv.cfg' sollten den gleichen Wert haben";
$str["ACP_PB_SSCEILING_COMMENT_3"]		=	"Wenn du dir nicht sicher bist, nimm eine gro&szlig;e Zahl wie 10000 oder frag nach Hilfe.";
$str["ACP_PB_SSCEILING_COMMENT_4"]		=	"Game-Violations hat diese Zahl auf 10000 gesetzt";
$str["ACP_PB_SSCEILING_COMMENT_5"]		=	"PB Standard ist 100";
$str["ACP_PBSV_DOWNLOAD_DIR"]			=	"PBSV Download Ordner";
$str["ACP_PBSV_DOWNLOAD_DIR_COMMENT"]	=	"Ort des Download Ordners, wenn du dich &uuml;ber FTP mit dem Webserver verbindest. Copy & Paste oder gib den Pfad nach dem Login direkt an";
$str["ACP_PBSV_DOWNLOAD_DIR_COMMENT_2"]	=	"Abschlie&szlig;enden Schr&auml;gstrich / weglassen";
$str["ACP_RESET"]						=	"Reset";
$str["ACP_RESET_COMMENT_1"]				=	"Standard =	false. Das Reset Feature erlaubt Admins das L&ouml;schen von allen Bildern und Logdateien vom Web- und Gameserver.";
$str["ACP_RESET_COMMENT_2"]				=	"Um diese Funktion nutzen zu k&ouml;nnen, m&uuml;ssen die Login-Details des FTP-Webhostings in config.inc.php eingestellt werden";
$str["ACP_PBSVSS_UPDATER"]				=	"pbsvss_updater";
$str["ACP_PBSVSS_UPDATER_COMMENT"]		=	"Standard = false. PB loggt Daten in pbsvss.htm, die neuesten Eintr&auml;ge werden ans Ende der Datei geschrieben. PB entfernt aber keine alten Daten, so dass diese Datei immer weiter w&auml;chst. Wenn der Wert 'true' ist, werden alte Eintr&auml;ge automatisch gel&ouml;scht. So bleibt die Datei klein.";
$str["ACP_LOGGING"]						=	"Logging";
$str["ACP_PB_LOG"]						=	"PB_log";
$str["ACP_PB_LOG_COMMENT_1"]			=	"Erhalte durch Logs mehr Informationen &uuml;ber Bilder, wie z.B. MD5-Checksum oder IP-Adressen von Spielern";
$str["ACP_PB_LOG_COMMENT_2"]			=	"Standard = false, Logging ist ausgeschaltet.";
$str["ACP_PB_LOG_COMMENT_3"]			=	"Beachte, dass der FTP Webhost (nicht der Gameserver) korrekt konfigurierte Login-Details in 'config.inc.php' ben&ouml;tigt, wenn du Logging benutzen willst.";
$str["ACP_MAX_LOGS"]					=	"Maximale Anzahl Logs auf dem Webserver";
$str["ACP_MAX_LOGS_COMMENT_1"]			=	"Standard =	4, der Wert muss kleiner sein als PB_SV_LogCeiling, sonst gibt es kein Auto-Delete. Der Wert gibt die Anzahl der auf dem Webserver gespeicherten Logs an.";
$str["ACP_MAX_LOGS_COMMENT_2"]			=	"Wenn du 0 angibst, werden Logdateien direkt nach dem Update gel&ouml;scht.";
$str["ACP_MAX_LOGS_COMMENT_3"]			=	"Wenn du keine Logs vom Webserver l&ouml;schen willst, gib -1 an";
$str["ACP_TEMPLATE"]					=	"Vorlage";
$str["ACP_SCREENS_MAIN"]				=	"Bilder auf der Hauptseite";
$str["ACP_SCREENS_MAIN_COMMENT"]		=	"Standard = 10, auf der Hauptseite werden die x letzten Bilder gezeigt, um Bandbreite zu sparen.";
$str["ACP_SCREENS_SEARCH"]				=	"Anzahl angezeigter Bilder pro Seite";
$str["ACP_SCREENS_SEARCH_COMMENT"]		=	"Gib an, wie viele Bilder auf jeder Seite eines Suchergebnisses angezeigt werden sollen.";
$str["ACP_SCREENS_PER_ROW"]				=	"Bilder pro Reihe";
$str["ACP_SCREENS_PER_ROW_COMMENT"]		=	"Anzahl der Bilder in einer Reihe";
$str["ACP_IMG_W"]						=	"Bildbreite";
$str["ACP_IMG_W_COMMENT"]				=	"Thumbnail Breite";
$str["ACP_IMG_H"]						=	"Bildh&ouml;he";
$str["ACP_IMG_H_COMMENT"]				=	"Thumbnail H&ouml;he";
$str["ACP_LANGUAGE"]					=	"Standardsprache";
$str["ACP_CB_GAME"]						=	"CB Spiel";
$str["ACP_CB_GAME_COMMENT"]				=	"Die Spiele in dieser Liste werden von Clanbase unterst&uuml;tzt. Bitte w&auml;hle das Spiel aus, das auf deinem Gameserver l&auml;uft. Diese Information wird benutzt, um automatisch Clanbase Spieler f&uuml;r jedes PB Bild zu finden (nur wenn der jeweilige Spieler bei Clanbase angemeldet ist). W&auml;hle 'none' wenn du diese zus&auml;tzlichen Informationen nicht m&ouml;chtest. ";
$str["ACP_CB_NONE"]						=	"none";
$str["ACP_ADVANCED"]					=	"Erweitert";
$str["ACP_MIN_SCRN_SIZE"]				=	"Minimale Bildergr&ouml;&szlig;e zum Download";
$str["ACP_MIN_SCRN_SIZE_COMMENT"]		=	"Bilder mit einer geringeren Gr&ouml;&szlig;e als dieser Wert werden nicht heruntergeladen. Die Gr&ouml;&szlig;e ist in Byte angegeben.";
$str["ACP_CookieExpTime"]				=	"Cookie experiment time";
$str["ACP_CookieExpTime_COMMENT"]		=	"Sensible verschl&uuml;sselte Informationen f&uuml;r das Login werden in Cookies gespeichert. Hier kannst du angeben, nach wievielen Sekunden die Cookies automatisch vom Client-PC gel&ouml;scht werden sollen. Standard ist eine Woche: 3600*24*7 = 604800 Sekunden.";
$str["ACP_SCRIPT_LOAD"]					=	"Script Ladezeit";
$str["ACP_SCRIPT_LOAD_COMMENT"]			=	"Nach dieser Zeit wird das Script gestoppt. Wenn du z.B. viele Bilder downloaden musst, wird eine l&auml;ngere Scriptlaufzeit empfohlen. Wenn du dir nicht sicher bist, verwende den Standardwert. Standard=600 Sekunden oder 10 Minuten, danach wird 'Maximum execution time error' angezeigt.";
$str["ACP_WEB_LOG_DIR"]					=	"Web Log Verzeichnis";
$str["ACP_WEB_LOG_DIR_COMMENT"]			=	"Verzeichnis f&uuml;r die Log-Dateien. Empfehlung f&uuml;r das Verzeichnis: CHMODDED zu 777.";
$str["ACP_FTP_PASS"]					=	"FTP Passiv Modus";
$str["ACP_FTP_PASS_COMMENT"]			=	"Standard = false, d.h. nicht-passiver Modus. Manchmal muss der passive Modus eingeschaltet werden, damit der PBSViewer funktioniert. Wenn du FTP-bezogene Fehlermeldungen bekommst, k&ouml;nnte das Wechseln zum passiven Modus helfen.";
$str["ACP_DEBUG"]						=	"Debug";
$str["ACP_DEBUG_COMMENT"]				=	"Standard ist 'false'";
$str["ACP_SAVE"]						=	"Einstellungen speichern";
$str["ACP_TRUE"]						=	"True";
$str["ACP_FALSE"]						=	"False";

//----------------PRIVATE PBSViewer-------------------
$str['PRIVATE_TITLE']					=	"Zugriff verweigert - Privater PBSViewer";
$str['PRIVATE_MSG']						=	"Dies ist eine private Seite. Der PBSViewer kann nur mit dem korrekten Passwort benutzt werden. Admins k&ouml;nnen sich mit einen Klick auf 'Login' anmelden (siehe rechts oben).";
$str['PRIVATE_PASSWORD']				=	"Passwort";
$str['PRIVATE_LOGIN']					=	"Login";
$str['PRIVATE_CLICK_HERE']				=	"Klick hier um dein Passwort einzugeben";

//---------------------------------------------
//REMAINING MESSAGES
//---------------------------------------------

//----------------ERROR MESSAGES-------------------
$str['ERROR_TITLE']						= 	"Fehler";
$str['ERROR_SEARCH_1']					= 	"Es konnte kein Bild gefunden werden";
$str['ERROR_SEARCH_2']					= 	"F&uuml;r den Suchbegriff konnte kein Bild gefunden werden";
$str['ERROR_SEARCH_3']					= 	"Gib einen anderen Suchbegriff ein oder kontaktiere einen Admin f&uuml;r ein Update falls n&ouml;tig.";

//----------------DEBUG MESSAGES-------------------

//----------------MISC-------------------
$str['MISC_ACCESS_DENIED_ADMIN']			=	"Nur Admins k&ouml;nnen auf diese Seite zugreifen. Bitte kontaktiere den Webmaster f&uuml;r weitere Informationen.";
$str['MISC_ACCESS_DENIED_ADMIN_TITLE']		=	"Zugriff verweigert!";
$str['MISC_ACCESS_DENIED_NO_PERM_TITLE']	=	"Zugriff verweigert!";
$str['MISC_ACCESS_DENIED_NO_PERM']			=	"Du darfst auf diese Seite nicht zugreifen. Bitte kontaktiere den Webmaster, wenn du auf diese Seite zugreifen m&ouml;chtest.";



?>