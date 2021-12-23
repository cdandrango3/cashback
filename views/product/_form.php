<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\product */
/* @var $form yii\widgets\ActiveForm */
$listpr=ArrayHelper::map($model2,"name","name");
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

        <div class="card">
            <div class="card-header bg-primary">
                Productos y Servicios
            </div>
            <div class="card-body">
                <div class="row">
                <div class="col-lg-6 col-sm-6 col-md-6 col-12 ">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'status')->checkbox() ?>
                <?=$form->field($model2[0],"name")->dropDownList($listpr,['prompt'=>'Select...','readonly'=>false,'id'=>'listpr'])->label("tipo");?>
                <?= $form->field($model, 'institution_id')->textInput() ?>

                <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6 col-12 ">
                <?= $form->field($model, 'brand')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'purpose')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'product_iva_id')->textInput() ?>

                <?= $form->field($model, 'precio')->textInput() ?>

                <?= $form->field($model, 'costo')->textInput(['id'=>'listpro','readonly' => false]) ?>

                    </div>
                </div>

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>
                <?=
                $js="$('#listpr').change(function(){
                        console.log($(this).val());
                      c=$(this).val();
                      if(c=='servicio'){
                      $('#listpro').val('0');
                           
                      }
                      if(c=='producto'){
                       $('#listpro').val('');
                      $('#listpro').attr({
                      
                      });
                      }
                     })";
                $this->registerJs($js, View::POS_READY);
                ?>


                <?php ActiveForm::end(); ?>
            </div>
        </div>


</div>
<script>


</script>
