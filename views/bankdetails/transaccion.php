<?php
/* @var $model2 app\models\BankdetailsSearch */

?>
<table class="table table-striped table-bordered ">
    <thead class="bg-white">
    <tr>
        <td>Emision</td>
        <td>Comprobante</td>
        <td>Persona</td>
        <td>Transaccion</td>
        <td>Cuenta</td>
        <td>Total</td>
    </tr>
    </thead>
    <tbody>
    <?php

    use yii\helpers\Html;
    use yii\helpers\Url;


    foreach($transaccion as $tran):?>
    <tr>
        <?php
        $tipo=\app\models\Charges::findOne($tran->id_charge);
        $person=\app\models\Person::findOne($tipo->person_id);

        $chart=\app\models\ChartAccounts::findOne($tran->chart_account);
        yii::debug($chart)
        ?>
        <td><?= $tran->date ?></td>
        <td><?= HTML::a($tran->comprobante,Url::to(["detail", "id"=>$tran->comprobante])) ?> </td>
        <td><?= $person->name ?></td>
        <td><?= $tipo->type_charge ?></td>

        <td><?= $chart->code." ".$chart->slug ?></td>
        <td><?= $tran->amount?></td>
    </tr>
    <?php endforeach?>

    </tbody>
</table>
