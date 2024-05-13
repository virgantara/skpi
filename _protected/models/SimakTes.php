<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_tes".
 *
 * @property string $id
 * @property string $nim
 * @property string $jenis_tes
 * @property string $nama_tes
 * @property string $penyelenggara
 * @property string $tanggal_tes
 * @property int $tahun
 * @property float $skor_tes
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
class SimakTes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_tes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nim', 'jenis_tes', 'nama_tes', 'penyelenggara', 'tanggal_tes', 'tahun', 'skor_tes'], 'required'],
            [['tahun', 'approved_by'], 'integer'],
            [['skor_tes'], 'number'],
            [['catatan'], 'string'],
            [['updated_at', 'created_at'], 'safe'],
            [['id', 'nama_tes', 'penyelenggara', 'tanggal_tes'], 'string', 'max' => 255],
            [['nim'], 'string', 'max' => 25],
            [['jenis_tes', 'status_validasi'], 'string', 'max' => 1],
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
            'jenis_tes' => 'Jenis Tes',
            'nama_tes' => 'Nama Tes',
            'penyelenggara' => 'Penyelenggara',
            'tanggal_tes' => 'Tanggal Tes',
            'tahun' => 'Tahun',
            'skor_tes' => 'Skor Tes',
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
