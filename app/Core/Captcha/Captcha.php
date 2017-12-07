<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 06.12.2017
 * Time: 17:00
 */

namespace NTSchool\Phpblog\Core\Captcha;


use NTSchool\Phpblog\Core\ServiceContainer;

class Captcha implements CaptchaInterface
{
    public $symbols = 6;
    public $img;
    public $container;

    public function __construct(ServiceContainer $container)
    {
        $this->container = $container;
        $session = $this->container->get('http.session');
        $this->img = imageCreateFromJpeg("app/Core/Captcha/img/noise.jpg");
        $background = imageColorAllocate($this->img, 64, 64, 64);
        imageAntiAlias($this->img, true);
        $randStr = substr(md5(uniqid()), 0, $this->symbols);

        $session->collection()->set("randStr", $randStr);
        $session->save();

        $x = 20;
        $y = 30;
        $deltaX = 40;
        for($i = 0; $i < $this->symbols; $i++){
            $size = rand(18, 30);
            $angle = -30 + rand(0, 60);
            imagettftext($this->img, $size, $angle, $x, $y, $background, "app/Core/Captcha/fonts/bellb.ttf", $randStr{$i});
            $x += $deltaX;
        }
        header("Content-Type: image/jpeg");
        imagejpeg($this->img, null, 50);
        imagedestroy($this->img);
    }

    /*public function create()
    {
        $session = $this->container->get('http.session');
        $this->img = imageCreateFromJpeg("app/Core/Captcha/img/noise.jpg");
        $background = imageColorAllocate($this->img, 64, 64, 64);
        imageAntiAlias($this->img, true);
        $randStr = substr(md5(uniqid()), 0, $this->symbols);

        $session->collection()->set("randStr", $randStr);
        $session->save();

        $x = 20;
        $y = 30;
        $deltaX = 40;
        for($i = 0; $i < $this->symbols; $i++){
            $size = rand(18, 30);
            $angle = -30 + rand(0, 60);
            imagettftext($this->img, $size, $angle, $x, $y, $background, "app/Core/Captcha/fonts/bellb.ttf", $randStr{$i});
            $x += $deltaX;
        }
        header("Content-Type: image/jpeg");
        imagejpeg($this->img, null, 50);
        imagedestroy($this->img);
    }*/
}