<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakKegiatan;

/**
 * SimakKegiatanSearch represents the model behind the search form of `app\models\SimakKegiatan`.
 */
class SimakKegiatanSearch extends SimakKegiatan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nilai', 'id_jenis_kegiatan'], 'integer'],
            [['nama_kegiatan', 'sub_kegiatan', 'sk_unida_siman', 'sk_unida_cabang', 'is_active', 'created_at', 'updated_at'], 'safe'],
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
        $query = SimakKegiatan::find();

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
            'nilai' => $this->nilai,
            'id_jenis_kegiatan' => $this->id_jenis_kegiatan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nama_kegiatan', $this->nama_kegiatan])
            ->andFilterWhere(['like', 'sub_kegiatan', $this->sub_kegiatan])
            ->andFilterWhere(['like', 'sk_unida_siman', $this->sk_unida_siman])
            ->andFilterWhere(['like', 'sk_unida_cabang', $this->sk_unida_cabang])
            ->andFilterWhere(['like', 'is_active', $this->is_active]);

        return $dataProvider;
    }
}
