<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редагувати категорію: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Керування категоріями', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="category-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        <small class="form-text text-muted" style="margin-top: -15px; display: block; margin-bottom: 15px;">Залиште порожнім, щоб автоматично перегенерувати</small>

        <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>

        <div class="form-group">
            <?= Html::submitButton('Оновити', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Скасувати', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
