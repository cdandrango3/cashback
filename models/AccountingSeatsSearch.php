<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * AccountingSeatsSearch represents the model behind the search form of `app\models\AccountingSeats`.
 */
class AccountingSeatsSearch extends AccountingSeats
{
    /**
     * {@inheritdoc}
     */

    public $datefrom;
    public $dateto;
    public $cost_center;
    public $account;
    public function rules()
    {
        return [
            [['id', 'institution_id'], 'integer'],
            [['date', 'description'], 'safe'],
            [['nodeductible', 'status'], 'boolean'],
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
        $query = AccountingSeats::find();

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
            'date' => $this->date,
            'institution_id' => $this->institution_id,
            'nodeductible' => $this->nodeductible,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['ilike', 'description', $this->description]);

        return $dataProvider;
    }
}
