<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakKegiatanMahasiswa;

/**
 * SimakKegiatanMahasiswaSearch represents the model behind the search form of `app\models\SimakKegiatanMahasiswa`.
 */
class SimakKegiatanMahasiswaSearch extends SimakKegiatanMahasiswa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_jenis_kegiatan', 'id_kegiatan', 'nilai', 'is_approved'], 'integer'],
            [['nim', 'event_id', 'waktu', 'keterangan', 'tema', 'instansi', 'bagian', 'bidang', 'nama_kegiatan_mahasiswa', 'tahun_akademik', 'semester', 'tahun', 'penilai', 'file', 'file_path', 's3_path', 'uuid', 'created_at', 'updated_at','namaMahasiswa','namaProdi','namaKampus','kode_prodi'], 'safe'],
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
        $query = SimakKegiatanMahasiswa::find();
        $query->alias('t');
        $query->joinWith(['kegiatan as keg','nim0 as m','nim0.kodeProdi as p','nim0.kampus0 as k']);
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
            'asc' => ['m.nama_mahasiswa'=>SORT_ASC],
            'desc' => ['m.nama_mahasiswa'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaProdi'] = [
            'asc' => ['p.nama_prodi'=>SORT_ASC],
            'desc' => ['p.nama_prodi'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaKampus'] = [
            'asc' => ['k.nama_kampus'=>SORT_ASC],
            'desc' => ['k.nama_kampus'=>SORT_DESC]
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'p.kode_prodi' => $this->namaProdi,
            'k.kode_kampus' => $this->namaKampus,
            'id' => $this->id,
            'id_jenis_kegiatan' => $this->id_jenis_kegiatan,
            'id_kegiatan' => $this->id_kegiatan,
            'nilai' => $this->nilai,
            'waktu' => $this->waktu,
            'is_approved' => $this->is_approved,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nim', $this->nim])
            ->andFilterWhere(['like', 'event_id', $this->event_id])
            ->andFilterWhere(['like', 'm.nama_mahasiswa', $this->namaMahasiswa])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'tema', $this->tema])
            ->andFilterWhere(['like', 'instansi', $this->instansi])
            ->andFilterWhere(['like', 'bagian', $this->bagian])
            ->andFilterWhere(['like', 'bidang', $this->bidang])
            ->andFilterWhere(['like', 'nama_kegiatan_mahasiswa', $this->nama_kegiatan_mahasiswa])
            ->andFilterWhere(['like', 'tahun_akademik', $this->tahun_akademik])
            ->andFilterWhere(['like', 'semester', $this->semester])
            ->andFilterWhere(['like', 'tahun', $this->tahun])
            ->andFilterWhere(['like', 'penilai', $this->penilai])
            ->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'file_path', $this->file_path])
            ->andFilterWhere(['like', 's3_path', $this->s3_path])
            ->andFilterWhere(['like', 'uuid', $this->uuid]);

        if(Yii::$app->user->identity->access_role == 'sekretearis'){

            $query->andWhere(['m.kode_prodi' => Yii::$app->user->identity->prodi]);
        }

        else if(Yii::$app->user->identity->access_role == 'fakultas'){
            $query->andWhere(['p.kode_fakultas' => Yii::$app->user->identity->fakultas]);
        }

        else if(Yii::$app->user->identity->access_role == 'Mahasiswa'){
            $query->andWhere(['t.nim' => Yii::$app->user->identity->nim]);
        }

        $query->andFilterWhere(['like', 'keg.nama_kegiatan', 'juara']);
        $query->andWhere(['keg.is_active' => 1]);

        return $dataProvider;
    }
}
