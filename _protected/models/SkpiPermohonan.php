<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_skpi_permohonan".
 *
 * @property string $id
 * @property string|null $nim
 * @property string|null $nomor_skpi
 * @property string|null $link_barcode
 * @property string|null $status_pengajuan
 * @property string|null $tanggal_pengajuan
 * @property string|null $updated_at
 * @property string|null $created_at
 *
 * @property SimakMastermahasiswa $nim0
 */
class SkpiPermohonan extends \yii\db\ActiveRecord
{
    public $namaMahasiswa;
    public $namaProdi;
    public $namaKampus;
    public $kode_prodi;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_skpi_permohonan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['tanggal_pengajuan', 'updated_at', 'created_at','deskripsi','deskripsi_en','approved_by'], 'safe'],
            [['id', 'link_barcode'], 'string', 'max' => 255],
            [['nim'], 'string', 'max' => 25],
            [['nomor_skpi'], 'string', 'max' => 50],
            [['status_pengajuan'], 'string', 'max' => 1],
            [['id'], 'unique'],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::class, 'targetAttribute' => ['nim' => 'nim_mhs']],
            [['approved_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['approved_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nim' => 'NIM',
            'nomor_skpi' => 'Nomor SKPI',
            'link_barcode' => 'Link Barcode',
            'status_pengajuan' => 'Status Pengajuan',
            'tanggal_pengajuan' => 'Tanggal Pengajuan',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'deskripsi' => Yii::t('app', 'Deskripsi'),
            'deskripsi_en' => Yii::t('app', 'Description'),
            'namaProdi' => Yii::t('app', 'Program Studi'),
            'namaKampus' => Yii::t('app', 'Kelas'),
            'kode_prodi' => Yii::t('app', 'Prodi'),
        ];
    }

    public function getApprovedBy()
    {
        return $this->hasOne(User::class, ['id' => 'approved_by']);
    }

    /**
     * Gets query for [[Nim0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNim0()
    {
        return $this->hasOne(SimakMastermahasiswa::class, ['nim_mhs' => 'nim']);
    }
}
