<?php

/** @var yii\web\View $this */
/** @var yii\data\Pagination $pagination */
/** @var array $posts */

use yii\bootstrap5\Html;
use yii\widgets\LinkPager;

$this->title = 'Усі статті';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="post-index">
    <h1 style="margin-top: 15px; margin-bottom: 15px;"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-8">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post-card">
                        <?php if ($post->image): ?>
                            <img src="<?= Html::encode($post->image) ?>" alt="<?= Html::encode($post->title) ?>" class="post-image">
                        <?php endif; ?>
                        <div class="post-content">
                            <h3>
                                <?= Html::a(Html::encode($post->title), ['view', 'slug' => $post->slug]) ?>
                            </h3>
                            <div class="text-muted small mb-2">
                                <strong><?= $post->author->username ?></strong> | 
                                <?= date('d.m.Y', $post->created_at) ?>
                                <?php if ($post->category): ?>
                                    | <?= Html::a(
                                        Html::encode($post->category->name),
                                        ['/category/view', 'slug' => $post->category->slug]
                                    ) ?>
                                <?php endif; ?>
                            </div>
                            <p><?= Html::encode(substr(strip_tags($post->content), 0, 200)) ?>...</p>
                            
                            <?php if ($post->tags): ?>
                                <div class="mb-3">
                                    <?php foreach ($post->tags as $tag): ?>
                                        <span class="tag">
                                            <?= Html::a(Html::encode($tag->name), ['/tag/view', 'slug' => $tag->slug]) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <p>
                                <?= Html::a('Читати →', ['view', 'slug' => $post->slug], ['class' => 'btn btn-sm btn-primary']) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="d-flex justify-content-center">
                    <?= LinkPager::widget([
                        'pagination' => $pagination,
                    ]) ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    Статей не знайдено.
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <?php if (!\Yii::$app->user->isGuest): ?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Створити статтю</h5>
                        <p><?= Html::a('Написати нову статтю', ['create'], ['class' => 'btn btn-primary btn-sm']) ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!\Yii::$app->user->isGuest && \Yii::$app->user->identity->is_admin): ?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Керування</h5>
                        <div class="d-grid gap-2">
                            <p><?= Html::a('Переглянути категорії', ['/category/index'], ['class' => 'btn btn-success btn-sm']) ?></p>
                            <p><?= Html::a('Переглянути мітки', ['/tag/index'], ['class' => 'btn btn-warning btn-sm']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
