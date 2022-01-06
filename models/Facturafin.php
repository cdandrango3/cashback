<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "facturafin".
 *
 * @property int $id
 * @property float|null $total
 * @property float|null $subtotal12
 * @property int|null $descuento
 * @property string $id_head
 * @property float|null $iva
 * @property float|null $subtotal0
 *
 * @property HeadFact $head
 */
class Facturafin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'facturafin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['total', 'subtotal12', 'iva', 'subtotal0'], 'number'],
            [['descuento'], 'default', 'value' => null],
            [['descuento'], 'integer'],
            [['id_head'], 'required'],
            [['id_head'], 'string'],
            [['id_head'], 'unique'],
            [['id_head'], 'exist', 'skipOnError' => true, 'targetClass' => HeadFact::className(), 'targetAttribute' => ['id_head' => 'n_documentos']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'total' => 'Total',
            'subtotal12' => 'Subtotal12',
            'descuento' => 'Descuento',
            'id_head' => 'Id Head',
            'iva' => 'Iva',
            'subtotal0' => 'subtotal0',
        ];
    }

    /**
     * Gets query for [[Head]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHead()
    {
        return $this->hasOne(HeadFact::className(), ['n_documentos' => 'id_head']);
    }
}
