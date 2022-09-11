<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_tahfidz_kelompok_anggota".
 *
 * @property int $id
 * @property string $nim
 * @property int $kelompok_id
 * @property int $periode_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SimakMastermahasiswa $nim0
 * @property SimakTahfidzKelompok $kelompok
 * @property SimakTahfidzPeriode $periode
 */
class SimakTahfidzKelompokAnggota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_tahfidz_kelompok_anggota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nim', 'kelompok_id', 'periode_id'], 'required'],
            [['kelompok_id', 'periode_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nim'], 'string', 'max' => 25],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::className(), 'targetAttribute' => ['nim' => 'nim_mhs']],
            [['kelompok_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakTahfidzKelompok::className(), 'targetAttribute' => ['kelompok_id' => 'id']],
            [['periode_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakTahfidzPeriode::className(), 'targetAttribute' => ['periode_id' => 'id']],
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
            'kelompok_id' => 'Kelompok ID',
            'periode_id' => 'Periode ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNim0()
    {
        return $this->hasOne(SimakMastermahasiswa::className(), ['nim_mhs' => 'nim']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKelompok()
    {
        return $this->hasOne(SimakTahfidzKelompok::className(), ['id' => 'kelompok_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriode()
    {
        return $this->hasOne(SimakTahfidzPeriode::className(), ['id' => 'periode_id']);
    }
}
