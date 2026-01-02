<?php

/** @var yii\web\View $this */
/** @var array $posts */

use yii\bootstrap5\Html;

$this->title = 'Блог про мобільні телефони';
?>
<div class="site-index">
    <div class="jumbotron text-center bg-primary text-white mt-0 mb-5" style="padding: 20px 20px; border-radius: 8px;">
        <h1 class="display-4">Ласкаво просимо до нашого блогу!</h1>
        <p class="lead">Найкраще джерело інформації про мобільні телефони</p>
        <p>Будьте в курсі найновіших технологій, оглядів та новин зі світу мобільної індустрії.</p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="mb-4">Останні статті</h2>
                
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
                                    <?= date('d.m.Y H:i', $post->created_at) ?>
                                    <?php if ($post->category): ?>
                                        | <?= Html::a(
                                            Html::encode($post->category->name),
                                            ['/category/view', 'slug' => $post->category->slug],
                                            ['class' => 'text-decoration-none']
                                        ) ?>
                                    <?php endif; ?>
                                </div>
                                <p><?= Html::encode(substr(strip_tags($post->content), 0, 150)) ?>...</p>
                                
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
                                    <?= Html::a('Читати далі →', ['/post/view', 'slug' => $post->slug], ['class' => 'btn btn-sm btn-primary']) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="text-center">
                        <?= Html::a('Усі статті', ['/post/index'], ['class' => 'btn btn-lg btn-outline-primary']) ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <p>Статті поки що не додані. <?php if (!\Yii::$app->user->isGuest): ?>
                            <?= Html::a('Створіть першу статтю!', ['/post/create']) ?>
                        <?php endif; ?></p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-4" style="margin-top: 63px;">
                    <div class="card-body">
                        <h5 class="card-title">Про блог</h5>
                        <p class="card-text">
                            Ласкаво просимо до нашого спеціалізованого блогу про мобільні телефони! Тут ви знайдете актуальні 
                            огляди, новини та корисні поради про новітні смартфони.
                        </p>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Популярні мітки</h5>
                        <div>
                            <span class="tag"><?= Html::a('Samsung', ['/tag/view', 'slug' => 'samsung']) ?></span>
                            <span class="tag"><?= Html::a('iPhone', ['/tag/view', 'slug' => 'iphone']) ?></span>
                            <span class="tag"><?= Html::a('Android', ['/tag/view', 'slug' => 'android']) ?></span>
                            <span class="tag"><?= Html::a('Огляд', ['/tag/view', 'slug' => 'oglyad']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
