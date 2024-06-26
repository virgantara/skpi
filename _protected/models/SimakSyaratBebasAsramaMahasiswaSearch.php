<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakSyaratBebasAsramaMahasiswa;

/**
 * SimakSyaratBebasAsramaMahasiswaSearch represents the model behind the search form of `app\models\SimakSyaratBebasAsramaMahasiswa`.
 */
class SimakSyaratBebasAsramaMahasiswaSearch extends SimakSyaratBebasAsramaMahasiswa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'file_path', 'updated_at', 'created_at'], 'safe'],
            [['syarat_id', 'mhs_id'], 'integer'],
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
        $query = SimakSyaratBebasAsramaMahasiswa::find();

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
            'syarat_id' => $this->syarat_id,
            'mhs_id' => $this->mhs_id,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'file_path', $this->file_path]);

        return $dataProvider;
    }
}
