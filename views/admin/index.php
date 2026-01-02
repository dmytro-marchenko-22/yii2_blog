<?php

use yii\helpers\Html;

$this->title = 'Панель адміністратора';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Категорії</h5>
                    <p class="card-text">Управління категоріями блогу</p>
                    <?= Html::a('Перейти до управління', ['/category/index'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Мітки</h5>
                    <p class="card-text">Управління мітками блогу</p>
                    <?= Html::a('Перейти до управління', ['/tag/index'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Публікації</h5>
                    <p class="card-text">Управління дописами блогу</p>
                    <?= Html::a('Перейти до управління', ['/post/index'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Коментарі</h5>
                    <p class="card-text">Управління коментарями</p>
                    <?= Html::a('Перейти до управління', ['/comment/index'], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
