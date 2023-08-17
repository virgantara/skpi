<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_simkatmawa_mbkm".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $jenis_simkatmawa
 * @property string $nama_program
 * @property string $tempat_pelaksanaan
 * @property string|null $tanggal_mulai
 * @property string|null $tanggal_selesai
 * @property string|null $penyelenggara
 * @property int|null $level
 * @property string|null $judul_penelitian
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
 * @property int|null $prodi_id
 *
 * @property SimakMasterprogramstudi $prodi
 * @property SimkatmawaMahasiswa[] $simkatmawaMahasiswas
 * @property User $user
 */
class SimkatmawaMbkm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_simkatmawa_mbkm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'level', 'status_sks', 'hasil_jenis', 'rekognisi_id', 'kategori_pembinaan_id', 'kategori_belmawa_id', 'prodi_id'], 'integer'],
            [['nama_program', 'tempat_pelaksanaan'], 'required'],
            [['tanggal_mulai', 'tanggal_selesai', 'created_at', 'updated_at'], 'safe'],
            [['jenis_simkatmawa'], 'string', 'max' => 150],
            [['nama_program', 'tempat_pelaksanaan', 'penyelenggara', 'judul_penelitian', 'sk_penerimaan_path', 'surat_tugas_path', 'rekomendasi_path', 'khs_pt_path', 'sertifikat_path', 'laporan_path', 'hasil_path', 'url_berita', 'foto_penyerahan_path', 'foto_kegiatan_path', 'foto_karya_path'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['prodi_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMasterprogramstudi::class, 'targetAttribute' => ['prodi_id' => 'id']], 
            [['sertifikat_path', 'sk_penerimaan_path', 'rekomendasi_path', 'khs_pt_path', 'foto_penyerahan_path', 'foto_kegiatan_path', 'foto_karya_path', 'surat_tugas_path', 'laporan_path', 'hasil_path'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 1024 * 1024 * 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'jenis_simkatmawa' => Yii::t('app', 'Jenis Simkatmawa'),
            'nama_program' => Yii::t('app', 'Nama Program'),
            'tempat_pelaksanaan' => Yii::t('app', 'Tempat Pelaksanaan'),
            'tanggal_mulai' => Yii::t('app', 'Tanggal Mulai'),
            'tanggal_selesai' => Yii::t('app', 'Tanggal Selesai'),
            'penyelenggara' => Yii::t('app', 'Penyelenggara'),
            'level' => Yii::t('app', 'Level'),
            'judul_penelitian' => Yii::t('app', 'Judul Penelitian'),
            'status_sks' => Yii::t('app', 'Status Sks'),
            'sk_penerimaan_path' => Yii::t('app', 'Sk Penerimaan Path'),
            'surat_tugas_path' => Yii::t('app', 'Surat Tugas Path'),
            'rekomendasi_path' => Yii::t('app', 'Rekomendasi Path'),
            'khs_pt_path' => Yii::t('app', 'Khs Pt Path'),
            'sertifikat_path' => Yii::t('app', 'Sertifikat Path'),
            'laporan_path' => Yii::t('app', 'Laporan Path'),
            'hasil_path' => Yii::t('app', 'Hasil Path'),
            'hasil_jenis' => Yii::t('app', 'Hasil Jenis'),
            'rekognisi_id' => Yii::t('app', 'Rekognisi ID'),
            'kategori_pembinaan_id' => Yii::t('app', 'Kategori Pembinaan ID'),
            'kategori_belmawa_id' => Yii::t('app', 'Kategori Belmawa ID'),
            'url_berita' => Yii::t('app', 'Url Berita'),
            'foto_penyerahan_path' => Yii::t('app', 'Foto Penyerahan Path'),
            'foto_kegiatan_path' => Yii::t('app', 'Foto Kegiatan Path'),
            'foto_karya_path' => Yii::t('app', 'Foto Karya Path'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'prodi_id' => Yii::t('app', 'Prodi ID'),
        ];
    }

    /**
     * Gets query for [[Prodi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdi()
    {
        return $this->hasOne(SimakMasterprogramstudi::class, ['id' => 'prodi_id']);
    }

    /**
     * Gets query for [[SimkatmawaMahasiswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimkatmawaMahasiswas()
    {
        return $this->hasMany(SimkatmawaMahasiswa::class, ['simkatmawa_mbkm_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
