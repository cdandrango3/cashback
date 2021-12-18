<?php


use app\models\Person;
use yii\Bootstrap4;
use yii\bootstrap4\Modal;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HeadFact */
/* @var $form ActiveForm */
$listData=ArrayHelper::map($ven,"name","name");
$listProduct=ArrayHelper::map($produc,"name","name");
$listPrecio=ArrayHelper::map($pro2,"name","precio");
$listruc=ArrayHelper::map($query,"id","");
$authItemChild = Yii::$app->request->post('Person');

$auth = Yii::$app->request->post('HeadFact');
$request=Yii::$app->request->post('FacturaBody');

?>

<div class="cliente-factura">

    <?php $form = ActiveForm::begin(); ?>
       <div class="row">
               <div class="col-6">
        <?=$form->field($ven[0],"name")->dropDownList($listData,['prompt'=>'Select...'])->label("vendedor");?>

        <?=$form->field($model, 'id_personas')->dropDownList($listruc,['prompt'=>'Select...'])->label("persona")?>



        <?= $form->field($model, 'f_timestamp');?>
        <?= $form->field($model, 'Entregado')->checkBox(['label' => 'entregado']);  ?>
                   </div>
           <div class="col-6">
        <?= $form->field($model, 'n_documentos') ?>
        <?= $form->field($model, 'referencia') ?>
        <?= $form->field($model, 'orden_cv') ?>
        <?= $form->field($model, 'autorizacion') ?>
        <?= $form->field($model, 'tipo_de_documento') ?>
           </div>
        <div class="form-group">

        </div>
           </div>
       </div>
<table class="table table-dark">
    <thead>
       <th>Cantidad</th>
       <th> Producto </th>
       <th> Valor unitario </th>
       <th> Valor final </th>
    </thead>
    <tbody>
    <tr>
        <td>
<?= $form->field($model2, '[0]cant')->label("")->textInput(['readonly' => false ,'value' =>"" ,"id"=>"can",'onkey'=>"javascript:fields2()"]) ?>
    </td>
        <td>
            <?= $form->field($produc[0], '[0]name')->dropDownList($listProduct,['prompt'=>'Select...','onchange'=>"javascript:fields()","id"=>"valo"])->label("")?>
        </td>
    <td>
<?= $form->field($model2, '[0]precio_u')->label("")->textInput(['readonly' => true, 'value' =>"" ,"id"=>"idn"])?> ?>
    </td>
    <td>
<?= $form->field($model2, '[0]precio_total')->label("")->textInput(['readonly' => true, 'value' =>"" ,"id"=>"valtotal"]) ?>
    </td>
    </tr>
    <tr>
        <td><?= $form->field($model2, '[1]cant')->label("")->textInput(['readonly' => false ,'value' =>"" ,"id"=>"can1",'onkey'=>"javascript:fields2()"]) ?></td>
        <td><?= $form->field($produc[0], '[1]name')->dropDownList($listProduct,['prompt'=>'Select...','onchange'=>"javascript:fields2()","id"=>"valo1"])->label("")?></td>
        <td><?= $form->field($model2, '[1]precio_u')->label("")->textInput(['readonly' => true, 'value' =>"" ,"id"=>"idn1"])?> ?></td>
        <td><?= $form->field($model2, '[1]precio_total')->label("")->textInput(['readonly' => true, 'value' =>"" ,"id"=>"valtotal1"]) ?></td>
    </tr>
    </tbody>
</table>
<div class="row">
    <div class="col-7">

    </div>
    <div class="col-5">
        <td><?= $form->field($model3, 'subtotal')->label("subtotal")->textInput(['readonly' => false ,'value' =>"" ,"id"=>"sub"]) ?></td>
        <td><?= $form->field($model3, 'descuento')->label("descuento")->textInput(['readonly' => false ,'value' =>"" ,"id"=>"desc"]) ?></td>
        <td><?= $form->field($model3, 'iva')->label("iva")->textInput(['readonly' => false ,'value' =>"" ,"id"=>"iva"]) ?></td>
        <td><?= $form->field($model3, 'total')->label("total")->textInput(['readonly' => false ,'value' =>"" ,"id"=>"total"]) ?></td>
    </div>
</div>
<?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>



</div><!-- cliente-factura -->
<?php echo HTML::tag("button", "mostrar", ["value" => "ff", "id" => "modalb", "class" => "btn btn-primary"]); ?>

<?php

    Modal::begin([
        'title'=>'<h1 class="text-primary">Escoger Persona</h1>',
        'id'=>'modal',
        'size'=>'modal-lg',

    ]);
$models=New Person;
$model=$models::find()->select("ruc")->all();
    echo $this->renderAjax("formclientrender",compact('model'));

    Modal::end();
print_r($authItemChild);
print_r($auth);

?>

<script type="text/javascript">

    function fields()

    {

       var h=document.getElementById('valo').value;
       document.getElementById('idn').value=<?php echo $listPrecio["Hilook"]?>;
        var g= document.getElementById('can').value;
        var total =g*document.getElementById('idn').value;
        console.log(g)
        document.getElementById('valtotal').value=total;
        var stotal=parseInt(document.getElementById('valtotal1').value) + parseInt(document.getElementById('valtotal').value);
        var iva=stotal*0.12;
        var tot=stotal+iva;
        document.getElementById('sub').value=stotal
        document.getElementById('iva').value=iva
        document.getElementById('total').value=tot

    }
    function fields2()

    {

        var h=document.getElementById('valo1').value;

        document.getElementById('idn1').value=<?php echo $listPrecio["Hilook"]?>;
        var g= document.getElementById('can1').value;
        var total =g*document.getElementById('idn1').value;
        console.log(g)
        document.getElementById('valtotal1').value=total;
        var stotal=parseInt(document.getElementById('valtotal1').value) + parseInt(document.getElementById('valtotal').value);
        var iva=stotal*0.12;
        var tot=stotal+iva;
        document.getElementById('sub').value=stotal
        document.getElementById('iva').value=iva
        document.getElementById('total').value=tot
    }

</script>

