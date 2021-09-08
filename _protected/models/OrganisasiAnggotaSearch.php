<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OrganisasiAnggota;

/**
 * OrganisasiAnggotaSearch represents the model behind the search form of `app\models\OrganisasiAnggota`.
 */
class OrganisasiAnggotaSearch extends OrganisasiAnggota
{

    public $namaProdi;
    public $namaFakultas;
    public $namaKampus;
    public $namaMahasiswa;

    public $tahun_akademik;
    public $kampus;
    public $tahun_masuk;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'organisasi_id', 'jabatan_id'], 'integer'],
            [['nim', 'peran', 'created_at', 'updated_at','namaProdi', 'namaFakultas', 'namaKampus','namaMahasiswa'], 'safe'],
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
        $query = OrganisasiAnggota::find();
        $query->alias('t');
        $query->joinWith([
            'organisasi as org',
            'nim0 as m',
            'nim0.kodeProdi as p',
            'nim0.kampus0 as k',
            
        ]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['namaProdi'] = [
            'asc' => ['p.nama_prodi'=>SORT_ASC],
            'desc' => ['p.nama_prodi'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaMahasiswa'] = [
            'asc' => ['m.nama_mahasiswa'=>SORT_ASC],
            'desc' => ['m.nama_mahasiswa'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaKampus'] = [
            'asc' => ['k.nama_kampus'=>SORT_ASC],
            'desc' => ['k.nama_kampus'=>SORT_DESC]
        ];

        

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if(!empty($this->tahun_akademik))
        {
            $query->andWhere([
                'org.tahun_akademik' => $this->tahun_akademik,
            ]);
        }

        if(!empty($this->kampus))
        {
            $query->andWhere([
                'org.kampus' => $this->kampus,
            ]);
        }

        if(!empty($this->tahun_masuk))
        {
            $query->andWhere([
                'm.tahun_masuk' => $this->tahun_masuk,
            ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            't.organisasi_id' => $this->organisasi_id,
            'jabatan_id' => $this->jabatan_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nim', $this->nim])
            ->andFilterWhere(['like', 'peran', $this->peran])
            ->andFilterWhere(['like', 'm.nama_mahasiswa', $this->namaMahasiswa])
            ->andFilterWhere(['like', 'k.nama_kampus', $this->namaKampus])
            ->andFilterWhere(['like', 'p.nama_prodi', $this->namaProdi]);

        return $dataProvider;
    }
}
