<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "head_fact".
 *
 * @property int $id
 * @property int|null $id_saleman
 * @property string|null $f_timestamp
 * @property string $n_documentos
 * @property int $id_personas
 * @property string|null $referencia
 * @property string $orden_cv
 * @property bool|null $Entregado
 * @property string|null $autorizacion
 * @property string|null $tipo_de_documento
 *
 * @property Facturafin[] $facturafins
 * @property Person $personas
 * @property Salesman $saleman
 */
class HeadFact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'head_fact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_saleman', 'id_personas'], 'default', 'value' => null],
            [['id_saleman', 'id_personas'], 'integer'],
            [['f_timestamp'], 'safe'],
            [['n_documentos', 'id_personas', 'orden_cv'], 'required'],
            [['Entregado'], 'boolean'],
            [['n_documentos', 'referencia', 'orden_cv', 'autorizacion', 'tipo_de_documento'], 'string', 'max' => 50],
            [['n_documentos', 'n_documentos'], 'unique', 'targetAttribute' => ['n_documentos', 'n_documentos']],
            [['id_personas'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['id_personas' => 'id']],
            [['id_saleman'], 'exist', 'skipOnError' => true, 'targetClass' => Salesman::className(), 'targetAttribute' => ['id_saleman' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_saleman' => 'Id Saleman',
            'f_timestamp' => 'F Timestamp',
            'n_documentos' => 'N Documentos',
            'id_personas' => 'Id Personas',
            'referencia' => 'Referencia',
            'orden_cv' => 'Orden Cv',
            'Entregado' => 'Entregado',
            'autorizacion' => 'Autorizacion',
            'tipo_de_documento' => 'Tipo De Documento',
        ];
    }

    /**
     * Gets query for [[Facturafins]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFacturafins()
    {
        return $this->hasMany(Facturafin::className(), ['id_head' => 'id']);
    }

    /**
     * Gets query for [[Personas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersonas()
    {
        return $this->hasOne(Person::className(), ['id' => 'id_personas']);
    }

    /**
     * Gets query for [[Saleman]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSaleman()
    {
        return $this->hasOne(Salesman::className(), ['id' => 'id_saleman']);
    }
}
