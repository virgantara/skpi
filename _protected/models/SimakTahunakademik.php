<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_tahunakademik".
 *
 * @property int $id
 * @property string $tahun_id
 * @property string $tahun
 * @property int|null $hijriyah
 * @property int|null $semester
 * @property string $nama_tahun
 * @property string|null $krs_mulai
 * @property string|null $krs_selesai
 * @property string|null $krs_online_mulai
 * @property string|null $krs_online_selesai
 * @property string|null $krs_ubah_mulai
 * @property string|null $krs_ubah_selesai
 * @property string|null $kss_cetak_mulai
 * @property string|null $kss_cetak_selesai
 * @property string|null $cuti
 * @property string|null $mundur
 * @property string|null $bayar_mulai
 * @property string|null $bayar_selesai
 * @property string|null $kuliah_mulai
 * @property string|null $kuliah_selesai
 * @property string|null $uts_mulai
 * @property string|null $uts_selesai
 * @property string|null $uas_mulai
 * @property string|null $uas_selesai
 * @property string|null $ekd_mulai
 * @property string|null $ekd_selesai
 * @property string|null $akpam_mulai
 * @property string|null $akpam_selesai
 * @property float|null $nilai_lulus_akpam
 * @property string|null $nilai_mulai
 * @property string|null $nilai_selesai
 * @property string|null $nilai
 * @property string|null $akhir_kss
 * @property int $proses_buka
 * @property int $proses_ipk
 * @property int $proses_tutup
 * @property string $buka
 * @property string $syarat_krs
 * @property string $syarat_krs_ips
 * @property string|null $cuti_selesai
 * @property int $max_sks
 * @property float|null $bobot_hafalan
 * @property float|null $bobot_kelancaran
 * @property float|null $bobot_makhroj
 * @property float|null $bobot_tajwid
 * @property float|null $nilai_lulus_tahfidz
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property SimakKurikulum[] $simakKurikulums
 * @property SimakPencekalan[] $simakPencekalans
 * @property SimakTahfidzNilai[] $simakTahfidzNilais
 * @property SimakTahfidzPeriode[] $simakTahfidzPeriodes
 */
class SimakTahunakademik extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_tahunakademik';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hijriyah', 'semester', 'proses_buka', 'proses_ipk', 'proses_tutup', 'max_sks'], 'integer'],
            [['nama_tahun'], 'required'],
            [['krs_mulai', 'krs_selesai', 'krs_online_mulai', 'krs_online_selesai', 'krs_ubah_mulai', 'krs_ubah_selesai', 'kss_cetak_mulai', 'kss_cetak_selesai', 'cuti', 'mundur', 'bayar_mulai', 'bayar_selesai', 'kuliah_mulai', 'kuliah_selesai', 'uts_mulai', 'uts_selesai', 'uas_mulai', 'uas_selesai', 'ekd_mulai', 'ekd_selesai', 'akpam_mulai', 'akpam_selesai', 'nilai_mulai', 'nilai_selesai', 'nilai', 'akhir_kss', 'cuti_selesai', 'created_at', 'updated_at'], 'safe'],
            [['nilai_lulus_akpam', 'bobot_hafalan', 'bobot_kelancaran', 'bobot_makhroj', 'bobot_tajwid', 'nilai_lulus_tahfidz'], 'number'],
            [['tahun_id'], 'string', 'max' => 5],
            [['tahun'], 'string', 'max' => 4],
            [['nama_tahun'], 'string', 'max' => 50],
            [['buka', 'syarat_krs', 'syarat_krs_ips'], 'string', 'max' => 10],
            [['tahun_id'], 'unique'],
            [['tahun', 'semester'], 'unique', 'targetAttribute' => ['tahun', 'semester']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahun_id' => 'Tahun ID',
            'tahun' => 'Tahun',
            'hijriyah' => 'Hijriyah',
            'semester' => 'Semester',
            'nama_tahun' => 'Nama Tahun',
            'krs_mulai' => 'Krs Mulai',
            'krs_selesai' => 'Krs Selesai',
            'krs_online_mulai' => 'Krs Online Mulai',
            'krs_online_selesai' => 'Krs Online Selesai',
            'krs_ubah_mulai' => 'Krs Ubah Mulai',
            'krs_ubah_selesai' => 'Krs Ubah Selesai',
            'kss_cetak_mulai' => 'Kss Cetak Mulai',
            'kss_cetak_selesai' => 'Kss Cetak Selesai',
            'cuti' => 'Cuti',
            'mundur' => 'Mundur',
            'bayar_mulai' => 'Bayar Mulai',
            'bayar_selesai' => 'Bayar Selesai',
            'kuliah_mulai' => 'Kuliah Mulai',
            'kuliah_selesai' => 'Kuliah Selesai',
            'uts_mulai' => 'Uts Mulai',
            'uts_selesai' => 'Uts Selesai',
            'uas_mulai' => 'Uas Mulai',
            'uas_selesai' => 'Uas Selesai',
            'ekd_mulai' => 'Ekd Mulai',
            'ekd_selesai' => 'Ekd Selesai',
            'akpam_mulai' => 'Akpam Mulai',
            'akpam_selesai' => 'Akpam Selesai',
            'nilai_lulus_akpam' => 'Nilai Lulus Akpam',
            'nilai_mulai' => 'Nilai Mulai',
            'nilai_selesai' => 'Nilai Selesai',
            'nilai' => 'Nilai',
            'akhir_kss' => 'Akhir Kss',
            'proses_buka' => 'Proses Buka',
            'proses_ipk' => 'Proses Ipk',
            'proses_tutup' => 'Proses Tutup',
            'buka' => 'Buka',
            'syarat_krs' => 'Syarat Krs',
            'syarat_krs_ips' => 'Syarat Krs Ips',
            'cuti_selesai' => 'Cuti Selesai',
            'max_sks' => 'Max Sks',
            'bobot_hafalan' => 'Bobot Hafalan',
            'bobot_kelancaran' => 'Bobot Kelancaran',
            'bobot_makhroj' => 'Bobot Makhroj',
            'bobot_tajwid' => 'Bobot Tajwid',
            'nilai_lulus_tahfidz' => 'Nilai Lulus Tahfidz',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[SimakKurikulums]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakKurikulums()
    {
        return $this->hasMany(SimakKurikulum::className(), ['tahun_id' => 'tahun_id']);
    }

    /**
     * Gets query for [[SimakPencekalans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakPencekalans()
    {
        return $this->hasMany(SimakPencekalan::className(), ['tahun_id' => 'tahun_id']);
    }

    /**
     * Gets query for [[SimakTahfidzNilais]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakTahfidzNilais()
    {
        return $this->hasMany(SimakTahfidzNilai::className(), ['tahun_id' => 'tahun_id']);
    }

    /**
     * Gets query for [[SimakTahfidzPeriodes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakTahfidzPeriodes()
    {
        return $this->hasMany(SimakTahfidzPeriode::className(), ['tahun_id' => 'tahun_id']);
    }

    public static function getTahunAktif()
    {
        $model = SimakTahunakademik::find()->where(['buka' => 'Y'])->one();

        return !empty($model) ? $model : null;
    }

    public static function getList()
    {
        $model = SimakTahunakademik::find()->orderBy(['tahun_id'=>SORT_DESC])->all();

        return $model;
    }    
}
