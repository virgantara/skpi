<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimkatmawaBelmawa;

/**
 * SimkatmawaBelmawaSearch represents the model behind the search form of `app\models\SimkatmawaBelmawa`.
 */
class SimkatmawaBelmawaSearch extends SimkatmawaBelmawa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'simkatmawa_belmawa_kategori_id'], 'integer'],
            [['jenis_simkatmawa', 'nama_kegiatan', 'peringkat', 'keterangan', 'tahun', 'url_kegiatan', 'laporan_path', 'created_at', 'updated_at'], 'safe'],
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
        $query = SimkatmawaBelmawa::find();

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
            'user_id' => $this->user_id,
            'simkatmawa_belmawa_kategori_id' => $this->simkatmawa_belmawa_kategori_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'jenis_simkatmawa', $this->jenis_simkatmawa])
            ->andFilterWhere(['like', 'nama_kegiatan', $this->nama_kegiatan])
            ->andFilterWhere(['like', 'peringkat', $this->peringkat])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'tahun', $this->tahun])
            ->andFilterWhere(['like', 'url_kegiatan', $this->url_kegiatan])
            ->andFilterWhere(['like', 'laporan_path', $this->laporan_path]);

        return $dataProvider;
    }
}
