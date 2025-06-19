<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_range_nilai".
 *
 * @property int $id
 * @property float $dari
 * @property float $sampai
 * @property string $nilai_huruf
 * @property float|null $angka
 * @property string|null $keterangan
 */
class SimakRangeNilai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_range_nilai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dari', 'sampai', 'nilai_huruf','kode_prodi'], 'required'],
            [['dari', 'sampai', 'angka'], 'number'],
            [['nilai_huruf'], 'string', 'max' => 2],
            [['keterangan'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dari' => 'Dari',
            'sampai' => 'Sampai',
            'nilai_huruf' => 'Nilai Huruf',
            'angka' => 'Angka',
            'keterangan' => 'Keterangan',
        ];
    }

    public function getNamaProdi()
    {
        $prodi = SimakMasterprogramstudi::findOne(['kode_prodi' => $this->kode_prodi]);

        return (!empty($prodi) ? $prodi->nama_prodi : null);
    }

    public static function getNilaiHuruf($angka)
    {
        $prodi = Yii::$app->user->identity->prodi;
        $query = new \yii\db\Query();
        $query->select(['nilai_huruf']);
        $query->from('simak_range_nilai');
        $query->where($angka.' >= dari AND '.$angka.' <= sampai');
        $query->andWhere(['kode_prodi' => $prodi]);
        
        return $query->one();
    }
}
