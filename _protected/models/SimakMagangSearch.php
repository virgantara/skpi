<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SimakMagang;

/**
 * SimakMagangSearch represents the model behind the search form of `app\models\SimakMagang`.
 */
class SimakMagangSearch extends SimakMagang
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nim', 'nama_instansi', 'alamat_instansi', 'telp_instansi', 'email_instansi', 'nama_pembina_instansi', 'jabatan_pembina_instansi', 'kota_instansi', 'is_dalam_negeri', 'tanggal_mulai_magang', 'tanggal_selesai_magang', 'status_magang_id','jenis_magang_id', 'keterangan','pembimbing_id','nama_dosen','nama_prodi','kode_prodi','kampus','namaMahasiswa','negara','provinsi'], 'safe'],
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

    public function searchTambahan($params)
    {
        $query = SimakMagang::find();
        $query->alias('t');
        $query->joinWith(['nim0 as mhs','pembimbing as p','statusMagang as sm','nim0.kodeProdi as prod']);

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

        $dataProvider->sort->attributes['namaMahasiswa'] = [
            'asc' => ['mhs.nama_mahasiswa'=>SORT_ASC],
            'desc' => ['mhs.nama_mahasiswa'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['nama_prodi'] = [
            'asc' => ['prod.nama_prodi'=>SORT_ASC],
            'desc' => ['prod.nama_prodi'=>SORT_DESC]
        ];

        // grid filtering conditions
        $query->andFilterWhere([
            'status_magang_id' => $this->status_magang_id,
            'jenis_magang_id' => $this->jenis_magang_id,
            'mhs.kampus' => $this->kampus,
            't.nim' => $this->nim,
            't.kota_instansi' => $this->kota_instansi,
            'prod.kode_prodi' => $this->kode_prodi,
            'tanggal_mulai_magang' => $this->tanggal_mulai_magang,
            'tanggal_selesai_magang' => $this->tanggal_selesai_magang,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'mhs.nama_mahasiswa', $this->nim])
            ->andFilterWhere(['like', 'p.display_name', $this->nama_dosen])
            ->andFilterWhere(['like', 'nama_instansi', $this->nama_instansi])
            ->andFilterWhere(['like', 'alamat_instansi', $this->alamat_instansi])
            ->andFilterWhere(['like', 'telp_instansi', $this->telp_instansi])
            ->andFilterWhere(['like', 'email_instansi', $this->email_instansi])
            ->andFilterWhere(['like', 'nama_pembina_instansi', $this->nama_pembina_instansi])
            ->andFilterWhere(['like', 'jabatan_pembina_instansi', $this->jabatan_pembina_instansi])
            ->andFilterWhere(['like', 'is_dalam_negeri', $this->is_dalam_negeri])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        // if(Yii::$app->user->identity->access_role == 'Dosen'){
        //     // print_r(Yii::$app->user->identity->id);exit;
        //     $query->andWhere([
        //         'pembimbing_id' => Yii::$app->user->identity->id
        //     ]);
        // }

        // else  if(in_array(Yii::$app->user->identity->access_role,['sekretearis','kaprodi','fakultas','kurikulum_prodi'])){
        //     $query->andWhere([
        //         'mhs.kode_prodi' => Yii::$app->user->identity->prodi
        //     ]);
        // }


        return $dataProvider;
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
        $query = SimakMagang::find();
        $query->joinWith(['nim0 as mhs','pembimbing as p']);

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
            'status_magang_id' => $this->status_magang_id,
            'jenis_magang_id' => $this->jenis_magang_id,
            'mhs.kode_prodi' => $this->kode_prodi,
            'tanggal_mulai_magang' => $this->tanggal_mulai_magang,
            'tanggal_selesai_magang' => $this->tanggal_selesai_magang,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'mhs.nama_mahasiswa', $this->nim])
            ->andFilterWhere(['like', 'p.display_name', $this->nama_dosen])
            ->andFilterWhere(['like', 'nama_instansi', $this->nama_instansi])
            ->andFilterWhere(['like', 'alamat_instansi', $this->alamat_instansi])
            ->andFilterWhere(['like', 'telp_instansi', $this->telp_instansi])
            ->andFilterWhere(['like', 'email_instansi', $this->email_instansi])
            ->andFilterWhere(['like', 'nama_pembina_instansi', $this->nama_pembina_instansi])
            ->andFilterWhere(['like', 'jabatan_pembina_instansi', $this->jabatan_pembina_instansi])
            ->andFilterWhere(['like', 'kota_instansi', $this->kota_instansi])
            ->andFilterWhere(['like', 'is_dalam_negeri', $this->is_dalam_negeri])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        // if(Yii::$app->user->identity->access_role == 'Dosen'){
        //     // print_r(Yii::$app->user->identity->id);exit;
        //     $query->andWhere([
        //         'pembimbing_id' => Yii::$app->user->identity->id
        //     ]);
        // }

        // else  if(in_array(Yii::$app->user->identity->access_role,['sekretearis','kaprodi','fakultas','kurikulum_prodi'])){
        //     $query->andWhere([
        //         'mhs.kode_prodi' => Yii::$app->user->identity->prodi
        //     ]);
        // }


        return $dataProvider;
    }
}
