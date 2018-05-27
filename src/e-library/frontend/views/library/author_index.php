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
<p><a class="btn btn-info" href="/library/index" >Список публикаций</a>
<form method="post" action="/library/author-search" class="form-inline">
    <?= yii\helpers\Html:: hiddenInput(\Yii:: $app->getRequest()->csrfParam, \Yii:: $app->getRequest()->getCsrfToken(), []) ?>
    <div class="form-group">
        <label for="author-search">ФИО</label>
        <input id="author-search" type="text" name="AuthorSearch[name]" class="form-control" value="<?= $author->name ?>">
        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>
</form>
<div id="authors" class="row">
    <?php foreach ($authors as $author) { ?>
        <div class="row">
            <div class="col-md-4"><?= $author->name ?></div>
            <div class="col-md-1"><a href="/library/author-info?author_id=<?= $author->id ?>" class="glyphicon glyphicon-zoom-in"></a></div>
        </div>
    <?php } ?>
</div>
<div id="pagination">
    <?= LinkPager::widget(['pagination' => $pages]); ?>
</div>