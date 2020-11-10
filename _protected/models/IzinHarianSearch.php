<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\IzinHarian;

/**
 * IzinHarianSearch represents the model behind the search form of `app\models\IzinHarian`.
 */
class IzinHarianSearch extends IzinHarian
{
    public $namaMahasiswa;
    public $namaProdi;
    public $namaAsrama;
    public $namaKamar;
    public $semester;
    public $statusIzin;
    public $namaKota;
    public $namaNegara;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status_izin'], 'integer'],
            [['nim', 'waktu_keluar','waktu_masuk', 'created_at', 'updated_at','namaMahasiswa','namaProdi','semester','namaKota','namaKeperluan','namaFakultas','namaAsrama','namaKamar','statusIzin','approved','baak_approved','prodi_approved','namaNegara'], 'safe'],
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
        $query = IzinHarian::find();

        $query->joinWith([
            'nim0 as mhs',
            'nim0.kodeProdi as p',
            'nim0.kamar as kk',
            'nim0.kamar.asrama as a',
        ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
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

        $dataProvider->sort->attributes['namaAsrama'] = [
            'asc' => ['a.nama'=>SORT_ASC],
            'desc' => ['a.nama'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaKamar'] = [
            'asc' => ['kk.nama'=>SORT_ASC],
            'desc' => ['kk.nama'=>SORT_DESC]
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['a.id'=> $this->namaAsrama]);
        $query->andFilterWhere(['p.kode_prodi'=>$this->namaProdi]);
        $query->andFilterWhere(['mhs.semester' => $this->semester]);
        $query->andFilterWhere(['like', 'mhs.nama_mahasiswa', $this->namaMahasiswa]);

        // grid filtering conditions
        $query->andFilterWhere([
            'waktu_keluar' => $this->waktu_keluar,
            'status_izin' => $this->status_izin,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nim', $this->nim]);

        return $dataProvider;
    }
}
