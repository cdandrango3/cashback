<?php

use app\models\Charges;
use app\models\ChartAccounts;
use app\models\Person;
use yii\helpers\Html;
use yii\helpers\Url;

$model2=Charges::findOne(["id"=>$transaccion->id_charge]);
$person=Person::findOne(["id"=>$model2->person_id]);
$char=ChartAccounts::findOne(["id"=>$transaccion->chart_account]);

?>
<div class="float-right"> <?= HTML::a("pdf",Url::to(["pdfview","com"=>$transaccion->comprobante]),["class"=>"btn btn-primary"])?> </div>
<div class="row">

</div>
<br>
<br>
<br>
<div class="container">
    <div class="card">
        <div class="card-header bg-primary">
            Datos Generales
        </div>
   <div class="card-body">
<div>
   Tipo de transaccion :   <?=$model2->type_charge?>
</div>
       <div>
           Fecha de emisión :   <?=$model2->date?>
       </div>
       <div>
           Persona :   <?=$person->name?>
       </div>
       <div>
           Cuenta de Cobro :   <?=$char->slug?>
       </div>
       <div>
           Total :   <?=$transaccion->amount?> $
       </div>
       <div>
           Descripcion :   <?=$model2->Description?> $
       </div>
   </div>
    </div>

</div>
<br>
<div class="container">
    <div class="card">
        <div class="card-body">
<table class="table table-striped table-bordered">

    <thead class="table">
    <tr>
        <td>
      Documento
        </td>
        <td>Fecha de emision</td>
        <td>Tipo de Documento</td>
        <td>Valor</td>
        <td>Saldo A Pagar</td>
        <td>Valor a pagar</td>
    </tr>
    </thead>
    <tbody>
<tr>
    <td><?= HTML::a($model2->n_document,Url::to(["/cliente/viewf","id"=>$model2->n_document]))?></td>
    <td><?= $model2->date?></td>
    <td>Factura</td>
    <td><?= $transaccion->balance?></td>
    <td><?= $transaccion->saldo?></td>
    <td><?= $transaccion->amount?></td>
</tr>
    </tbody>
</table>
        </div>
    </div>
</div>