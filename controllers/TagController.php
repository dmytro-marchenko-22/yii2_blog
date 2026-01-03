<?php

namespace app\controllers;

use app\models\Tag;
use app\models\Post;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\Pagination;

class TagController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $user = \Yii::$app->user->identity;
                            return $user && ($user->is_admin == 1);
                        }
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
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
     * Список всіх міток (для адміністратора)
     */
    public function actionIndex()
    {
        $query = Tag::find();
        
        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $query->count(),
        ]);
        
        $tags = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'tags' => $tags,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Створення нової мітки
     */
    public function actionCreate()
    {
        $model = new Tag();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Мітка успішно створена.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Редагування мітки
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Мітка успішно оновлена.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Видалення мітки
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        if ($model->delete()) {
            \Yii::$app->session->setFlash('success', 'Мітка успішно видалена.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Список публікацій з певною міткою
     */
    public function actionView($slug)
    {
        $tag = Tag::findOne(['slug' => $slug]);
        if (!$tag) {
            throw new NotFoundHttpException('Мітка не знайдена.');
        }

        $query = Post::find()
            ->joinWith('tags')
            ->where(['{{%tag}}.id' => $tag->id, '{{%post}}.status' => Post::STATUS_PUBLISHED])
            ->with('author', 'category')
            ->orderBy(['{{%post}}.created_at' => SORT_DESC])
            ->distinct();
            
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);
        
        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('view', [
            'tag' => $tag,
            'posts' => $posts,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Пошук моделі за ID
     */
    protected function findModel($id)
    {
        if (($model = Tag::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошена мітка не знайдена.');
    }
}
