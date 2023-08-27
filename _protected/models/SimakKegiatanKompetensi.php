<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_kegiatan_kompetensi".
 *
 * @property int $id
 * @property int $pilihan_id
 * @property int $kegiatan_id
 * @property float $bobot
 * @property float $persentase_bobot
 *
 * @property SimakKegiatan $kegiatan
 * @property SimakPilihan $pilihan
 */
class SimakKegiatanKompetensi extends \yii\db\ActiveRecord
{
    public $captcha;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_kegiatan_kompetensi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['captcha', 'captcha'],
            [['pilihan_id', 'kegiatan_id'], 'required'],
            [['pilihan_id', 'kegiatan_id'], 'integer'],
            [['bobot', 'persentase_bobot'], 'number'],
            [['kegiatan_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakKegiatan::class, 'targetAttribute' => ['kegiatan_id' => 'id']],
            [['pilihan_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakPilihan::class, 'targetAttribute' => ['pilihan_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pilihan_id' => 'Pilihan ID',
            'kegiatan_id' => 'Kegiatan ID',
            'bobot' => 'Bobot',
            'persentase_bobot' => 'Persentase Bobot',
        ];
    }

    /**
     * Gets query for [[Kegiatan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKegiatan()
    {
        return $this->hasOne(SimakKegiatan::class, ['id' => 'kegiatan_id']);
    }

    /**
     * Gets query for [[Pilihan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPilihan()
    {
        return $this->hasOne(SimakPilihan::class, ['id' => 'pilihan_id']);
    }
}
