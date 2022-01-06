<?php

?>
<?php use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Registrar Cobro/Pagos';
$this->params['breadcrumbs'][] = $this->title;
$form=ActiveForm::begin()?>
<div class="card">
    <div class="card-header bg-primary">
        Información de Transacción

    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-10 col-12">
<?= $form->field($chargem, 'type_charge')->dropDownList(
    ['Caja' => 'Caja', 'Transferencia' => 'Transferencia','Cheque' => 'Cheque'], ["id" => "tipodocu"])->label("Forma de Cobro")  ?>
<?=
$form->field($chargem,'date')->textInput(["readonly"=>True,"value"=>$header->f_timestamp])->label("Fecha");
?>
<?=
$form->field($Person,'name')->textInput(["readonly"=>True,"value"=>$Person->name])->label("Persona");
?>
<div class="form-group">
<?= $form->field($chargem,'comprobante',[
    'template' => 'N de Comprobante <div class="input-group">{input}
           <label class="ml-5 efectivo " for="">Efectivo</label><input type="checkbox" class="ml-5 efectivo" id="efectivo"></div> {error}{hint}'
])->label("N de Comprobante")->textInput(['maxlength' => true, 'id' => 'compro']); ?>
<?=

$form->field($chargem,'Description')->label("Descripción")->textarea(['rows' => '6']);
?>


        </div>
    </div>
</div>
    <br/>
    <br/>
    <br/>

<div class="card">
    <div class="card-header">
        <table class="table">
            <thead>
            <tr class="thead-dark">
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
               <div class="input-group">
               <?= $form->field($header,'n_documentos')->textInput(["readonly"=>False,"value"=>$header->n_documentos])->label(false);?>

               </div>
           </td>
           <td><?=\Yii::$app->formatter->asDate($header->f_timestamp, 'dd/MM/yyyy') ?></td>
           <td>Factura</td>
           <td><?= $body->total ?></td>
           <?php if($upt==False){ ?>
           <td><?=$body->total?></td>
           <?php } else {?>
               <?php $d=$chargem::findOne(["n_document"=>$header->n_documentos])?>
           <td><?=$d->saldo?></td>
           <?php } ?>
           <td><?= $form->field($chargem,'amount',[
    'template' => '<div class="input-group">{input}
          <a class="btn btn-primary" id="copiar">Copiar</a></div> {error}{hint}'
])->label(false)->textInput(["id"=>"labec"]); ?></td>
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
        <?php
        $script = <<< JS
$('#efectivo').click(function() {
  if ($(this).is(':checked')) {
    $('#compro').val("efectivo")
  }
  else{
     $('#compro').val("")   
  }
});
$('#copiar').click(function(){
   
    $('#labec').val($body->total)
})
       $('#tipodocu').change(function(){
           actual=$(this).val();
           if(actual=="Caja"){
              $(".efectivo").show(); 
              c=$("#efectivo").is(":checked");
              console.log($('#compro').val());
             
              if ($("#efectivo").is(":checked")){
                  $('#compro').val("efectivo")
              }
              else{
                $('#compro').val("")  
              }
           }
           else{
               $(".efectivo").hide();
               $('#compro').val("")
           }
       })
JS;
        $this->registerJs($script);

        ?>
