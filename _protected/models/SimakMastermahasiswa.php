<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_mastermahasiswa".
 *
 * @property int $id
 * @property string|null $kode_pt
 * @property string|null $kode_fakultas
 * @property string|null $kode_prodi
 * @property string|null $kode_jenjang_studi
 * @property string $nim_mhs
 * @property string $nama_mahasiswa
 * @property string|null $tempat_lahir
 * @property string|null $tgl_lahir
 * @property string|null $jenis_kelamin
 * @property string|null $tahun_masuk
 * @property string|null $semester_awal
 * @property string|null $batas_studi
 * @property string|null $asal_propinsi
 * @property string|null $tgl_masuk
 * @property string|null $tgl_lulus
 * @property string|null $status_aktivitas
 * @property string|null $status_awal
 * @property string|null $jml_sks_diakui
 * @property string|null $nim_asal
 * @property string|null $asal_pt
 * @property string|null $nama_asal_pt
 * @property string|null $asal_jenjang_studi
 * @property string|null $asal_prodi
 * @property string|null $kode_biaya_studi
 * @property string|null $kode_pekerjaan
 * @property string|null $tempat_kerja
 * @property string|null $kode_pt_kerja
 * @property string|null $kode_ps_kerja
 * @property string|null $nip_promotor
 * @property string|null $nip_co_promotor1
 * @property string|null $nip_co_promotor2
 * @property string|null $nip_co_promotor3
 * @property string|null $nip_co_promotor4
 * @property string|null $photo_mahasiswa
 * @property string|null $semester
 * @property string|null $keterangan
 * @property int|null $status_bayar
 * @property string|null $telepon
 * @property string|null $hp
 * @property string|null $email
 * @property string|null $alamat
 * @property string|null $berat
 * @property string|null $tinggi
 * @property string|null $ktp
 * @property string|null $rt
 * @property string|null $rw
 * @property string|null $dusun
 * @property string|null $kode_pos
 * @property string|null $desa
 * @property string|null $kecamatan
 * @property string|null $kecamatan_feeder
 * @property string|null $jenis_tinggal
 * @property string|null $penerima_kps
 * @property string|null $no_kps
 * @property string|null $provinsi
 * @property string|null $kabupaten
 * @property string|null $status_warga
 * @property string|null $warga_negara
 * @property string|null $warga_negara_feeder
 * @property string|null $status_sipil
 * @property string|null $agama
 * @property string|null $gol_darah
 * @property string|null $masuk_kelas
 * @property string|null $tgl_sk_yudisium
 * @property string|null $no_ijazah
 * @property int|null $status_mahasiswa 1 Reguler, 2 Intensif
 * @property string|null $kampus
 * @property string|null $jur_thn_smta
 * @property int|null $is_synced
 * @property string|null $kode_pd
 * @property string|null $va_code
 * @property int|null $kamar_id
 * @property int|null $is_eligible
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property BillTagihan[] $billTagihans
 * @property BillTransaksi[] $billTransaksis
 * @property RiwayatPelanggaran[] $riwayatPelanggarans
 * @property SimakMahasiswaOrtu[] $simakMahasiswaOrtus
 * @property SimakMahasiswaProgramTambahan[] $simakMahasiswaProgramTambahans
 * @property SimakMasterprogramstudi $kodeProdi
 * @property Kamar $kamar
 * @property SimakKampus $kampus0
 * @property SimakPencekalan[] $simakPencekalans
 * @property SimakTahfidzKelompokAnggotum[] $simakTahfidzKelompokAnggota
 * @property SimakTahfidzNilai[] $simakTahfidzNilais
 */
class SimakMastermahasiswa extends \yii\db\ActiveRecord
{

