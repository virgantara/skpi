<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CapaianPembelajaranLulusan;

/**
 * CapaianPembelajaranLulusanSearch represents the model behind the search form of `app\models\CapaianPembelajaranLulusan`.
 */
class CapaianPembelajaranLulusanSearch extends CapaianPembelajaranLulusan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kode', 'jenis', 'kode_prodi', 'deskripsi', 'deskripsi_en', 'state'], 'safe'],
            [['urutan'], 'integer'],
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
        $query = CapaianPembelajaranLulusan::find();

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
            'urutan' => $this->urutan,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'kode', $this->kode])
            ->andFilterWhere(['like', 'jenis', $this->jenis])
            ->andFilterWhere(['like', 'kode_prodi', $this->kode_prodi])
            ->andFilterWhere(['like', 'deskripsi', $this->deskripsi])
            ->andFilterWhere(['like', 'deskripsi_en', $this->deskripsi_en])
            ->andFilterWhere(['like', 'state', $this->state]);

        return $dataProvider;
    }
}
