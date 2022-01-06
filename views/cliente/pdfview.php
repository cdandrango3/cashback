<?php

use app\models\Product;
use yii\helpers\Html;
$producto=New Product;
?>

<div class="container">
    <div class="card">
        <div class="card-head p-2">
            <div class="container">
                <h3>Datos de la factura</h3>
            </div>

        </div>
        <div class="card-body">
            <div class="" style="font-size:12px">
                <?= "Fecha de emisión:".$model->f_timestamp?>
            </div>
            <div class="" style="font-size:12px">
                <?= "Número de documento:".$model->n_documentos?>
            </div>
            <div class="" style="font-size:12px">
                <?= "Persona:".$personam->name?>

    </div>
</div>
<br><br><br>
<div class="container">

            <table class="table table-bordered">
                <thead>
                <tr>
                <th>Cantidad</th>
                <th> Producto </th>
                <th> Valor unitario </th>
                <th> Valor final </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($model2 as $mbody): ?>
                    <?php $pro=$producto::findOne($mbody->id_producto)?>
                    <tr>
                        <td><?=$mbody->cant?></td>
                        <td><?=$pro->name?></td>
                        <td><?=$mbody->precio_u?></td>
                        <td><?=$mbody->precio_total?></td>

                    </tr>
                <?php endforeach ?>
                </tbody>

            </table>


</div>
<div class="container">
        <div class="">

                <strong>Subtotal:   </strong>  <div class="su"><?=$modelfin->subtotal12?></div>
                <strong>Iva: </strong>  <div class="su"> <?=$modelfin->iva ?></div>
                <strong>Total: </strong>  <div class="su"><?=$modelfin->iva ?><?=$modelfin->total ?></div>

        </div>
</div>

