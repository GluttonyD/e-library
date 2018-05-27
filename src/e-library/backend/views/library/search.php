<?php
/**
 * @var yii\web\View $this
 * @var \common\models\Publication $item
 * @var app\models\PublicationSearch $publications
 * @var \yii\data\Pagination $pages
 */
use yii\widgets\LinkPager;
use yii\helpers\Html;
?>
<p><a class="btn btn-info" href="/library/add-publication" >Добавить публикацию</a></p>
<form id="search-form" class=" form-group" method="post" action="/library/search-publications">
    <div class="row" style="margin-bottom: 10px">
        <div class="col-md-2"><h4>Найти публикацию</h4></div>
        <?= yii\helpers\Html:: hiddenInput(\Yii:: $app->getRequest()->csrfParam, \Yii:: $app->getRequest()->getCsrfToken(), []) ?>
        <div class="col-md-2"><label for="publocation_name">Название публикации</label><input id="publocation_name" type="text" class="form-control" name="PublicationSearch[publication_name]"></div>
        <div class="col-md-2"><label for="publication_edition">Издание</label><input id="publication_edition" type="text" class="form-control" name="PublicationSearch[publication_edition]"></div>
        <div class="col-md-2"><label for="author_name">Автор</label><input id="author_name" type="text" class="form-control" name="PublicationSearch[author_name]"></div>
        <div class="col-md-2"><?= Html::submitButton('Найти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?></div>
    </div>
</form>
<div id="publications">
    <?php foreach ($publications as $item) { ?>
        <div id="<?= $item->id ?>" class="row" style="border: 1px solid #000000">
            <div class="col-md-1">
                <?php foreach ($item->authors as $author) { ?>
                    <p style="font-size: x-small"><?= $author['surname'] ?>   <?= $author['name'] ?></p>
                <?php } ?>
            </div>
            <div class="col-md-2">
                <p style="font-size: x-small"><?= $item->name ?></p>
            </div>
            <div class="col-md-2">
                <p style="font-size: x-small"><?= $item->edition ?></p>
            </div>
            <div class="col-md-2">
                <p style="font-size: x-small"><?= $item->out_data ?></p>
            </div>
            <div class="col-md-2">
                <a href="/library/add-publication?publication_id=<?= $item->id ?>" class="glyphicon glyphicon-zoom-in"></a>
            </div>
            <div class="col-md-2">
                <a href="/library/delete-publication?publication_id=<?= $item->id ?>" class="glyphicon glyphicon-remove"></a>
            </div>
        </div>
    <?php } ?>
</div>
<div id="pagination">
    <?= LinkPager::widget(['pagination'=>$pages]);  ?>
</div>
