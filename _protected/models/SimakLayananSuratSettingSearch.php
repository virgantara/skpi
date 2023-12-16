<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakLayananSuratSetting;

/**
 * SimakLayananSuratSettingSearch represents the model behind the search form of `app\models\SimakLayananSuratSetting`.
 */
class SimakLayananSuratSettingSearch extends SimakLayananSuratSetting
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['file_header_path', 'file_sign_path', 'kode_fakultas'], 'safe'],
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
        $query = SimakLayananSuratSetting::find();

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
        ]);

        $query->andFilterWhere(['like', 'file_header_path', $this->file_header_path])
            ->andFilterWhere(['like', 'file_sign_path', $this->file_sign_path])
            ->andFilterWhere(['like', 'kode_fakultas', $this->kode_fakultas]);

        return $dataProvider;
    }
}
