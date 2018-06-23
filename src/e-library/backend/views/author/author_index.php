<?php
/**
 * @var yii\web\View $this
 * @var \common\models\Author $author
 * @var common\models\PublicationSearch $publications
 * @var \yii\data\Pagination $pages
 * @var $authors
 */

use yii\widgets\LinkPager;
use yii\helpers\Html;

?>
<p><a class="btn btn-info" href="/library/index" style="margin-right: 15px" >Список публикаций</a><a class="btn btn-info" href="/author/add-author" >Добавить автора</a></p>
<form method="post" action="/author/author-search" class="form-inline">
    <?= yii\helpers\Html:: hiddenInput(\Yii:: $app->getRequest()->csrfParam, \Yii:: $app->getRequest()->getCsrfToken(), []) ?>
    <div class="form-group">
        <label for="author-search">ФИО</label>
        <input id="author-search" type="text" name="AuthorSearch[name]" class="form-control">
        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>
</form>
<div id="authors" class="row">
    <?php foreach ($authors as $author) { ?>
        <div class="row">
            <div class="col-md-4"><?= $author->name ?></div>
            <div class="col-md-1"><a href="/author/add-author?author_id=<?= $author->id ?>" class="glyphicon glyphicon-pencil"></a></div>
            <div class="col-md-1"><a href="/author/author-delete?author_id=<?= $author->id ?>" class="glyphicon glyphicon-remove"></a></div>
        </div>
    <?php } ?>
</div>
<div id="pagination">
    <?= LinkPager::widget(['pagination' => $pages]); ?>
</div>
