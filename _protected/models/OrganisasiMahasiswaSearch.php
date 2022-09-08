<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OrganisasiMahasiswa;

/**
 * OrganisasiMahasiswaSearch represents the model behind the search form of `app\models\OrganisasiMahasiswa`.
 */
class OrganisasiMahasiswaSearch extends OrganisasiMahasiswa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'organisasi_id'], 'integer'],
            [['tanggal_mulai', 'tanggal_selesai', 'no_sk', 'tanggal_sk', 'created_at', 'updated_at','pembimbing_id','tahun_akademik','kampus'], 'safe'],
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
        $query = OrganisasiMahasiswa::find();
        $query->alias('t');

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
            'kampus' => $this->kampus,
            'organisasi_id' => $this->organisasi_id,
            'tahun_akademik' => $this->tahun_akademik,
            'pembimbing_id' => $this->pembimbing_id,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'tanggal_sk' => $this->tanggal_sk,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'no_sk', $this->no_sk]);

        if(!Yii::$app->user->isGuest)
        {

            if(Yii::$app->user->identity->access_role == 'akpam' || Yii::$app->user->identity->access_role == 'akpam')
            {
                $query->andWhere([
                    't.kampus' => Yii::$app->user->identity->kampus
                ]);
            }
        }


        return $dataProvider;
    }


}
