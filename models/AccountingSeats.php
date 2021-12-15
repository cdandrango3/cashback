<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accounting_seats".
 *
 * @property int $id
 * @property string $date
 * @property int $institution_id
 * @property string $description
 * @property bool|null $nodeductible
 * @property bool $status
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $deleted_at
 *
 * @property Institution $institution
 * @property AccountingSeatsDetails[] $accountingSeatsDetails
 */
class AccountingSeats extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $datefrom;
    public $dateto;
    public $cost_center;
    public $account;
    public static function tableName()
    {
        return 'accounting_seats';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['institution_id', 'description'], 'required'],
            [['institution_id'], 'default', 'value' => null],
            [['institution_id'], 'integer'],
            [['description'], 'string'],
            [['nodeductible', 'status'], 'boolean'],
            [['institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => Institution::className(), 'targetAttribute' => ['institution_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Fecha',
            'institution_id' => 'ID Institución',
            'description' => 'Glosa',
            'nodeductible' => 'No Deducible',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Institution]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInstitution()
    {
        return $this->hasOne(Institution::className(), ['id' => 'institution_id']);
    }

    /**
     * Gets query for [[AccountingSeatsDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccountingSeatsDetails()
    {
        return $this->hasMany(AccountingSeatsDetails::className(), ['accounting_seat_id' => 'id']);
    }
}
