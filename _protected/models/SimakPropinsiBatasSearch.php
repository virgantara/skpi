<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakPropinsiBatas;

/**
 * SimakPropinsiBatasSearch represents the model behind the search form of `app\models\SimakPropinsiBatas`.
 */
class SimakPropinsiBatasSearch extends SimakPropinsiBatas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kode_prop'], 'integer'],
            [['latitude', 'longitude'], 'number'],
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
        $query = SimakPropinsiBatas::find();

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
            'kode_prop' => $this->kode_prop,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);

        return $dataProvider;
    }
}
