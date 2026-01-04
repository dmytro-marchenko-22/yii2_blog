<?php

/** @var yii\web\View $this */
/** @var app\models\Tag $tag */
/** @var yii\data\Pagination $pagination */
/** @var array $posts */

use yii\bootstrap5\Html;
use yii\widgets\LinkPager;

$this->title = 'Мітка: ' . Html::encode($tag->name);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tag-view">
    <h1>#<?= Html::encode($tag->name) ?></h1>

    <p class="lead">Статті, позначені міткою "<?= Html::encode($tag->name) ?>"</p>

    <hr>

    <div class="row">
        <div class="col-md-8">
            <h2 class="mb-4">Знайдено статей: <?= count($posts) ?></h2>

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
                                    <?php foreach ($post->tags as $t): ?>
                                        <span class="tag">
                                            <?= Html::a(Html::encode($t->name), ['view', 'slug' => $t->slug]) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <p>
                                <?= Html::a('Читати →', ['/post/view', 'slug' => $post->slug], ['class' => 'btn btn-sm btn-primary']) ?>
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
                    Статей з цією міткою не знайдено.
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Пошук за мітками</h5>
                    <p class="card-text">
                        Використовуйте мітки для швидкого пошуку статей за цікавими для вас темами.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
