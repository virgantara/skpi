<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakMastermahasiswa;

/**
 * MahasiswaSearch represents the model behind the search form of `app\models\SimakMastermahasiswa`.
 */
class MahasiswaSearch extends SimakMastermahasiswa
{   
    public $namaProdi;
    public $namaFakultas;
    public $namaKampus;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_bayar', 'status_mahasiswa', 'is_synced', 'is_eligible', 'kamar_id'], 'integer'],
            [['kode_pt', 'kode_fakultas', 'kode_prodi', 'kode_jenjang_studi', 'nim_mhs', 'nama_mahasiswa', 'tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'tahun_masuk', 'semester_awal', 'batas_studi', 'asal_propinsi', 'tgl_masuk', 'tgl_lulus', 'status_aktivitas', 'status_awal', 'jml_sks_diakui', 'nim_asal', 'asal_pt', 'nama_asal_pt', 'asal_jenjang_studi', 'asal_prodi', 'kode_biaya_studi', 'kode_pekerjaan', 'tempat_kerja', 'kode_pt_kerja', 'kode_ps_kerja', 'nip_promotor', 'nip_co_promotor1', 'nip_co_promotor2', 'nip_co_promotor3', 'nip_co_promotor4', 'photo_mahasiswa', 'semester', 'keterangan', 'telepon', 'hp', 'email', 'alamat', 'berat', 'tinggi', 'ktp', 'rt', 'rw', 'dusun', 'kode_pos', 'desa', 'kecamatan', 'kecamatan_feeder', 'jenis_tinggal', 'penerima_kps', 'no_kps', 'provinsi', 'kabupaten', 'status_warga', 'warga_negara', 'warga_negara_feeder', 'status_sipil', 'agama', 'gol_darah', 'masuk_kelas', 'tgl_sk_yudisium', 'no_ijazah', 'kampus', 'jur_thn_smta', 'kode_pd', 'va_code', 'created_at', 'updated_at', 'namaProdi', 'namaFakultas', 'namaKampus','dapur_id','rfid','tahun_masuk'], 'safe'],
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
    public function search($params, $status_aktif = null, $tahun_now = null)
    {
        $query = SimakMastermahasiswa::find();
        $query->alias('t');
        $query->joinWith(['kampus0 as k','kodeProdi as p']);

        // $query->joinWith(['simak_users u']);
        // $query->joinWith(['SimakKegiatanMahasiswas']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'status_aktivitas' => SORT_ASC,
                    'kampus' => SORT_ASC,
                    'nama_mahasiswa' => SORT_ASC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (Yii::$app->user->identity->access_role == ('theCreator')) {
            $query->andFilterWhere(['status_hapus' => $this->status_hapus]);
        } else {
            $query->andWhere(['status_hapus' => 0]);
        }

        if (Yii::$app->user->identity->access_role == 'Mahasiswa') {
            $query->andWhere(['nim_mhs' => Yii::$app->user->identity->nim]);
        }

        // grid filtering conditions

        if (!empty($this->kode_prodi)) {
            $query->andWhere(['t.kode_prodi' => $this->kode_prodi]);
        }


        if (!empty($this->kampus)) {
            $query->andWhere(['kampus' => $this->kampus]);
        }

        if (!empty($status_aktif)) {

            $query->andWhere(['status_aktivitas' => $status_aktif]);
        }

        if (!empty($this->tahun_lulus_keluar)) {
            $min_year = min($this->tahun_lulus_keluar);
            $max_year = max($this->tahun_lulus_keluar);

            $sd = $min_year . '-01-01';
            $ed = $max_year . '-12-31';
            $query->andWhere(['between', 'tgl_sk_yudisium', $sd, $ed]);
        }

        $query->andFilterWhere(['nip_promotor' => $this->nip_promotor])
            ->andFilterWhere(['status_aktivitas' => $this->status_aktivitas])
            ->andFilterWhere(['status_warga' => $this->status_warga])
            ->andFilterWhere(['tahun_masuk' => $this->tahun_masuk])

            ->andFilterWhere(['apakah_4_tahun' => $this->apakah_4_tahun]);

        $query->andFilterWhere(['like', 'kode_fakultas', $this->kode_fakultas])
            ->andFilterWhere(['like', 'nim_mhs', $this->nim_mhs])
            ->andFilterWhere(['like', 'nisn', $this->nisn])
            ->andFilterWhere(['like', 'keterangan_lulus_keluar', $this->keterangan_lulus_keluar])
            ->andFilterWhere(['like', 'nama_mahasiswa', $this->nama_mahasiswa])
            ->andFilterWhere(['like', 'tempat_lahir', $this->tempat_lahir])
            ->andFilterWhere(['like', 'jenis_kelamin', $this->jenis_kelamin])

            ->andFilterWhere(['like', 'semester', $this->semester])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'telepon', $this->telepon])
            ->andFilterWhere(['like', 'hp', $this->hp])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'ktp', $this->ktp])
            ->andFilterWhere(['like', 'kk', $this->kk])
            ->andFilterWhere(['like', 'kecamatan', $this->kecamatan])
            ->andFilterWhere(['like', 'kecamatan_feeder', $this->kecamatan_feeder])
            ->andFilterWhere(['like', 'jenis_tinggal', $this->jenis_tinggal])
            ->andFilterWhere(['like', 'provinsi', $this->provinsi])
            ->andFilterWhere(['like', 'kabupaten', $this->kabupaten])
            ->andFilterWhere(['like', 'warga_negara', $this->warga_negara])
            ->andFilterWhere(['like', 'warga_negara_feeder', $this->warga_negara_feeder])
            ->andFilterWhere(['like', 'status_sipil', $this->status_sipil])

            ->andFilterWhere(['like', 'va_code', $this->va_code]);

        if(Yii::$app->user->identity->access_role == 'Mahasiswa'){
            $query->andWhere(['nim_mhs' => Yii::$app->user->identity->nim]);
        }

        else if(Yii::$app->user->identity->access_role == 'sekretearis'){
            $query->andWhere(['t.kode_prodi' => Yii::$app->user->identity->prodi]);   
        }

        else if(Yii::$app->user->identity->access_role == 'fakultas'){
            $query->andWhere(['p.kode_fakultas' => Yii::$app->user->identity->fakultas]);   
        }

        return $dataProvider;
    }
}
