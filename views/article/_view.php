<?php

use yii\helpers\Html;
use yii\helpers\Markdown;

/* @var $model app\models\Article */
?>
<div class="card mb-3">
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
                Последнее обновление: <?= date('h:i A M j Y e', $model->update_time); ?>
            </div>
            <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id < 3): ?>
                <div class="list-group-item">
                    <?= Html::a('Редактировать', ['article/update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                </div>
                <div class="list-group-item">
                    <?= Html::a('Удалить', ['article/delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                            'method' => 'post',
                        ],]) ?>
                </div>
            <?php endif; ?>
        </nav>
    </div>
</div>