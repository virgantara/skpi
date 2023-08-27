<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakMagangNilai;

/**
 * SimakMagangNilaiSearch represents the model behind the search form of `app\models\SimakMagangNilai`.
 */
class SimakMagangNilaiSearch extends SimakMagangNilai
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['kriteria', 'magang_id', 'updated_at', 'created_at'], 'safe'],
            [['nilai_angka', 'bobot'], 'number'],
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
        $query = SimakMagangNilai::find();

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
            'nilai_angka' => $this->nilai_angka,
            'bobot' => $this->bobot,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'kriteria', $this->kriteria])
            ->andFilterWhere(['like', 'magang_id', $this->magang_id]);

        return $dataProvider;
    }
}
