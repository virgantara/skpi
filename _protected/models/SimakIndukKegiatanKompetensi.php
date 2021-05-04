<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_induk_kegiatan_kompetensi".
 *
 * @property int $id
 * @property int $induk_id
 * @property int $pilihan_id
 *
 * @property SimakIndukKegiatan $induk
 * @property SimakPilihan $pilihan
 * @property SimakKompetensiRangeNilai[] $simakKompetensiRangeNilais
 */
class SimakIndukKegiatanKompetensi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_induk_kegiatan_kompetensi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['induk_id', 'pilihan_id'], 'required'],
            [['induk_id', 'pilihan_id'], 'integer'],
            [['induk_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakIndukKegiatan::className(), 'targetAttribute' => ['induk_id' => 'id']],
            [['pilihan_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakPilihan::className(), 'targetAttribute' => ['pilihan_id' => 'id']],
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
            'pilihan_id' => 'Pilihan ID',
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
     * Gets query for [[Pilihan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPilihan()
    {
        return $this->hasOne(SimakPilihan::className(), ['id' => 'pilihan_id']);
    }

    /**
     * Gets query for [[SimakKompetensiRangeNilais]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakKompetensiRangeNilais()
    {
        return $this->hasMany(SimakKompetensiRangeNilai::className(), ['induk_kompetensi_id' => 'id']);
    }
}
