<?php

/** @var yii\web\View $this */
/** @var app\models\Post $post */
/** @var array $comments */
/** @var app\models\Comment $comment */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = Html::encode($post->title);
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
if ($post->category) {
    $this->params['breadcrumbs'][] = ['label' => $post->category->name, 'url' => ['/category/view', 'slug' => $post->category->slug]];
}
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="post-view">
    <div class="row">
        <div class="col-md-8">
            <?php if ($post->image): ?>
                <img src="<?= Html::encode($post->image) ?>" alt="<?= Html::encode($post->title) ?>" class="post-detail-image">
            <?php endif; ?>

            <h1><?= Html::encode($post->title) ?></h1>

            <div class="post-meta text-muted mb-3">
                <div>
                    <strong>Автор:</strong> <?= Html::encode($post->author->username) ?><br>
                    <strong>Дата:</strong> <?= date('d.m.Y H:i', $post->created_at) ?><br>
                    <?php if ($post->category): ?>
                        <strong>Категорія:</strong> 
                        <?= Html::a(Html::encode($post->category->name), ['/category/view', 'slug' => $post->category->slug]) ?><br>
                    <?php endif; ?>
                </div>

                <?php if ($post->tags): ?>
                    <div class="mt-2">
                        <strong>Мітки:</strong><br>
                        <?php foreach ($post->tags as $tag): ?>
                            <span class="tag">
                                <?= Html::a(Html::encode($tag->name), ['/tag/view', 'slug' => $tag->slug]) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="mt-2">
                    <strong>Поділитися:</strong>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(\Yii::$app->request->absoluteUrl) ?>" target="_blank" class="ms-2">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?= urlencode(\Yii::$app->request->absoluteUrl) ?>&text=<?= urlencode($post->title) ?>" target="_blank" class="ms-2">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(\Yii::$app->request->absoluteUrl) ?>" target="_blank" class="ms-2">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>

            <hr>

            <div class="post-body mb-5">
                <?= $post->content ?>
            </div>

            <?php if (!\Yii::$app->user->isGuest && \Yii::$app->user->id == $post->author_id): ?>
                <div class="mb-4">
                    <?= Html::a('Редагувати', ['update', 'id' => $post->id], ['class' => 'btn btn-warning']) ?>
                    <form method="post" action="<?= \Yii::$app->urlManager->createUrl(['post/delete', 'id' => $post->id]) ?>" style="display:inline;">
                        <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->csrfToken) ?>
                        <?= Html::submitButton('Видалити', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Ви впевнені?");']) ?>
                    </form>
                </div>
            <?php endif; ?>

            <h2 class="mt-5 mb-3">Коментарі (<?= count($comments) ?>)</h2>

            <?php foreach ($comments as $item): ?>
                <div class="comment mb-3" style="border-left: 3px solid #007bff; padding-left: 15px;">
                    <strong><?= Html::encode($item->name) ?></strong>
                    <div class="text-muted small"><?= date('d.m.Y H:i', $item->created_at) ?></div>
                    <p><?= Html::encode($item->content) ?></p>

                    <?php if (!empty($item->replies)): ?>
                        <div style="margin-left: 30px;">
                            <?php foreach ($item->replies as $reply): ?>
                                <div class="comment mb-2" style="border-left: 3px solid #6c757d; padding-left: 15px;">
                                    <strong><?= Html::encode($reply->name) ?></strong>
                                    <div class="text-muted small"><?= date('d.m.Y H:i', $reply->created_at) ?></div>
                                    <p><?= Html::encode($reply->content) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <h3 class="mt-4 mb-3">Залишити коментар</h3>

            <?php $form = ActiveForm::begin(['action' => ['/comment/create']]); ?>

                <input type="hidden" name="Comment[post_id]" value="<?= $post->id ?>">

                <?php if (!\Yii::$app->user->isGuest): ?>
                    <input type="hidden" name="Comment[user_id]" value="<?= \Yii::$app->user->id ?>">
                    <input type="hidden" name="Comment[name]" value="<?= Html::encode(\Yii::$app->user->identity->username) ?>">
                    <input type="hidden" name="Comment[email]" value="<?= Html::encode(\Yii::$app->user->identity->email) ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Ваш коментар:</label>
                        <textarea class="form-control" name="Comment[content]" rows="4" required></textarea>
                    </div>
                <?php else: ?>
                    <div class="mb-3">
                        <label class="form-label">Ваше ім'я:</label>
                        <input type="text" class="form-control" name="Comment[name]" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email:</label>
                        <input type="email" class="form-control" name="Comment[email]" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Коментар:</label>
                        <textarea class="form-control" name="Comment[content]" rows="4" required></textarea>
                    </div>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary">Надіслати коментар</button>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Про автора</h5>
                    <p class="card-text">
                        <strong><?= Html::encode($post->author->username) ?></strong><br>
                        Автор блогу про мобільні телефони та технології. 
                    </p>
                </div>
            </div>

            <?php if ($post->tags): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Мітки</h5>
                        <div>
                            <?php foreach ($post->tags as $tag): ?>
                                <span class="tag">
                                    <?= Html::a(Html::encode($tag->name), ['/tag/view', 'slug' => $tag->slug]) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
