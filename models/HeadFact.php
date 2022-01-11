<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "head_fact".
 *
 * @property string|null $f_timestamp
 * @property string $n_documentos
 * @property int $id_personas
 * @property string|null $referencia
 * @property string $orden_cv
 * @property bool|null $Entregado
 * @property string|null $autorizacion
 * @property string|null $tipo_de_documento
 * @property int|null $id_saleman
 * @property int $id
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
            [['f_timestamp'], 'safe'],
            [['id_personas', 'orden_cv'], 'required'],
            [['id_personas', 'id_saleman'], 'default', 'value' => null],
            [['id_personas', 'id_saleman'], 'integer'],
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
            'f_timestamp' => 'F Timestamp',
            'n_documentos' => 'N Documentos',
            'id_personas' => 'Id Personas',
            'referencia' => 'Referencia',
            'orden_cv' => 'Orden Cv',
            'Entregado' => 'Entregado',
            'autorizacion' => 'Autorizacion',
            'tipo_de_documento' => 'Tipo De Documento',
            'id_saleman' => 'Id Saleman',
            'id' => 'ID',
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
