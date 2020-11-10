<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_izin_harian".
 *
 * @property int $id
 * @property string $nim
 * @property string $waktu
 * @property int $status_izin 1= Sudah kembali, 2 = belum kembali
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SimakMastermahasiswa $nim0
 */
class IzinHarian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_izin_harian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nim', 'waktu'], 'required'],
            [['waktu', 'created_at', 'updated_at'], 'safe'],
            [['status_izin'], 'integer'],
            [['nim'], 'string', 'max' => 25],
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
            'waktu' => 'Waktu',
            'status_izin' => 'Status Izin',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Nim0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNim0()
    {
        return $this->hasOne(SimakMastermahasiswa::className(), ['nim_mhs' => 'nim']);
    }

    public function getNamaMahasiswa()
    {
        return $this->nim0->nama_mahasiswa;
    }

    public function getNamaProdi()
    {
        return $this->nim0->kodeProdi->nama_prodi;
    }

    public function getNamaFakultas()
    {
        return $this->nim0->kodeProdi->kodeFakultas->nama_fakultas;
    }

    public function getNamaAsrama()
    {
        return !empty($this->nim0->kamar) ? $this->nim0->kamar->asrama->nama : '';
    }

    public function getNamaKamar()
    {
        return !empty($this->nim0->kamar) ? $this->nim0->kamar->nama : '';
    }
}
