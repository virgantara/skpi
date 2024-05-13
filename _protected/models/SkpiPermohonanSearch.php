<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SkpiPermohonan;

/**
 * SkpiPermohonanSearch represents the model behind the search form of `app\models\SkpiPermohonan`.
 */
class SkpiPermohonanSearch extends SkpiPermohonan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nim', 'nomor_skpi', 'link_barcode', 'status_pengajuan', 'tanggal_pengajuan', 'updated_at', 'created_at','namaMahasiswa','namaProdi','namaKampus','kode_prodi'], 'safe'],
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
        $query = SkpiPermohonan::find();
        $query->alias('t');
        $query->joinWith(['nim0 as m','nim0.kodeProdi as p','nim0.kampus0 as k']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'tanggal_pengajuan' => SORT_ASC,
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

        $query->andFilterWhere([
            'p.kode_prodi' => $this->namaProdi,
            'k.kode_kampus' => $this->namaKampus,
            'tanggal_pengajuan' => $this->tanggal_pengajuan,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);


        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'nim', $this->nim])
            ->andFilterWhere(['like', 'm.nama_mahasiswa', $this->namaMahasiswa])
            ->andFilterWhere(['like', 'nomor_skpi', $this->nomor_skpi])
            ->andFilterWhere(['like', 'link_barcode', $this->link_barcode])
            ->andFilterWhere(['like', 'status_pengajuan', $this->status_pengajuan]);

        if (!empty($this->kode_prodi)) {
            $query->andWhere(['p.kode_prodi' => $this->kode_prodi]);
        }

        if(Yii::$app->user->identity->access_role == 'Mahasiswa'){
            $query->andWhere(['nim' => Yii::$app->user->identity->nim]);   
        }

        else if(Yii::$app->user->identity->access_role == 'sekretearis'){
            $query->andWhere(['m.kode_prodi' => Yii::$app->user->identity->prodi]);   
        }

        else if(Yii::$app->user->identity->access_role == 'fakultas'){
            $query->andWhere(['p.kode_fakultas' => Yii::$app->user->identity->fakultas]);   
        }



        return $dataProvider;
    }
}
