<?php

/** @var yii\web\View $this */
/** @var array $comments */

use yii\bootstrap5\Html;
use yii\widgets\Pagination;

$this->title = 'Управління коментарями';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="comment-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Автор</th>
                    <th>Email</th>
                    <th>Стаття</th>
                    <th>Коментар</th>
                    <th>Дата</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $comment): ?>
                    <tr>
                        <td><?= Html::encode($comment->id) ?></td>
                        <td><?= Html::encode($comment->name) ?></td>
                        <td><?= Html::encode($comment->email) ?></td>
                        <td>
                            <?php if ($comment->post): ?>
                                <?= Html::a(
                                    Html::encode($comment->post->title),
                                    ['/post/view', 'slug' => $comment->post->slug],
                                    ['target' => '_blank']
                                ) ?>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?= Html::encode(substr($comment->content, 0, 50)) ?>...
                            </div>
                        </td>
                        <td><?= date('d.m.Y H:i', $comment->created_at) ?></td>
                        <td>
                            <form method="post" action="<?= \Yii::$app->urlManager->createUrl(['/comment/delete', 'id' => $comment->id]) ?>" style="display:inline;">
                                <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->csrfToken) ?>
                                <?= Html::submitButton('Видалити', ['class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm("Видалити цей коментар?");']) ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (empty($comments)): ?>
        <div class="alert alert-info">
            Коментарів поки що немає.
        </div>
    <?php endif; ?>
</div>
