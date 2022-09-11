<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_tahfidz_nilai".
 *
 * @property int $id
 * @property int $periode_id
 * @property string $nim
 * @property float $hafalan
 * @property float $kelancaran
 * @property float $makhrojul_huruf
 * @property float $tajwid
 * @property float $nilai_angka
 * @property string $nilai_huruf
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SimakMastermahasiswa $nim0
 * @property SimakTahfidzPeriode $periode
 */
class SimakTahfidzNilai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_tahfidz_nilai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['periode_id', 'nim', 'hafalan', 'kelancaran', 'makhrojul_huruf', 'tajwid', 'nilai_angka', 'nilai_huruf'], 'required'],
            [['periode_id'], 'integer'],
            [['hafalan', 'kelancaran', 'makhrojul_huruf', 'tajwid', 'nilai_angka'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['nim'], 'string', 'max' => 25],
            [['nilai_huruf'], 'string', 'max' => 3],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::className(), 'targetAttribute' => ['nim' => 'nim_mhs']],
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
            'periode_id' => 'Periode ID',
            'nim' => 'Nim',
            'hafalan' => 'Hafalan',
            'kelancaran' => 'Kelancaran',
            'makhrojul_huruf' => 'Makhrojul Huruf',
            'tajwid' => 'Tajwid',
            'nilai_angka' => 'Nilai Angka',
            'nilai_huruf' => 'Nilai Huruf',
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
    public function getPeriode()
    {
        return $this->hasOne(SimakTahfidzPeriode::className(), ['id' => 'periode_id']);
    }
}
