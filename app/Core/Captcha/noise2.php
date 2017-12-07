<?php
session_start();
$symbols = 5;

$img = imageCreateFromJpeg("img/noise.jpg");
$background = imageColorAllocate($img, 64, 64, 64);
imageAntiAlias($img, true);
$randStr = substr(md5(uniqid()), 0, $symbols);

$_SESSION["randStr"] = $randStr;

$x = 20;
$y = 30;
$deltaX = 40;
for($i = 0; $i < $symbols; $i++){
    $size = rand(18, 30);
    $angle = -30 + rand(0, 60);
    imagettftext($img, $size, $angle, $x, $y, $background, "fonts/bellb.ttf", $randStr{$i});
    $x += $deltaX;
}
header("Content-Type: image/jpeg");
imagejpeg($img, null, 50);
imagedestroy($img);