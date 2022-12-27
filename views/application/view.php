<?php

use yii\helpers\Html;
use yii\helpers\Markdown;

/** @var yii\web\View $this */
/** @var app\models\Application $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="application-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <p>Последнее изменение: <?= date('h:i A F j Y e', $model->update_time); ?></p>
    <p>
        <?= Markdown::process($model->content); ?>
    </p>

</div>
