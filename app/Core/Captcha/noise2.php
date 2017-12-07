<?php
session_start();
$symbols = 5;

//$img = imageCreateFromJpeg("img/noise.jpg");
$img = imageCreateFromJpeg("img/sunset.jpg");
$background = imageColorAllocate($img, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
imageAntiAlias($img, true);
$randStr = substr(md5(uniqid()), 0, $symbols);

$_SESSION["randStr"] = $randStr;

$x = 80;
$y = 250;
$deltaX = 150;
for($i = 0; $i < $symbols; $i++){
    $size = rand(140, 160);
    $angle = -30 + rand(0, 60);
    imagettftext($img, $size, $angle, $x, $y, $background, "fonts/bellb.ttf", $randStr{$i});
    $x += $deltaX;
}
header("Content-Type: image/jpeg");
imagejpeg($img, null, 50);
imagedestroy($img);