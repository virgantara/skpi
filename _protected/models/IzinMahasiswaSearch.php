<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\IzinMahasiswa;

/**
 * IzinMahasiswaSearch represents the model behind the search form of `app\models\IzinMahasiswa`.
 */
class IzinMahasiswaSearch extends IzinMahasiswa
{
    public $namaMahasiswa;
    public $namaProdi;
    public $namaFakultas;
    public $namaPelanggaran;
    public $namaKeperluan;
    public $namaAsrama;
    public $namaKamar;
    public $semester;
    public $statusIzin;
    public $namaKota;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tahun_akademik', 'semester', 'keperluan_id', 'status'], 'integer'],
            [['nim', 'kota_id', 'alasan', 'tanggal_berangkat', 'tanggal_pulang', 'created_at', 'updated_at','namaMahasiswa','namaProdi','semester','namaKota','namaKeperluan','namaFakultas','namaAsrama','namaKamar','statusIzin','approved','baak_approved','prodi_approved'], 'safe'],
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
        $query = IzinMahasiswa::find();

        // add conditions that should always apply here

         $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
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

        $dataProvider->sort->attributes['namaProdi'] = [
            'asc' => ['p.nama_prodi'=>SORT_ASC],
            'desc' => ['p.nama_prodi'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaFakultas'] = [
            'asc' => ['f.nama_fakultas'=>SORT_ASC],
            'desc' => ['f.nama_fakultas'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaKota'] = [
            'asc' => ['k.kab'=>SORT_ASC],
            'desc' => ['k.kab'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['semester'] = [
            'asc' => ['mhs.semester'=>SORT_ASC],
            'desc' => ['mhs.semester'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['statusIzin'] = [
            'asc' => [self::tableName().'.status'=>SORT_ASC],
            'desc' => [self::tableName().'.status'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaKeperluan'] = [
            'asc' => [self::tableName().'.keperluan_id'=>SORT_ASC],
            'desc' => [self::tableName().'.keperluan_id'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaAsrama'] = [
            'asc' => ['a.nama'=>SORT_ASC],
            'desc' => ['a.nama'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaKamar'] = [
            'asc' => ['kk.nama'=>SORT_ASC],
            'desc' => ['kk.nama'=>SORT_DESC]
        ];

        $query->joinWith([
            'nim0 as mhs',
            'nim0.kodeProdi as p',
            'nim0.kamar as kk',
            'nim0.kamar.asrama as a',
            'nim0.kodeProdi.kodeFakultas as f',
            'kota as k'
        ]);

        $query->andFilterWhere(['like', 'nim', $this->nim]);
        $query->andFilterWhere(['like', 'mhs.nama_mahasiswa', $this->namaMahasiswa]);
        $query->andFilterWhere(['like', 'kk.nama', $this->namaKamar]);
        $query->andFilterWhere(['like', 'alasan', $this->alasan]);
        $query->andFilterWhere(['like', 'mhs.semester', $this->semester]);
        $query->andFilterWhere(['like', 'k.kab', $this->namaKota]);
        $query->andFilterWhere(['like', 'kk.nama', $this->namaKamar]);

        if(!empty($this->namaKeperluan))
        {
            $query->andWhere(['keperluan_id'=>$this->namaKeperluan]);
        }

        if(!empty($this->namaAsrama))
        {
            $query->andWhere(['a.id'=> $this->namaAsrama]);
        }
        
        if(!empty($this->tanggal_berangkat)){

            list($sd, $ed) = explode(' - ', $this->tanggal_berangkat);
            $query->andFilterWhere(['between','tanggal_berangkat',$sd, $ed]);
            $this->tanggal_berangkat = null;
        }

        if(!empty($this->tanggal_pulang)){

            list($sd, $ed) = explode(' - ', $this->tanggal_pulang);
            $query->andFilterWhere(['between','tanggal_pulang',$sd, $ed]);
            $this->tanggal_pulang = null;
        }

        if(!empty($this->namaProdi)){
            $query->andWhere(['p.kode_prodi'=>$this->namaProdi]);
        }

        if(!empty($this->namaFakultas)){
            $query->andWhere(['f.kode_fakultas'=>$this->namaFakultas]);
        }

        if(!empty($this->statusIzin)){
            $query->andWhere(['status'=>$this->statusIzin]);
        }

        if(!empty($this->approved))
            $query->andWhere(['approved'=>$this->approved]);

        if(!empty($this->baak_approved))
            $query->andWhere(['baak_approved'=>$this->baak_approved]);

        if(!empty($this->prodi_approved))
            $query->andWhere(['prodi_approved'=>$this->prodi_approved]);

        return $dataProvider;
    }
}
