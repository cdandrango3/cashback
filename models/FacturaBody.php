<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "factura_body".
 *
 * @property int $id
 * @property int|null $cant
 * @property float|null $precio_u
 * @property float|null $precio_total
 * @property int|null $id_producto
 *
 * @property Product $producto
 * @property Facturafin[] $facturafins
 */
class FacturaBody extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'factura_body';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cant', 'id_producto'], 'default', 'value' => null],
            [['cant', 'id_producto'], 'integer'],
            [['precio_u', 'precio_total'], 'number'],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['id_producto' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cant' => 'Cant',
            'precio_u' => 'Precio U',
            'precio_total' => 'Precio Total',
            'id_producto' => 'Id Producto',
        ];
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Product::className(), ['id' => 'id_producto']);
    }

    /**
     * Gets query for [[Facturafins]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFacturafins()
    {
        return $this->hasMany(Facturafin::className(), ['id_facd' => 'id']);
    }
}
