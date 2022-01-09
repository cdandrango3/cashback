<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelhead app\models\FacturaHead*/
/* @var $form yii\widgets\ActiveForm */

?>
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($modelhead, 'n_documentos')->textInput(["id"=>"nfac"]) ?>

    <?= $form->field($modelhead, 'id_personas')->textInput() ?>

<?= HTML::tag("a","buscar" ,["class"=>"btn btn-primary","id"=>"clickeo"])?>


    <div class="form-group">

    </div>

    <?php ActiveForm::end(); ?>

