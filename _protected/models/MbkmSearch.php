<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mbkm;

/**
 * MbkmSearch represents the model behind the search form of `app\models\Mbkm`.
 */
class MbkmSearch extends Mbkm
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'mbkm_jenis_id', 'level', 'apresiasi', 'status_sks', 'hasil_jenis', 'rekognisi_id', 'kategori_pembinaan_id', 'kategori_belmawa_id'], 'integer'],
            [['nim', 'nama_program', 'tempat_pelaksanaan', 'tanggal_mulai', 'tanggal_selesai', 'penyelenggara', 'sk_penerimaan_path', 'surat_tugas_path', 'rekomendasi_path', 'khs_pt_path', 'sertifikat_path', 'laporan_path', 'hasil_path', 'url_berita', 'foto_penyerahan_path', 'foto_kegiatan_path', 'foto_karya_path', 'created_at', 'updated_at'], 'safe'],
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
        $query = Mbkm::find();

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
            'mbkm_jenis_id' => $this->mbkm_jenis_id,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'level' => $this->level,
            'apresiasi' => $this->apresiasi,
            'status_sks' => $this->status_sks,
            'hasil_jenis' => $this->hasil_jenis,
            'rekognisi_id' => $this->rekognisi_id,
            'kategori_pembinaan_id' => $this->kategori_pembinaan_id,
            'kategori_belmawa_id' => $this->kategori_belmawa_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nim', $this->nim])
            ->andFilterWhere(['like', 'nama_program', $this->nama_program])
            ->andFilterWhere(['like', 'tempat_pelaksanaan', $this->tempat_pelaksanaan])
            ->andFilterWhere(['like', 'penyelenggara', $this->penyelenggara])
            ->andFilterWhere(['like', 'sk_penerimaan_path', $this->sk_penerimaan_path])
            ->andFilterWhere(['like', 'surat_tugas_path', $this->surat_tugas_path])
            ->andFilterWhere(['like', 'rekomendasi_path', $this->rekomendasi_path])
            ->andFilterWhere(['like', 'khs_pt_path', $this->khs_pt_path])
            ->andFilterWhere(['like', 'sertifikat_path', $this->sertifikat_path])
            ->andFilterWhere(['like', 'laporan_path', $this->laporan_path])
            ->andFilterWhere(['like', 'hasil_path', $this->hasil_path])
            ->andFilterWhere(['like', 'url_berita', $this->url_berita])
            ->andFilterWhere(['like', 'foto_penyerahan_path', $this->foto_penyerahan_path])
            ->andFilterWhere(['like', 'foto_kegiatan_path', $this->foto_kegiatan_path])
            ->andFilterWhere(['like', 'foto_karya_path', $this->foto_karya_path]);

        return $dataProvider;
    }
}
