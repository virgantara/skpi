<?php

namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RiwayatPelanggaran;

/**
 * RiwayatPelanggaranSearch represents the model behind the search form of `app\models\RiwayatPelanggaran`.
 */
class RiwayatPelanggaranSearch extends RiwayatPelanggaran
{

    public $namaMahasiswa;
    public $namaProdi;
    public $namaFakultas;
    public $namaPelanggaran;
    public $kodePelanggaran;
    public $namaKategori;
    public $namaAsrama;
    public $namaKamar;
    public $semester;
    public $statusAktif;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pelanggaran_id', 'tahun_id'], 'integer'],
            [['tanggal', 'nim', 'created_at', 'updated_at','namaMahasiswa','namaProdi','semester','namaPelanggaran','namaKategori','namaFakultas','namaAsrama','namaKamar','pelapor','statusAktif','kodePelanggaran','status_kasus'], 'safe'],
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
        $query = RiwayatPelanggaran::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['tanggal'=>SORT_DESC]]
        ]);

        $dataProvider->sort->attributes['namaMahasiswa'] = [
            'asc' => ['mhs.nama_mahasiswa'=>SORT_ASC],
            'desc' => ['mhs.nama_mahasiswa'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaProdi'] = [
            'asc' => ['p.nama_prodi'=>SORT_ASC],
            'desc' => ['p.nama_prodi'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['status_kasus'] = [
            'asc' => ['status_kasus'=>SORT_ASC],
            'desc' => ['status_kasus'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaFakultas'] = [
            'asc' => ['f.nama_fakultas'=>SORT_ASC],
            'desc' => ['f.nama_fakultas'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['semester'] = [
            'asc' => ['mhs.semester'=>SORT_ASC],
            'desc' => ['mhs.semester'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['statusAktif'] = [
            'asc' => ['mhs.status_aktivitas'=>SORT_ASC],
            'desc' => ['mhs.status_aktivitas'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaPelanggaran'] = [
            'asc' => ['pl.nama'=>SORT_ASC],
            'desc' => ['pl.nama'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['kodePelanggaran'] = [
            'asc' => ['pl.kode'=>SORT_ASC],
            'desc' => ['pl.kode'=>SORT_DESC]
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
            'pelanggaran as pl',
            'pelanggaran.kategori as k',
            'nim0.kodeProdi.kodeFakultas as f'
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $query->andFilterWhere(['like', 'nim', $this->nim]);
        $query->andFilterWhere(['like', 'mhs.nama_mahasiswa', $this->namaMahasiswa]);
       
        $query->andFilterWhere(['like', 'kk.nama', $this->namaKamar]);
        
        // $query->andFilterWhere(['like', 'f.nama_fakultas', $this->namaFakultas]);
        $query->andFilterWhere(['like', 'mhs.semester', $this->semester]);
        $query->andFilterWhere(['like', 'pl.nama', $this->namaPelanggaran]);
        $query->andFilterWhere(['like', 'pl.kode', $this->kodePelanggaran]);
        $query->andFilterWhere(['like', 'kk.nama', $this->namaKamar]);

        if(!empty($this->namaKategori))
        {
            $query->andWhere(['k.nama'=>$this->namaKategori]);
        }

        if(!empty($this->namaAsrama))
        {
            $query->andWhere(['a.id'=> $this->namaAsrama]);
        }

        $query->andFilterWhere(['status_kasus' => $this->status_kasus]);
        
        if(!empty($this->tanggal)){

            list($sd, $ed) = explode(' - ', $this->tanggal);
            $sd = $sd.' 00:00:01';
            $ed = $ed.' 23:59:59';
            // print_r($sd);exit;
            $query->andFilterWhere(['between','tanggal',$sd, $ed]);
            $this->tanggal = null;
        }

        if(!empty($this->namaProdi)){
            $query->andWhere(['p.kode_prodi'=>$this->namaProdi]);
        }

        if(!empty($this->namaFakultas)){
            $query->andWhere(['f.kode_fakultas'=>$this->namaFakultas]);
        }

        if(!empty($this->statusAktif)){
            $query->andWhere(['mhs.status_aktivitas'=>$this->statusAktif]);
        }

        if(Yii::$app->user->identity->access_role == 'operatorCabang')
        {
            $query->andWhere(['mhs.kampus'=>Yii::$app->user->identity->kampus]);    
        }

        return $dataProvider;
    }

    public static function getRekapPelanggaran()
    {   
        $query=new \yii\db\Query(); 

        $rows=$query->select(['kp.nama','count(*) as total']) //specify required columns in an array
         ->from('erp_kategori_pelanggaran kp') 
         ->innerJoin('erp_pelanggaran as p','p.kategori_id = kp.id')
         ->innerJoin('erp_riwayat_pelanggaran as rp','rp.pelanggaran_id = p.id')
         ->groupBy('kp.nama')
         ->all(); //returns an
        return $rows;
    }

    
}
