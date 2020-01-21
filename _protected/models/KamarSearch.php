<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kamar;

/**
 * KamarSearch represents the model behind the search form of `app\models\Kamar`.
 */
class KamarSearch extends Kamar
{
    public $namaAsrama;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'asrama_id', 'kapasitas'], 'integer'],
            [['nama', 'created_at', 'updated_at','namaAsrama'], 'safe'],
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
        $query = Kamar::find();
        $query->joinWith(['asrama as a']);

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

        $dataProvider->sort->attributes['namaAsrama'] = [
            'asc' => ['a.nama'=>SORT_ASC],
            'desc' => ['a.nama'=>SORT_DESC]
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'asrama_id' => $this->asrama_id,
            'kapasitas' => $this->kapasitas,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama]);
        $query->andFilterWhere(['like', 'a.nama', $this->namaAsrama]);

        return $dataProvider;
    }

    public static function searchByNama($nama)
    {
        $query = Kamar::find();
        $query->joinWith(['asrama as a']);
        $query->andFilterWhere(['like', 'nama', $nama]);
        $query->andFilterWhere(['like', 'a.nama', $nama]);

        return $query->all();
    }
}
