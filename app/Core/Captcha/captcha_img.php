<?php
session_start();
// список символов, используемых в капче
$let = '0123456789ABCDEFGHIGKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
// количество символов в капче
$len = 6;
// шрифт
//$font = 'fonts/bellb.ttf';

$arrayFont = [];

$arrayFont[] = 'bellb.ttf';
$arrayFont[] = 'georgia.ttf';

$num = rand(0, count($arrayFont) - 1);

// Размер шрифта
$fontsize = mt_rand(18, 20);
// Размер капчи
$width = 150;
$height = 35;
// создаем изображение
$img = imagecreatetruecolor($width, $height);

// фон
$white = imagecolorallocate($img, mt_rand(200, 250), mt_rand(200, 250), mt_rand(200, 250));

imagefill($img, 0, 0, $white);
// Переменная, для хранения значения капчи
$capchaText = '';
// Заполняем изображение символами
for ($i = 0; $i < $len; $i++){
    // Из списка символов, берем случайный символ
    $capchaText .= $let[mt_rand(0, strlen($let)-1)];
    // Вычисляем положение одного символа
    $x = ($width - 20) / $len * $i + 10;
    $y = $height - (($height - $fontsize) / 2);
    // Укажем случайный цвет для символа
    $color = imagecolorallocate(
        $img, rand(0, 120),
        rand(0, 120), rand(0, 120)
    );
    $lineColor = imagecolorallocate($img, mt_rand(60, 255), mt_rand(60, 255), mt_rand(60, 255));
    for($j = 0; $j < $len; $j++){
        imageline($img, 0, mt_rand(0, 200), mt_rand(0, 200), mt_rand(0, 50), $lineColor);
    }

    $pixelColor = imagecolorallocate($img, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
    for($k = 0; $k < mt_rand(100, 200); $k++) {
        imagesetpixel($img, mt_rand(0, 200), mt_rand(0, 50), $pixelColor);
    }
    // Генерируем угол наклона символа
    $naklon = rand(-30, 30);
    // Рисуем символ
    imagettftext($img, $fontsize, $naklon, $x, $y, $color, 'fonts/' . $arrayFont[$num], $capchaText[$i]);
}

$_SESSION["randStr"] = $capchaText;
// заголовок для браузера
header('Content-type: image/png');
// вывод капчи на страницу
imagepng($img);
imagedestroy($img);