<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Разделы';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'columns' => [
        'section',
        'subsection',
        'cnt'
    ],
]) ?>
