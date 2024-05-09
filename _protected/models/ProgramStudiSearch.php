<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ProgramStudi;

/**
 * ProgramStudiSearch represents the model behind the search form of `app\models\ProgramStudi`.
 */
class ProgramStudiSearch extends ProgramStudi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kode_nim'], 'integer'],
            [['kode_fakultas', 'kode_jurusan', 'kode_prodi', 'kode_prodi_dikti', 'kode_jenjang_studi', 'gelar_lulusan', 'gelar_lulusan_en', 'gelar_lulusan_short', 'nama_prodi', 'nama_prodi_en', 'domain_email', 'semester_awal', 'no_sk_dikti', 'tgl_sk_dikti', 'tgl_akhir_sk_dikti', 'jml_sks_lulus', 'kode_status', 'tahun_semester_mulai', 'email_prodi', 'tgl_pendirian_program_studi', 'no_sk_akreditasi', 'tgl_sk_akreditasi', 'tgl_akhir_sk_akreditasi', 'kode_status_akreditasi', 'frekuensi_kurikulum', 'pelaksanaan_kurikulum', 'nidn_ketua_prodi', 'telp_ketua_prodi', 'fax_prodi', 'nama_operator', 'hp_operator', 'telepon_program_studi', 'singkatan', 'kode_feeder'], 'safe'],
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
        $query = ProgramStudi::find();

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
            'tgl_sk_dikti' => $this->tgl_sk_dikti,
            'tgl_akhir_sk_dikti' => $this->tgl_akhir_sk_dikti,
            'tgl_pendirian_program_studi' => $this->tgl_pendirian_program_studi,
            'tgl_sk_akreditasi' => $this->tgl_sk_akreditasi,
            'tgl_akhir_sk_akreditasi' => $this->tgl_akhir_sk_akreditasi,
            'kode_nim' => $this->kode_nim,
        ]);

        $query->andFilterWhere(['like', 'kode_fakultas', $this->kode_fakultas])
            ->andFilterWhere(['like', 'kode_jurusan', $this->kode_jurusan])
            ->andFilterWhere(['like', 'kode_prodi', $this->kode_prodi])
            ->andFilterWhere(['like', 'kode_prodi_dikti', $this->kode_prodi_dikti])
            ->andFilterWhere(['like', 'kode_jenjang_studi', $this->kode_jenjang_studi])
            ->andFilterWhere(['like', 'gelar_lulusan', $this->gelar_lulusan])
            ->andFilterWhere(['like', 'gelar_lulusan_en', $this->gelar_lulusan_en])
            ->andFilterWhere(['like', 'gelar_lulusan_short', $this->gelar_lulusan_short])
            ->andFilterWhere(['like', 'nama_prodi', $this->nama_prodi])
            ->andFilterWhere(['like', 'nama_prodi_en', $this->nama_prodi_en])
            ->andFilterWhere(['like', 'domain_email', $this->domain_email])
            ->andFilterWhere(['like', 'semester_awal', $this->semester_awal])
            ->andFilterWhere(['like', 'no_sk_dikti', $this->no_sk_dikti])
            ->andFilterWhere(['like', 'jml_sks_lulus', $this->jml_sks_lulus])
            ->andFilterWhere(['like', 'kode_status', $this->kode_status])
            ->andFilterWhere(['like', 'tahun_semester_mulai', $this->tahun_semester_mulai])
            ->andFilterWhere(['like', 'email_prodi', $this->email_prodi])
            ->andFilterWhere(['like', 'no_sk_akreditasi', $this->no_sk_akreditasi])
            ->andFilterWhere(['like', 'kode_status_akreditasi', $this->kode_status_akreditasi])
            ->andFilterWhere(['like', 'frekuensi_kurikulum', $this->frekuensi_kurikulum])
            ->andFilterWhere(['like', 'pelaksanaan_kurikulum', $this->pelaksanaan_kurikulum])
            ->andFilterWhere(['like', 'nidn_ketua_prodi', $this->nidn_ketua_prodi])
            ->andFilterWhere(['like', 'telp_ketua_prodi', $this->telp_ketua_prodi])
            ->andFilterWhere(['like', 'fax_prodi', $this->fax_prodi])
            ->andFilterWhere(['like', 'nama_operator', $this->nama_operator])
            ->andFilterWhere(['like', 'hp_operator', $this->hp_operator])
            ->andFilterWhere(['like', 'telepon_program_studi', $this->telepon_program_studi])
            ->andFilterWhere(['like', 'singkatan', $this->singkatan])
            ->andFilterWhere(['like', 'kode_feeder', $this->kode_feeder]);

        return $dataProvider;
    }
}
