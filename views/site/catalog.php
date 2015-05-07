<?php
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'columns' => [
        'id',
        'section',
        'subsection',
        'article',
        'brend',
        'model',
        'name',
        'size',
        'color',
        'orientation',
        'cnt'
    ],
]) ?>
