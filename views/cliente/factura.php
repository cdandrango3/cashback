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
$listcosto=ArrayHelper::map($pro2,"name","costo");
$listService=ArrayHelper::map($proser,"name","precio");
$listServicepre=ArrayHelper::map($precioser,"name","precio");

$listtypepro=ArrayHelper::map($modeltype,"name","name");
$listruc=ArrayHelper::map($query,"id","id");
$prelist=\yii\helpers\Json::encode($listPrecio);
$listse=\yii\helpers\Json::encode($listService);
$prolist=\yii\helpers\Json::encode($listProduct);
$lcosto=\yii\helpers\Json::encode($listcosto);
$authItemChild = Yii::$app->request->post('Person');

$auth = Yii::$app->request->post('HeadFact');
$request=Yii::$app->request->post('FacturaBody');

?>

<div class="cliente-factura">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'f_timestamp')->label("Fecha de Emision");?>
            <?=$form->field($ven[0],"id")->dropDownList($listruc,['prompt'=>'Select...'])->label("Persona");?>

            <?=$form->field($ven[0],"name")->dropDownList($listData,['prompt'=>'Select...'])->label("vendedor");?>
            <?= $form->field($model, 'Entregado')->checkBox(['label' => 'entregado']);  ?>
            <?=$form->field($modeltype[0],"name")->dropDownList($listtypepro,['prompt'=>'Select...','id'=>'listtype'])->label("tipo venta");?>
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
<?php echo HTML::tag("a", "mostrar", ["value" => "ff", "id" => "añadir", "class" => "btn btn-success float-right mr-4"]); ?>
<table class="table table-dark">
    <thead>
    <th>Cantidad</th>
    <th> Producto </th>
    <th> Valor unitario </th>
    <th> Valor final </th>
    </thead>
    <tbody id="nuevo">


    </tbody>
</table>
<div class="row">
    <div class="col-7">

    </div>
    <div class="col-5">
        <?= $form->field($produ, 'costo')->label("subtotal")->textInput(['value' =>"" ,"id"=>"pre",'type'=>"hidden"]) ?>
        <td><?= $form->field($model3, 'subtotal')->label("subtotal")->textInput(['readonly' => false ,'value' =>"" ,"id"=>"sub"]) ?></td>
        <td><?= $form->field($model3, 'descuento')->label("descuento")->textInput(['readonly' => false ,'value' =>"" ,"id"=>"desc"]) ?></td>
        <td><?= $form->field($model3, 'iva')->label("iva")->textInput(['readonly' => false ,'value' =>"" ,"id"=>"iva"]) ?></td>
        <td><?= $form->field($model3, 'total')->label("total")->textInput(['readonly' => false ,'value' =>"" ,"id"=>"total"]) ?></td>
    </div>
</div>
<?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>




</div><!-- cliente-factura -->
<?php ActiveForm::end(); ?>


<?php

Modal::begin([
    'title'=>'<h1 class="text-primary">Escoger Persona</h1>',
    'id'=>'modal2',
    'size'=>'modal-lg',

]);

Modal::end();

?>
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

?>



<script type="text/javascript">
    var count=0;
    cov=[]
    $(document).ready(function(){
        $('#personm').append('<a id="buscar" class="btn btn-primary">buscar</a>')
    })
    $('#buscar').click(function() {
        $('#modal').modal('show')
            .find('#modalContent')
    })
    $('#listtype').change(function(){
        c=$(this).val();
        if(c=='servicio'){
            pro='<?php echo $listse ?>'
            dapro=JSON.parse(pro)
            $('.s').remove();
            for(i in dapro){
                var c='<option class="s" value="'+i+'">"'+i+'"</option>'
                $('.la').append(c);
            }
        }
        else {
            pro = '<?php echo $prolist ?>'
            dapro = JSON.parse(pro)
            $('.s').remove();
            for (i in dapro) {
                var c = '<option class="s" value="' + i + '">"' + i + '"</option>'
                $('.la').append(c);
            }
        }
        })
