<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_kegiatan_harian_mahasiswa".
 *
 * @property string $id
 * @property string $nim
 * @property int|null $tahun_akademik
 * @property string|null $kode_kegiatan
 * @property int|null $kegiatan_rutin_id
 * @property float|null $poin
 * @property string|null $waktu
 */
class SimakKegiatanHarianMahasiswa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_kegiatan_harian_mahasiswa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nim'], 'required'],
            [['tahun_akademik', 'kegiatan_rutin_id'], 'integer'],
            [['poin'], 'number'],
            [['waktu'], 'safe'],
            [['id'], 'string', 'max' => 50],
            [['nim', 'kode_kegiatan'], 'string', 'max' => 20],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nim' => 'Nim',
            'tahun_akademik' => 'Tahun Akademik',
            'kode_kegiatan' => 'Kode Kegiatan',
            'kegiatan_rutin_id' => 'Kegiatan Rutin ID',
            'poin' => 'Poin',
            'waktu' => 'Waktu',
        ];
    }
}
