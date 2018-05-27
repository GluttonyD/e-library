<?php
/**
 * @var yii\web\View $this
 * @var \common\models\Publication $item
 * @var common\models\Publication $publications
 * @var common\models\PublicationSearch $searchData
 * @var \yii\data\Pagination $pages
 */

use yii\widgets\LinkPager;
use yii\helpers\Html;

?>
<p><a class="btn btn-info" href="/library/add-publication">Добавить публикацию</a><a class="btn btn-info"
                                                                                     href="/library/author-index">Список
        авторов</a></p>
<form id="search-form" method="post" action="/library/search-publications">
    <?= yii\helpers\Html:: hiddenInput(\Yii:: $app->getRequest()->csrfParam, \Yii:: $app->getRequest()->getCsrfToken(), []) ?>
    <div class="row">
        <div class="col-md-2"><h4>Найти публикацию</h4></div>
    </div>
    <div class="form-group row">
        <div class="col-md-3"><label for="publication_name">Название публикации</label><input id="publication_name"
                                                                                              type="text"
                                                                                              class="form-control"
                                                                                              name="PublicationSearch[publication_name]"
            value="<?= $searchData->publication_name ?>">
        </div>
        <div class="col-md-3"><label for="publication_edition">Издание</label><input id="publication_edition"
                                                                                     type="text" class="form-control"
                                                                                     name="PublicationSearch[publication_edition]"
                                                                                     value="<?= $searchData->publication_edition ?>">
        </div>
        <div class="col-md-3"><label for="author_name">Автор</label><input id="author_name" type="text"
                                                                           class="form-control"
                                                                           name="PublicationSearch[author_name]"
                                                                           value="<?= $searchData->author_name ?>"></div>
    </div>
    <div class="form-group row">
        <div class="col-md-3"><label for="scopusID">ScopusID</label><input id="scopusID" type="text"
                                                                           class="form-control"
                                                                           name="PublicationSearch[scopusID]"
                                                                           value="<?= $searchData->scopusID ?>"></div>
        <div class="col-md-3"><label for="wos">WOS</label><input id="wos" type="text" class="form-control"
                                                                 name="PublicationSearch[wos]"
                                                                 value="<?= $searchData->wos ?>"></div>
        <div class="col-md-3"><label for="doi">DOI</label><input id="doi" type="text" class="form-control"
                                                                 name="PublicationSearch[doi]"
                                                                 value="<?= $searchData->doi ?>"></div>

    </div>
    <div class="form-group row">
        <div class="col-md-1"><label for="year-from">От года</label><input id="year-from" type="text"
                                                                           class="form-control"
                                                                           name="PublicationSearch[year_from]"
                                                                           value="<?= $searchData->year_from ?>"></div>
        <div class="col-md-1"><label for="year-to">До года</label><input id="year-to" type="text" class="form-control"
                                                                         name="PublicationSearch[year_to]"
                                                                         value="<?= $searchData->year_to ?>"></div>
        <div class="col-md-3">
            <label for="language">Язык</label>
            <select id="language" name="PublicationSearch[language]" class="form-control" style="width: 200px">
                <option value="" selected>Выберите язык</option>
                <option value="rus" <?= ($searchData->language=='rus')?('selected'):null ?>>Русский</option>
                <option value="eng" <?= ($searchData->language=='eng')?('selected'):null ?>>Английский</option>
            </select>
        </div>
        <div class="col-md-3">
            <label >Тип публикации</label>
            <select name="PublicationSearch[type]" class="form-control" style="width: 200px">
                <option selected value="" >Тип публикации</option>
                <option value="1" <?= ($searchData->type==1)?('selected'):null ?>>Книга</option>
                <option value="2"  <?= ($searchData->type==2)?('selected'):null ?>>Статья в журнале</option>
                <option value="3"  <?= ($searchData->type==3)?('selected'):null ?>>Статья в сборнике</option>
                <option value="4"  <?= ($searchData->type==4)?('selected'):null ?>>Диссертация</option>
            </select>
        </div>
        <div class="col-md-1">
            <label for="index">РИНЦ</label>
            <input id="index" type="checkbox" name="PublicationSearch[index]">
            <label for="index">ВАК</label>
            <input id="index" type="checkbox" name="PublicationSearch[certificate]">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-5"><?= Html::submitButton('Найти', ['class' => 'btn btn-success col-md-5', 'name' => 'login-button']) ?></div>
    </div>
    <p>
        <button id="DESC"  class="glyphicon glyphicon-sort-by-attributes-alt"></button>
        <button id="ASC" class="glyphicon glyphicon-sort-by-attributes"></button>
    </p>
</form>
<div id="publications">
    <?php foreach ($publications as $item) { ?>
        <div id="<?= $item->id ?>" class="row" style="border: 1px solid #000000">
            <div class="col-md-9">
                <p style="font-size: small">
                    <?= $item->getStandardName(); ?>
                </p>
            </div>
                <div class="col-md-1">
                    <?php if ($item->file) { ?>
                    <a class="glyphicon glyphicon-folder-open" href="/<?= $item->file ?>"></a>
                    <?php } ?>
                </div>
            <div class="col-md-1">
                <a href="/library/add-publication?publication_id=<?= $item->id ?>"
                   class="glyphicon glyphicon-pencil"></a>
            </div>
            <div class="col-md-1">
                <a href="/library/delete-publication?publication_id=<?= $item->id ?>"
                   class="glyphicon glyphicon-remove"></a>
            </div>
        </div>
    <?php } ?>
</div>
<?php if(!$searchData){ ?>
<div id="pagination">
    <?= LinkPager::widget(['pagination' => $pages]); ?>
</div>
<?php } ?>
