<h2><?= $errorMessage; ?></h2>
<? if($dev): ?>
    <div>
        <?= $errorStackTrace ?>
    </div>
<? endif; ?>