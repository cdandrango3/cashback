<?php

namespace app\controllers;

use app\models\Charges;
use app\models\Facturafin;
use app\models\HeadFact;
use app\models\Person;
use Yii;
use yii\web\Controller;

class CobrosController extends Controller
{
public function actionCobros($id){
$chargem=New charges;
$Persona=New Person;
$Header=New HeadFact;
$id=$_GET['id'];
$body=Facturafin::findOne(["id_head"=>$id]);
$header=$Header->findOne($id);
$persona=$Persona::findOne(["id"=>$header->id_personas]);

return $this->render("index",["chargem"=>$chargem,"Person"=>$persona,"body"=>$body,"header"=>$header]);
}
}