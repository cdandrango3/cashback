<?php

namespace app\controllers;
use app\models\AccountingSeats;
use app\models\AccountingSeatsDetails;
use app\models\ChartAccounts;
use app\models\Clients;
use app\models\FacturaBody;
use app\models\Facturafin;
use app\models\Institution;
use app\models\Person;
use app\models\HeadFact;
use app\models\Product;
use app\models\ProductType;
use app\models\Providers;
use app\models\Salesman;
use Cassandra\Date;
use yii\web\Json;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\Controller;

class ClienteController extends controller
{
    public $id;
    public $id_product;
public function actionIndex($tipos){
    $models=New clients;
    $modelhead=New HeadFact;
    $modelf=New Facturafin;
    if($tipos=="Cliente"){
        $query1 = HeadFact::find()->where(["tipo_de_documento"=>"Cliente"]);
    }
    else{
        if ($tipos=="Proveedor") {
            $query1 = HeadFact::find()->where(["tipo_de_documento"=>"Proveedor"]);
        }

    }

    Yii::debug($query1);
    $pages = new Pagination(['defaultPageSize' => 5,'totalCount' => $query1->count()]);
    $modelhe = $query1->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
    Yii::debug($modelhe);
    $query = $models::find();
    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);

    return $this->render('index',["models"=>$dataProvider,"modelhead"=>$modelhead,"pages"=>$pages,"headfac"=>$modelhe]);
}
    public function actionViewf($id){
    $modelhead=New HeadFact;
    $modelbody=New FacturaBody;
    $modelfin=New Facturafin;
        $persona=New Person;


    $id=$_GET["id"];
    $model1=$modelhead::findOne($id);
    $model2=$modelbody::find()->where(["id_head"=>$id])->all();
    $model3=$modelfin::findOne(["id_head"=>$id]);
    $persona=$persona::findOne(["id"=>$model1->id_personas]);


        return $this->render("viewf",["model"=>$model1,"model2"=>$model2,"modelfin"=>$model3,"personam"=>$persona]);
    }
    public function actionFactura()
    {
        $model = new HeadFact;
        $person = new Person;
        $client=New Clients;
        $institucion=New Institution;
        $model_tip=New ProductType;
        $salesman = new Salesman;
        $model2 = new FacturaBody;
        $productos = new Product;
        $facturafin = new Facturafin;
        $accounting_seats=new AccountingSeats;
        $accounting_seats_details=New AccountingSeatsDetails;
        $persona = $person::find()->select("name")->innerJoin("clients","person.id=clients.person_id")->all();
        $model_tipo=$model_tip::find()->select("name")->all();
        $pro = $productos::find()->select("name")->all();
        $precio = $productos::find()->all();
        $precioser = $productos::find()->where(['product_type_id'=>2])->all();
        $d= Yii::$app->request->post('Facturafin');
        $per= Yii::$app->request->post('Person');
        $query = $person::find()->innerJoin("clients","person.id=clients.person_id")->all();
        $providers = $person::find()->innerJoin("providers","person.id=providers.person_id")->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->id_personas=$per["id"];
            if ($model->validate())
                $model->id_personas=$per["id"];
                $model->save();
                $c = rand(1, 100090000);
                $this->id=$c;
                $facturafin->id = $c;
                $facturafin->subtotal12 = $d["subtotal12"];
                $facturafin->total = $d["total"];
                $facturafin->iva = $d["iva"];
            $facturafin->iva = $d["iva"];
                $facturafin->id_head = $model->n_documentos;
                $facturafin->save();

                if($model->save()){
                    $tipo=$model->tipo_de_documento;
                    if($tipo=="Cliente") {
                        //* Aqui inicia si es una compra//
                        $ch1 = $client::findOne(['person_id' => $model->id_personas]);
                        $accou_c = $ch1->chart_account_id;
                        $ins = $person::findOne(['id' => $model->id_personas]);
                        $id_ins = $ins->institution_id;
                        $descripcion = "fact1";
                        $nodeductible = False;
                        $status = True;
                        $h = rand(1, 10000000);
                        $accounting_seats->id = $h;
                        $accounting_seats->head_fact = $model->n_documentos;
                        $accounting_seats->institution_id = $id_ins;
                        $accounting_seats->description = $descripcion;
                        $accounting_seats->nodeductible = $nodeductible;
                        $accounting_seats->status = $status;
                        if ($accounting_seats->save()) {
                            $debea = $accou_c;
                            $bodyf=FacturaBody::find()->where(['id_head'=>$model->n_documentos])->all();
                            $haber=array();
                            $suma=array();
                            $sum=0;
                            foreach ($bodyf as $bod){
                                $cos=Product::findOne(["id"=>$bod->id_producto]);
                                $sum=$sum+($bod->precio_total);
                                if (!(is_null($cos->charingresos))) {
                                    $haber[] = $cos->charingresos;
                                    yii::debug($haber);
                                    $suma[] = $bod->precio_total;
                                    yii::debug($suma);
                                }
                                     yii::debug($haber);
                            }


                            Yii::debug(count($haber));
                            if(count($haber) !=0 ){
                                Yii::debug("estoy aqui");
                                $debea=$accou_c;
                                $haber[]=13272;
                                $i=count($haber);
                                $count=0;

                                $accounting_seats_details = new AccountingSeatsDetails;
                                $accounting_seats_details->accounting_seat_id = $accounting_seats->id;
                                $accounting_seats_details->chart_account_id = $debea;
                                $accounting_seats_details->debit = $facturafin->total;
                                $accounting_seats_details->credit = 0;
                                $accounting_seats_details->cost_center_id = 1;
                                $accounting_seats_details->status = true;
                                $accounting_seats_details->save();
                                foreach ($haber as $habe) {

                                    if($count<$i-1){
                                        $accounting_seats_details = new AccountingSeatsDetails;
                                        $accounting_seats_details->accounting_seat_id = $accounting_seats->id;
                                        $accounting_seats_details->chart_account_id = $habe;
                                        $accounting_seats_details->debit = 0;
                                        $accounting_seats_details->credit = $suma[$count];
                                        $accounting_seats_details->cost_center_id = 1;
                                        $accounting_seats_details->status = true;
                                        $accounting_seats_details->save();
                                        yii::debug("suma");
                                        yii::debug($suma);
                                    }
                                    else{
                                        $accounting_seats_details = new AccountingSeatsDetails;
                                        $accounting_seats_details->accounting_seat_id = $accounting_seats->id;
                                        $accounting_seats_details->chart_account_id = $habe;
                                        $accounting_seats_details->debit =0;
                                        $accounting_seats_details->credit = $facturafin->iva;;
                                        $accounting_seats_details->cost_center_id = 1;
                                        $accounting_seats_details->status = true;
                                        $accounting_seats_details->save();
                                        yii::debug("aqui");
                                    }
                                    $count=$count+1;

                                }
                            }
                                $gr = rand(1, 100090000);
                                //Aqui inicia Inventarios
                            $bodyf=FacturaBody::find()->where(['id_head'=>$model->n_documentos])->all();
                            $sum=0;
                            $debe=array();
                            $haber=array();
                            $suma=array();
                            foreach ($bodyf as $bod){
                                $cos=Product::findOne(["id"=>$bod->id_producto]);
                                Yii::debug($cos);
                                if (!(is_null($cos->Chairinve))) {
                                    $sum=$sum+(($cos->costo)*($bod->cant));
                                    $debe[]=$cos->chairaccount_id;
                                    $haber[] = $cos->Chairinve;
                                    $suma[]=($cos->costo)*($bod->cant);
                                    yii::debug($haber);
                                }


                            }
                            if(count($haber)!=0) {
                                $accounting_sea = new AccountingSeats;
                                $accounting_sea->head_fact = $model->n_documentos;
                                $accounting_sea->id = $gr;
                                $accounting_sea->institution_id = $id_ins;
                                $accounting_sea->description = "fact2";
                                $accounting_sea->nodeductible = $nodeductible;
                                $accounting_sea->status = $status;
                                if ($accounting_sea->save()) {

                                    $pro = Yii::$app->request->post("Product");
                                    for ($i = 0; $i < count($debe); $i++) {
                                        $accounting_seats_details = new AccountingSeatsDetails;
                                        $accounting_seats_details->accounting_seat_id = $accounting_sea->id;
                                        $accounting_seats_details->chart_account_id = $debe[$i];
                                        yii::debug($debe[$i]);
                                        $accounting_seats_details->debit = $suma[$i];
                                        $accounting_seats_details->credit = 0;
                                        $accounting_seats_details->cost_center_id = 1;
                                        $accounting_seats_details->status = true;
                                        $accounting_seats_details->save();
                                        $accounting_seats_details = new AccountingSeatsDetails;
                                        $accounting_seats_details->accounting_seat_id = $accounting_sea->id;
                                        $accounting_seats_details->chart_account_id = $haber[$i];
                                        $accounting_seats_details->debit = 0;
                                        $accounting_seats_details->credit = $suma[$i];
                                        $accounting_seats_details->cost_center_id = 1;
                                        $accounting_seats_details->status = true;
                                        $accounting_seats_details->save();
                                    }
                                }
                            }



                            return $this->redirect('factura');
                        }
                    }
                    else{
                        if($tipo=="Proveedor"){
                            $accounting_seats=new AccountingSeats;


                            $h = rand(1, 10000000);
                            $ch1 = Providers::findOne(['person_id' => $model->id_personas]);
                            $accou_c = $ch1->paid_chart_account_id;
                            $ins = $person::findOne(['id' => $model->id_personas]);
                            $id_ins = $ins->institution_id;

                            $descripcion = "fact1";
                            $nodeductible = True;
                            $status = True;
                            $accounting_seats->head_fact = $model->n_documentos;
                            $accounting_seats->id = $h;
                            $accounting_seats->institution_id = $id_ins;
                            $accounting_seats->description = $descripcion;
                            $accounting_seats->nodeductible = $nodeductible;
                            $accounting_seats->status = $status;
                            if ($accounting_seats->save()) {
                                $bodyf=FacturaBody::find()->where(['id_head'=>$model->n_documentos])->all();
                                $sum=0;
                                $haber=array();
                                $suma=array();
                                foreach ($bodyf as $bod) {
                                    $cos = Product::findOne(["id" => $bod->id_producto]);
                                    $sum = $sum + ($bod->precio_total);
                                    if ($cos->product_type_id == 1) {
                                        $debea[] = $cos->Chairinve;
                                    } else {
                                        if ($cos->product_type_id == 2){
                                            $debea[] = $cos->chairaccount_id;
                                        }
                                }
                                    $suma[]=$bod->precio_total;
                                    yii::debug($suma);
                                }

                                $debea[]= 13161;
                                $habera = $accou_c;
                                $i=count($debea);

                                 $facturafin->iva;
                                $count=0;
                                foreach ($debea as $debe) {

                                    if($count<$i-1){
                                        $accounting_seats_details = new AccountingSeatsDetails;
                                        $accounting_seats_details->accounting_seat_id = $accounting_seats->id;
                                        $accounting_seats_details->chart_account_id = $debe;
                                        $accounting_seats_details->debit = $suma[$count];
                                        $accounting_seats_details->credit = 0;
                                        $accounting_seats_details->cost_center_id = 1;
                                        $accounting_seats_details->status = true;
                                        $accounting_seats_details->save();

                                        yii::debug($suma);
                                    }
                                    else{
                                        $accounting_seats_details = new AccountingSeatsDetails;
                                        $accounting_seats_details->accounting_seat_id = $accounting_seats->id;
                                        $accounting_seats_details->chart_account_id = $debe;
                                        $accounting_seats_details->debit = $facturafin->iva;
                                        $accounting_seats_details->credit = 0;
                                        $accounting_seats_details->cost_center_id = 1;
                                        $accounting_seats_details->status = true;
                                        $accounting_seats_details->save();
                                        yii::debug("aqui");
                                    }
                                    $count=$count+1;

                                }
                                $accounting_seats_details = new AccountingSeatsDetails;
                                $accounting_seats_details->accounting_seat_id = $accounting_seats->id;
                                $accounting_seats_details->chart_account_id = $habera;
                                $accounting_seats_details->debit = 0;
                                $accounting_seats_details->credit = $facturafin->total;
                                $accounting_seats_details->cost_center_id = 1;
                                $accounting_seats_details->status = true;
                                $accounting_seats_details->save();

                            }
                            return $this->redirect('factura');
                        }
                    }
                }
            }












            return $this->render('factura', [
                'model' => $model, "ven" => $persona, "model2" => $model2, "produc" => $pro, "precio" => $precio,"query"=>$query, 'model3' => $facturafin,'modeltype'=>$model_tipo,'produ'=>$productos,"providers"=>$providers

            ]);
        }
