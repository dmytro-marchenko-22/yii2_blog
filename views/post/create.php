<?php

/** @var yii\web\View $this */
/** @var app\models\Post $post */
/** @var array $categories */
/** @var array $allTags */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Створити нову статтю';
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="post-create">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <?= $form->field($post, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Название статьи']) ?>

                <?= $form->field($post, 'category_id')->dropDownList(
                    array_combine(
                        array_map(function($c) { return $c->id; }, $categories), 
                        array_map(function($c) { return $c->name; }, $categories)
                    ),
                    ['prompt' => 'Виберіть категорію']
                ) ?>
    
                <?= $form->field($post, 'imageFile')->fileInput(['accept' => 'image/*']) ?>

                <?= $form->field($post, 'content')->textarea(['rows' => 10, 'placeholder' => 'Зміст статті']) ?>

                <?= $form->field($post, 'status')->dropDownList([
                    \app\models\Post::STATUS_DRAFT => 'Чернетка',
                    \app\models\Post::STATUS_PUBLISHED => 'Опубліковано',
                ]) ?>

                <div class="mb-3">
                    <label class="form-label">Мітки:</label>
                    <div>
                        <?php foreach ($allTags as $tag): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tags[]" 
                                       value="<?= $tag->id ?>" id="tag_<?= $tag->id ?>">
                                <label class="form-check-label" for="tag_<?= $tag->id ?>">
                                    <?= Html::encode($tag->name) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Створити статтю', ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Скасування', ['index'], ['class' => 'btn btn-secondary ms-2']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
