<?php

namespace app\controllers;

use app\models\Comment;
use app\models\Post;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class CommentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'delete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $user = \Yii::$app->user->identity;
                            return $user && ($user->is_admin == 1);
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['POST'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Список всіх коментарів.
     */
    public function actionIndex()
    {
        $comments = Comment::find()->orderBy(['created_at' => SORT_DESC])->all();
        
        return $this->render('index', [
            'comments' => $comments,
        ]);
    }

    /**
     * Створення нового коментаря.
     */
    public function actionCreate()
    {
        $comment = new Comment();

        if ($this->request->isPost) {
            $comment->load($this->request->post());
            $comment->status = Comment::STATUS_ACTIVE;

            if ($comment->save()) {
                \Yii::$app->session->setFlash('success', 'Коментар успішно додано.');
                $post = Post::findOne($comment->post_id);
                return $this->redirect(['/post/view', 'slug' => $post->slug]);
            }
        }

        throw new NotFoundHttpException('Помилка при додаванні коментаря.');
    }

    /**
     * Оновлення коментаря.
     */
    public function actionUpdate($id)
    {
        $comment = Comment::findOne($id);
        if (!$comment) {
            throw new NotFoundHttpException('Коментар не знайдено.');
        }

        if ($this->request->isPost) {
            $comment->load($this->request->post());

            if ($comment->save()) {
                \Yii::$app->session->setFlash('success', 'Коментар оновлено.');
                $post = Post::findOne($comment->post_id);
                return $this->redirect(['/post/view', 'slug' => $post->slug]);
            }
        }

        return $this->render('update', [
            'comment' => $comment,
        ]);
    }

    /**
     * Видалення коментаря.
     */
    public function actionDelete($id)
    {
        $comment = Comment::findOne($id);
        if (!$comment) {
            throw new NotFoundHttpException('Коментар не знайдено.');
        }

        $postId = $comment->post_id;
        $post = Post::findOne($postId);
        $comment->delete();

        \Yii::$app->session->setFlash('success', 'Коментар видалено.');
        return $this->redirect(['/post/view', 'slug' => $post->slug]);
    }
}
