<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "facturafin".
 *
 * @property int $id
 * @property float|null $total
 * @property float|null $subtotal
 * @property int|null $descuento
 * @property float|null $iva
 * @property int|null $id_head
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
            [['total', 'subtotal', 'iva'], 'number'],
            [['descuento', 'id_head'], 'default', 'value' => null],
            [['descuento', 'id_head'], 'integer'],
            [['id_head'], 'exist', 'skipOnError' => true, 'targetClass' => HeadFact::className(), 'targetAttribute' => ['id_head' => 'id']],
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
            'subtotal' => 'Subtotal',
            'descuento' => 'Descuento',
            'iva' => 'Iva',
            'id_head' => 'Id Head',
        ];
    }

    /**
     * Gets query for [[Head]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHead()
    {
        return $this->hasOne(HeadFact::className(), ['id' => 'id_head']);
    }
}
