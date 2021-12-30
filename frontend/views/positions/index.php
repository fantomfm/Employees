<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PositionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статистика';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="positions-index">

    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'position',
            [
                'attribute' => 'countPositions',
                'label' => 'Количество активных сотрудников',
            ],
        ],
    ]); ?>


</div>
