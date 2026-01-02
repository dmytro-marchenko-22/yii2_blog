<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Створити мітку';
$this->params['breadcrumbs'][] = ['label' => 'Керування мітками', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tag-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        <small class="form-text text-muted" style="margin-top: -15px; display: block; margin-bottom: 15px;">Залиште порожнім, щоб автоматично згенерувати</small>

        <div class="form-group">
            <?= Html::submitButton('Створити', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Скасувати', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
