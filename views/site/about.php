<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Про нас';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 10px;">
    <div class="jumbotron bg-light p-5 rounded-lg">
        <h1 class="display-4 mb-4" style="color: black;"><?= Html::encode($this->title) ?></h1>
        <p class="lead" style="color: black;">
            Ласкаво просимо на наш блог! Тут ви знайдете цікаві статті, корисні поради та актуальну інформацію з різних тем.
        </p>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h2 class="card-title">
                        <i class="fa fa-info-circle text-primary"></i> Про блог
                    </h2>
                    <p class="card-text">
                        Наш блог створений для того, щоб поділитися знаннями та досвідом з нашою аудиторією. 
                        Ми регулярно публікуємо нові статті, що охоплюють різні сфери інтересів.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h2 class="card-title">
                        <i class="fa fa-star text-warning"></i> Що ви знайдете тут:
                    </h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0"><i class="fa fa-check text-success"></i> Цікаві статті та огляди</li>
                        <li class="list-group-item border-0"><i class="fa fa-check text-success"></i> Поради та рекомендації</li>
                        <li class="list-group-item border-0"><i class="fa fa-check text-success"></i> Обговорення актуальних тем</li>
                        <li class="list-group-item border-0"><i class="fa fa-check text-success"></i> Корисні ресурси та посилання</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-info mt-5" role="alert">
        <h4 class="alert-heading">
            <i class="fa fa-heart"></i> Дякуємо за увагу!
        </h4>
        <p>
            Дякуємо, що відвідуєте наш блог! Ми будемо раді вашим коментарям та пропозиціям.
        </p>
    </div>
</div>
