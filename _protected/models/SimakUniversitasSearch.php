<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakUniversitas;

/**
 * SimakUniversitasSearch represents the model behind the search form of `app\models\SimakUniversitas`.
 */
class SimakUniversitasSearch extends SimakUniversitas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'rektor'], 'integer'],
            [['alamat', 'telepon', 'fax', 'website', 'email', 'sk_rektor', 'tgl_sk_rektor', 'periode', 'status_aktif', 'catatan_resmi', 'catatan_resmi_en', 'deskripsi_skpi', 'deskripsi_skpi_en', 'nama_institusi', 'nama_institusi_en', 'sk_pendirian', 'tanggal_sk_pendirian', 'peringkat_akreditasi', 'nomor_sertifikat_akreditasi', 'lembaga_akreditasi', 'persyaratan_penerimaan', 'persyaratan_penerimaan_en', 'sistem_penilaian', 'sistem_penilaian_en'], 'safe'],
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
        $query = SimakUniversitas::find();

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
            'rektor' => $this->rektor,
            'tgl_sk_rektor' => $this->tgl_sk_rektor,
            'tanggal_sk_pendirian' => $this->tanggal_sk_pendirian,
        ]);

        $query->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'telepon', $this->telepon])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'sk_rektor', $this->sk_rektor])
            ->andFilterWhere(['like', 'periode', $this->periode])
            ->andFilterWhere(['like', 'status_aktif', $this->status_aktif])
            ->andFilterWhere(['like', 'catatan_resmi', $this->catatan_resmi])
            ->andFilterWhere(['like', 'catatan_resmi_en', $this->catatan_resmi_en])
            ->andFilterWhere(['like', 'deskripsi_skpi', $this->deskripsi_skpi])
            ->andFilterWhere(['like', 'deskripsi_skpi_en', $this->deskripsi_skpi_en])
            ->andFilterWhere(['like', 'nama_institusi', $this->nama_institusi])
            ->andFilterWhere(['like', 'nama_institusi_en', $this->nama_institusi_en])
            ->andFilterWhere(['like', 'sk_pendirian', $this->sk_pendirian])
            ->andFilterWhere(['like', 'peringkat_akreditasi', $this->peringkat_akreditasi])
            ->andFilterWhere(['like', 'nomor_sertifikat_akreditasi', $this->nomor_sertifikat_akreditasi])
            ->andFilterWhere(['like', 'lembaga_akreditasi', $this->lembaga_akreditasi])
            ->andFilterWhere(['like', 'persyaratan_penerimaan', $this->persyaratan_penerimaan])
            ->andFilterWhere(['like', 'persyaratan_penerimaan_en', $this->persyaratan_penerimaan_en])
            ->andFilterWhere(['like', 'sistem_penilaian', $this->sistem_penilaian])
            ->andFilterWhere(['like', 'sistem_penilaian_en', $this->sistem_penilaian_en]);

        return $dataProvider;
    }
}
