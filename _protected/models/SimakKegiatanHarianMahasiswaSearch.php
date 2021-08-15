<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakKegiatanHarianMahasiswa;

/**
 * SimakKegiatanHarianMahasiswaSearch represents the model behind the search form of `app\models\SimakKegiatanHarianMahasiswa`.
 */
class SimakKegiatanHarianMahasiswaSearch extends SimakKegiatanHarianMahasiswa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nim', 'kode_kegiatan', 'waktu'], 'safe'],
            [['tahun_akademik', 'kegiatan_rutin_id'], 'integer'],
            [['poin'], 'number'],
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
        $query = SimakKegiatanHarianMahasiswa::find();

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
            'tahun_akademik' => $this->tahun_akademik,
            'kegiatan_rutin_id' => $this->kegiatan_rutin_id,
            'poin' => $this->poin,
            'waktu' => $this->waktu,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'nim', $this->nim])
            ->andFilterWhere(['like', 'kode_kegiatan', $this->kode_kegiatan]);

        return $dataProvider;
    }
}
