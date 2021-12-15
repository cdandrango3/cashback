<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AccountingSeats;
use app\models\AccountingSeatsDetails;

/**
 * AccountingSeatsSearch represents the model behind the search form about `app\models\AccountingSeats`.
 */
class AccountingSeatsSearch extends AccountingSeats
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'institution_id'], 'integer'],
            [['date', 'description', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['nodeductible', 'status'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
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
        $query2 = AccountingSeatsDetails::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $ids = false;
        $this->account = isset($params['AccountingSeats']['account']) ? $params['AccountingSeats']['account'] : $this->account;
        $this->cost_center = isset($params['AccountingSeats']['cost_center']) ? $params['AccountingSeats']['cost_center'] : null;
        $this->datefrom = isset($params['AccountingSeats']['datefrom']) ? $params['AccountingSeats']['datefrom'] : date('Y-m-d',strtotime('first day of this month'));
        $this->dateto = isset($params['AccountingSeats']['dateto']) ? $params['AccountingSeats']['dateto'] : date('Y-m-d');
        if ($this->account || $this->cost_center || $this->datefrom || $this->dateto) {
            $query2->select('accounting_seats.id')->from('accounting_seats')->innerJoin('accounting_seats_details', 'accounting_seats_details.accounting_seat_id = accounting_seats.id')->distinct('accounting_seats.id');
            $query2->andFilterWhere(['chart_account_id' => $this->account]);
            $query2->andFilterWhere(['cost_center_id' => $this->cost_center]);
            $query2->andFilterWhere(['between', 'date', $this->datefrom, $this->dateto]);
            $query2->andWhere(['accounting_seats_details.status'=>1,'accounting_seats.status'=>1]);
            $ids = $query2->asArray()->all();
        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if ($ids===false) {
            $query->andFilterWhere([
                'id' => $this->id,
                //'date' => $this->date,
                'institution_id' => $this->institution_id,
                'nodeductible' => $this->nodeductible,
                'status' => 1,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'deleted_at' => $this->deleted_at,
            ]);
            if ($this->datefrom) {
                $query->andWhere(['between', 'date', $this->datefrom, $this->dateto]);
            } else {
                $query->andWhere(['between', 'date', '1900-01-01', '1900-01-01']);
            }
            $query->andFilterWhere(['like', 'description', $this->description]);
        } else {
            $query->andWhere(['in','id',$ids]);
        }

        return $dataProvider;
    }
    
}
