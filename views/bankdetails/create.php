<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BankDetails */

$this->title = Yii::t('app', 'Detalles Bancarios');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Detalles Bancarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
