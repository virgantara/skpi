<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_jenis_kegiatan".
 *
 * @property int $id
 * @property int|null $induk_id
 * @property string $nama_jenis_kegiatan
 * @property string|null $nama_jenis_kegiatan_en
 * @property int $nilai_minimal
 * @property int $nilai_maximal
 *
 * @property SimakIndukKegiatan $induk
 * @property SimakKegiatanMahasiswa[] $simakKegiatanMahasiswas
 * @property SimakKegiatan[] $simakKegiatans
 */
class SimakJenisKegiatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_jenis_kegiatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['induk_id', 'nilai_minimal', 'nilai_maximal'], 'integer'],
            [['nama_jenis_kegiatan', 'nilai_minimal', 'nilai_maximal'], 'required'],
            [['nama_jenis_kegiatan'], 'string', 'max' => 50],
            [['nama_jenis_kegiatan_en'], 'string', 'max' => 255],
            [['induk_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakIndukKegiatan::className(), 'targetAttribute' => ['induk_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'induk_id' => 'Induk ID',
            'nama_jenis_kegiatan' => 'Nama Jenis Kegiatan',
            'nama_jenis_kegiatan_en' => 'Nama Jenis Kegiatan En',
            'nilai_minimal' => 'Nilai Minimal',
            'nilai_maximal' => 'Nilai Maximal',
        ];
    }

    /**
     * Gets query for [[Induk]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInduk()
    {
        return $this->hasOne(SimakIndukKegiatan::className(), ['id' => 'induk_id']);
    }

    /**
     * Gets query for [[SimakKegiatanMahasiswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakKegiatanMahasiswas()
    {
        return $this->hasMany(SimakKegiatanMahasiswa::className(), ['id_jenis_kegiatan' => 'id']);
    }

    /**
     * Gets query for [[SimakKegiatans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakKegiatans()
    {
        return $this->hasMany(SimakKegiatan::className(), ['id_jenis_kegiatan' => 'id']);
    }
}
