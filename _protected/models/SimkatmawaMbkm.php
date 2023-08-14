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
 *
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
            [['user_id', 'level', 'status_sks', 'hasil_jenis', 'rekognisi_id', 'kategori_pembinaan_id', 'kategori_belmawa_id'], 'integer'],
            [['nama_program', 'tempat_pelaksanaan'], 'required'],
            [['tanggal_mulai', 'tanggal_selesai', 'created_at', 'updated_at'], 'safe'],
            [['jenis_simkatmawa'], 'string', 'max' => 150],
            [['nama_program', 'tempat_pelaksanaan', 'penyelenggara', 'judul_penelitian', 'sk_penerimaan_path', 'surat_tugas_path', 'rekomendasi_path', 'khs_pt_path', 'sertifikat_path', 'laporan_path', 'hasil_path', 'url_berita', 'foto_penyerahan_path', 'foto_kegiatan_path', 'foto_karya_path'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'jenis_simkatmawa' => 'Jenis Simkatmawa',
            'nama_program' => 'Nama Program',
            'tempat_pelaksanaan' => 'Tempat Pelaksanaan',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'penyelenggara' => 'Penyelenggara',
            'level' => 'Level',
            'judul_penelitian' => 'Judul Penelitian',
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
