<div id="templatemo_main">
    <? foreach($articles as $article): ?>
        <div class="post_section">
            <h2><a href="<?= ROOT ?>post/<?= $article['id_news']; ?>"><?= $article['title']; ?></a></h2>
            <p><?= $article['pub_date']; ?> | <strong>Автор:</strong> <?= $article['name']; ?></p>
            <? if($isAuth): ?>
                &nbsp;  <a href="<?= ROOT ?>post/edit/<?= $article['id_news']; ?>"><i class="fa fa-pencil-square-o"></i></a>
                &nbsp;  <a href="<?= ROOT ?>post/delete/<?= $article['id_news']; ?>" class="delete"><i
                            class="fa fa-times"></i></a>
            <? endif; ?>
        </div>
    <? endforeach; ?>
</div>