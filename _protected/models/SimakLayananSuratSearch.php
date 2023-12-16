<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakLayananSurat;

/**
 * SimakLayananSuratSearch represents the model behind the search form of `app\models\SimakLayananSurat`.
 */
class SimakLayananSuratSearch extends SimakLayananSurat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nim', 'keperluan', 'bahasa', 'tanggal_diajukan', 'tanggal_disetujui', 'nomor_surat', 'nama_pejabat', 'status_ajuan', 'updated_at', 'created_at','namaMahasiswa','namaProdi','namaKampus'], 'safe'],
            [['tahun_id'], 'integer'],
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
        $query = SimakLayananSurat::find();
        $query->alias('t');
        $query->joinWith(['nim0 as m','nim0.kodeProdi as p','nim0.kampus0 as k']);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'status_ajuan' => SORT_ASC,
                    'tanggal_diajukan' => SORT_DESC,
                ]
            ]
        ]);

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

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->where(['jenis_surat' => $this->jenis_surat]);

        // grid filtering conditions
        $query->andFilterWhere([
            'tahun_id' => $this->tahun_id,
            'p.kode_prodi' => $this->namaProdi,
            'k.kode_kampus' => $this->namaKampus,
            'tanggal_diajukan' => $this->tanggal_diajukan,
            'tanggal_disetujui' => $this->tanggal_disetujui,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'nim', $this->nim])
            ->andFilterWhere(['like', 'm.nama_mahasiswa', $this->namaMahasiswa])
            ->andFilterWhere(['like', 'keperluan', $this->keperluan])
            ->andFilterWhere(['like', 'bahasa', $this->bahasa])
            ->andFilterWhere(['like', 'nomor_surat', $this->nomor_surat])
            ->andFilterWhere(['like', 'nama_pejabat', $this->nama_pejabat])
            ->andFilterWhere(['like', 'status_ajuan', $this->status_ajuan]);

        if(Yii::$app->user->identity->access_role == 'Mahasiswa'){
            $query->andWhere(['nim' => Yii::$app->user->identity->nim]);   
        }

        else if(Yii::$app->user->identity->access_role == 'sekretearis'){
            $query->andWhere(['m.kode_prodi' => Yii::$app->user->identity->prodi]);   
        }

        return $dataProvider;
    }
}
