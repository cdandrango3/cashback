<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "head_fact".
 *
 * @property int $id
 * @property int|null $id_saleman
 * @property string|null $f_timestamp
 * @property string|null $n_documentos
 * @property int|null $id_personas
 * @property string|null $referencia
 * @property string|null $orden_cv
 * @property bool|null $Entregado
 * @property string|null $autorizacion
 * @property string|null $tipo_de_documento
 *
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
            [['Entregado'], 'boolean'],
            [['n_documentos', 'referencia', 'orden_cv', 'autorizacion', 'tipo_de_documento'], 'string', 'max' => 50],
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
            'id_saleman' => 'Vendedor',
            'f_timestamp' => 'F Timestamp',
            'n_documentos' => 'N Documentos',
            'id_personas' => 'Persona',
            'referencia' => 'Referencia',
            'orden_cv' => 'Orden_Cv',
            'Entregado' => 'Entregado',
            'autorizacion' => 'Autorizacion',
            'tipo_de_documento' => 'TipoDe Documento',
        ];
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
