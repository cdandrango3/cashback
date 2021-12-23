<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\product;

/**
 * productSearch represents the model behind the search form of `app\models\product`.
 */
class productSearch extends product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'institution_id', 'product_type_id', 'product_iva_id'], 'integer'],
            [['name', 'category', 'brand', 'purpose'], 'safe'],
            [['status'], 'boolean'],
            [['precio', 'costo'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = product::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'institution_id' => $this->institution_id,
            'product_type_id' => $this->product_type_id,
            'product_iva_id' => $this->product_iva_id,
            'precio' => $this->precio,
            'costo' => $this->costo,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'category', $this->category])
            ->andFilterWhere(['ilike', 'brand', $this->brand])
            ->andFilterWhere(['ilike', 'purpose', $this->purpose]);

        return $dataProvider;
    }
}
