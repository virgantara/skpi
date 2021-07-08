<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Events;

/**
 * EventsSearch represents the model behind the search form of `app\models\Events`.
 */
class EventsSearch extends Events
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nama', 'venue', 'tanggal_mulai', 'tanggal_selesai', 'penyelenggara', 'tingkat', 'url','status','kegiatan_id','tahun_id','toleransi_masuk','toleransi_keluar','fakultas','prodi','dosen_id'], 'safe'],
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
        $query = Events::find();

        $query->joinWith(['kegiatan as k']);
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

        $query->andFilterWhere(['like','k.nama_kegiatan',$this->kegiatan_id]);

        // grid filtering conditions
        $query->andFilterWhere([
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'tahun_id' => $this->tahun_id,
            'fakultas' => $this->fakultas,
            'prodi' => $this->prodi,
            'dosen_id' => $this->dosen_id,
            'toleransi_masuk' => $this->toleransi_masuk,
            'toleransi_keluar' => $this->toleransi_keluar,
            // 'kegiatan_id' => $this->kegiatan_id,
            'status' => $this->status
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'venue', $this->venue])
            ->andFilterWhere(['like', 'penyelenggara', $this->penyelenggara])
            ->andFilterWhere(['like', 'tingkat', $this->tingkat])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }



    public function searchDaily($daily='today',$params)
    {
        $query = Events::find();

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

        $date_today = date('Y-m-d 00:00:00');
        
        if($daily == 'previous')
            $query->andWhere('tanggal_mulai < "'.$date_today.'"');
        else if($daily == 'today'){
            $ed = date('Y-m-d 23:59:59');
            $query->andWhere('tanggal_mulai BETWEEN "'.$date_today.'" AND "'.$ed.'"');
        }
        else if($daily =='upcoming'){
            $date_today = date('Y-m-d 00:00:00',strtotime('+1 days'));
            $query->andWhere('tanggal_mulai >= "'.$date_today.'"');
        }

        $query->andFilterWhere([
            'status' => $this->status
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'venue', $this->venue])
            ->andFilterWhere(['like', 'penyelenggara', $this->penyelenggara])
            ->andFilterWhere(['like', 'tingkat', $this->tingkat])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
