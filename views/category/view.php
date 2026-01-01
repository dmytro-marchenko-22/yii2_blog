<?php

/** @var yii\web\View $this */
/** @var app\models\Category $category */
/** @var yii\data\Pagination $pagination */
/** @var array $posts */

use yii\bootstrap5\Html;
use yii\widgets\LinkPager;

$this->title = 'Категория: ' . Html::encode($category->name);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="category-view">
    <h1><?= Html::encode($category->name) ?></h1>
    
    <?php if ($category->description): ?>
        <p class="lead"><?= Html::encode($category->description) ?></p>
    <?php endif; ?>

    <hr>

    <div class="row">
        <div class="col-md-8">
            <h2 class="mb-4">Статьи в категории (<?= count($posts) ?>)</h2>

            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="post-card">
                        <?php if ($post->image): ?>
                            <img src="<?= Html::encode($post->image) ?>" alt="<?= Html::encode($post->title) ?>" class="post-image">
                        <?php endif; ?>
                        <div class="post-content">
                            <h3>
                                <?= Html::a(Html::encode($post->title), ['/post/view', 'slug' => $post->slug]) ?>
                            </h3>
                            <div class="text-muted small mb-2">
                                <strong><?= $post->author->username ?></strong> | 
                                <?= date('d.m.Y', $post->created_at) ?>
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
                                <?= Html::a('Читать →', ['/post/view', 'slug' => $post->slug], ['class' => 'btn btn-sm btn-primary']) ?>
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
                    Статей в этой категории не найдено.
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">О категории</h5>
                    <p class="card-text">
                        <?= $category->description ?: 'Описание категории скоро появится' ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
