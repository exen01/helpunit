<?php

use yii\helpers\Html;
use yii\helpers\Markdown;

/* @var $model app\models\Article */
?>
<div class="card md-3">
    <div class="card-header">
        <?= Html::a(Html::encode($model->title), $model->getUrl()) ?>
    </div>
    <div class="card-body">
        <div class="card-text">
            <?= Markdown::process(substr($model->content, 0, 250) . '...'); ?>
        </div>
    </div>
    <div class="card-footer">
        <nav class="list-group list-group-horizontal">
            <div class="list-group-item">
                Last updated on <?= date('h:i A, F j, Y', $model->update_time); ?>
            </div>
        </nav>
    </div>
</div>