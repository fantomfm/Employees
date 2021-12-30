<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EmployeesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сотрудники';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employees-index">

    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h1><?= Html::encode($this->title) ?></h1>
            <p><?= Html::a('Нанять', ['create'], ['class' => 'btn btn-success']) ?></p>
        </div>
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'tableOptions' => ['class' => 'table table-striped table-bordered text-center'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['class' => 'align-middle'],
                'contentOptions' => ['class' => 'align-middle'],
            ],
            
            [
                'attribute' => 'image',
                'format' => 'raw',
                'options' => [
                    'width' => '70',
                ],
                'value' => function ($model) {
                    if (file_exists($model->image))
                        return Html::img($model->image, ['alt' => 'фото Сотрудника', 'width' => 50]);
                    return '';
                },
                'headerOptions' => ['class' => 'text-wrap align-middle'],
            ],
            [
                'attribute' => 'name',
                'headerOptions' => ['class' => 'align-middle'],
                'contentOptions' => ['class' => 'align-middle'],
            ],
            [
                'attribute' => 'birthday',
                'format' =>  ['date', 'dd.MM.Y'],
                'headerOptions' => ['class' => 'align-middle'],
                'contentOptions' => ['class' => 'align-middle'],
            ],
            [
                'attribute' => 'phone',
                'headerOptions' => ['class' => 'align-middle'],
                'contentOptions' => ['class' => 'align-middle'],
            ],
            [
                'attribute' => 'email',
                'format' => 'email',
                'headerOptions' => ['class' => 'align-middle'],
                'contentOptions' => ['class' => 'align-middle'],
            ],
            [
                'attribute' => 'positionName',
                'headerOptions' => ['class' => 'text-wrap align-middle'],
                'contentOptions' => ['class' => 'align-middle'],
            ],
            [
                'attribute' => 'dateEmployment',
                'label' => 'Дата трудоустройства/ увольнения',
                'headerOptions' => ['class' => 'text-wrap align-middle'],
                'contentOptions' => ['class' => 'align-middle'],
            ],
            [
                'attribute' => 'status',
                'headerOptions' => ['class' => 'align-middle'],
                'contentOptions' => ['class' => 'align-middle'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '80'],
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url,$model,$key) {
                        return Html::a('<img src="img/view.png" alt="посмотреть карточку" />', $url);
                    },
                ],
                'contentOptions' => ['class' => 'align-middle'],
            ],
        ],
    ]); ?>


</div>
