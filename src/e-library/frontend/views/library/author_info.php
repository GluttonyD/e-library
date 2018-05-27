<?php
/**
 * @var yii\web\View $this
 * @var frontend\models\AuthorInfo $author
 * @var $author_id
 */

use yii\helpers\Html;
use yii\helpers\Url;

$config=array();
array_push($config, '/library/add-author');
($author_id) ? ($config['author_id'] = $author_id) : null;
?>

    <div id="author" class="form-group" style="margin-bottom: 30px">
        <p><b>ФИО : </b><?= $author->name ?></p>
    </div>
    <div id="pennames" data-count="<?= ($model->pennames[0])? count($model->pennames):0 ?>" data-author_id="<?= $author_id ?>">
        <?php if ($author->pennames[0]) { ?>
            <?php foreach ($author->pennames as $num => $penname) { ?>
                <div class="row" style="margin-bottom: 20px">
                    <p><b>Псевдоним : </b><?= $penname ?></p>
                </div>
            <?php } ?>
        <?php } ?>
    </div>