$(añadir).click(function(){

count=count+1
 f=document.getElementById('listtype').value
  if(f=='servicio'){
      pro='<?php echo $listse ?>'
      cov=[];
  }
  else{
      pro='<?php echo $prolist ?>'
  }

    dapro=JSON.parse(pro)
     var c='<tr id="int'+count+'">'
         c+='<td>'
       c+='<div class="form-group field-can"> <label class="control-label" for="facturabody-'+count+'-cant"></label><input type="text" id="can'+count+'" class="form-control" name="FacturaBody['+count+'][cant]" value="" onkey="javascript:fields2()">'
      c+='</td>'
     c+='<td>'
    c+='<div class="form-group field-valo"><label class="control-label" for="valo"></label><select id="'+count+'" class="form-control la" name="Product['+count+'][name]"> <option value="">Select...</option>'
        for(i in dapro){
         c+='<option class="s" value="'+i+'">"'+i+'"</option>'
        }
    c+='</select></div>'
    c+='</td>'
    c+='<td>'
    c+='<div class="form-group field-idn"><label class="control-label" for="facturabody-'+count+'-precio_u"></label><input type="text" id="idn'+count+'" class="form-control" name="FacturaBody['+count+'][precio_u]" value="" readonly><div class="help-block"></div> </div> '
    c+='</td>'
    c+='<td>'
    c+='<div class="form-group field-valtotal"><label class="control-label" for="facturabody-+count+-precio_total"></label><input type="text" id="valtotal'+count+'" class="form-control g" name="FacturaBody['+count+'][precio_total]" value="" readonly>'
    c+='<td>'
    c+='<button class="btn btn-danger mt-3 remove" id="'+count+'">Eliminar</button>'
    c+='</td>'
    c+='</tr>'

    $('#hola').click(function(){

    });

    $('#actionmodal').click(function(){
        $('#modal2').show()
    })

    $(document).on('click','.remove',function(){
        id=$(this).attr("id");


        $("#int"+id).remove();
        $('.g').each(function(){
            sum=sum+parseFloat($(this).val());
            c = cov.splice(1,id)
            console.log(c)
        })
        $('#sub').val(sum)
        iva=sum*0.12;
        des=0;
        total=sum+iva+des;
        $('#iva').val(iva)
        $('#des').val(iva)
        $('#total').val(total)
        sum=0;
    })

    $('#nuevo').append(c);
})
    $('body').on('beforeSubmit', 'form#dynamic-form111', function () {
        var form = $(this);
        // return false if form still have some validation errors
        if (form.find('.has-error').length)
        {
            return false;
        }
        // submit form
        $.ajax({
            url    : form.attr('action'),
            type   : 'get',
            data   : form.serialize(),
            success: function (response)
            {
                var getupdatedata = $(response).find('#filter_id_test');
                // $.pjax.reload('#note_update_id'); for pjax update
                $('#yiiikap').html(getupdatedata);
                //console.log(getupdatedata);
            },
            error  : function ()
            {
                console.log('internal server error');
            }
        });
        return false;
    });

    $(document).on('change','.la',function(){
        h=$(this).attr("id");
        d=$(this).val();
        f=JSON.parse('<?php echo $prelist?>');
        cost=JSON.parse('<?php echo $lcosto?>');
        console.log(cost)
        $('#idn'+h+'').val(f[d]);
        co=cost[d]
        cost=$('#can'+h).val()*co
suma=0;
        cov.push(cost);
        console.log(cov)
        for (const element of cov){
            suma=suma+parseFloat(element)
        }
        console.log(suma)
        $('#pre').val(suma)
        re=($('#can'+h).val())*($('#idn'+h).val())
        $('#valtotal'+h).val(re);
        console.log(cost)
        sum=0;
        $('.g').each(function(){
            sum=sum+parseFloat($(this).val());

        })
      $('#sub').val(sum)
        iva=sum*0.12;
        des=0;
        total=sum+iva+des;
        $('#iva').val(iva)
        $('#des').val(iva)
        $('#total').val(total)
    })
    $('#añadir')


</script>

