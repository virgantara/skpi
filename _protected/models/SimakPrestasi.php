<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_prestasi".
 *
 * @property string $id
 * @property string|null $nim
 * @property int|null $kegiatan_id
 * @property string $status_validasi
 * @property int|null $approved_by
 * @property string|null $updated_at
 * @property string|null $created_at
 *
 * @property SimakKegiatanMahasiswa $kegiatan
 * @property SimakMastermahasiswa $nim0
 */
class SimakPrestasi extends \yii\db\ActiveRecord
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
        return 'simak_prestasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['kegiatan_id', 'approved_by'], 'integer'],
            [['updated_at', 'created_at','catatan'], 'safe'],
            [['id'], 'string', 'max' => 255],
            [['nim'], 'string', 'max' => 25],
            [['status_validasi'], 'string', 'max' => 1],
            [['id'], 'unique'],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::class, 'targetAttribute' => ['nim' => 'nim_mhs']],
            [['kegiatan_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakKegiatanMahasiswa::class, 'targetAttribute' => ['kegiatan_id' => 'id']],
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
            'nim' => 'Nim',
            'kegiatan_id' => 'Kegiatan ID',
            'status_validasi' => 'Status Validasi',
            'approved_by' => 'Approved By',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    public function getApprovedBy()
    {
        return $this->hasOne(User::class, ['id' => 'approved_by']);
    }

    /**
     * Gets query for [[Kegiatan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKegiatan()
    {
        return $this->hasOne(SimakKegiatanMahasiswa::class, ['id' => 'kegiatan_id']);
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
