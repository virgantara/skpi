<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_induk_kegiatan".
 *
 * @property int $id
 * @property string $nama
 *
 * @property SimakIndukKegiatanKompetensi[] $simakIndukKegiatanKompetensis
 * @property SimakIndukRangeNilai[] $simakIndukRangeNilais
 * @property SimakJenisKegiatan[] $simakJenisKegiatans
 */
class SimakIndukKegiatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_induk_kegiatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
        ];
    }

    /**
     * Gets query for [[SimakIndukKegiatanKompetensis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakIndukKegiatanKompetensis()
    {
        return $this->hasMany(SimakIndukKegiatanKompetensi::className(), ['induk_id' => 'id']);
    }

    /**
     * Gets query for [[SimakIndukRangeNilais]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakIndukRangeNilais()
    {
        return $this->hasMany(SimakIndukRangeNilai::className(), ['induk_id' => 'id']);
    }

    /**
     * Gets query for [[SimakJenisKegiatans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakJenisKegiatans()
    {
        return $this->hasMany(SimakJenisKegiatan::className(), ['induk_id' => 'id']);
    }
}
