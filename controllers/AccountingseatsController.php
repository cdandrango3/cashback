<?php

namespace app\controllers;

use Yii;
use app\models\AccountingSeats;
use app\models\AccountingSeatsDetails;
use app\models\AccountingSeatsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use kartik\mpdf\Pdf;

/**
 * AccountingseatsController implements the CRUD actions for AccountingSeats model.
 */
class AccountingseatsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulkdelete' => ['post'],
                ],
            ],
        ];
    }

    function actionViewpdf($id)
    {
        $model = AccountingSeats::findOne($id);
        $this->layout = 'blank';
        $content = '';
        $content = $this->render('pdf', [
            'model' => $model,
        ]);
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            //            'defaultFontSize' => 12,
            //            'defaultFont' => 'Arial',
            // set to use core fonts only
            'mode' => Pdf::MODE_BLANK,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            'marginLeft' => 20,
            'marginRight' => 20,
            'marginTop' => 20,
            'filename' => 'invoice.pdf',
            'marginBottom' => 20,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            //'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '
                    .kv-heading-1{font-size:18px}
                    .nb {border: none}
                    body {
                        height: 100%;
                    }

                    body {
                        /*margin-top: 50px;*/
                        font-family: "Noto Sans Thai UI", sans-serif;
                        font-size: 14px;
                    }

                    * {
                        font-family: "Noto Sans Thai UI", sans-serif;
                        font-size: 14px;
                    }

                    @font-face {
                        font-family: \'Noto Sans Thai UI\';
                        src: url(\'font/subset-NotoSansThaiUI-Regular.woff2\') format(\'woff2\'),
                            url(\'font/subset-NotoSansThaiUI-Regular.woff\') format(\'woff\');
                        font-weight: normal;
                        font-style: normal;
                    }
            ',
            // set mPDF properties on the fly
            'options' => [
                'title' => 'invoice',
            ],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => false,
                'SetFooter' => false,
            ]
        ]);
        return $pdf->render();
    }
    /**
     * Lists all AccountingSeats models.
     * @return mixed
     */
    public function actionIndex($account = 2)
    {
        $searchModel = new AccountingSeatsSearch();
        $searchModel->account = 2;
        $searchModel->institution_id = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single AccountingSeats model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "AccountingSeats #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new AccountingSeats model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($institution_id)
    {
        $request = Yii::$app->request;
        $model = new AccountingSeats();
        $model->institution_id = $institution_id;
        $model->date = date('Y-m-d');

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Registrar Asiento",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]),
                    //Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            } else if ($model->load($request->post()) && $model->save()) {
                $request = Yii::$app->request;
                $accounts = $request->post('account');
                $debits = $request->post('debit');
                $credits = $request->post('credit');
                $cost_centers =  $request->post('cost_center');
                for ($i = 0; $i < count($accounts); $i++) {
                    $detail = new AccountingSeatsDetails;
                    $detail->accounting_seat_id = $model->id;
                    $detail->chart_account_id = $accounts[$i];
                    $detail->debit = $debits[$i];
                    $detail->credit = $credits[$i];
                    $detail->cost_center_id = $cost_centers[$i];
                    $detail->save();
                }
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Registrar Asiento",
                    'content' => '<span class="text-success">Create AccountingSeats success</span>',
                    'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]),
                    //Html::a('',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];
            } else {
                return [
                    'title' => "Registrar Asiento",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Cerrar', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]),
                    //Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                $request = Yii::$app->request;
                $accounts = $request->post('account');
                $debits = $request->post('debit');
                $credits = $request->post('credit');
                $cost_centers =  $request->post('cost_center');
                for ($i = 0; $i < count($accounts); $i++) {
                    $detail = new AccountingSeatsDetails;
                    $detail->accounting_seat_id = $model->id;
                    $detail->chart_account_id = $accounts[$i];
                    $detail->debit = $debits[$i];
                    $detail->credit = $credits[$i];
                    $detail->cost_center_id = $cost_centers[$i];
                    $detail->save();
                }
                return $this->redirect(['index', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing AccountingSeats model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update AccountingSeats #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "AccountingSeats #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update AccountingSeats #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing AccountingSeats model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //only is manual 
        $request = Yii::$app->request;
        AccountingSeatsDetails::deleteAll(['accounting_seat_id'=>$id]);
        $this->findModel($id)->delete();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Delete multiple existing AccountingSeats model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkdelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the AccountingSeats model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AccountingSeats the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AccountingSeats::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
