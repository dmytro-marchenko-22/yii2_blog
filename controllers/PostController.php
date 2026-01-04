<?php

namespace app\controllers;

use app\models\Post;
use app\models\Category;
use app\models\Tag;
use app\models\PostTag;
use app\models\Comment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class PostController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Список усіх публікацій.
     */
    public function actionIndex()
    {
        $query = Post::find()
            ->with('author', 'category');
        
        // Відображення опублікованих публікацій та чернеток для їх авторів
        if (\Yii::$app->user->isGuest) {
            $query->where(['status' => Post::STATUS_PUBLISHED]);
        } else {
            $query->andWhere(['or',
                ['status' => Post::STATUS_PUBLISHED],
                ['and', ['status' => Post::STATUS_DRAFT], ['author_id' => \Yii::$app->user->id]]
            ]);
        }
        
        $query->orderBy(['created_at' => SORT_DESC]);
            
        $pagination = new \yii\data\Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);
        
        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'posts' => $posts,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Список чернеток (тільки для адміністраторів).
     */
    public function actionDrafts()
    {
        $query = Post::find()
            ->with('author', 'category')
            ->where(['status' => Post::STATUS_DRAFT])
            ->orderBy(['created_at' => SORT_DESC]);
            
        $pagination = new \yii\data\Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);
        
        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('drafts', [
            'posts' => $posts,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Відображення публікації.
     */
    public function actionView($slug)
    {
        $post = Post::findOne(['slug' => $slug]);
        if (!$post) {
            throw new NotFoundHttpException('Статтю не знайдено.');
        }
        
        // Відображення чернеток лише для автора або адміністратора
        if ($post->status == Post::STATUS_DRAFT && (\Yii::$app->user->isGuest || \Yii::$app->user->id != $post->author_id)) {
            throw new NotFoundHttpException('Статтю не знайдено.');
        }

        $comments = Comment::find()
            ->where(['post_id' => $post->id, 'parent_id' => null, 'status' => Comment::STATUS_ACTIVE])
            ->with('replies', 'user')
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        $comment = new Comment();
        $comment->post_id = $post->id;

        return $this->render('view', [
            'post' => $post,
            'comments' => $comments,
            'comment' => $comment,
        ]);
    }

    /**
     * Створення нової публікації.
     */
    public function actionCreate()
    {
        $post = new Post();
        $post->author_id = \Yii::$app->user->id;
        $post->status = Post::STATUS_DRAFT;

        if ($this->request->isPost) {
            $post->load($this->request->post());
            $post->imageFile = \yii\web\UploadedFile::getInstance($post, 'imageFile');

            if (isset($this->request->post()['tags'])) {
                $tags = $this->request->post()['tags'];
            } else {
                $tags = [];
            }

            if ($post->save()) {
                $post->uploadImage();
                if ($post->image) {
                    $post->save(false); 
                }
                
                // Збереження міток
                PostTag::deleteAll(['post_id' => $post->id]);
                foreach ($tags as $tag_id) {
                    $postTag = new PostTag();
                    $postTag->post_id = $post->id;
                    $postTag->tag_id = $tag_id;
                    $postTag->save();
                }

                \Yii::$app->session->setFlash('success', 'Статтю успішно створено.');
                return $this->redirect(['view', 'slug' => $post->slug]);
            }
        }

        $categories = Category::find()->all();
        $allTags = Tag::find()->all();

        return $this->render('create', [
            'post' => $post,
            'categories' => $categories,
            'allTags' => $allTags,
        ]);
    }

    /**
     * Оновлення існуючої публікації.
     */
    public function actionUpdate($id)
    {
        $post = $this->findModel($id);
        $oldImage = $post->image; 

        if ($this->request->isPost) {
            $post->load($this->request->post());
            $post->image = $oldImage; 
            $post->imageFile = \yii\web\UploadedFile::getInstance($post, 'imageFile');

            if (isset($this->request->post()['tags'])) {
                $tags = $this->request->post()['tags'];
            } else {
                $tags = [];
            }

            if ($post->save()) {
                if ($post->imageFile) {
                    $post->uploadImage();
                    if ($post->image) {
                        $post->save(false);
                    }
                } else {
                    $post->image = $oldImage;
                    $post->save(false);
                }
                
                // Збереження міток
                PostTag::deleteAll(['post_id' => $post->id]);
                foreach ($tags as $tag_id) {
                    $postTag = new PostTag();
                    $postTag->post_id = $post->id;
                    $postTag->tag_id = $tag_id;
                    $postTag->save();
                }

                \Yii::$app->session->setFlash('success', 'Статтю успішно оновлено.');
                return $this->redirect(['view', 'slug' => $post->slug]);
            }
        }

        $categories = Category::find()->all();
        $allTags = Tag::find()->all();
        $selectedTags = $post->tags;

        return $this->render('update', [
            'post' => $post,
            'categories' => $categories,
            'allTags' => $allTags,
            'selectedTags' => $selectedTags,
        ]);
    }

    /**
     * Видалення існуючої публікації.
     */
    public function actionDelete($id)
    {
        $post = $this->findModel($id);
        $post->delete();

        \Yii::$app->session->setFlash('success', 'Статтю успішно видалено.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Post::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Статтю не знайдено.');
    }
}
