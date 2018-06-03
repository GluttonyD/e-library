<?php
/**
 * @var yii\web\View $this
 * @var app\models\Publications $model
 * @var $modify_id
 */

use yii\helpers\Html;
use yii\helpers\Url;

$config = array();
array_push($config, '/library/add-publication');
($modify_id) ? ($config['publication_id'] = $modify_id) : null;
$author_number = 1;
if ($model->name) {
    $authors_count = $model->authors_count;
} else {
    $authors_count = 0;
}
?>
<?php if($model->hasErrors()){
    foreach ($model->errors as $error){
        foreach ($error as $item) {
            echo '<p><font color="red">'.$item.'</font></p>';
        }
    }
} ?>
<form id="publication-form" data-publication_id="<?= $modify_id ?>" method="post" action="<?= Url::to($config) ?>"
      class="form-group" enctype="multipart/form-data">
    <div>
        <div class="row">
            <div class="col-md-3">
                <label>*Язык</label>
                <select name="Publications[language]" class="form-control" style="width: 200px">
                    <option disabled selected value="null">Выберите язык</option>
                    <option value="rus" <?= ($model->language=='rus')?('selected'):null ?>>Русский</option>
                    <option value="eng"  <?= ($model->language=='eng')?('selected'):null ?>>Английский</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Тип публикации</label>
                <select name="Publications[type]" class="form-control" style="width: 200px">
                    <option disabled selected value="null" >Тип публикации</option>
                    <option value="1" <?= ($model->type==1)?('selected'):null ?>>Книга</option>
                    <option value="2"  <?= ($model->type==2)?('selected'):null ?>>Статья в журнале</option>
                    <option value="3"  <?= ($model->type==3)?('selected'):null ?>>Статья в сборнике</option>
                    <option value="4"  <?= ($model->type==4)?('selected'):null ?>>Диссертация</option>
                </select>
            </div>
        </div>
        <div class="row">
            <?= yii\helpers\Html:: hiddenInput(\Yii:: $app->getRequest()->csrfParam, \Yii:: $app->getRequest()->getCsrfToken(), []) ?>
            <div class="col-md-4"><p><label for="publication-name">*Название</label><input id="publication-name"
                                                                                          class="form-control"
                                                                                          type="test"
                                                                                          name="Publications[name]"
                                                                                          value="<?= ($model->name)?$model->name:null ?>">
                </p>
            </div>
            <div class="col-md-4"><p><label for="publication-edition">Издание</label><input id="publication-edition"
                                                                                            class="form-control"
                                                                                            type="text"
                                                                                            name="Publications[edition]"
                                                                                            value="<?= ($model->edition)?$model->edition:null ?>">
                </p></div>
        </div>
        <div class="row" style="border: 1px solid #000000; border-radius: 15px">
            <h4 style="margin-left: 10px">Выходные данные</h4>
            <div class="col-md-2">
                <label for="data_city">Город</label>
                <input id="data_city" class="form-control" type="text" name="Publications[data_city]" value="<?= $model->data_city ?>">
            </div>
            <div class="col-md-2">
                <label for="data_publication">Издатель</label>
                <input id="data_publication" class="form-control" type="text" name="Publications[data_publication]" value="<?= $model->data_publication ?>">
            </div>
            <div class="col-md-2">
                <label for="data_pages">Страницы</label>
                <input id="data_pages" class="form-control" type="text" name="Publications[data_pages]" value="<?= $model->data_pages ?>">
            </div>
            <div class="col-md-2">
                <label for="data_number">Номер издания</label>
                <input id="data_number" class="form-control" type="text" name="Publications[data_number]" value="<?= $model->data_number ?>">
            </div>
            <div class="col-md-2" style="margin-bottom: 25px">
                <label for="data_date">Дата</label>
                <input id="data_date" class="form-control" type="text" name="Publications[data_date]" value="<?= $model->data_date ?>">
            </div>
        </div>
        <div class="row" style="margin-top: 25px">
            <?php if ($model->certificate) { ?>
                <div class="col-md-2"><label for="publication-certificate">ВАК </label><input
                            id="publication-certificate"
                            class="" type="checkbox"
                            name="Publications[certificate]"
                            value="+"
                            checked></div>
            <?php } else { ?>
                <div class="col-md-2"><label for="publication-certificate">ВАК </label><input
                            id="publication-certificate"
                            class="" type="checkbox"
                            name="Publications[certificate]"
                            value="+"
                    ></div>
            <?php } ?>
            <?php if ($model->index) { ?>
                <div class="col-md-2"><label for="publication-certificate">РИНЦ </label><input
                            id="publication-certificate"
                            class="" type="checkbox"
                            name="Publications[index]"
                            value="+"
                            checked></div>
            <?php } else { ?>
                <div class="col-md-2"><label for="publication-certificate">РИНЦ </label><input
                            id="publication-certificate"
                            class="" type="checkbox"
                            name="Publications[index]"
                            value="+"
                    ></div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-md-4">
                <p><label for="publication-certificate">DOI </label><input id="publication-certificate"
                                                                           class="form-control" type="text"
                                                                           name="Publications[doi]"
                                                                           value="<?= $model->doi ?>"></p>
            </div>
            <div class="col-md-4">
                <p><label for="publication-certificate">SCOPUS ID </label><input id="publication-certificate"
                                                                              class="form-control" type="text"
                                                                              name="Publications[scopus]"
                                                                              value="<?= $model->scopus ?>"></p>
            </div>
            <div class="col-md-4">
                <p><label for="publication-certificate">WOS </label><input id="publication-certificate"
                                                                           class="form-control" type="text"
                                                                           name="Publications[wos]"
                                                                           value="<?= $model->wos ?>"></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"><label for="publication-date">*Год</label><input id="publication-date"
                                                                                  class="form-control" type="text"
                                                                                  name="Publications[year]"
                                                                                  value="<?= $model->year ?>"></div>
        </div>
        <div class="row">
            <div class="col-md-3"><label for="publication-file">Загрузить файл</label><input type="file"
                                                                                             id="publication-file"
                                                                                             name="Publications[file]">
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <a class="glyphicon glyphicon-folder-open" href="/<?= $model->filePath ?>"></a>
            </div>
        </div>
        <div style="margin-top: 20px; margin-bottom: 20px" id="authors" data-authors_count="<?= $authors_count ?>">
            <label>*Авторы</label>
            <?php if ($model->name != null) { ?>
                <?php foreach ($model->authors as $author) { ?>
                    <div id="author_<?= $author_number ?>">
                        <h4 class="author-header" data-authors_count="<?= $model->authors_count ?>">Автор</h4>
                        <p><label for="author_name">ФИО</label><input id="author_name_<?= $author_number ?>"
                                                                      class="form-control author"
                                                                      style="width: 250px"
                                                                      type="text"
                                                                      name="Publications[authors][<?= $author_number ?>][name]"
                                                                      value="<?= $author['name'] ?>"
                                                                      data-id="<?= $author['id'] ?>"
                                                                      ></p>
                    </div>
                    <?php $author_number++;
                } ?>
            <?php } ?>
        </div>
        <p>
            <input class="btn btn-info" type="button" id="add-fields" value="Добавить автора">
            <input class="btn btn-info" type="button" id="delete-fields" value="Убрать автора">
        </p>
        <?= ($modify_id)? Html::submitButton('Сохранить изменения', ['class' => 'btn btn-primary', 'name' => 'login-button']): Html::submitButton('Добавить публикацию', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        <a href="/library/index" class="btn btn-primary">Отмена</a>
    </div>
</form>
