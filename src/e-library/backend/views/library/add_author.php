<?php
/**
 * @var yii\web\View $this
 * @var app\models\Authors $model
 * @var $author_id
 */

use yii\helpers\Html;
use yii\helpers\Url;

$config=array();
array_push($config, '/library/add-author');
($author_id) ? ($config['author_id'] = $author_id) : null;
?>

<form method="post" action="<?= Url::to($config) ?>" class="form-inline">
    <?= yii\helpers\Html:: hiddenInput(\Yii:: $app->getRequest()->csrfParam, \Yii:: $app->getRequest()->getCsrfToken(), []) ?>
    <div id="author" class="form-group" style="margin-bottom: 30px">
        <label for="author-name">ФИО</label>
        <input id="author-name" style="width: 300px" class="form-control" type="text" name="Authors[name]" value="<?= $model->name ?>">
        <?= ($author_id)?Html::submitButton('Сохранить изменения', ['class' => 'btn btn-success', 'name' => 'login-button']):Html::submitButton('Добавить автора', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
        <button  id="add-penname" class="add-penname btn btn-success" >Добавить псевдоним</button>
        <button id="remove-penname" class="remove-penname btn btn-success">Убрать псевдоним</button>
    </div>
    <div id="pennames" data-count="<?= ($model->pennames[0])? count($model->pennames):0 ?>" data-author_id="<?= $author_id ?>">
        <?php if ($model->pennames[0]) { ?>
            <?php foreach ($model->pennames as $num => $penname) { ?>
                <div id="<?= $num ?>"  data-id="<?= $penname['id'] ?>" class="row" style="margin-bottom: 20px">
                    <label class="col-md-1">Псевдоним</label><input type="text" value="<?= $penname['penname'] ?>"
                                                                    name="Authors[pennames][<?= $num ?>][penname]"

                                                                    class="form-control col-md-4" style="width: 300px">
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</form>
