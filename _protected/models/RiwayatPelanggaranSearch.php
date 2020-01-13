<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RiwayatPelanggaran;

/**
 * RiwayatPelanggaranSearch represents the model behind the search form of `app\models\RiwayatPelanggaran`.
 */
class RiwayatPelanggaranSearch extends RiwayatPelanggaran
{


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pelanggaran_id', 'tahun_id'], 'integer'],
            [['tanggal', 'nim', 'created_at', 'updated_at'], 'safe'],
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
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'pelanggaran_id' => $this->pelanggaran_id,
            'tanggal' => $this->tanggal,
            'tahun_id' => $this->tahun_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nim', $this->nim]);

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
