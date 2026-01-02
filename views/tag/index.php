<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Керування мітками';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tag-index">
    <h1 style="margin-bottom: 30px;"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Створити мітку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= Yii::$app->session->getFlash('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($tags)): ?>
        <p>Міток не знайдено.</p>
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
                <?php foreach ($tags as $tag): ?>
                    <tr>
                        <td><?= $tag->id ?></td>
                        <td><?= Html::encode($tag->name) ?></td>
                        <td><?= Html::encode($tag->slug) ?></td>
                        <td><?= count($tag->getPosts()->all()) ?></td>
                        <td><?= date('d.m.Y', $tag->created_at) ?></td>
                        <td>
                            <?= Html::a('Редагувати', ['update', 'id' => $tag->id], ['class' => 'btn btn-primary btn-sm']) ?>
                            <?= Html::beginForm(['delete', 'id' => $tag->id], 'post', ['style' => 'display:inline;']) ?>
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
