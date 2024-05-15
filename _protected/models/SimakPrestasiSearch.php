<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakPrestasi;

/**
 * SimakPrestasiSearch represents the model behind the search form of `app\models\SimakPrestasi`.
 */
class SimakPrestasiSearch extends SimakPrestasi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nim', 'status_validasi', 'updated_at', 'created_at','namaMahasiswa','namaProdi','namaKampus'], 'safe'],
            [['kegiatan_id', 'approved_by'], 'integer'],
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
        $query = SimakPrestasi::find();
        $query->alias('t');
        $query->joinWith(['nim0 as m','nim0.kodeProdi as p','nim0.kampus0 as k']);

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
            'kegiatan_id' => $this->kegiatan_id,
            'approved_by' => $this->approved_by,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'nim', $this->nim])
            ->andFilterWhere(['like', 'm.nama_mahasiswa', $this->namaMahasiswa])
            ->andFilterWhere(['like', 'status_validasi', $this->status_validasi]);

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
