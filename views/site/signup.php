<?php

/** @var yii\web\View $this */
/** @var app\models\SignupForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>Пожалуйста, заполните следующие поля для регистрации:</p>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Ваше имя пользователя']) ?>

                <?= $form->field($model, 'email')->emailInput(['placeholder' => 'Ваш email']) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль']) ?>

                <?= $form->field($model, 'confirmPassword')->passwordInput(['placeholder' => 'Повторите пароль']) ?>

                <div class="form-group">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

            <p class="mt-3">
                Уже зарегистрированы? 
                <?= Html::a('Войдите сюда', ['site/login']) ?>
            </p>
        </div>
    </div>
</div>
