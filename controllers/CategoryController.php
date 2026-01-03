<?php

namespace app\controllers;

use app\models\Category;
use app\models\Post;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\Pagination;

class CategoryController extends Controller
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
     * Список всіх категорій (для адміністратора)
     */
    public function actionIndex()
    {
        $query = Category::find();
        
        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $query->count(),
        ]);
        
        $categories = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'categories' => $categories,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Створення нової категорії
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Категорія успішно створена.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Редагування категорії
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Категорія успішно оновлена.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Видалення категорії
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        if ($model->delete()) {
            \Yii::$app->session->setFlash('success', 'Категорія успішно видалена.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Відображення постів за категорією
     */
    public function actionView($slug)
    {
        $category = Category::findOne(['slug' => $slug]);
        if (!$category) {
            throw new NotFoundHttpException('Категорія не знайдена.');
        }

        $query = Post::find()
            ->where(['category_id' => $category->id, 'status' => Post::STATUS_PUBLISHED])
            ->with('author')
            ->orderBy(['created_at' => SORT_DESC]);
            
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);
        
        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('view', [
            'category' => $category,
            'posts' => $posts,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Пошук моделі за ID
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошена категорія не знайдена.');
    }
}
