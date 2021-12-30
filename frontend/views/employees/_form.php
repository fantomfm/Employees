<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use nex\chosen\Chosen;
use frontend\models\Positions;
use frontend\models\Placement;

/* @var $this yii\web\View */
/* @var $model frontend\models\Employees */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employees-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class ='mb-4'>
        <?= $form->field($model, 'name', ['options' => ['class' => 'p-0 col-5 mb-3']])->textInput(['maxlength' => true]) ?>

        <div class='p-0 mb-3 col-3'>
            <label class='control-label' for='employees-position_list'>Должность</label>
            <?= Chosen::widget([
                    'model' => $model,
                    'attribute' => 'position_list',
                    'items' => ArrayHelper::map(
                        Positions::find()->select('id, position')->orderBy('position')->asArray()->all(), 
                        'id', 
                        'position'
                    ),
                    // 'options' => [
                    //     'class' => 'vehicle_id form-control input-sm',
                    // ],
                    'multiple' => false,
                    'placeholder' => 'Выберите должность',
                    'clientOptions' => [
                        'search_contains' => true,
                        'max_selected_options' => 1,
                    ],
                ]);
            ?>
        </div>
    
    
        <?= $form->field($model, 'birthday', ['options' => ['class' => 'p-0 col-3 mb-3']])->textInput(['type' => 'date']) ?>

        <?= $form->field($model, 'phone', ['options' => ['class' => 'p-0 col-3 mb-3']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email', ['options' => ['class' => 'p-0 col-3 mb-3']])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'image', ['options' => ['class' => 'p-0 col-3 btn']])->fileInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
