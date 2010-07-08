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
	
?>