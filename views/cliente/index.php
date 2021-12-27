<?php

use app\models\Facturafin;
use yii\grid\GridView;
use yii\helpers\Html;
use app\models\Person;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $modelhead app\models\head_fact*/
$f=New Facturafin;
?>
<?php
echo HTML::a('crear factura',['cliente/factura'],['class'=>['btn btn-success float-right']]);
?>

<br>
<div class="container m-4">
    <div class="card">
        <div class="card-header bg-primary">
            Buscar
    </div>
        <div class="card-body"/>
        <?= $this->render('_formsearch', [
            'modelhead' => $modelhead

        ]) ?>
        </div>
</div>

<div class="container">
<table class="table">
    <thead class="table table-dark">
    <tr>
        <td>Acciones</td>
        <td>Emision</td>
        <td>Documento</td>
        <td>Neto</td>
        <td>Iva</td>
        <td>Total</td>
    </tr>

    </thead>
<tbody class="table table-light">
<?php foreach($headfac as $fac):?>
    <?php $total=$f::findOne(['id_head'=>$fac->n_documentos])?>
    <tr>
    <td>
        <?= HTML::a("Borrar",['#'],['class'=>'btn btn-danger']) ?>
    </td>
    <td><?=Yii::$app->formatter->asDate($fac->f_timestamp, 'php:Y-m-d');?></td>
    <td>
        <?= HTML::a("fac" .  $fac->n_documentos,Url::to(['cliente/viewf', 'id' => $fac->n_documentos]))?></td>
    <td>
         <?= $total->subtotal?>
    </td>
    <td><?= $total->iva?></td>
    <td><?= $total->total?></td>
</tr>
<?php endforeach ?>
</tbody>
</table>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?= LinkPager::widget(['pagination'=>$pages])?>
        </ul>
    </nav>

</div>
