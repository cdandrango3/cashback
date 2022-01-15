<?php

namespace app\controllers;

use app\models\AccountingSeats;
use app\models\Charges;
use app\models\ChargesDetail;
use app\models\FacturaBody;
use app\models\Facturafin;
use app\models\HeadFact;
use app\models\Person;
use Yii;
use app\models\BankDetails;
use app\models\BankdetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BankdetailsController implements the CRUD actions for BankDetails model.
 */
class BankdetailsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all BankDetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BankdetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BankDetails model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BankDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BankDetails();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BankDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BankDetails model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BankDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BankDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BankDetails::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actionTransaction(){
        $model=ChargesDetail::find()->where(["type_transaccion"=>"Transferencia"])->all();
        return $this->render('transaccion', [
            'transaccion'=>$model
        ]);
    }
    public function actionDetail($id){
        $model=ChargesDetail::findOne(["comprobante"=>$id]);

        return $this->render('detail', [
            'transaccion'=>$model
        ]);
    }
    public function actionPdfview($com)
    {
        $modelfin=New ChargesDetail;
        $persona=New Person;
        $id=$_GET["com"];
        $modelo= ChargesDetail::findOne(["comprobante"=>$id]);
        $modelo2=Charges::findOne(["id"=>$modelo->id_charge]);
        yii::debug($modelo->id_asiento);
        $accounting_sea=AccountingSeats::findOne([["id"=>$modelo->id_asiento]]);
        $content = $this->renderPartial('pdfview', [
            "modelo"=>$accounting_sea,"model2"=>$modelo2,"charge"=>$modelo]);
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
