<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Керування категоріями';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="category-index">
    <h1 style="margin-bottom: 30px;"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Створити категорію', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= Yii::$app->session->getFlash('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($categories)): ?>
        <p>Категорій не знайдено.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Назва</th>
                    <th>URL</th>
                    <th>Кількість постів</th>
                    <th>Дата створення</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= $category->id ?></td>
                        <td><?= Html::encode($category->name) ?></td>
                        <td><?= Html::encode($category->slug) ?></td>
                        <td><?= count($category->getPosts()->all()) ?></td>
                        <td><?= date('d.m.Y', $category->created_at) ?></td>
                        <td>
                            <?= Html::a('Редагувати', ['update', 'id' => $category->id], ['class' => 'btn btn-primary btn-sm']) ?>
                            <?= Html::beginForm(['delete', 'id' => $category->id], 'post', ['style' => 'display:inline;']) ?>
                            <?= Html::submitButton('Видалити', ['class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Ви впевнені?")']) ?>
                            <?= Html::endForm() ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?= LinkPager::widget(['pagination' => $pagination]) ?>
    <?php endif; ?>
</div>
