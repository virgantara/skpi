<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimkatmawaMandiri;

/**
 * SimkatmawaMandiriSearch represents the model behind the search form of `app\models\SimkatmawaMandiri`.
 */
class SimkatmawaMandiriSearch extends SimkatmawaMandiri
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'simkatmawa_rekognisi_id', 'level', 'apresiasi'], 'integer'],
            [['jenis_simkatmawa', 'nama_kegiatan', 'penyelenggara', 'tempat_pelaksanaan', 'url_kegiatan', 'tanggal_mulai', 'tanggal_selesai', 'sertifikat_path', 'foto_penyerahan_path', 'foto_kegiatan_path', 'foto_karya_path', 'surat_tugas_path', 'laporan_path', 'created_at', 'updated_at'], 'safe'],
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
    public function search($params, $jenisSimkatmawa)
    {
        $query = SimkatmawaMandiri::find();

        // add conditions that should always apply here
        $query->andWhere(['jenis_simkatmawa' => $jenisSimkatmawa]);

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
            'simkatmawa_rekognisi_id' => $this->simkatmawa_rekognisi_id,
            'level' => $this->level,
            'apresiasi' => $this->apresiasi,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'jenis_simkatmawa', $this->jenis_simkatmawa])
            ->andFilterWhere(['like', 'nama_kegiatan', $this->nama_kegiatan])
            ->andFilterWhere(['like', 'penyelenggara', $this->penyelenggara])
            ->andFilterWhere(['like', 'tempat_pelaksanaan', $this->tempat_pelaksanaan])
            ->andFilterWhere(['like', 'url_kegiatan', $this->url_kegiatan])
            ->andFilterWhere(['like', 'sertifikat_path', $this->sertifikat_path])
            ->andFilterWhere(['like', 'foto_penyerahan_path', $this->foto_penyerahan_path])
            ->andFilterWhere(['like', 'foto_kegiatan_path', $this->foto_kegiatan_path])
            ->andFilterWhere(['like', 'foto_karya_path', $this->foto_karya_path])
            ->andFilterWhere(['like', 'surat_tugas_path', $this->surat_tugas_path])
            ->andFilterWhere(['like', 'laporan_path', $this->laporan_path]);

        return $dataProvider;
    }
}
