<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_layanan_surat".
 *
 * @property string $id
 * @property int $jenis_surat
 * @property string|null $nim
 * @property int|null $tahun_id
 * @property string|null $keperluan
 * @property string|null $bahasa
 * @property string|null $tanggal_diajukan
 * @property string|null $tanggal_disetujui
 * @property string|null $nomor_surat
 * @property string|null $nama_pejabat
 * @property string|null $status_ajuan
 * @property string|null $updated_at
 * @property string|null $created_at
 *
 * @property SimakMastermahasiswa $nim0
 * @property SimakTahunakademik $tahun
 */
class SimakLayananSurat extends \yii\db\ActiveRecord
{

    public $namaMahasiswa;
    public $namaProdi;
    public $namaKampus;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_layanan_surat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jenis_surat','nim','tahun_id','keperluan'], 'required'],
            [['jenis_surat', 'tahun_id'], 'integer'],
            [['keperluan'], 'string'],
            [['tanggal_diajukan', 'tanggal_disetujui', 'updated_at', 'created_at','nip'], 'safe'],
            [['id', 'nama_pejabat'], 'string', 'max' => 255],
            [['nim'], 'string', 'max' => 25],
            [['bahasa'], 'string', 'max' => 10],
            [['nomor_surat'], 'string', 'max' => 100],
            [['status_ajuan'], 'string', 'max' => 1],
            [['id'], 'unique'],
            // [['jenis_surat', 'nim','tahun_id'], 'unique', 'targetAttribute' => ['jenis_surat', 'nim','tahun_id']],
            [['tahun_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakTahunakademik::className(), 'targetAttribute' => ['tahun_id' => 'id']],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::className(), 'targetAttribute' => ['nim' => 'nim_mhs']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'jenis_surat' => Yii::t('app', 'Jenis Surat'),
            'nim' => Yii::t('app', 'NIM'),
            'nip' => Yii::t('app', 'NIY'),
            'tahun_id' => Yii::t('app', 'Periode'),
            'keperluan' => Yii::t('app', 'Keperluan'),
            'bahasa' => Yii::t('app', 'Bahasa'),
            'namaProdi' => Yii::t('app', 'Program Studi'),
            'namaKampus' => Yii::t('app', 'Kelas'),
            'tanggal_diajukan' => Yii::t('app', 'Tanggal Diajukan'),
            'tanggal_disetujui' => Yii::t('app', 'Tanggal Disetujui'),
            'nomor_surat' => Yii::t('app', 'Nomor Surat'),
            'nama_pejabat' => Yii::t('app', 'Nama Pejabat'),
            'status_ajuan' => Yii::t('app', 'Status Ajuan'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
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
     * Gets query for [[Tahun]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTahun()
    {
        return $this->hasOne(SimakTahunakademik::className(), ['id' => 'tahun_id']);
    }
}
