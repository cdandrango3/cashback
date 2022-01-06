<?php

namespace app\controllers;

use app\models\AccountingSeats;
use app\models\AccountingSeatsDetails;
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
    $upt=$chargem::find()->where(["n_document"=>$header->n_documentos])->exists();
if($chargem->load(Yii::$app->request->post())) {
    Yii::debug($chargem->validate());
    $up=$chargem::find()->where(["n_document"=>$header->n_documentos])->exists();
    if ($up==True){
        $ac=$chargem::findOne(["n_document"=>$header->n_documentos]);
        $ac->updateAttributes(['amount' => $chargem->amount]);
        $ac->updateAttributes(['saldo' => ($body->total) - ($chargem->amount)]);
        Yii::$app->session->setFlash('success', "El valor debe ser menor al valor a pagar");
    }
    else {
        $c = rand(1, 10000303);
        $chargem->id = $c;
        $chargem->n_document = $header->n_documentos;
        $chargem->person_id = $persona->id;
        $chargem->balance = $body->total;
        $chargem->saldo = $body->total;

        $chargem->save();
        if ($chargem->save()) {
            $chargem->saldo = ($chargem->balance) - ($chargem->amount);
            $chargem->save();
            $gr = rand(1, 100090000);
            if($chargem->type_transaccion=="Cobro") {
                if ($chargem->type_charge == "Caja") {
                    $this->asientoscreate($gr, 13586, 13133, $body);
                } else {
                    if ($chargem->type_charge == "Transferencia" || $chargem->type_charge == "Cheque") {
                        $this->asientoscreate($gr, 13125, 13133, $body);
                    }
                }
            }
            //aqui empieza pagos//
            if($chargem->type_transaccion=="Pago") {
                if ($chargem->type_charge == "Caja") {

                    $this->asientoscreate($gr, 13234, 13586, $body);
                } else {

                    if ($chargem->type_charge == "Transferencia" || $chargem->type_charge == "Cheque") {
                        $this->asientoscreate($gr, 13234, 13125, $body);
                    }
                }
            }
        }
    }
if($chargem->validate()){

}
}
return $this->render("index",["chargem"=>$chargem,"Person"=>$persona,"body"=>$body,"header"=>$header,"upt"=>$upt]);
}
public function asientoscreate($gr,$debe,$haber,$body){
    $accounting_sea=new AccountingSeats;
    $accounting_sea->id= $gr;
    $accounting_sea->institution_id=1;
    $accounting_sea->description="fact2";
    $accounting_sea->nodeductible="";
    $accounting_sea->status=true;
    if($accounting_sea->save()) {

        $debe = $debe;
        $haber = $haber;

        $accounting_seats_details = new AccountingSeatsDetails;
        $accounting_seats_details->accounting_seat_id = $accounting_sea->id;
        $accounting_seats_details->chart_account_id = $debe;
        $accounting_seats_details->debit = $body->total;
        $accounting_seats_details->credit = 0;
        $accounting_seats_details->cost_center_id = 1;
        $accounting_seats_details->status = true;
        $accounting_seats_details->save();
        $accounting_seats_details = new AccountingSeatsDetails;
        $accounting_seats_details->accounting_seat_id = $accounting_sea->id;
        $accounting_seats_details->chart_account_id = $haber;
        $accounting_seats_details->debit = 0;
        $accounting_seats_details->credit = $body->total;
        $accounting_seats_details->cost_center_id = 1;
        $accounting_seats_details->status = true;
        $accounting_seats_details->save();
    }
}
}