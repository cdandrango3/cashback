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
$authItemChild = Yii::$app->request->post('Person');
$auth = Yii::$app->request->post('HeadFact');
    unset($authItemChild["name"]);

?>

<div class="cliente-factura">

    <?php $form = ActiveForm::begin(); ?>
       <div class="row">
               <div class="col-6">
        <?=$form->field($ven[0],"name")->dropDownList($listData,['prompt'=>'Select...']);?>
        <?php if($authItemChild){?>
        <?=$form->field($model, 'id_personas')->textInput(['readonly' => true, 'value' =>$authItemChild["ruc"]])?>
        <?php } else {?>
        <?=$form->field($model, 'id_personas')->textInput(['readonly' => true, 'value' =>""])?>

        <?php }?>
        <?= $form->field($model, 'f_timestamp');?>
        <?= $form->field($model, 'Entregado') ?>
                   </div>
           <div class="col-6">
        <?= $form->field($model, 'n_documentos') ?>
        <?= $form->field($model, 'referencia') ?>
        <?= $form->field($model, 'orden_cv') ?>
        <?= $form->field($model, 'autorizacion') ?>
        <?= $form->field($model, 'tipo_de_documento') ?>
           </div>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
           </div>
       </div>
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


?>



