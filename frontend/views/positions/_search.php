<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PositionsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="positions-search">
 
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'd-flex align-items-end'],
    ]); ?>

    <?= $form->field($model, 'position', ['options' => ['class' => 'me-2']]) ?>

    <?= $form->field($model, 'start', ['options' => ['class' => 'me-2']])->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'end', ['options' => ['class' => 'me-2']])->textInput(['type' => 'date']) ?>

    <div>
        <?= Html::submitButton('Найти', ['class' => 'btn btn-success']) ?>
        <?= Html::resetButton('Сбросить', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>