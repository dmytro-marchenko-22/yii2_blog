<?php

namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class AdminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $user = \Yii::$app->user->identity;
                            return $user && ($user->is_admin == 1);
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Головна сторінка адміністратора.
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
