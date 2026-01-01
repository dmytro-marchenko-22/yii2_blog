<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => \Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => \Yii::getAlias('@web/favicon.ico')]);
$this->registerLinkTag(['rel' => 'stylesheet', 'href' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= \Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        body {
            background-color: #f5f5f5;
        }
        #header {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        #main {
            margin-top: 80px;
        }
        .post-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            margin-bottom: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,.15);
        }
        .post-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
        }
        .post-content {
            padding: 20px;
        }
        .tag {
            display: inline-block;
            background: #e9ecef;
            padding: 5px 10px;
            border-radius: 20px;
            margin-right: 5px;
            font-size: 0.85rem;
            margin-bottom: 5px;
        }
        .tag a {
            text-decoration: none;
            color: #495057;
        }
        .tag a:hover {
            color: #007bff;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => 'Мобільний Блог',
        'brandUrl' => \Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark']
    ]);
    
    $menuItems = [
        ['label' => 'Головна', 'url' => ['/site/index']],
        ['label' => 'Статті', 'url' => ['/post/index']],
        ['label' => 'Про сайт', 'url' => ['/site/about']],
    ];
    
    if (\Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Вхід', 'url' => ['/site/login']];
        $menuItems[] = ['label' => 'Реєстрація', 'url' => ['/site/signup']];
    } else {
        $menuItems[] = [
            'label' => 'Нова стаття',
            'url' => ['/post/create']
        ];
        $menuItems[] = [
            'label' => 'Вихід (' . \Yii::$app->user->identity->username . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'],
        'items' => $menuItems
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                &copy; Блог о мобильных телефонах <?= date('Y') ?>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="#" class="text-white"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-white ms-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white ms-2"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
