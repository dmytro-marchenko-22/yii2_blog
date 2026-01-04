<?php

/** @var yii\web\View $this */
/** @var app\models\Post $post */
/** @var array $comments */
/** @var app\models\Comment $comment */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = Html::encode($post->title);
$this->params['breadcrumbs'][] = ['label' => 'Статті', 'url' => ['index']];
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

                    <div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('reply-form-<?= $item->id ?>').style.display = document.getElementById('reply-form-<?= $item->id ?>').style.display === 'none' ? 'block' : 'none';">
                            Відповісти
                        </button>

                        <?php if (!\Yii::$app->user->isGuest && \Yii::$app->user->identity->is_admin): ?>
                            <form method="post" action="<?= \Yii::$app->urlManager->createUrl(['/comment/delete', 'id' => $item->id]) ?>" style="display:inline;">
                                <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->csrfToken) ?>
                                <?= Html::submitButton('Видалити', ['class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm("Видалити цей коментар?");']) ?>
                            </form>
                        <?php endif; ?>
                    </div>

                    <!-- Форма для ответа -->
                    <div id="reply-form-<?= $item->id ?>" style="display: none; margin-top: 15px; padding-top: 15px; border-top: 1px solid #ddd;">
                        <?php $form = ActiveForm::begin(['action' => ['/comment/create']]); ?>
                            <input type="hidden" name="Comment[post_id]" value="<?= $post->id ?>">
                            <input type="hidden" name="Comment[parent_id]" value="<?= $item->id ?>">

                            <?php if (!\Yii::$app->user->isGuest): ?>
                                <input type="hidden" name="Comment[user_id]" value="<?= \Yii::$app->user->id ?>">
                                <input type="hidden" name="Comment[name]" value="<?= Html::encode(\Yii::$app->user->identity->username) ?>">
                                <input type="hidden" name="Comment[email]" value="<?= Html::encode(\Yii::$app->user->identity->email) ?>">
                                
                                <div class="mb-3">
                                    <textarea class="form-control" name="Comment[content]" rows="3" placeholder="Напишіть вашу відповідь..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Надіслати відповідь</button>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <a href="<?= \Yii::$app->urlManager->createUrl(['/site/login']) ?>">Увійдіть</a>, щоб відповісти на коментар
                                </div>
                            <?php endif; ?>
                        <?php ActiveForm::end(); ?>
                    </div>

                    <?php if (!empty($item->replies)): ?>
                        <div style="margin-left: 30px; margin-top: 15px;">
                            <?php foreach ($item->replies as $reply): ?>
                                <div class="comment mb-2" style="border-left: 3px solid #6c757d; padding-left: 15px;">
                                    <strong><?= Html::encode($reply->name) ?></strong>
                                    <div class="text-muted small"><?= date('d.m.Y H:i', $reply->created_at) ?></div>
                                    <p><?= Html::encode($reply->content) ?></p>

                                    <?php if (!\Yii::$app->user->isGuest && \Yii::$app->user->identity->is_admin): ?>
                                        <form method="post" action="<?= \Yii::$app->urlManager->createUrl(['/comment/delete', 'id' => $reply->id]) ?>" style="display:inline;">
                                            <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->csrfToken) ?>
                                            <?= Html::submitButton('Видалити', ['class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm("Видалити цей коментар?");']) ?>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <h3 class="mt-4 mb-3">Залишити коментар</h3>

            <?php if (\Yii::$app->user->isGuest): ?>
                <div class="alert alert-info">
                    <p>Щоб оставити коментар, будь ласка, <?= Html::a('авторизуйтеся', ['/site/login']) ?> або <?= Html::a('зареєструйтеся', ['/site/signup']) ?>.</p>
                </div>
            <?php else: ?>
                <?php $form = ActiveForm::begin(['action' => ['/comment/create']]); ?>

                    <input type="hidden" name="Comment[post_id]" value="<?= $post->id ?>">
                    <input type="hidden" name="Comment[user_id]" value="<?= \Yii::$app->user->id ?>">
                    <input type="hidden" name="Comment[name]" value="<?= Html::encode(\Yii::$app->user->identity->username) ?>">
                    <input type="hidden" name="Comment[email]" value="<?= Html::encode(\Yii::$app->user->identity->email) ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Ваш коментар:</label>
                        <textarea class="form-control" name="Comment[content]" rows="4" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Надіслати коментар</button>

                <?php ActiveForm::end(); ?>
            <?php endif; ?>
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
