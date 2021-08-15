<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakKegiatanHarian;

/**
 * SimakKegiatanHarianSearch represents the model behind the search form of `app\models\SimakKegiatanHarian`.
 */
class SimakKegiatanHarianSearch extends SimakKegiatanHarian
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kode', 'jam_mulai', 'jam_selesai', 'kode_venue'], 'safe'],
            [['kegiatan_id', 'tahun_akademik'], 'integer'],
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
        $query = SimakKegiatanHarian::find();

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
            'kegiatan_id' => $this->kegiatan_id,
            'tahun_akademik' => $this->tahun_akademik,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'kode', $this->kode])
            ->andFilterWhere(['like', 'kode_venue', $this->kode_venue]);

        return $dataProvider;
    }
}
