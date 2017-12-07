<?php
session_start();
// список символов, используемых в капче
$let = '0123456789ABCDEFGHIGKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
// количество символов в капче
$len = 5;
// шрифт
$font = 'fonts/bellb.ttf';
// Размер шрифта
$fontsize = 20;
// Размер капчи
$width = 150;
$height = 37;
// создаем изображение
$img = imagecreatetruecolor($width, $height);

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
        $img, rand(0, 120),
        rand(0, 120), rand(0, 120)
    );
    // Генерируем угол наклона символа
    $naklon = rand(-30, 30); // Рисуем символ
    imagettftext($img, $fontsize, $naklon, $x, $y, $color, $font, $capchaText[$i]);
}

$_SESSION["randStr"] = $capchaText;
// заголовок для браузера
header('Content-type: image/png');
// вывод капчи на страницу
imagepng($img);
imagedestroy($img);