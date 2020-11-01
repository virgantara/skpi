<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pelanggaran;

/**
 * PelanggaranSearch represents the model behind the search form of `app\models\Pelanggaran`.
 */
class PelanggaranSearch extends Pelanggaran
{
    public $namaKategori;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kategori_id'], 'integer'],
            [['nama', 'created_at', 'updated_at', 'namaKategori','kode'], 'safe'],
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
        $query = Pelanggaran::find();
        $query->joinWith(['kategori as k']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['namaKategori'] = [
            'asc' => ['k.nama'=>SORT_ASC],
            'desc' => ['k.nama'=>SORT_DESC]
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'kategori_id' => $this->kategori_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', self::tableName().'.kode', $this->kode]);
        $query->andFilterWhere(['like', self::tableName().'.nama', $this->nama]);
        $query->andFilterWhere(['like', 'k.nama', $this->namaKategori]);

        return $dataProvider;
    }
}
