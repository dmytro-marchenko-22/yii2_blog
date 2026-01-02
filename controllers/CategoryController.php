<?php

namespace app\controllers;

use app\models\Category;
use app\models\Post;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{
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
            
        $pagination = new \yii\data\Pagination([
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
}
