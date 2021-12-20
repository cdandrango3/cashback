<?php

namespace app\controllers;
use app\models\AccountingSeats;
use app\models\Clients;
use app\models\FacturaBody;
use app\models\Facturafin;
use app\models\Institution;
use app\models\Person;
use app\models\HeadFact;
use app\models\Product;
use app\models\Salesman;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class ClienteController extends controller
{
    public $valores="";
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
        $salesman = new Salesman;
        $model2 = new FacturaBody;
        $productos = new Product;
        $facturafin = new Facturafin;
        $accounting_seats=new AccountingSeats;
        $persona = $person::find()->select("name")->all();
        $pro = $productos::find()->select("name")->all();
        $precio = $productos::find()->all();
        $d= Yii::$app->request->post('Facturafin');
        $per= Yii::$app->request->post('Person');
        $query = $person::find()->select("id")->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->id_personas=$per["id"];
            if ($model->validate())
                $model->id_personas=$per["id"];
                $model->save();

                $c = rand(100, 1000);
                $facturafin->id = $c;
                $facturafin->subtotal = $d["subtotal"];
                $facturafin->total = $d["total"];
                $facturafin->iva = $d["iva"];
                $facturafin->id_head = $model->id;
                $facturafin->save();

                if($model->save()){
                $ch1=$client::findOne(['person_id' => $model->id_personas]);
                $accou_c=$ch1->chart_account_id;
                $ins=$person::findOne(['id' => $model->id_personas]);
                $id_ins=$ins->id;
                $date=

                }
            }


        if ($model2->load(Yii::$app->request->post())) {
            if ($model2->validate()) {

            }
            $c = Yii::$app->request->post('FacturaBody');
            $per = Yii::$app->request->post('Person');

            $d = Yii::$app->request->post('Facturafin');
            foreach ($c as $fr) {
                $model2->cant = $fr["cant"];

                $model2->precio_u = $fr["precio_u"];
                $model2->precio_total = $fr["precio_total"];
                $model2->save();
            }




        }




            return $this->render('factura', [
                'model' => $model, 's' => False, "ven" => $persona, "model2" => $model2, "produc" => $pro, "pro2" => $precio, 'model3' => $facturafin,'query'=>$query
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

}