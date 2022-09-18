<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_mahasiswa_lulus_do".
 *
 * @property string $id
 * @property int $mhs_id
 * @property string|null $id_mahasiswa kode feeder mhs
 * @property string|null $id_registrasi_mahasiswa kode registrasi mhs dari history pendidikan
 * @property int|null $pilihan_id
 * @property string|null $tanggal_keluar
 * @property int|null $periode_keluar tahun akademik mengikuti kalender luar
 * @property string|null $tanggal_sk
 * @property string|null $nomor_sk nomor sk yudisium/keluar
 * @property float|null $ipk
 * @property string|null $nomor_ijazah
 * @property string|null $keterangan
 * @property string|null $file_sk
 * @property string|null $status_sinkron 0=belum sinkron,1=sudah sinkron
 * @property string|null $data_source
 * @property string|null $updated_at
 * @property string|null $created_at
 *
 * @property SimakMastermahasiswa $mhs
 * @property SimakPilihan $pilihan
 */
class SimakMahasiswaLulusDo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_mahasiswa_lulus_do';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'mhs_id'], 'required'],
            [['mhs_id', 'pilihan_id', 'periode_keluar'], 'integer'],
            [['tanggal_keluar', 'tanggal_sk', 'updated_at', 'created_at'], 'safe'],
            [['ipk'], 'number'],
            [['keterangan'], 'string'],
            [['id', 'id_mahasiswa', 'id_registrasi_mahasiswa', 'nomor_sk'], 'string', 'max' => 50],
            [['nomor_ijazah', 'data_source'], 'string', 'max' => 100],
            [['file_sk'], 'string', 'max' => 500],
            [['status_sinkron'], 'string', 'max' => 1],
            [['id_registrasi_mahasiswa'], 'unique'],
            [['id'], 'unique'],
            [['mhs_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::class, 'targetAttribute' => ['mhs_id' => 'id']],
            [['pilihan_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakPilihan::class, 'targetAttribute' => ['pilihan_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mhs_id' => 'Mhs',
            'id_mahasiswa' => 'Id Mahasiswa',
            'id_registrasi_mahasiswa' => 'Id Registrasi Mahasiswa',
            'pilihan_id' => 'Pilihan ID',
            'tanggal_keluar' => 'Tanggal Keluar',
            'periode_keluar' => 'Periode Keluar',
            'tanggal_sk' => 'Tanggal Sk',
            'nomor_sk' => 'Nomor Sk',
            'ipk' => 'Ipk',
            'nomor_ijazah' => 'Nomor Ijazah',
            'keterangan' => 'Keterangan',
            'file_sk' => 'File Sk',
            'status_sinkron' => 'Status Sinkron',
            'data_source' => 'Data Source',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Mhs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMhs()
    {
        return $this->hasOne(SimakMastermahasiswa::class, ['id' => 'mhs_id']);
    }

    /**
     * Gets query for [[Pilihan]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPilihan()
    {
        return $this->hasOne(SimakPilihan::class, ['id' => 'pilihan_id']);
    }
}
