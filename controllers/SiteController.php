<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\Post;
use app\models\Tag;
use app\models\Category;
use yii\db\Query;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Відображення головної сторінки.
     *
     * @return string
     */
    public function actionIndex()
    {
        $posts = Post::find()
            ->where(['status' => Post::STATUS_PUBLISHED])
            ->with('author', 'category')
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(5)
            ->all();

        // Отримати мітки з хоча б одним дописом
        $tags = Tag::find()
            ->innerJoinWith('posts', false)
            ->groupBy(['tag.id'])
            ->orderBy(['COUNT(post.id)' => SORT_DESC])
            ->all();

        // Отримати всі категорії
        $categories = Category::find()
            ->orderBy(['name' => SORT_ASC])
            ->all();

        return $this->render('index', [
            'posts' => $posts,
            'tags' => $tags,
            'categories' => $categories,
        ]);
    }

    /**
     * Процес входу
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Процес рееєстрації.
     *
     * @return Response|string
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(\Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (\Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Процес виходу із сайту.
     *
     * @return Response
     */
    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Відображення сторінки контактів.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(\Yii::$app->request->post()) && $model->contact(\Yii::$app->params['adminEmail'])) {
            \Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Відображення інформації про сторінку "Про нас".
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
