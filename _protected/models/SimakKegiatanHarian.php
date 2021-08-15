<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_kegiatan_harian".
 *
 * @property string $id
 * @property string $kode
 * @property int|null $kegiatan_id
 * @property string|null $kategori
 * @property int|null $tahun_akademik
 * @property string|null $jam_mulai
 * @property string|null $jam_selesai
 * @property string|null $kode_venue
 * @property float|null $poin
 *
 * @property SimakKegiatanHarianKategori $kategori0
 * @property SimakKegiatan $kegiatan
 * @property Venue $kodeVenue
 * @property SimakKegiatanHarianMahasiswa[] $simakKegiatanHarianMahasiswas
 */
class SimakKegiatanHarian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_kegiatan_harian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kode'], 'required'],
            [['kegiatan_id', 'tahun_akademik'], 'integer'],
            [['jam_mulai', 'jam_selesai'], 'safe'],
            [['poin'], 'number'],
            [['id'], 'string', 'max' => 100],
            [['kode'], 'string', 'max' => 50],
            [['kategori', 'kode_venue'], 'string', 'max' => 10],
            [['kode'], 'unique'],
            [['id'], 'unique'],
            [['kegiatan_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakKegiatan::className(), 'targetAttribute' => ['kegiatan_id' => 'id']],
            [['kode_venue'], 'exist', 'skipOnError' => true, 'targetClass' => Venue::className(), 'targetAttribute' => ['kode_venue' => 'kode']],
            [['kategori'], 'exist', 'skipOnError' => true, 'targetClass' => SimakKegiatanHarianKategori::className(), 'targetAttribute' => ['kategori' => 'kode']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode' => 'Kode',
            'kegiatan_id' => 'Kegiatan ID',
            'kategori' => 'Kategori',
            'tahun_akademik' => 'Tahun Akademik',
            'jam_mulai' => 'Jam Mulai',
            'jam_selesai' => 'Jam Selesai',
            'kode_venue' => 'Kode Venue',
            'poin' => 'Poin',
        ];
    }

    /**
     * Gets query for [[Kategori0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKategori0()
    {
        return $this->hasOne(SimakKegiatanHarianKategori::className(), ['kode' => 'kategori']);
    }

    /**
     * Gets query for [[Kegiatan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKegiatan()
    {
        return $this->hasOne(SimakKegiatan::className(), ['id' => 'kegiatan_id']);
    }

    /**
     * Gets query for [[KodeVenue]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeVenue()
    {
        return $this->hasOne(Venue::className(), ['kode' => 'kode_venue']);
    }

    /**
     * Gets query for [[SimakKegiatanHarianMahasiswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakKegiatanHarianMahasiswas()
    {
        return $this->hasMany(SimakKegiatanHarianMahasiswa::className(), ['kode_kegiatan' => 'kode']);
    }
}
