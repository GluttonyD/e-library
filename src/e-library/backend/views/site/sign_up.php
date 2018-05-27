<?php
/**
 * @var yii\web\View $this
 * @var app\models\SignUp $model
 */
use yii\helpers\Html;
?>
<div>
    <form method="post" action="/site/sign-up" class="form-group" style="width: 40%">
        <?= yii\helpers\Html:: hiddenInput(\Yii:: $app->getRequest()->csrfParam, \Yii:: $app->getRequest()->getCsrfToken(), []) ?>
        <label for="username">Имя</label>
        <input  class="form-control" id="username" type="text" name="SignUp[username]">
        <label for="password">Пароль</label>
        <input class="form-control" id="password" type="password" name="SignUp[password]" style="margin-bottom: 10px">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary form-control', 'name' => 'login-button']) ?>
    </form>
    <?php if( $model->hasErrors()){
        \yii\helpers\VarDumper::dump($model->errors);
    } ?>
</div>
