<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Countries;

/**
 * CountriesSearch represents the model behind the search form of `app\models\Countries`.
 */
class CountriesSearch extends Countries
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'flag'], 'integer'],
            [['name', 'iso3', 'iso2', 'phonecode', 'capital', 'currency', 'native', 'emoji', 'emojiU', 'created_at', 'updated_at', 'wikiDataId'], 'safe'],
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
        $query = Countries::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'flag' => $this->flag,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'iso3', $this->iso3])
            ->andFilterWhere(['like', 'iso2', $this->iso2])
            ->andFilterWhere(['like', 'phonecode', $this->phonecode])
            ->andFilterWhere(['like', 'capital', $this->capital])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'native', $this->native])
            ->andFilterWhere(['like', 'emoji', $this->emoji])
            ->andFilterWhere(['like', 'emojiU', $this->emojiU])
            ->andFilterWhere(['like', 'wikiDataId', $this->wikiDataId]);

        return $dataProvider;
    }
}
