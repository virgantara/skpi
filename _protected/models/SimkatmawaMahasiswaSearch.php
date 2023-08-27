<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimkatmawaMahasiswa;

/**
 * SimkatmawaMahasiswaSearch represents the model behind the search form of `app\models\SimkatmawaMahasiswa`.
 */
class SimkatmawaMahasiswaSearch extends SimkatmawaMahasiswa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'simkatmawa_mbkm_id', 'simkatmawa_mandiri_id', 'simkatmawa_belmawa_id', 'simkatmawa_non_lomba_id'], 'integer'],
            [['nim', 'nama', 'prodi', 'kampus'], 'safe'],
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
        $query = SimkatmawaMahasiswa::find();

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
            'simkatmawa_mbkm_id' => $this->simkatmawa_mbkm_id,
            'simkatmawa_mandiri_id' => $this->simkatmawa_mandiri_id,
            'simkatmawa_belmawa_id' => $this->simkatmawa_belmawa_id,
            'simkatmawa_non_lomba_id' => $this->simkatmawa_non_lomba_id,
        ]);

        $query->andFilterWhere(['like', 'nim', $this->nim])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'prodi', $this->prodi])
            ->andFilterWhere(['like', 'kampus', $this->kampus]);

        return $dataProvider;
    }
}
