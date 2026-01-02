<?php

/** @var yii\web\View $this */
/** @var app\models\SignupForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Реєстрація';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>Будь ласка, заповніть наступні поля для реєстрації:</p>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Ваше ім\'я користувача']) ?>

                <?= $form->field($model, 'email')->textInput(['type' => 'email', 'placeholder' => 'Ваш email']) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль']) ?>

                <?= $form->field($model, 'confirmPassword')->passwordInput(['placeholder' => 'Повторіть пароль']) ?>

                <div class="form-group">
                    <?= Html::submitButton('Зареєструватися', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

            <p class="mt-3">
                Вже зареєстровані?? 
                <?= Html::a('Увійдіть сюди', ['site/login']) ?>
            </p>
        </div>
    </div>
</div>
