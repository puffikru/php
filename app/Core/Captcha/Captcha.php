<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 06.12.2017
 * Time: 17:00
 */

namespace NTSchool\Phpblog\Core\Captcha;


class Captcha implements CaptchaInterface
{
    public $symbols;
    public $width;
    public $height;
    public $color;
    public $img;

    public function __construct()
    {
        $img = imageCreateFromJpeg("images/noise.jpg");
        $color = imageColorAllocate($img, 64, 64, 64);
        imageAntiAlias($img, true);
        $nChars = 5;
        $randStr = substr(md5(uniqid()), 0, $nChars);
        $_SESSION["randStr"] = $randStr;
        $x = 20;
        $y = 30;
        $deltaX = 40;
        for($i = 0; $i<$nChars; $i++){
            $size = rand(18, 30);
            $angle = -30 + rand(0, 60);
            imageTTFText($img, $size, $angle, $x, $y, $color, "fonts/bellb.ttf", $randStr
            {
            $i
            });
            $x += $deltaX;
        }
        header("Content-Type: image/jpeg");
        imageJpeg($img, null, 50);
    }

    public function create()
    {

    }
}