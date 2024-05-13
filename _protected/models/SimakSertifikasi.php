<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_sertifikasi".
 *
 * @property string $id
 * @property string $nim
 * @property string $jenis_sertifikasi
 * @property string $lembaga_sertifikasi
 * @property string $nomor_registrasi_sertifikasi
 * @property string|null $nomor_sk_sertifikasi
 * @property int $tahun_sertifikasi
 * @property string $tmt_sertifikasi
 * @property string|null $tst_sertifikasi
 * @property string|null $file_path
 * @property string $status_validasi
 * @property int|null $approved_by
 * @property string|null $catatan
 * @property string $updated_at
 * @property string $created_at
 *
 * @property SimakUsers $approvedBy
 * @property SimakMastermahasiswa $nim0
 */
class SimakSertifikasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_sertifikasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nim', 'jenis_sertifikasi', 'lembaga_sertifikasi', 'nomor_registrasi_sertifikasi', 'tahun_sertifikasi', 'tmt_sertifikasi'], 'required'],
            [['tahun_sertifikasi', 'approved_by'], 'integer'],
            [['tmt_sertifikasi', 'tst_sertifikasi', 'updated_at', 'created_at'], 'safe'],
            [['catatan'], 'string'],
            [['id', 'lembaga_sertifikasi', 'nomor_registrasi_sertifikasi', 'nomor_sk_sertifikasi'], 'string', 'max' => 255],
            [['nim'], 'string', 'max' => 25],
            [['jenis_sertifikasi', 'status_validasi'], 'string', 'max' => 1],
            [['file_path'], 'string', 'max' => 500],
            [['id'], 'unique'],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::class, 'targetAttribute' => ['nim' => 'nim_mhs']],
            [['approved_by'], 'exist', 'skipOnError' => true, 'targetClass' => SimakUsers::class, 'targetAttribute' => ['approved_by' => 'id']],
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
            'jenis_sertifikasi' => 'Jenis Sertifikasi',
            'lembaga_sertifikasi' => 'Lembaga Sertifikasi',
            'nomor_registrasi_sertifikasi' => 'Nomor Registrasi Sertifikasi',
            'nomor_sk_sertifikasi' => 'Nomor Sk Sertifikasi',
            'tahun_sertifikasi' => 'Tahun Sertifikasi',
            'tmt_sertifikasi' => 'Tmt Sertifikasi',
            'tst_sertifikasi' => 'Tst Sertifikasi',
            'file_path' => 'File Path',
            'status_validasi' => 'Status Validasi',
            'approved_by' => 'Approved By',
            'catatan' => 'Catatan',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[ApprovedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApprovedBy()
    {
        return $this->hasOne(SimakUsers::class, ['id' => 'approved_by']);
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
