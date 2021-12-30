<?php

use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Главная страница';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">База сотрудников</h1>

        <p class="lead">Для просмотра перейдите по ссылке.</p>

        <p><?= Html::a('Начать', ['/employees/index'], ['class' => 'btn btn-lg btn-success']) ?></p>
    </div>

</div>
