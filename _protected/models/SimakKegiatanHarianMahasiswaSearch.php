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
    public $namaMahasiswa;
    public $namaProdi;
    public $semester;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nim', 'kode_kegiatan', 'waktu','namaMahasiswa','namaProdi','semester'], 'safe'],
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
    public function search($params,$today="yes")
    {
        $query = SimakKegiatanHarianMahasiswa::find();
        $query->alias('t');
        $query->joinWith([
            'nim0 as mhs',
            'nim0.kodeProdi as p',

        ]);

        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['namaMahasiswa'] = [
            'asc' => ['mhs.nama_mahasiswa'=>SORT_ASC],
            'desc' => ['mhs.nama_mahasiswa'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaProdi'] = [
            'asc' => ['p.nama_prodi'=>SORT_ASC],
            'desc' => ['p.nama_prodi'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['semester'] = [
            'asc' => ['mhs.semester'=>SORT_ASC],
            'desc' => ['mhs.semester'=>SORT_DESC]
        ];

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
        $query->andFilterWhere(['like', 'nim', $this->nim]);
        $query->andFilterWhere(['like', 'mhs.nama_mahasiswa', $this->namaMahasiswa]);
        $query->andFilterWhere(['like', 'mhs.semester', $this->semester]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'nim', $this->nim])
            ->andFilterWhere(['like', 'kode_kegiatan', $this->kode_kegiatan]);

        if($today=='yes'){
            $sd = date('Y-m-d 00:00:00');
            $ed = date('Y-m-d 23:59:59');
            $query->andWhere(['BETWEEN','t.created_at',$sd, $ed]);
        }

        return $dataProvider;
    }
}
