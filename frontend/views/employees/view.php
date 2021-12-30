<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Employees */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="employees-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?  if ($model->idRefStatuses == 1)
                echo Html::a('Уволить', ['dismiss', 'id' => $model->id], ['class' => 'btn btn-warning']) 
        ?>
        <?= Html::a('Удалить из базы', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Удалить эту запись из базы?',
                    'method' => 'post',
                ],
        ]) ?>
        <?  if ($model->image)
                echo Html::a('Удалить фото', ['delete-image', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'method' => 'post'
                        ]
                        ]);
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'options' => ['class' => 'table table-striped table-bordered detail-view col-9'],
        'attributes' => [
            [
                'attribute' => 'image',
                'format' => 'raw',
                'captionOptions' => ['class' => 'align-middle'],
                'value' => function ($model) {
                    if (file_exists($model->image)) 
                        return Html::img($model->image, ['alt' => 'фото Сотрудника', 'width' => 200]);
                    return '';
                },
            ],
            'name',
            'birthday',
            'phone',
            'email:email',
            'positionName',
            'status',
        ],
    ]) ?>

</div>
