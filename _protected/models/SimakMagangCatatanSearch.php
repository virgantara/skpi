<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakMagangCatatan;

/**
 * SimakMagangCatatanSearch represents the model behind the search form of `app\models\SimakMagangCatatan`.
 */
class SimakMagangCatatanSearch extends SimakMagangCatatan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'magang_id', 'tanggal', 'rincian_kegiatan', 'evaluasi', 'tindak_lanjut', 'catatan_pembimbing', 'is_approved', 'updated_at', 'created_at'], 'safe'],
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
        $query = SimakMagangCatatan::find();

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
            'tanggal' => $this->tanggal,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'magang_id', $this->magang_id])
            ->andFilterWhere(['like', 'rincian_kegiatan', $this->rincian_kegiatan])
            ->andFilterWhere(['like', 'evaluasi', $this->evaluasi])
            ->andFilterWhere(['like', 'tindak_lanjut', $this->tindak_lanjut])
            ->andFilterWhere(['like', 'catatan_pembimbing', $this->catatan_pembimbing])
            ->andFilterWhere(['like', 'is_approved', $this->is_approved]);

        return $dataProvider;
    }
}
