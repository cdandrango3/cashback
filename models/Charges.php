<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "charges".
 *
 * @property int $id
 * @property string|null $type_charge
 * @property int|null $person_id
 * @property float|null $saldo
 * @property float|null $balance
 * @property float|null $amount
 * @property bool|null $status
 * @property string|null $n_document
 * @property string|null $date
 * @property string|null $comprobante
 * @property string|null $Description
 * @property string|null $type_transaccion
 *
 * @property HeadFact $nDocument
 * @property Person $person
 */
class Charges extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'charges';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'person_id'], 'default', 'value' => null],
            [['id', 'person_id'], 'integer'],
            [['type_charge', 'n_document', 'comprobante', 'Description', 'type_transaccion'], 'string'],
            [['saldo', 'balance', 'amount'], 'number'],
            [['status'], 'boolean'],
            [['date'], 'safe'],
            [['id'], 'unique'],
            [['n_document'], 'exist', 'skipOnError' => true, 'targetClass' => HeadFact::className(), 'targetAttribute' => ['n_document' => 'n_documentos']],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['person_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_charge' => 'Type Charge',
            'person_id' => 'Person ID',
            'saldo' => 'Saldo',
            'balance' => 'Balance',
            'amount' => 'Amount',
            'status' => 'Status',
            'n_document' => 'N Document',
            'date' => 'Date',
            'comprobante' => 'Comprobante',
            'Description' => 'Description',
            'type_transaccion' => 'Type Transaccion',
        ];
    }

    /**
     * Gets query for [[NDocument]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNDocument()
    {
        return $this->hasOne(HeadFact::className(), ['n_documentos' => 'n_document']);
    }

    /**
     * Gets query for [[Person]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }
}
