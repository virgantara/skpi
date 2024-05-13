<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakSertifikasi;

/**
 * SimakSertifikasiSearch represents the model behind the search form of `app\models\SimakSertifikasi`.
 */
class SimakSertifikasiSearch extends SimakSertifikasi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nim', 'jenis_sertifikasi', 'lembaga_sertifikasi', 'nomor_registrasi_sertifikasi', 'nomor_sk_sertifikasi', 'tmt_sertifikasi', 'tst_sertifikasi', 'file_path', 'status_validasi', 'catatan', 'updated_at', 'created_at'], 'safe'],
            [['tahun_sertifikasi', 'approved_by'], 'integer'],
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
        $query = SimakSertifikasi::find();

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
            'tahun_sertifikasi' => $this->tahun_sertifikasi,
            'tmt_sertifikasi' => $this->tmt_sertifikasi,
            'tst_sertifikasi' => $this->tst_sertifikasi,
            'approved_by' => $this->approved_by,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'nim', $this->nim])
            ->andFilterWhere(['like', 'jenis_sertifikasi', $this->jenis_sertifikasi])
            ->andFilterWhere(['like', 'lembaga_sertifikasi', $this->lembaga_sertifikasi])
            ->andFilterWhere(['like', 'nomor_registrasi_sertifikasi', $this->nomor_registrasi_sertifikasi])
            ->andFilterWhere(['like', 'nomor_sk_sertifikasi', $this->nomor_sk_sertifikasi])
            ->andFilterWhere(['like', 'file_path', $this->file_path])
            ->andFilterWhere(['like', 'status_validasi', $this->status_validasi])
            ->andFilterWhere(['like', 'catatan', $this->catatan]);

        return $dataProvider;
    }
}
