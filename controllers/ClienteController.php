<?php

namespace app\controllers;
use app\models\AccountingSeats;
use app\models\AccountingSeatsDetails;
use app\models\Clients;
use app\models\FacturaBody;
use app\models\Facturafin;
use app\models\Institution;
use app\models\Person;
use app\models\HeadFact;
use app\models\Product;
use app\models\ProductType;
use app\models\Salesman;
use Cassandra\Date;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class ClienteController extends controller
{
    public $id;
public function actionIndex(){
    $models=New clients;
    $query = $models::find();
    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);

    return $this->render('index',["models"=>$dataProvider]);
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
        $persona = $person::find()->select("name")->all();
        $model_tipo=$model_tip::find()->select("name")->all();
        $pro = $productos::find()->select("name")->where(['product_type_id'=>1])->all();

        $precio = $productos::find()->all();
        $proser = $productos::find()->select("name")->where(['product_type_id'=>2])->all();

        $precioser = $productos::find()->where(['product_type_id'=>2])->all();
        $d= Yii::$app->request->post('Facturafin');
        $per= Yii::$app->request->post('Person');
        $query = $person::find()->select("id")->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->id_personas=$per["id"];
            if ($model->validate())
                $model->id_personas=$per["id"];
                $model->save();

                $c = rand(1, 100090000);
                $this->id=$c;
                $facturafin->id = $c;
                $facturafin->subtotal = $d["subtotal"];
                $facturafin->total = $d["total"];
                $facturafin->iva = $d["iva"];
                $facturafin->id_head = $model->n_documentos;
                $facturafin->save();

                if($model->save()){
                $ch1=$client::findOne(['person_id' => $model->id_personas]);
                $accou_c=$ch1->chart_account_id;

                $ins=$person::findOne(['id' => $model->id_personas]);
                $id_ins=$ins->institution_id;

                $descripcion="fact1";
                $nodeductible=True;
                $status=True;
                    $h = rand(1, 10000000);
                 $accounting_seats->id= $h;
                $accounting_seats->institution_id=$id_ins;
                $accounting_seats->description=$descripcion;
                $accounting_seats->nodeductible=$nodeductible;
                $accounting_seats->status=$status;
                if($accounting_seats->save()){
                    $debea=$accou_c;


                    if ($model_tip->load(Yii::$app->request->post())){
                        $fr=$model_tip["name"];
                        Yii::debug($fr);
                        if($fr=="servicio"){
                            $habera=[13272,13365];
                        }

                        if($fr=="producto"){
                            $habera=[13272,14129];
                        }
                        Yii::debug($habera);




                        $value=[$habera[0]=>$facturafin->iva,$habera[1]=>$facturafin->subtotal];
                        $accounting_seats_details=New AccountingSeatsDetails;
                        $accounting_seats_details->accounting_seat_id=$accounting_seats->id;
                        $accounting_seats_details->chart_account_id=$debea;
                        $accounting_seats_details->debit=$facturafin->total;
                        $accounting_seats_details->credit=0;
                        $accounting_seats_details->cost_center_id=1;
                        $accounting_seats_details->status=true;
                        $accounting_seats_details->save();

                        foreach($habera as $haber){
                            $accounting_seats_details=New AccountingSeatsDetails;
                            $accounting_seats_details->accounting_seat_id=$accounting_seats->id;
                            $accounting_seats_details->chart_account_id=$haber;
                            $accounting_seats_details->debit=0;
                            $accounting_seats_details->credit=$value[$haber];
                            $accounting_seats_details->cost_center_id=1;
                            $accounting_seats_details->status=true;
                            $accounting_seats_details->save();
                        }
                        $gr = rand(1, 100090000);
                        if($fr=="producto"){
                        $accounting_sea=new AccountingSeats;
                        $accounting_sea->id= $gr;
                        $accounting_sea->institution_id=$id_ins;
                        $accounting_sea->description="fact2";
                        $accounting_sea->nodeductible=$nodeductible;
                        $accounting_sea->status=$status;
                        if($accounting_sea->save()) {

                            $debe = 13567;
                            $haber = 23578;
                            $pro = Yii::$app->request->post("Product");

                            $accounting_seats_details = new AccountingSeatsDetails;
                            $accounting_seats_details->accounting_seat_id = $accounting_sea->id;
                            $accounting_seats_details->chart_account_id = $debe;
                            $accounting_seats_details->debit = $pro["costo"];
                            $accounting_seats_details->credit = 0;
                            $accounting_seats_details->cost_center_id = 1;
                            $accounting_seats_details->status = true;
                            $accounting_seats_details->save();
                            $accounting_seats_details = new AccountingSeatsDetails;
                            $accounting_seats_details->accounting_seat_id = $accounting_sea->id;
                            $accounting_seats_details->chart_account_id = $haber;
                            $accounting_seats_details->debit = 0;
                            $accounting_seats_details->credit = $pro["costo"];
                            $accounting_seats_details->cost_center_id = 1;
                            $accounting_seats_details->status = true;
                            $accounting_seats_details->save();
                        }
                    }



                    }
                    return $this->redirect('factura');
                }

                }
            }












            return $this->render('factura', [
                'model' => $model, 's' => False, "ven" => $persona, "model2" => $model2, "produc" => $pro, "pro2" => $precio, 'model3' => $facturafin,'query'=>$query,'proser'=>$proser,'precioser'=>$precioser,'modeltype'=>$model_tipo,'produ'=>$productos
            ]);
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

}