public function actionGetdata($data){
    $model=New Providers;
    $model2=New Clients;
    $model3=New Person;
if ($data=="Proveedor"){
    $model2::find()->all();
    $c=$model3::find()->innerJoin('providers',"person.id=providers.person_id")->all();
    foreach($c as $co){
        echo "<option value='$co->id'>$co->id</option>";
    }
}
else{
    if ($data=="Cliente"){
        $model2::find()->all();
        $c=$model3::find()->innerJoin('clients',"person.id=clients.person_id")->all();
        foreach($c as $co){
            echo "<option value='$co->id'>$co->id</option>";
        }
    }
}
}
    public function actionFormclientrender(){
    $person=new Person;
    $query=$person::find()->select("ruc")->all();
    $dataProvider = new ActiveDataProvider([
            'query' => $query

        ]);





    return $this->render('formclientrender', [
            'model' => $query
        ]);
    }

    public function actionVer(){


        $this->render("ver",["hola"=>"carton"]);
    }
    public function actionGuardarproceso(){

        if(Yii::$app->request->isAjax){
            $data=Yii::$app->request->post();
            $cantidad=$data['cantidad'];
            $producto=$data['produc'];
            $preciou=$data['preciou'];
            $precioto=$data['precioto'];
            $id_head=$data['ndocumento'];
            yii::debug($id_head);
            $i=count($cantidad);
            for($k=0;$k<$i;$k++){
                $id_product=New Product;
                $i_pro=$id_product::findOne(['name'=>$producto[$k]]);
                $facbody=New FacturaBody;
                $facbody->cant=$cantidad[$k];
                $facbody->precio_u=$preciou[$k];
                $facbody->precio_total=$precioto[$k];
                $facbody->id_producto=$i_pro->id;
                $facbody->id_head=$id_head;
                $facbody->save();
            }

        }


        $this->render("guardarproceso");
    }
    public function actionPdf($id){
        $modelhead=New HeadFact;
        $modelbody=New FacturaBody;
        $modelfin=New Facturafin;
        $persona=New Person;


        $id=$_GET["id"];
        $model1=$modelhead::findOne($id);
        $model2=$modelbody::find()->where(["id_head"=>$id])->all();
        $model3=$modelfin::findOne(["id_head"=>$id]);
        $persona=$persona::findOne(["id"=>$model1->id_personas]);
        $modelo= AccountingSeats::find()->where(["head_fact"=>$id])->all();

        $content = $this->renderPartial('pdfview', [
            'model' => $model1,"model2"=>$model2,"modelfin"=>$model3,"personam"=>$persona,"modelas"=>$modelo

        ]);
        $pdf = new \kartik\mpdf\Pdf([
            'mode' => \kartik\mpdf\Pdf::MODE_UTF8, // leaner size using standard fonts
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => [
                'title' => 'Factuur',
                'subject' => 'Generating PDF files via yii2-mpdf extension has never been easy'
            ],
            'methods' => [
                'SetHeader' => ['Factura '],
                'SetFooter' => ['|Page {PAGENO}|'],
            ]
        ]);
        return $pdf->render();
    }

}