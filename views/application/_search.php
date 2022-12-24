<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ApplicationSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mb-3">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'form-horizontal'],
    ]); ?>

    <?= $form->field($model, 'title')->label('Поиск заявки по заголовку') ?>

    <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary mt-3']) ?>
    <?= Html::resetButton('Сбросить', ['class' => 'btn btn-outline-secondary mt-3']) ?>

    <?php ActiveForm::end(); ?>

</div>
