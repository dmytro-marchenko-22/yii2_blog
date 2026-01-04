<?php

/** @var yii\web\View $this */
/** @var array $posts */
/** @var array $tags */
/** @var array $categories */

use yii\bootstrap5\Html;

$this->title = 'Блог про мобільні телефони';
?>
<div class="site-index">
    <div class="jumbotron text-center bg-primary text-white mt-0 mb-5" style="padding: 20px 20px; border-radius: 8px;">
        <h1 class="display-4">Ласкаво просимо до нашого блогу!</h1>
        <p class="lead">Найкраще джерело інформації про мобільні телефони.</p>
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
                    
                    <?php if (!\Yii::$app->user->isGuest && \Yii::$app->user->identity->is_admin): ?>
                        <div class="text-center">
                            <?= Html::a('Усі статті', ['/post/index'], ['class' => 'btn btn-lg btn-outline-primary']) ?>
                        </div>
                    <?php endif; ?>
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
                
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Популярні мітки</h5>
                        <div>
                            <?php if (!empty($tags)): ?>
                                <?php foreach ($tags as $tag): ?>
                                    <span class="tag"><?= Html::a(Html::encode($tag->name), ['/tag/view', 'slug' => $tag->slug]) ?></span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted">Мітки поки що не додані.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Категорії</h5>
                        <div>
                            <?php if (!empty($categories)): ?>
                                <ul style="list-style: none; padding: 0; margin: 0;">
                                    <?php foreach ($categories as $category): ?>
                                        <li style="margin-bottom: 8px;">
                                            <?= Html::a(Html::encode($category->name), ['/category/view', 'slug' => $category->slug], ['class' => 'text-decoration-none']) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-muted">Категорії поки що не додані.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
