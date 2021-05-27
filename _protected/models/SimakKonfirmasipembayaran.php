<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_konfirmasipembayaran".
 *
 * @property int $id
 * @property string|null $nim
 * @property string|null $pembayaran
 * @property string $semester
 * @property int|null $tahun_id
 * @property string $jumlah
 * @property string|null $tanggal
 * @property string $bank
 * @property string|null $file
 * @property string|null $keterangan
 * @property string|null $date_created
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SimakMastermahasiswa $nim0
 * @property SimakJenisPembayaran $pembayaran0
 */
class SimakKonfirmasipembayaran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_konfirmasipembayaran';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['semester', 'jumlah', 'bank'], 'required'],
            [['tahun_id', 'status'], 'integer'],
            [['tanggal', 'date_created', 'created_at', 'updated_at'], 'safe'],
            [['file', 'keterangan'], 'string'],
            [['nim'], 'string', 'max' => 25],
            [['pembayaran'], 'string', 'max' => 30],
            [['semester'], 'string', 'max' => 5],
            [['jumlah', 'bank'], 'string', 'max' => 20],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::className(), 'targetAttribute' => ['nim' => 'nim_mhs']],
            [['pembayaran'], 'exist', 'skipOnError' => true, 'targetClass' => SimakJenisPembayaran::className(), 'targetAttribute' => ['pembayaran' => 'kode_pembayaran']],
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
            'pembayaran' => 'Pembayaran',
            'semester' => 'Semester',
            'tahun_id' => 'Tahun ID',
            'jumlah' => 'Jumlah',
            'tanggal' => 'Tanggal',
            'bank' => 'Bank',
            'file' => 'File',
            'keterangan' => 'Keterangan',
            'date_created' => 'Date Created',
            'status' => 'Status',
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

    /**
     * Gets query for [[Pembayaran0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPembayaran0()
    {
        return $this->hasOne(SimakJenisPembayaran::className(), ['kode_pembayaran' => 'pembayaran']);
    }
}
