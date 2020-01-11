<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_riwayat_pelanggaran".
 *
 * @property int $id
 * @property int $pelanggaran_id
 * @property string $nim
 * @property string $nama_mahasiswa
 * @property int $tahun_id
 * @property string $created_at
 * @property string $updated_at
 */
class RiwayatPelanggaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_riwayat_pelanggaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pelanggaran_id', 'nim', 'nama_mahasiswa', 'tahun_id'], 'required'],
            [['pelanggaran_id', 'tahun_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nim'], 'string', 'max' => 25],
            [['nama_mahasiswa'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pelanggaran_id' => 'Pelanggaran',
            'nim' => 'NIM',
            'nama_mahasiswa' => 'Nama Mahasiswa',
            'tahun_id' => 'Tahun',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
