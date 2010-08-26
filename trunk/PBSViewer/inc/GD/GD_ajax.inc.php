<?php

//	first check if gd is supported
function_exists("gd_info")? $gd=true:$gd=false;

if($gd)
{
	
	$download_dir	=	'../../download/';

	if(isset($_GET['imgfid']))
	{
		$im = imagecreatefrompng($download_dir.$_GET['imgfid'].'.png');	

		if(isset($_GET['gammaOut']))
		{
		
			$gammaOut = $_GET['gammaOut'];

			if ($gammaOut<=0) $gammaOut =0;

			echo $gammaOut;
			
			// Correct gamma, out = 1.537
			imagegammacorrect($im, 1.0, $gammaOut);

			// Save and free image
			imagepng($im, $download_dir.'temp.png');
			imagedestroy($im);
			
			$IMGsrc = 'download/temp.png?'.time();
			list($widthIMG, $heightIMG, $typeIMG, $attrIMG) = getimagesize($IMGsrc);
   			echo "<img src=\"".$IMGsrc."\" style=\"width:".$widthIMG."px; height: ".$heightIMG."px;\" onmouseover=\"TJPzoomif(this);\" id=\"unique1337\" alt=\"".$fid.'png'."\">";

		}
		elseif (isset($_GET['negate']))
		{
	
			if($_GET['negate']==1)
			{
	
				function negate($im)
				{
    				if(function_exists('imagefilter'))
    				{
        				return imagefilter($im, IMG_FILTER_NEGATE);
    				}

    				for($x = 0; $x < imagesx($im); ++$x)
    				{
        				for($y = 0; $y < imagesy($im); ++$y)
        				{
            				$index = imagecolorat($im, $x, $y);
            				$rgb = imagecolorsforindex($index);
            				$color = imagecolorallocate($im, 255 - $rgb['red'], 255 - $rgb['green'], 255 - $rgb['blue']);

            				imagesetpixel($im, $x, $y, $color);
        				}
    				}

    				return(true);
				}

				if($im && negate($im))
				{
    				imagepng($im, $download_dir.'temp.png');
    				imagedestroy($im);
    
    				$IMGsrc = 'download/temp.png?'.time();
    				list($widthIMG, $heightIMG, $typeIMG, $attrIMG) = getimagesize($IMGsrc);
	    			echo "<img src=\"".$IMGsrc."\" style=\"width:".$widthIMG."px; height: ".$heightIMG."px;\" onmouseover=\"TJPzoomif(this);\" id=\"unique1337\" alt=\"".$fid.'png'."\">";
				}
				else
				{
    				echo 'Converting to negative colors failed.';
				}
			}
			else 
			{
				$IMGsrc = 'download/'.$_GET['imgfid'].'.png?'.time();
    			list($widthIMG, $heightIMG, $typeIMG, $attrIMG) = getimagesize($IMGsrc);
   	 			echo "<img src=\"".$IMGsrc."\" style=\"width:".$widthIMG."px; height: ".$heightIMG."px;\" onmouseover=\"TJPzoomif(this);\" id=\"unique1337\" alt=\"".$fid.'png'."\">";
			}
		}

	}
}
?>