<?php
/**
 * @var yii\web\View $this
 * @var frontend\models\PublicationInfo $model
 * @var $modify_id
 */

use yii\helpers\Html;
use yii\helpers\Url;

$author_number = 1;
switch ($model->type){
    case 1:
        $publication_type="Книга";
        break;
    case 2:
        $publication_type="Статья в журнале";
        break;
    case 3:
        $publication_type="Статья в сборнике";
        break;
    case 4:
        $publication_type="Диссертация";
        break;
}

?>
<?php if($model->hasErrors()){
    foreach ($model->errors as $error){
        foreach ($error as $item) {
            echo '<p><font color="red">'.$item.'</font></p>';
        }
    }
} ?>
    <div>
        <div class="row">
            <div class="col-md-3">
                <p><b>Язык : </b><?=($model->language=='rus')?('Русский'):('Английский')  ?></p>
            </div>
            <div class="col-md-3">
                <p><b>Тип публикации : </b><?= $publication_type ?></p>
            </div>
        </div>
        <div class="row">
            <?= yii\helpers\Html:: hiddenInput(\Yii:: $app->getRequest()->csrfParam, \Yii:: $app->getRequest()->getCsrfToken(), []) ?>
            <div class="col-md-4"><p><b>Название :</b> <?= $model->name ?></p>
            </div>
            <div class="col-md-4"><p><b>Издание :</b> <?= $model->edition ?></p></div>
        </div>
        <div class="row" style="border: 1px solid #000000; border-radius: 15px">
            <h4 style="margin-left: 10px">Выходные данные</h4>
            <div class="col-md-2">
                <p><b>Город : </b><?= $model->data_city ?></p>
            </div>
            <div class="col-md-2">
                <p><b>Издатель : </b><?= $model->data_publication ?></p>
            </div>
            <div class="col-md-2">
                <p><b>Страницы : </b><?= $model->data_pages ?></p>
            </div>
            <div class="col-md-2">
                <p><b>Номер издания : </b><?= $model->data_number ?></p>
            </div>
            <div class="col-md-2" style="margin-bottom: 25px">
                <p><b>Дата : </b><?= $model->data_date ?></p>
            </div>
        </div>
        <div class="row" style="margin-top: 25px">
            <div class="col-md-2">
                <p><b>ВАК : </b><?=  $model->certificate ?></p>
            </div>
            <div class="col-md-2">
                <p><b>РИНЦ : </b><?= $model->index ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <p><b>DOI : </b><?= $model->doi ?></p>
            </div>
            <div class="col-md-4">
                <p><b>SCOPUS ID : </b><?= $model->scopus ?></p>
            </div>
            <p><b>WOS : </b><?= $model->wos ?></p>
        </div>
        <div class="row">
            <div class="col-md-3"> <p><b>Год : </b><?= $model->year ?></p></div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <a class="glyphicon glyphicon-folder-open" href="/<?= $model->file ?>"></a>
            </div>
        </div>
        <div style="margin-top: 20px; margin-bottom: 20px" id="authors" >
            <?php if ($model->name != null) { ?>
                <?php foreach ($model->authors as $author) { ?>
                    <p><b>Автор : </b><?= $author['name'] ?></p>
            <?php } ?>
            <?php } ?>
        </div>
    </div>
