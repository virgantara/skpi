<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakPropinsi;

/**
 * SimakPropinsiSearch represents the model behind the search form of `app\models\SimakPropinsi`.
 */
class SimakPropinsiSearch extends SimakPropinsi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'id', 'created_by', 'updated_by', 'last_updated'], 'integer'],
            [['prov', 'keterangan', 'map_id', 'date_created'], 'safe'],
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
        $query = SimakPropinsi::find();

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
            'kode' => $this->kode,
            'id' => $this->id,
            'created_by' => $this->created_by,
            'date_created' => $this->date_created,
            'updated_by' => $this->updated_by,
            'last_updated' => $this->last_updated,
        ]);

        $query->andFilterWhere(['like', 'prov', $this->prov])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'map_id', $this->map_id]);

        return $dataProvider;
    }
}
