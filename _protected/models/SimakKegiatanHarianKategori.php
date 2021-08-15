<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_kegiatan_harian_kategori".
 *
 * @property string $kode
 * @property string|null $nama
 *
 * @property SimakKegiatanHarian[] $simakKegiatanHarians
 */
class SimakKegiatanHarianKategori extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_kegiatan_harian_kategori';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode'], 'required'],
            [['kode'], 'string', 'max' => 10],
            [['nama'], 'string', 'max' => 100],
            [['kode'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kode' => 'Kode',
            'nama' => 'Nama',
        ];
    }

    /**
     * Gets query for [[SimakKegiatanHarians]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakKegiatanHarians()
    {
        return $this->hasMany(SimakKegiatanHarian::className(), ['kategori' => 'kode']);
    }
}
