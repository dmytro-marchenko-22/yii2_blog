<?php

namespace app\controllers;

use app\models\Tag;
use app\models\Post;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TagController extends Controller
{
    /**
     * Перелік публікацій за міткою.
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
            
        $pagination = new \yii\data\Pagination([
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
}
