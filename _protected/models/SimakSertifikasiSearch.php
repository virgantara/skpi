<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakSertifikasi;

/**
 * SimakSertifikasiSearch represents the model behind the search form of `app\models\SimakSertifikasi`.
 */
class SimakSertifikasiSearch extends SimakSertifikasi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nim', 'jenis_sertifikasi', 'lembaga_sertifikasi', 'nomor_registrasi_sertifikasi', 'tmt_sertifikasi', 'tst_sertifikasi', 'file_path', 'status_validasi', 'updated_at', 'created_at','nomor_sk_sertifikasi','namaMahasiswa','namaKampus','namaProdi','namaKegiatan','namaJenisKegiatan','status_aktivitas','tahun_masuk'], 'safe'],
            [['tahun_sertifikasi'], 'integer'],
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
        $query = SimakSertifikasi::find();
        $query->alias('t');
        $query->joinWith(['nim0 as mhs','nim0.kampus0 as k','nim0.kodeProdi as p']);
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

        $dataProvider->sort->attributes['namaMahasiswa'] = [
            'asc' => ['mhs.nama_mahasiswa'=>SORT_ASC],
            'desc' => ['mhs.nama_mahasiswa'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaKampus'] = [
            'asc' => ['k.nama_kampus'=>SORT_ASC],
            'desc' => ['k.nama_kampus'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaProdi'] = [
            'asc' => ['p.nama_prodi'=>SORT_ASC],
            'desc' => ['p.nama_prodi'=>SORT_DESC]
        ];

        // grid filtering conditions
        if(!empty($this->namaKampus))
        {
            $query->andWhere(['mhs.kampus'=>$this->namaKampus]);
        }

        if(!empty($this->namaProdi))
        {
            $query->andWhere(['mhs.kode_prodi'=>$this->namaProdi]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'tahun_sertifikasi' => $this->tahun_sertifikasi,
            'tmt_sertifikasi' => $this->tmt_sertifikasi,
            'tst_sertifikasi' => $this->tst_sertifikasi,
            'jenis_sertifikasi' => $this->jenis_sertifikasi,
            'status_validasi' => $this->status_validasi,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);



        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'nim', $this->nim])
            ->andFilterWhere(['like', 'mhs.nama_mahasiswa', $this->namaMahasiswa])
            ->andFilterWhere(['like', 'lembaga_sertifikasi', $this->lembaga_sertifikasi])
            ->andFilterWhere(['like', 'nomor_registrasi_sertifikasi', $this->nomor_registrasi_sertifikasi])
            ->andFilterWhere(['like', 'nomor_sk_sertifikasi', $this->nomor_sk_sertifikasi])
            ->andFilterWhere(['like', 'file_path', $this->file_path]);

        if(Yii::$app->user->identity->access_role == 'Mahasiswa'){
            $query->andWhere(['nim' => Yii::$app->user->identity->nim]);
        }

        return $dataProvider;
    }
}
