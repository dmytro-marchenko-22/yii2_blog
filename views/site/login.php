<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Вхід';
?>
<div class="site-login">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>Будь ласка, заповніть наступні поля для входу:</p>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Ім\'я користувача']) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль']) ?>

                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => '<div class="form-check">{input} Запам’ятати мене</div>',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Вхід', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>

            <p class="mt-3">
                Не зареєстровані? 
                <?= Html::a('Створіть обліковий запис', ['site/signup']) ?>
            </p>
        </div>
    </div>
</div>
            </div>

        </div>
    </div>
</div>
