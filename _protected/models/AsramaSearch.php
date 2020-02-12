<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Asrama;

/**
 * AsramaSearch represents the model behind the search form of `app\models\Asrama`.
 */
class AsramaSearch extends Asrama
{

    public $namaKampus;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nama', 'created_at', 'updated_at','namaKampus'], 'safe'],
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
        $query = Asrama::find();
        $query->joinWith(['kampus as k']);
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

        $dataProvider->sort->attributes['namaKampus'] = [
            'asc' => ['k.nama_kampus'=>SORT_ASC],
            'desc' => ['k.nama_kampus'=>SORT_DESC]
        ];

        $query->andFilterWhere(['like', 'nama', $this->nama]);
        $query->andFilterWhere(['like', 'k.nama_kampus', $this->namaKampus]);

        return $dataProvider;
    }
}
