<?php
header ("Content-type: image/png");
$friendName = $_GET["friendName"];
$fullName = $_GET["fullName"];
$fullText = wordwrap($_GET["fullText"], 40, "\n", true);
$template = $_GET["template"];


$handle = imagecreatefrompng($template); 
$red = ImageColorAllocate ($handle, 255, 0, 0);
$lightBrown = ImageColorAllocate ($handle, 145, 116, 94);
$dark = ImageColorAllocate ($handle, 0, 0, 0);
$peach = ImageColorAllocate ($handle, 238, 222, 200);


ImageTTFText ($handle, 20, 0, 120, 50, $red, "font/Honeybee.ttf", $friendName);

ImageTTFText ($handle, 21, 0, 125, 120, $dark, "font/BeforeChristmas.ttf", $fullText);

ImageTTFText ($handle, 21, 0, 120, 750, $red, "font/Honeybee.ttf", $fullName);

$fontSize = "12";
$width = "420";
$textWidth = $fontSize * strlen($siteUrl);
$position_center = $width / 2 - $textWidth / 2.6;


imagealphablending( $handle, false );
imagesavealpha( $handle, true );
ImagePng ($handle);
imagedestroy( $handle );
?>