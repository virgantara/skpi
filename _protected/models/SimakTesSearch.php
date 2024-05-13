<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakTes;

/**
 * SimakTesSearch represents the model behind the search form of `app\models\SimakTes`.
 */
class SimakTesSearch extends SimakTes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nim', 'jenis_tes', 'nama_tes', 'penyelenggara', 'tanggal_tes', 'file_path', 'status_validasi', 'catatan', 'updated_at', 'created_at'], 'safe'],
            [['tahun', 'approved_by'], 'integer'],
            [['skor_tes'], 'number'],
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
        $query = SimakTes::find();

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
            'tahun' => $this->tahun,
            'skor_tes' => $this->skor_tes,
            'approved_by' => $this->approved_by,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'nim', $this->nim])
            ->andFilterWhere(['like', 'jenis_tes', $this->jenis_tes])
            ->andFilterWhere(['like', 'nama_tes', $this->nama_tes])
            ->andFilterWhere(['like', 'penyelenggara', $this->penyelenggara])
            ->andFilterWhere(['like', 'tanggal_tes', $this->tanggal_tes])
            ->andFilterWhere(['like', 'file_path', $this->file_path])
            ->andFilterWhere(['like', 'status_validasi', $this->status_validasi])
            ->andFilterWhere(['like', 'catatan', $this->catatan]);

        return $dataProvider;
    }
}
