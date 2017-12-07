<?php

session_start();
// список символов, используемых в капче
$let = '0123456789ABCDEFGH';
// количество символов в капче
$len = 4;
// шрифт
$font = 'app/Core/Captcha/fonts/bellb.ttf';
// Размер шрифта
$fontsize = 20;
// Размер капчи
$width = 150;
$height = 40;
// создаем изображение
$img = imageCreateFromJpeg("app/Core/Captcha/img/noise.jpg");


// фон
$white = imagecolorallocate($img, 220, 220, 220);

imagefill($img, 0, 0, $white);

// Переменная, для хранения значения капчи
$capchaText = '';

// Заполняем изображение символами
for ($i = 0; $i < $len; $i++){
    // Из списка символов, берем случайный символ
    $capchaText .= $let[rand(0, strlen($let)-1)]; // Вычисляем положение одного символа
    $x = ($width - 20) / $len * $i + 10;
    $y = $height - (($height - $fontsize) / 2); // Укажем случайный цвет для символа
    $color = imagecolorallocate(
        $img, rand(0, 150),
        rand(0, 150), rand(0, 150)
    );

    // Генерируем угол наклона символа
    $naklon = rand(-30, 30); // Рисуем символ
    imagettftext($img, $fontsize, $naklon, $x, $y, $color, $font, $capchaText[$i]);
}
// заголовок для браузера
header('Content-type: image/png');

// вывод капчи на страницу
imagepng($img);
// чистим память
imagedestroy($img);