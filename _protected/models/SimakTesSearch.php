<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakTes;

/**
 * SimakTesSearch represents the model behind the search form of `app\models\SimakTes`.
 */
class SimakTesSearch extends SimakTes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nim', 'jenis_tes', 'nama_tes', 'penyelenggara', 'tanggal_tes', 'file_path', 'status_validasi', 'catatan', 'updated_at', 'created_at','namaMahasiswa','namaKampus','namaProdi','namaKegiatan','namaJenisKegiatan','status_aktivitas','tahun_masuk'], 'safe'],
            [['tahun', 'approved_by'], 'integer'],
            [['skor_tes'], 'number'],
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
        $query = SimakTes::find();
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
            'jenis_tes' => $this->jenis_tes,
            'tahun' => $this->tahun,
            'skor_tes' => $this->skor_tes,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'status_validasi' => $this->status_validasi
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'nim', $this->nim])

            ->andFilterWhere(['like', 'nama_tes', $this->nama_tes])
            ->andFilterWhere(['like', 'penyelenggara', $this->penyelenggara])
            ->andFilterWhere(['like', 'tanggal_tes', $this->tanggal_tes])
            ->andFilterWhere(['like', 'file_path', $this->file_path]);

        if(Yii::$app->user->identity->access_role == 'Mahasiswa'){
            $query->andWhere(['nim' => Yii::$app->user->identity->nim]);
        }

        else if(Yii::$app->user->identity->access_role == 'sekretearis'){
            $query->andWhere(['mhs.kode_prodi' => Yii::$app->user->identity->prodi]);   
        }

        else if(Yii::$app->user->identity->access_role == 'fakultas'){
            $query->andWhere(['p.kode_fakultas' => Yii::$app->user->identity->fakultas]);   
        }


        return $dataProvider;
    }
}
