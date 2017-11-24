<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= ROOT; ?>public/css/font-awesome.css">
    <link rel="stylesheet" href="<?= ROOT; ?>public/css/style.css">
    <title><?= $title; ?></title>
</head>
<body>
<div id="templatemo_wrapper">

    <?= $menu; ?>

    <div id="templatemo_left_column">
        <div id="templatemo_header">

            <div id="site_title">
                <h1>
                    <a href="<?= ROOT ?>"><strong><?= $texts['title']; ?></strong><span><?= $texts['subtitle']; ?></span></a>
                </h1>
            </div>

        </div>
        <?= $sidebar; ?>
    </div>

    <div id="templatemo_right_column">
        <?= $content; ?>
        <div class="cleaner"></div>
    </div>

    <div class="cleaner_h20"></div>

    <div id="templatemo_footer">

        Copyright &copy; <?= date('Y'); ?> <a href="<?= ROOT; ?>"><?= $texts['copyright']; ?></a>
        &nbsp; Тел: <a href="tel:<?= $texts['phone']; ?>"><?= $texts['phone']; ?></a>

    </div>

    <div class="cleaner"></div>
</div>
</body>
</html>