<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_mahasiswa_program_tambahan".
 *
 * @property string $id
 * @property string $nim
 * @property string $nama
 * @property string $nama_en
 * @property string $durasi
 * @property string $durasi_en
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SimakMastermahasiswa $nim0
 */
class SimakMahasiswaProgramTambahan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_mahasiswa_program_tambahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nim', 'nama', 'nama_en', 'durasi', 'durasi_en'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['id', 'nama', 'nama_en', 'durasi', 'durasi_en'], 'string', 'max' => 255],
            [['nim'], 'string', 'max' => 25],
            [['id'], 'unique'],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::className(), 'targetAttribute' => ['nim' => 'nim_mhs']],
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
            'nama' => 'Nama',
            'nama_en' => 'Nama En',
            'durasi' => 'Durasi',
            'durasi_en' => 'Durasi En',
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
}
