<?php
use yii\grid\GridView;
use yii\helpers\Html;
use app\models\Person;
echo HTML::tag('a', 'crear factura',['class'=>['btn btn-primary float-right']]);

echo GridView::widget([

'dataProvider' => $models

]);
?>