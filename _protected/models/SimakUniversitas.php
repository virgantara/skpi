<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_universitas".
 *
 * @property int $id
 * @property int $rektor
 * @property string|null $alamat
 * @property string|null $telepon
 * @property string|null $fax
 * @property string|null $website
 * @property string|null $email
 * @property string|null $sk_rektor
 * @property string|null $tgl_sk_rektor
 * @property string|null $periode
 * @property string|null $status_aktif
 * @property string|null $catatan_resmi
 * @property string|null $catatan_resmi_en
 * @property string|null $deskripsi_skpi
 * @property string|null $deskripsi_skpi_en
 * @property string|null $nama_institusi
 * @property string|null $nama_institusi_en
 * @property string|null $sk_pendirian
 * @property string|null $tanggal_sk_pendirian
 * @property string|null $peringkat_akreditasi
 * @property string|null $nomor_sertifikat_akreditasi
 * @property string|null $lembaga_akreditasi
 * @property string|null $persyaratan_penerimaan
 * @property string|null $persyaratan_penerimaan_en
 * @property string|null $sistem_penilaian
 * @property string|null $sistem_penilaian_en
 *
 * @property SimakMasterdosen $rektor0
 */
class SimakUniversitas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_universitas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rektor'], 'required'],
            [['rektor'], 'integer'],
            [['tgl_sk_rektor', 'tanggal_sk_pendirian'], 'safe'],
            [['catatan_resmi', 'catatan_resmi_en', 'deskripsi_skpi', 'deskripsi_skpi_en', 'persyaratan_penerimaan', 'persyaratan_penerimaan_en', 'sistem_penilaian', 'sistem_penilaian_en'], 'string'],
            [['alamat', 'sk_rektor', 'periode', 'nama_institusi', 'nama_institusi_en', 'nomor_sertifikat_akreditasi'], 'string', 'max' => 255],
            [['telepon', 'fax', 'website'], 'string', 'max' => 50],
            [['email', 'sk_pendirian', 'peringkat_akreditasi', 'lembaga_akreditasi'], 'string', 'max' => 100],
            [['status_aktif'], 'string', 'max' => 1],
            [['rektor'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMasterdosen::class, 'targetAttribute' => ['rektor' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rektor' => 'Rektor',
            'alamat' => 'Alamat',
            'telepon' => 'Telepon',
            'fax' => 'Fax',
            'website' => 'Website',
            'email' => 'Email',
            'sk_rektor' => 'Sk Rektor',
            'tgl_sk_rektor' => 'Tgl Sk Rektor',
            'periode' => 'Periode',
            'status_aktif' => 'Status Aktif',
            'catatan_resmi' => 'Catatan Resmi',
            'catatan_resmi_en' => 'Catatan Resmi En',
            'deskripsi_skpi' => 'Deskripsi Skpi',
            'deskripsi_skpi_en' => 'Deskripsi Skpi En',
            'nama_institusi' => 'Nama Institusi',
            'nama_institusi_en' => 'Nama Institusi En',
            'sk_pendirian' => 'Sk Pendirian',
            'tanggal_sk_pendirian' => 'Tanggal Sk Pendirian',
            'peringkat_akreditasi' => 'Peringkat Akreditasi',
            'nomor_sertifikat_akreditasi' => 'Nomor Sertifikat Akreditasi',
            'lembaga_akreditasi' => 'Lembaga Akreditasi',
            'persyaratan_penerimaan' => 'Persyaratan Penerimaan',
            'persyaratan_penerimaan_en' => 'Persyaratan Penerimaan En',
            'sistem_penilaian' => 'Sistem Penilaian',
            'sistem_penilaian_en' => 'Sistem Penilaian En',
        ];
    }

    /**
     * Gets query for [[Rektor0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRektor0()
    {
        return $this->hasOne(SimakMasterdosen::class, ['id' => 'rektor']);
    }
}
