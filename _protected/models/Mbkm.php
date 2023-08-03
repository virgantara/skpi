<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_mbkm".
 *
 * @property int $id
 * @property string $nim
 * @property int $mbkm_jenis_id
 * @property string $nama_program
 * @property string $tempat_pelaksanaan
 * @property string|null $tanggal_mulai
 * @property string|null $tanggal_selesai
 * @property string|null $penyelenggara
 * @property int|null $level
 * @property int|null $apresiasi
 * @property int|null $status_sks
 * @property string|null $sk_penerimaan_path
 * @property string|null $surat_tugas_path
 * @property string|null $rekomendasi_path
 * @property string|null $khs_pt_path
 * @property string|null $sertifikat_path
 * @property string|null $laporan_path
 * @property string|null $hasil_path
 * @property int|null $hasil_jenis
 * @property int|null $rekognisi_id
 * @property int|null $kategori_pembinaan_id
 * @property int|null $kategori_belmawa_id
 * @property string|null $url_berita
 * @property string|null $foto_penyerahan_path
 * @property string|null $foto_kegiatan_path
 * @property string|null $foto_karya_path
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property KategoriBelmawa $kategoriBelmawa
 * @property MbkmJenis $mbkmJenis
 * @property SimakMastermahasiswa $nim0
 */
class Mbkm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_mbkm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nim', 'mbkm_jenis_id', 'nama_program', 'tempat_pelaksanaan'], 'required'],
            [['mbkm_jenis_id', 'level', 'apresiasi', 'status_sks', 'hasil_jenis', 'rekognisi_id', 'kategori_pembinaan_id', 'kategori_belmawa_id'], 'integer'],
            [['tanggal_mulai', 'tanggal_selesai', 'created_at', 'updated_at'], 'safe'],
            [['nim'], 'string', 'max' => 25],
            [['nama_program', 'tempat_pelaksanaan', 'penyelenggara', 'sk_penerimaan_path', 'surat_tugas_path', 'rekomendasi_path', 'khs_pt_path', 'sertifikat_path', 'laporan_path', 'hasil_path', 'url_berita', 'foto_penyerahan_path', 'foto_kegiatan_path', 'foto_karya_path'], 'string', 'max' => 255],
            [['kategori_belmawa_id'], 'exist', 'skipOnError' => true, 'targetClass' => KategoriBelmawa::class, 'targetAttribute' => ['kategori_belmawa_id' => 'id']],
            [['mbkm_jenis_id'], 'exist', 'skipOnError' => true, 'targetClass' => MbkmJenis::class, 'targetAttribute' => ['mbkm_jenis_id' => 'id']],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::class, 'targetAttribute' => ['nim' => 'nim_mhs']],
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
            'mbkm_jenis_id' => 'Mbkm Jenis ID',
            'nama_program' => 'Nama Program',
            'tempat_pelaksanaan' => 'Tempat Pelaksanaan',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'penyelenggara' => 'Penyelenggara',
            'level' => 'Level',
            'apresiasi' => 'Apresiasi',
            'status_sks' => 'Status Sks',
            'sk_penerimaan_path' => 'Sk Penerimaan Path',
            'surat_tugas_path' => 'Surat Tugas Path',
            'rekomendasi_path' => 'Rekomendasi Path',
            'khs_pt_path' => 'Khs Pt Path',
            'sertifikat_path' => 'Sertifikat Path',
            'laporan_path' => 'Laporan Path',
            'hasil_path' => 'Hasil Path',
            'hasil_jenis' => 'Hasil Jenis',
            'rekognisi_id' => 'Rekognisi ID',
            'kategori_pembinaan_id' => 'Kategori Pembinaan ID',
            'kategori_belmawa_id' => 'Kategori Belmawa ID',
            'url_berita' => 'Url Berita',
            'foto_penyerahan_path' => 'Foto Penyerahan Path',
            'foto_kegiatan_path' => 'Foto Kegiatan Path',
            'foto_karya_path' => 'Foto Karya Path',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[KategoriBelmawa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKategoriBelmawa()
    {
        return $this->hasOne(KategoriBelmawa::class, ['id' => 'kategori_belmawa_id']);
    }

    /**
     * Gets query for [[MbkmJenis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMbkmJenis()
    {
        return $this->hasOne(MbkmJenis::class, ['id' => 'mbkm_jenis_id']);
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
