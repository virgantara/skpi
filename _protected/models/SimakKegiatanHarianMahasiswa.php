<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_kegiatan_harian_mahasiswa".
 *
 * @property string $id
 * @property string|null $nim
 * @property int|null $tahun_akademik
 * @property string|null $kode_kegiatan
 * @property int|null $kegiatan_rutin_id
 * @property float|null $poin
 * @property string|null $waktu
 * @property string|null $updated_at
 * @property string|null $created_at
 *
 * @property SimakKegiatanHarian $kodeKegiatan
 * @property SimakMastermahasiswa $nim0
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
            [['id'], 'required'],
            [['tahun_akademik', 'kegiatan_rutin_id'], 'integer'],
            [['poin'], 'number'],
            [['waktu', 'updated_at', 'created_at'], 'safe'],
            [['id', 'kode_kegiatan'], 'string', 'max' => 50],
            [['nim'], 'string', 'max' => 20],
            [['id'], 'unique'],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::className(), 'targetAttribute' => ['nim' => 'nim_mhs']],
            [['kode_kegiatan'], 'exist', 'skipOnError' => true, 'targetClass' => SimakKegiatanHarian::className(), 'targetAttribute' => ['kode_kegiatan' => 'kode']],
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
            'kode_kegiatan' => 'Kegiatan Harian',
            'kegiatan_rutin_id' => 'Kegiatan Rutin ID',
            'poin' => 'Poin',
            'waktu' => 'Waktu',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[KodeKegiatan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeKegiatan()
    {
        return $this->hasOne(SimakKegiatanHarian::className(), ['kode' => 'kode_kegiatan']);
    }

    /**
     * Gets query for [[Nim0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNim0()
    {
        return $this->hasOne(SimakMastermahasiswa::className(), ['nim_mhs' => 'nim']);
    }

    public function getNamaMahasiswa()
    {
        return !empty($this->nim0) ? $this->nim0->nama_mahasiswa : '-';
    }

    public function getNamaProdi()
    {
        return !empty($this->nim0) && !empty($this->nim0->kodeProdi) ? $this->nim0->kodeProdi->nama_prodi : '-';
    }

    public function getSemester()
    {
        return !empty($this->nim0) ? $this->nim0->semester : '-';
    }
}
