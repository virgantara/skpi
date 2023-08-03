<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimkatmawaNonLomba;
use Yii;

/**
 * SimkatmawaNonLombaSearch represents the model behind the search form of `app\models\SimkatmawaNonLomba`.
 */
class SimkatmawaNonLombaSearch extends SimkatmawaNonLomba
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'simkatmawa_kegiatan_id'], 'integer'],
            [['nama_kegiatan', 'tanggal_mulai', 'tanggal_selesai', 'laporan_path', 'url_kegiatan', 'foto_kegiatan_path', 'created_at', 'updated_at'], 'safe'],
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
        $query = SimkatmawaNonLomba::find();

        // add conditions that should always apply here
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->access_role == "operatorUnit") {
            $query->andWhere(['user_id' => Yii::$app->user->identity->id]);
        }

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
            'simkatmawa_kegiatan_id' => $this->simkatmawa_kegiatan_id,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nama_kegiatan', $this->nama_kegiatan])
            ->andFilterWhere(['like', 'laporan_path', $this->laporan_path])
            ->andFilterWhere(['like', 'url_kegiatan', $this->url_kegiatan])
            ->andFilterWhere(['like', 'foto_kegiatan_path', $this->foto_kegiatan_path]);

        return $dataProvider;
    }
}
