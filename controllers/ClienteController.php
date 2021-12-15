<?php

namespace app\controllers;
use app\models\Clients;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class ClienteController extends controller
{
public function actionIndex(){
    $models=New clients;
    $query = $models::find();
    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);

    return $this->render('index',["models"=>$dataProvider]);
}
}