<?php

namespace app\controllers;
use app\models\Clients;
use app\models\Person;
use app\models\HeadFact;
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
        $person=new Person;
        $salesman=New Salesman;


        $persona=$person::find()->select("name")->all();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {

            }
            return $this->redirect("factura");
        }


        return $this->render('factura', [
            'model' => $model,'s'=>False,"ven"=>$persona
        ]);
    }
    public function actionFormclientrender(){
    $person=new Person;
    $query=$person::find()->select("ruc")->all();
    $dataProvider = new ActiveDataProvider([
            'query' => $query

        ]);
        if ($person->load(Yii::$app->request->isAjax)) {




            return $this->render('factura', [
                    'model' => $model,
                    's' =>True,"person"=>'casas'
                ]

            );

        }

    return $this->render('formclientrender', [
            'model' => $query
        ]);
    }

}