    public $states_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_mastermahasiswa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nim_mhs', 'nama_mahasiswa'], 'required'],
            [['tgl_lahir', 'tgl_masuk', 'tgl_lulus', 'tgl_sk_yudisium', 'created_at', 'updated_at','no_sk_yudisium','konsulat','dapur_id','rfid','foto_path'], 'safe'],
            [['keterangan'], 'string'],
            [['status_bayar', 'status_mahasiswa', 'is_synced', 'kamar_id', 'is_eligible'], 'integer'],
            [['kode_pt', 'asal_prodi', 'kode_pos'], 'string', 'max' => 6],
            [['kode_fakultas', 'kode_prodi', 'kode_jenjang_studi', 'jenis_kelamin', 'semester_awal', 'batas_studi', 'status_awal', 'asal_jenjang_studi', 'rt', 'rw'], 'string', 'max' => 5],
            [['nim_mhs', 'nama_asal_pt', 'telepon', 'hp'], 'string', 'max' => 25],
            [['nama_mahasiswa', 'dusun', 'desa', 'kecamatan', 'warga_negara', 'status_sipil', 'jur_thn_smta', 'kode_pd'], 'string', 'max' => 100],
            [['tempat_lahir', 'asal_propinsi', 'status_aktivitas', 'status_warga'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
            [['rfid'], 'unique','message' => 'RFID ini sudah digunakan'],
            [['jml_sks_diakui'], 'number'],
            [['nim_asal', 'kode_biaya_studi', 'kode_pekerjaan', 'tempat_kerja', 'kode_pt_kerja'], 'string', 'max' => 55],
            [['asal_pt', 'ktp'], 'string', 'max' => 30],
            [['nip_co_promotor1'], 'number'],
            [['nip_co_promotor2'], 'number'],
            [['nip_co_promotor3'], 'number'],
            [['photo_mahasiswa', 'alamat', 'kecamatan_feeder', 'kabupaten', 'warga_negara_feeder', 'no_ijazah','no_sk_yudisium'], 'string', 'max' => 255],
            [['berat', 'tinggi'], 'string', 'max' => 3],
            [['jenis_tinggal', 'no_kps', 'agama', 'va_code'], 'string', 'max' => 20],
            [['penerima_kps', 'masuk_kelas'], 'string', 'max' => 1],
            [['gol_darah', 'kampus'], 'string', 'max' => 2],
            [['nim_mhs'], 'unique'],
            [['kode_prodi'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMasterprogramstudi::className(), 'targetAttribute' => ['kode_prodi' => 'kode_prodi']],
            [['kamar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kamar::className(), 'targetAttribute' => ['kamar_id' => 'id']],
            [['dapur_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dapur::className(), 'targetAttribute' => ['dapur_id' => 'id']],
            [['kampus'], 'exist', 'skipOnError' => true, 'targetClass' => SimakKampus::className(), 'targetAttribute' => ['kampus' => 'kode_kampus']],
            [['kode_fakultas'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMasterfakultas::className(), 'targetAttribute' => ['kode_fakultas' => 'kode_fakultas']],
            [['konsulat'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['konsulat' => 'id']],
            [['koordinator_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakKampusKoordinator::class, 'targetAttribute' => ['koordinator_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_pt' => 'Kode Pt',
            'kode_fakultas' => 'Kode Fakultas',
            'kode_prodi' => 'Kode Prodi',
            'kode_jenjang_studi' => 'Kode Jenjang Studi',
            'nim_mhs' => 'NIM',
            'nama_mahasiswa' => 'Nama Mahasiswa',
            'tempat_lahir' => 'Tempat Lahir',
            'tgl_lahir' => 'Tgl Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'tahun_masuk' => 'Tahun Masuk',
            'semester_awal' => 'Semester Awal',
            'koordinator_id' => 'Koordinator',
            'batas_studi' => 'Batas Studi',
            'asal_propinsi' => 'Asal Propinsi',
            'tgl_masuk' => 'Tgl Masuk',
            'tgl_lulus' => 'Tgl Lulus',
            'status_aktivitas' => 'Status Aktivitas',
            'status_awal' => 'Status Awal',
            'jml_sks_diakui' => 'Jml Sks Diakui',
            'nim_asal' => 'Nim Asal',
            'asal_pt' => 'Asal Pt',
            'nama_asal_pt' => 'Nama Asal Pt',
            'asal_jenjang_studi' => 'Asal Jenjang Studi',
            'asal_prodi' => 'Asal Prodi',
            'kode_biaya_studi' => 'Kode Biaya Studi',
            'kode_pekerjaan' => 'Kode Pekerjaan',
            'tempat_kerja' => 'Tempat Kerja',
            'kode_pt_kerja' => 'Kode Pt Kerja',
            'kode_ps_kerja' => 'Kode Ps Kerja',
            'nip_promotor' => 'Dosen PA',
            'nip_co_promotor1' => 'Nip Co Promotor1',
            'nip_co_promotor2' => 'Nip Co Promotor2',
            'nip_co_promotor3' => 'Nip Co Promotor3',
            'nip_co_promotor4' => 'Nip Co Promotor4',
            'photo_mahasiswa' => 'Photo Mahasiswa',
            'semester' => 'Semester',
            'keterangan' => 'Keterangan',
            'status_bayar' => 'Status Bayar',
            'telepon' => 'Telepon',
            'hp' => 'Hp',
            'email' => 'Email',
            'alamat' => 'Alamat',
            'berat' => 'Berat',
            'tinggi' => 'Tinggi',
            'ktp' => 'Ktp',
            'rt' => 'Rt',
            'rw' => 'Rw',
            'dusun' => 'Dusun',
            'kode_pos' => 'Kode Pos',
            'desa' => 'Desa',
            'kecamatan' => 'Kecamatan',
            'kecamatan_feeder' => 'Kecamatan Feeder',
            'jenis_tinggal' => 'Jenis Tinggal',
            'penerima_kps' => 'Penerima Kps',
            'no_kps' => 'No Kps',
            'provinsi' => 'Provinsi',
            'kabupaten' => 'Kabupaten',
            'status_warga' => 'Status Warga',
            'warga_negara' => 'Warga Negara',
            'warga_negara_feeder' => 'Warga Negara Feeder',
            'status_sipil' => 'Status Sipil',
            'agama' => 'Agama',
            'gol_darah' => 'Gol Darah',
            'masuk_kelas' => 'Masuk Kelas',
            'tgl_sk_yudisium' => 'Tgl Sk Yudisium',
            'no_ijazah' => 'No Ijazah',
            'status_mahasiswa' => 'Status Mahasiswa',
            'kampus' => 'Kelas',
            'jur_thn_smta' => 'Jur Thn Smta',
            'is_synced' => 'Is Synced',
            'kode_pd' => 'Kode Pd',
            'va_code' => 'Va Code',
            'kamar_id' => 'Kamar ID',
            'dapur_id' => 'Dapur',
            'is_eligible' => 'Is Eligible',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getSimakPrestasis()
    {
        return $this->hasMany(SimakPrestasi::class, ['nim' => 'nim_mhs']);
    }

    public function getSimakSertifikasis()
    {
        return $this->hasMany(SimakSertifikasi::class, ['nim' => 'nim_mhs']);
    }

    public function getKoordinator()
    {
        return $this->hasOne(SimakKampusKoordinator::class, ['id' => 'koordinator_id']);
    }

    public function getKonsulat0()
    {
        return $this->hasOne(Cities::className(), ['id' => 'konsulat']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillTagihans()
    {
        return $this->hasMany(BillTagihan::className(), ['nim' => 'nim_mhs']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillTransaksis()
    {
        return $this->hasMany(BillTransaksi::className(), ['CUSTID' => 'nim_mhs']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRiwayatPelanggarans()
    {
        return $this->hasMany(RiwayatPelanggaran::className(), ['nim' => 'nim_mhs']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSimakMahasiswaOrtus()
    {
        return $this->hasMany(SimakMahasiswaOrtu::className(), ['nim' => 'nim_mhs']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSimakMahasiswaProgramTambahans()
    {
        return $this->hasMany(SimakMahasiswaProgramTambahan::className(), ['nim' => 'nim_mhs']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeProdi()
    {
        return $this->hasOne(SimakMasterprogramstudi::className(), ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKamar()
    {
        return $this->hasOne(Kamar::className(), ['id' => 'kamar_id']);
    }

    public function getDapur()
    {
        return $this->hasOne(Dapur::className(), ['id' => 'dapur_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKampus0()
    {
        return $this->hasOne(SimakKampus::className(), ['kode_kampus' => 'kampus']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSimakPencekalans()
    {
        return $this->hasMany(SimakPencekalan::className(), ['nim' => 'nim_mhs']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSimakTahfidzKelompokAnggota()
    {
        return $this->hasMany(SimakTahfidzKelompokAnggotum::className(), ['nim' => 'nim_mhs']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSimakTahfidzNilais()
    {
        return $this->hasMany(SimakTahfidzNilai::className(), ['nim' => 'nim_mhs']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeFakultas()
    {
        return $this->hasOne(SimakMasterfakultas::className(), ['kode_fakultas' => 'kode_fakultas']);
    }

    public function getNamaProdi()
    {
        return !empty($this->kodeProdi) ? $this->kodeProdi->nama_prodi : 'not set';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNamaFakultas()
    {
        return !empty($this->kodeFakultas) ? $this->kodeFakultas->nama_fakultas  : 'not set';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNamaKampus()
    {
        return !empty($this->kampus0) ? $this->kampus0->nama_kampus : '-';
    }

    public function getKodeOrtu()
    {
        return $this->hasMany(SimakMahasiswaOrtu::className(), ['nim' => 'nim_mhs']);
    }

    public function getOrtuAyah()
    {
        return $this->getKodeOrtu()->where(['hubungan' => 'ayah']);
    }
    public function getOrtuIbu()
    {
        return $this->getKodeOrtu()->where(['hubungan' => 'ibu']);
    }
    public function getOrtuWali()
    {
        return $this->getKodeOrtu()->where(['hubungan' => 'wali']);
    }

    public function labelNegara(){
        if ($this->warga_negara == 'ID') {
            return 'INDONESIA';
        }elseif ($this->warga_negara == 'MY') {
            return 'MALAYSIA';
        }elseif ($this->warga_negara == 'TH') {
            return 'THAILAND';
        }
        else{
            return $this->warga_negara;
        }
    }

    public function labelStatus(){
        if ($this->status_aktivitas =='A') {
            return 'AKTIF';
        }elseif ($this->status_aktivitas =='C') {
            return 'CUTI';
        }elseif ($this->status_aktivitas =='D') {
            return 'DROP OUT / PUTUS STUDI';
        }elseif ($this->status_aktivitas =='K') {
            return 'KELUAR';
        }elseif ($this->status_aktivitas =='L') {
            return 'LULUS';
        }elseif ($this->status_aktivitas =='N') {
            return 'NON AKTIF';
        }elseif ($this->status_aktivitas =='G') {
            return 'SEDANG DOUBLE DEGREE';
        }
        else{
            return $this->status_aktivitas;
        }
    }
}
