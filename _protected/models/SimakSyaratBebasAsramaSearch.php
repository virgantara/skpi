<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakSyaratBebasAsrama;

/**
 * SimakSyaratBebasAsramaSearch represents the model behind the search form of `app\models\SimakSyaratBebasAsrama`.
 */
class SimakSyaratBebasAsramaSearch extends SimakSyaratBebasAsrama
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nama', 'is_aktif'], 'safe'],
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
        $query = SimakSyaratBebasAsrama::find();

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
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'is_aktif', $this->is_aktif]);

        return $dataProvider;
    }
}
