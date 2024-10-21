<?php
session_start();

$captcha_code = $_SESSION['captcha'];

$image = imagecreatetruecolor(100, 40);

$background_color = imagecolorallocate($image, 255, 255, 255); 
$text_color = imagecolorallocate($image, 0, 0, 0); 
$line_color = imagecolorallocate($image, 64, 64, 64); 

imagefilledrectangle($image, 0, 0, 100, 40, $background_color);

for ($i = 0; $i < 6; $i++) {
    imageline($image, rand(0, 100), rand(0, 40), rand(0, 100), rand(0, 40), $line_color);
}

$font = dirname(__FILE__) . '/fonts/arial.ttf';
imagettftext($image, 20, 0, 10, 30, $text_color, $font, $captcha_code);

header('Content-Type: image/png');

imagepng($image);

imagedestroy($image);
?>
