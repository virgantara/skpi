<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_pilihan".
 *
 * @property int $id
 * @property string $kode
 * @property int|null $kode_feeder
 * @property string $nama
 * @property string $value
 * @property string $label
 *
 * @property SimakMahasiswaOrtu[] $simakMahasiswaOrtus
 * @property SimakMahasiswaOrtu[] $simakMahasiswaOrtus0
 * @property SimakMahasiswaOrtu[] $simakMahasiswaOrtus1
 * @property SimakMahasiswaOrtu[] $simakMahasiswaOrtus2
 */
class SimakPilihan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_pilihan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'nama', 'value', 'label'], 'required'],
            [['kode_feeder'], 'integer'],
            [['kode', 'value'], 'string', 'max' => 10],
            [['nama', 'label'], 'string', 'max' => 100],
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
            'kode_feeder' => 'Kode Feeder',
            'nama' => 'Nama',
            'value' => 'Value',
            'label' => 'Label',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSimakMahasiswaOrtus()
    {
        return $this->hasMany(SimakMahasiswaOrtu::className(), ['agama' => 'value']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSimakMahasiswaOrtus0()
    {
        return $this->hasMany(SimakMahasiswaOrtu::className(), ['pendidikan' => 'value']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSimakMahasiswaOrtus1()
    {
        return $this->hasMany(SimakMahasiswaOrtu::className(), ['pekerjaan' => 'value']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSimakMahasiswaOrtus2()
    {
        return $this->hasMany(SimakMahasiswaOrtu::className(), ['penghasilan' => 'value']);
    }
}
