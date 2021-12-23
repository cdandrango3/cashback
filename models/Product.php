<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property bool $status
 * @property int $institution_id
 * @property string|null $category
 * @property int $product_type_id
 * @property string|null $brand
 * @property string|null $purpose
 * @property int $product_iva_id
 * @property float|null $precio
 * @property float|null $costo
 *
 * @property FacturaBody[] $facturaBodies
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'institution_id', 'product_type_id', 'product_iva_id'], 'required'],
            [['status'], 'boolean'],
            [['institution_id', 'product_type_id', 'product_iva_id'], 'default', 'value' => null],
            [['institution_id', 'product_type_id', 'product_iva_id'], 'integer'],
            [['precio', 'costo'], 'number'],
            [['name', 'brand', 'purpose'], 'string', 'max' => 250],
            [['category'], 'string', 'max' => 258],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'status' => 'Status',
            'institution_id' => 'Institucion',
            'category' => 'Categorias',
            'product_type_id' => 'Tipo de producto',
            'brand' => 'Marca',
            'purpose' => 'Proposito',
            'product_iva_id' => 'Producto Iva',
            'precio' => 'Precio',
            'costo' => 'Costo',
        ];
    }

    /**
     * Gets query for [[FacturaBodies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFacturaBodies()
    {
        return $this->hasMany(FacturaBody::className(), ['id_producto' => 'id']);
    }
}
