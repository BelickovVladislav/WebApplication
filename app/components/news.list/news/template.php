<?php
/*
 *
 */
function showNews($items, $params)
{
    foreach ($items as $item) {
        ?>
        <div class='item'>
        <h2><?= $item['title'] ?></h2>
        <div class="pubDate"><?= $item['pubDate'] ?></div>
        <div class='description'><?= $item['description'] ?></div>
        <?php
        if ($params['show_pic'] == 'Y') {
            ?><img src='/app/data<?= $item['picture'] ?>'>
            <?php
        }
        ?> <br><a class="more" href="<?= $item['link'] ?>" target = '_blank'>Подробнее</a>
        </div>
        <?php
    }
}