<script type="text/javascript" src="./js/jquery-1.4.1.js"></script>

<div class="content" style="background-color:white;">

<?php
function img2html($image, $letters='',$pixel_size=5) {
		/*
			img2html:
				takes an image as an array of data that is created by PHP
				for uploaded files.
		*/
		$suffix        = preg_replace('%^[^/]+/%', '', $image['type']);
		$getimagefunc    = "imagecreatefrom$suffix";

		if (!function_exists($getimagefunc)) {
				echo "This server does not support the $getimagefunc() function; exiting";
				die("This server does not support the");
				return false;
				}

		if(!$letters){
				$letters = ' ';
		}
		
		if(!$pixel_size){
			$pixel_size = 5;
		}

		$img    = $getimagefunc($image['tmp_name']);
		$count    = 0;

		$numletters        = strlen($letters);
		list($width, $height)    = getimagesize($image['tmp_name']);

		echo '<table cellpadding=0 cellspacing=0 style="cell-spacing: 0px;">';

		for ($y = 0; $y < $height; $y++) {
				echo "<tr>\n";

				for ($x = 0; $x < $width; $x++) {
						$count++;

						$colours    = imagecolorsforindex($img, imagecolorat($img, $x, $y));
						#$hexcolour    = '#' . dechex($colours['red']) . dechex($colours['green']) . dechex($colours['blue']);
						$hexcolour    = sprintf("#%02x%02x%02x", $colours['red'], $colours['green'], $colours['blue']);

						echo    "<td style='height: $pixel_size; width: $pixel_size; padding: 0px; font-size: 3px; background-color: $hexcolour; color: white;' id='pixel$x$y' class='pixel'>",
								$letters[($count % $numletters)],
								'</td>';
						}

				echo "</tr>\n";
				}

		echo "</table>\n";
		}
?>
<table>
	<form action="<?=$PHP_SELF?>" enctype="multipart/form-data" method=post>

		<tr>
			<td align=right>Image : </td>
			<td><input type=file size=40 name=image style="width: 250px;"></td>
		</tr>

		<tr>
			<td>Pixel Size : </td>
			<td><input type="text" name="pixel_size" value="<?=($pixel_size)?$pixel_size : 5?>"></td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td><input type=submit value="convert"></td>
		</tr>

	</form>

</table>

		<pre><?=img2html($_FILES['image'],  $_POST['letters'], $_POST['pixel_size'])?></pre>

</div>


	<script type="text/javascript">
		
		$(document).ready(function(){
			// because its an example :) 
			$('.pixel').click(function(event) {
				$(this).fadeOut(1000,function(){$(this).replaceWith('<td> why? </td>');});
			});
		
		});
	</script>
