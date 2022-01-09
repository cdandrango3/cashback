var count=0;

$(document).ready(function(){
    $('#personm').append('<a id="buscar" class="btn btn-primary">buscar</a>')
});
$('#buscar').click(function() {
    $('#modal').modal('show')
        .find('#modalContent');
});

$('#tipodocu').change(function(){
    tipo=$(this).val();
    if (tipo=="Proveedor") {
        $("#vendedor").hide()
        $(".preu").val("");
    }
    else{
        $("#vendedor").show()
        $(".preu").val("");
    }




})
$('#listtype').change(function(){
    c=$(this).val();

    pro = '<?php echo $prolist ?>';
    dapro = JSON.parse(pro);
    $('.s').remove();
    for (i in dapro) {
        var c = '<option class="s" value="' + i + '">"' + i + '"</option>'
        $('.la').append(c);

    }
})
$(añadir).click(function(){
    count=count+1

    pro='<?php echo $prolist ?>'


    dapro=JSON.parse(pro)
    var c='<tr id="int'+count+'">'
    c+='<td>'
    c+='<div class="form-group field-can"> <label class="control-label" for="facturabody-'+count+'-cant"></label><input type="text" id="can'+count+'" class="form-control cant" name="FacturaBody['+count+'][cant]" value="" onkey="javascript:fields2()">'
    c+='</td>'
    c+='<td>'
    c+='<div class="form-group field-valo"><label class="control-label" for="valo"></label><select id="'+count+'" class="form-control la" name="Product['+count+'][name]"> <option value="">Select...</option>'
    for(i in dapro){
        c+='<option class="s" value="'+i+'">"'+i+'"</option>'
    }
    c+='</select></div>'
    c+='</td>'
    c+='<td>'
    c+='<div class="form-group field-idn"><label class="control-label" for="facturabody-'+count+'-precio_u"></label><input type="text" id="idn'+count+'" class="form-control preu" name="FacturaBody['+count+'][precio_u]" value=""><div class="help-block"></div> </div> '
    c+='</td>'
    c+='<td>'
    c+='<div class="form-group field-desc"><label class="control-label" for="facturabody-+count+-desc"></label><input type="text" id="desc'+count+'" class="form-control desc" name="FacturaBody['+count+'][desc]" value="">'
    c+='</td>'
    c+='<td>'
    c+='<div class="form-group field-valtotal"><label class="control-label" for="facturabody-+count+-precio_total"></label><input type="text" id="valtotal'+count+'" class="form-control g" name="FacturaBody['+count+'][precio_total]" value="" readonly>'
    c+='</td>'
    c+='<td>'
    c+='<button class="btn btn-danger mdwsdsdsft-3 remove" id="'+count+'">Eliminar</button>'
    c+='</td>'
    c+='</tr>'

    $('#hola').click(function(){

    });

    $('#actionmodal').click(function(){
        $('#modal2').show()
    })
    $(document).on('keyup','.preu',function(){
        precio=$(this).val()
        te=$(this).attr("id");
        h=te.substring(3);
        cant=$('#can'+h).val();
        $('#valtotal'+h).val(cant*precio);
        sum=0;
        c=0;
        sumiv=0;
        sumn=0;
        iva=JSON.parse('<?php echo $liva?>');
        item=[];
        $('.la').each(function(){
            item.push($(this).val())
        })
        $('.g').each(function(){

            console.log(c)
            if(iva[item[c]]==12){
                sumiv=sumiv+parseFloat($(this).val());
            }
            if(iva[item[c]]==0){
                sumn=sumn+parseFloat($(this).val());
            }
            c=c+1;
        })
        $('#sub0').val(round(sumn))
        $('#sub').val(round(sumiv))

        console.log(sumn);
        console.log(sumiv);
        iva=sumiv*0.12;
        des=0;
        total=sumiv+sumn+iva+des;
        $('#iva').val(round(iva))
        $('#des').val(round(iva))
        $('#total').val(round(total))
        console.log(h)

    })

    $(document).on('click','.remove',function(){
        id=$(this).attr("id");


        $("#int"+id).remove();
        sum=0;
        c=0;
        sumiv=0;
        sumn=0;
        iva=JSON.parse('<?php echo $liva?>');
        item=[];
        $('.la').each(function(){
            item.push($(this).val())
        })
        console.log(item[0]);
        $('.g').each(function(){

            console.log(c)
            if(iva[item[c]]==12){
                sumiv=sumiv+parseFloat($(this).val());
            }
            if(iva[item[c]]==0){
                sumn=sumn+parseFloat($(this).val());
            }
            c=c+1;
        })
        $('#sub0').val(sumn)
        $('#sub').val(sumiv)

        console.log(sumn);
        console.log(sumiv);
        iva=sumiv*0.12;
        des=0;
        total=sumiv+sumn+iva+des;
        $('#iva').val(iva)
        $('#des').val(iva)
        $('#total').val(total)
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
function calcular(){
    tip= $('#tipodocu').val();
    console.log(tip)
    if(tip=="Cliente"){
        f=JSON.parse('<?php echo $prelist?>');

    }
    else {
        if (tip == "Proveedor") {
            f = JSON.parse('<?php echo $lcosto?>');

        }
    }

    cost=JSON.parse('<?php echo $lcosto?>');
    console.log(cost);
    $('#idn'+h+'').val(f[d]);
    co=cost[d]
    cost=$('#can'+h).val()*co
    suma=0;
    cov.push(cost);
    console.log(cov)
    for (const element of cov){
        suma=suma+parseFloat(element)
        cost=JSON.parse('<?php echo $lcosto?>');
    }
    console.log(suma)
    $('#pre').val(suma)
    re=($('#can'+h).val())*($('#idn'+h).val())
    $('#valtotal'+h).val(re);
    console.log(cost)
    sum=0;
    c=0;
    sumiv=0;
    sumn=0;
    iva=JSON.parse('<?php echo $liva?>');
    item=[];
    $('.la').each(function(){
        item.push($(this).val())
    })
    console.log(item[0]);
    $('.g').each(function(){

        console.log(c)
        if(iva[item[c]]==12){
            sumiv=sumiv+parseFloat($(this).val());
        }
        if(iva[item[c]]==0){
            sumn=sumn+parseFloat($(this).val());
        }
        c=c+1;
    })
    $('#sub0').val(round(sumn))
    $('#sub').val(round(sumiv))
    console.log(round(sumn));
    console.log(round(sumiv));
    iva=sumiv*0.12;
    des=0;
    total=sumiv+sumn+iva+des;
    $('#iva').val(round(iva))
    $('#des').val(round(iva))
    $('#total').val(round(total))
}
$(document).on('change','.la',function(){
    h=$(this).attr("id");
    d=$(this).val();
    calcular();
})
$(document).on('keyup','.cant',function(){
    precio=$(this).val()
    te=$(this).attr("id");
    h=te.substring(3);
    cant=$('#idn'+h).val();
    $('#valtotal'+h).val(cant*precio);
    sum=0;
    c=0;
    sumiv=0;
    sumn=0;
    iva=JSON.parse('<?php echo $liva?>');
    item=[];
    $('.la').each(function(){
        item.push($(this).val())
    })
    $('.g').each(function(){

        console.log(c)
        if(iva[item[c]]==12){
            sumiv=sumiv+parseFloat($(this).val());
        }
        if(iva[item[c]]==0){
            sumn=sumn+parseFloat($(this).val());
        }
        c=c+1;
    })
    $('#sub0').val(round(sumn))
    $('#sub').val(round(sumiv))

    console.log(sumn);
    console.log(sumiv);
    iva=sumiv*0.12;
    des=0;
    total=sumiv+sumn+iva+des;
    $('#iva').val(round(iva))
    $('#des').val(round(iva))
    $('#total').val(round(total))
    console.log(h)
})
$(document).on('keyup','.desc',function(){
    te=$(this).attr("id");
    h=te.substring(4);
    console.log(h);

    preciou=$('#idn'+h+'').val();
    cant=$('#can'+h).val();
    $('#valtotal'+h).val(preciou*cant);
    val=$('#valtotal'+h).val();
    desc=val*($(this).val())/100;
    val=$('#valtotal'+h).val();
    valf=val-desc;
    $('#valtotal'+h).val(valf);

    sum=0;

    $('.g').each(function(){
        sum=sum+parseFloat($(this).val());


    })
    $('')
    $('#sub').val(sum)
    iva=sum*0.12;
    des=0;
    total=sum+iva+des;
    $('#iva').val(iva)
    $('#desc').val(desc)
    $('#total').val(total)
    console.log(val);
})
$('#añadir')
$('#buttonsubmit').click(function(){
    cantidad=[];
    preciou=[];
    pro=[];
    preciot=[];

    $('.cant').each(function(){
        cantidad.push($(this).val())
    })
    $('.la').each(function(){
        pro.push($(this).val())
    })
    $('.preu').each(function(){
        preciou.push($(this).val())
    })
    $('.g').each(function(){
        preciot.push($(this).val())
    })
    n_docu= $('#ndocu').val();

    $.ajax({
        method: "POST",
        data: { cantidad:cantidad,produc:pro,preciou:preciou,precioto:preciot,ndocumento:n_docu },
        url: '<?php echo Yii::$app->request->baseUrl. "/cliente/guardarproceso" ?>',
        success: function (data) {
            console.log(data);
        },
        error: function (err) {

            //do something else
            console.log(err);
            if(err){
                alert('It works!');
            }

        }

    })

})
function round(num) {
    var m = Number((Math.abs(num) * 100).toPrecision(15));
    return Math.round(m) / 100 * Math.sign(num);
}