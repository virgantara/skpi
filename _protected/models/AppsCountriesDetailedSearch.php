<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AppsCountriesDetailed;

/**
 * AppsCountriesDetailedSearch represents the model behind the search form of `app\models\AppsCountriesDetailed`.
 */
class AppsCountriesDetailedSearch extends AppsCountriesDetailed
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'geonameId'], 'integer'],
            [['countryCode', 'countryName', 'currencyCode', 'fipsCode', 'isoNumeric', 'north', 'south', 'east', 'west', 'capital', 'continentName', 'continent', 'languages', 'isoAlpha3'], 'safe'],
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
        $query = AppsCountriesDetailed::find();

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
            'geonameId' => $this->geonameId,
        ]);

        $query->andFilterWhere(['like', 'countryCode', $this->countryCode])
            ->andFilterWhere(['like', 'countryName', $this->countryName])
            ->andFilterWhere(['like', 'currencyCode', $this->currencyCode])
            ->andFilterWhere(['like', 'fipsCode', $this->fipsCode])
            ->andFilterWhere(['like', 'isoNumeric', $this->isoNumeric])
            ->andFilterWhere(['like', 'north', $this->north])
            ->andFilterWhere(['like', 'south', $this->south])
            ->andFilterWhere(['like', 'east', $this->east])
            ->andFilterWhere(['like', 'west', $this->west])
            ->andFilterWhere(['like', 'capital', $this->capital])
            ->andFilterWhere(['like', 'continentName', $this->continentName])
            ->andFilterWhere(['like', 'continent', $this->continent])
            ->andFilterWhere(['like', 'languages', $this->languages])
            ->andFilterWhere(['like', 'isoAlpha3', $this->isoAlpha3]);

        return $dataProvider;
    }
}
