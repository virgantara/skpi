<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakKampusKoordinator;

/**
 * SimakKampusKoordinatorSearch represents the model behind the search form of `app\models\SimakKampusKoordinator`.
 */
class SimakKampusKoordinatorSearch extends SimakKampusKoordinator
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kampus_id'], 'integer'],
            [['nama_cabang', 'nama_koordinator','niy'], 'safe'],
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
        $query = SimakKampusKoordinator::find();

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
            'kampus_id' => $this->kampus_id,
        ]);

        $query->andFilterWhere(['like', 'niy', $this->niy])
            ->andFilterWhere(['like', 'nama_cabang', $this->nama_cabang])
            ->andFilterWhere(['like', 'nama_koordinator', $this->nama_koordinator]);

        return $dataProvider;
    }
}
