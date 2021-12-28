<?php

?>
<?php use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form=ActiveForm::begin()?>
<?= $form->field($chargem, 'type_charge')->dropDownList(
    ['Caja' => 'Caja', 'Transferencia' => 'Transferencia','Cheque' => 'Cheque'], ["id" => "tipodocu"])->label("Forma de Cobro")  ?>
<?=
$form->field($chargem,'date')->textInput(["readonly"=>True,"value"=>\Yii::$app->formatter->asDate($header->f_timestamp, 'dd/MM/yyyy')])->label("Fecha");
?>
<?=
$form->field($Person,'name')->textInput(["readonly"=>True,"value"=>$Person->name])->label("Persona");
?>
<?=
$form->field($chargem,'comprobante')->label("N de Comprobante");

?>
<?=
$form->field($chargem,'Description')->label("Descripción")->textarea(['rows' => '6']);
?>
    <br/>
    <br/>
    <br/>
<div class="card">
    <div class="card-header">
        <table class="table table-light">
            <thead>
            <tr>
            <td>Documento</td>
            <td>Fecha de emisión</td>
            <td>Tipo de Documentos</td>
            <td>Valor</td>
            <td>Saldo</td>
                <td>Valor a pagar</td>
            </tr>
            </thead>
        <tbody>
       <tr>
           <td>
               <?= $header->n_documentos?>
           </td>
           <td><?=\Yii::$app->formatter->asDate($header->f_timestamp, 'dd/MM/yyyy') ?></td>
           <td>Factura</td>
           <td><?= $body->total ?></td>
           <td><?=$body->total?></td>
           <td><?= $form->field($chargem,'amount')->label(false); ?></td>
       </tr>
        </tbody>
        </table>
    </div>
    <div class="card-body">

    </div>
</div>
    <br>
    <br>
    <br>
<?= HTML::tag("button","Guardar",["class"=>"btn btn-success"]) ?>
<?php ActiveForm::end()?>