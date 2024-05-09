<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_masterprogramstudi".
 *
 * @property int $id
 * @property string $kode_fakultas
 * @property string|null $kode_jurusan
 * @property string $kode_prodi
 * @property string|null $kode_prodi_dikti
 * @property string $kode_jenjang_studi
 * @property string|null $gelar_lulusan
 * @property string|null $gelar_lulusan_en
 * @property string|null $gelar_lulusan_short
 * @property string $nama_prodi
 * @property string|null $nama_prodi_en
 * @property string|null $domain_email
 * @property string $semester_awal
 * @property string|null $no_sk_dikti
 * @property string|null $tgl_sk_dikti
 * @property string|null $tgl_akhir_sk_dikti
 * @property string|null $jml_sks_lulus
 * @property string|null $kode_status
 * @property string|null $tahun_semester_mulai
 * @property string|null $email_prodi
 * @property string|null $tgl_pendirian_program_studi
 * @property string|null $no_sk_akreditasi
 * @property string|null $tgl_sk_akreditasi
 * @property string|null $tgl_akhir_sk_akreditasi
 * @property string|null $kode_status_akreditasi
 * @property string|null $frekuensi_kurikulum
 * @property string|null $pelaksanaan_kurikulum
 * @property string|null $nidn_ketua_prodi
 * @property string|null $telp_ketua_prodi
 * @property string|null $fax_prodi
 * @property string|null $nama_operator
 * @property string|null $hp_operator
 * @property string|null $telepon_program_studi
 * @property string|null $singkatan
 * @property string|null $kode_feeder
 * @property int|null $kode_nim
 *
 * @property ErpSimkatmawaBelmawa[] $erpSimkatmawaBelmawas
 * @property ErpSimkatmawaMandiri[] $erpSimkatmawaMandiris
 * @property ErpSimkatmawaMbkm[] $erpSimkatmawaMbkms
 * @property ErpSimkatmawaNonLomba[] $erpSimkatmawaNonLombas
 * @property ErpUserProdi[] $erpUserProdis
 * @property Events[] $events
 * @property InputSoal[] $inputSoals
 * @property SimakMasterfakultas $kodeFakultas
 * @property SimakKampus[] $kodeKampuses
 * @property SimakMasterdosen $nidnKetuaProdi
 * @property SimakAbsenHarian[] $simakAbsenHarians
 * @property SimakAktivitasMahasiswa[] $simakAktivitasMahasiswas
 * @property SimakBahanKajian[] $simakBahanKajians
 * @property SimakCapaianLulusanMaster[] $simakCapaianLulusanMasters
 * @property SimakCapaianLulusan[] $simakCapaianLulusans
 * @property SimakCpmkMaster[] $simakCpmkMasters
 * @property SimakDatakrs[] $simakDatakrs
 * @property SimakDayaTampung[] $simakDayaTampungs
 * @property SimakJadwal[] $simakJadwals
 * @property SimakKampusProdi[] $simakKampusProdis
 * @property SimakKurikulumPetaMatkul[] $simakKurikulumPetaMatkuls
 * @property SimakKurikulum[] $simakKurikulums
 * @property SimakMasterdosen[] $simakMasterdosens
 * @property SimakMastermahasiswa[] $simakMastermahasiswas
 * @property SimakMastermatakuliah[] $simakMastermatakuliahs
 * @property SimakMatakuliah[] $simakMatakuliahs
 * @property SimakProdiCapem[] $simakProdiCapems
 * @property SimakProfilLulusan[] $simakProfilLulusans
 * @property SimakProposalSkripsiRubrik[] $simakProposalSkripsiRubriks
 * @property SimakSkripsiRubrik[] $simakSkripsiRubriks
 * @property SimakSk[] $simakSks
 * @property SimakTahunakademikProdi[] $simakTahunakademikProdis
 */
class ProgramStudi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_masterprogramstudi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_fakultas', 'kode_prodi', 'kode_jenjang_studi', 'nama_prodi', 'semester_awal'], 'required'],
            [['tgl_sk_dikti', 'tgl_akhir_sk_dikti', 'tgl_pendirian_program_studi', 'tgl_sk_akreditasi', 'tgl_akhir_sk_akreditasi'], 'safe'],
            [['kode_nim'], 'integer'],
            [['kode_fakultas', 'kode_jurusan', 'semester_awal', 'jml_sks_lulus', 'tahun_semester_mulai', 'kode_status_akreditasi'], 'string', 'max' => 5],
            [['kode_prodi'], 'string', 'max' => 15],
            [['kode_prodi_dikti', 'frekuensi_kurikulum', 'pelaksanaan_kurikulum'], 'string', 'max' => 10],
            [['kode_jenjang_studi'], 'string', 'max' => 20],
            [['gelar_lulusan', 'gelar_lulusan_en', 'gelar_lulusan_short', 'nama_prodi_en', 'singkatan', 'kode_feeder'], 'string', 'max' => 255],
            [['nama_prodi', 'no_sk_dikti', 'email_prodi', 'nama_operator'], 'string', 'max' => 50],
            [['domain_email'], 'string', 'max' => 100],
            [['kode_status'], 'string', 'max' => 1],
            [['no_sk_akreditasi', 'nidn_ketua_prodi', 'telp_ketua_prodi', 'fax_prodi', 'hp_operator', 'telepon_program_studi'], 'string', 'max' => 25],
            [['kode_prodi'], 'unique'],
            [['kode_fakultas'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMasterfakultas::class, 'targetAttribute' => ['kode_fakultas' => 'kode_fakultas']],
            [['nidn_ketua_prodi'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMasterdosen::class, 'targetAttribute' => ['nidn_ketua_prodi' => 'nidn']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_fakultas' => 'Kode Fakultas',
            'kode_jurusan' => 'Kode Jurusan',
            'kode_prodi' => 'Kode Prodi',
            'kode_prodi_dikti' => 'Kode Prodi Dikti',
            'kode_jenjang_studi' => 'Kode Jenjang Studi',
            'gelar_lulusan' => 'Gelar Lulusan',
            'gelar_lulusan_en' => 'Gelar Lulusan En',
            'gelar_lulusan_short' => 'Gelar Lulusan Short',
            'nama_prodi' => 'Nama Prodi',
            'nama_prodi_en' => 'Nama Prodi En',
            'domain_email' => 'Domain Email',
            'semester_awal' => 'Semester Awal',
            'no_sk_dikti' => 'No Sk Dikti',
            'tgl_sk_dikti' => 'Tgl Sk Dikti',
            'tgl_akhir_sk_dikti' => 'Tgl Akhir Sk Dikti',
            'jml_sks_lulus' => 'Jml Sks Lulus',
            'kode_status' => 'Kode Status',
            'tahun_semester_mulai' => 'Tahun Semester Mulai',
            'email_prodi' => 'Email Prodi',
            'tgl_pendirian_program_studi' => 'Tgl Pendirian Program Studi',
            'no_sk_akreditasi' => 'No Sk Akreditasi',
            'tgl_sk_akreditasi' => 'Tgl Sk Akreditasi',
            'tgl_akhir_sk_akreditasi' => 'Tgl Akhir Sk Akreditasi',
            'kode_status_akreditasi' => 'Kode Status Akreditasi',
            'frekuensi_kurikulum' => 'Frekuensi Kurikulum',
            'pelaksanaan_kurikulum' => 'Pelaksanaan Kurikulum',
            'nidn_ketua_prodi' => 'Nidn Ketua Prodi',
            'telp_ketua_prodi' => 'Telp Ketua Prodi',
            'fax_prodi' => 'Fax Prodi',
            'nama_operator' => 'Nama Operator',
            'hp_operator' => 'Hp Operator',
            'telepon_program_studi' => 'Telepon Program Studi',
            'singkatan' => 'Singkatan',
            'kode_feeder' => 'Kode Feeder',
            'kode_nim' => 'Kode Nim',
            'nidn_ketua_prodi' => 'Ketua Prodi',
        ];
    }

    public function getJenjang(){
        $pilihan = SimakPilihan::find()->select(['label','label_en'])->where(['kode'=>'01','value'=>$this->kode_jenjang_studi])->one();

        return $pilihan;
        
    }

    public function getKaprodi()
    {
        return $this->hasOne(SimakMasterdosen::className(), ['nidn' => 'nidn_ketua_prodi']);
    }

    /**
     * Gets query for [[ErpSimkatmawaBelmawas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getErpSimkatmawaBelmawas()
    {
        return $this->hasMany(ErpSimkatmawaBelmawa::class, ['prodi_id' => 'id']);
    }

    /**
     * Gets query for [[ErpSimkatmawaMandiris]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getErpSimkatmawaMandiris()
    {
        return $this->hasMany(ErpSimkatmawaMandiri::class, ['prodi_id' => 'id']);
    }

    /**
     * Gets query for [[ErpSimkatmawaMbkms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getErpSimkatmawaMbkms()
    {
        return $this->hasMany(ErpSimkatmawaMbkm::class, ['prodi_id' => 'id']);
    }

    /**
     * Gets query for [[ErpSimkatmawaNonLombas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getErpSimkatmawaNonLombas()
    {
        return $this->hasMany(ErpSimkatmawaNonLomba::class, ['prodi_id' => 'id']);
    }

    /**
     * Gets query for [[ErpUserProdis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getErpUserProdis()
    {
        return $this->hasMany(ErpUserProdi::class, ['prodi_id' => 'id']);
    }

    /**
     * Gets query for [[Events]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Events::class, ['prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[InputSoals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInputSoals()
    {
        return $this->hasMany(InputSoal::class, ['prodi_id' => 'id']);
    }

    /**
     * Gets query for [[KodeFakultas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeFakultas()
    {
        return $this->hasOne(SimakMasterfakultas::class, ['kode_fakultas' => 'kode_fakultas']);
    }

    /**
     * Gets query for [[KodeKampuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeKampuses()
    {
        return $this->hasMany(SimakKampus::class, ['kode_kampus' => 'kode_kampus'])->viaTable('simak_kampus_prodi', ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[NidnKetuaProdi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNidnKetuaProdi()
    {
        return $this->hasOne(SimakMasterdosen::class, ['nidn' => 'nidn_ketua_prodi']);
    }

    /**
     * Gets query for [[SimakAbsenHarians]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakAbsenHarians()
    {
        return $this->hasMany(SimakAbsenHarian::class, ['jurusan' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakAktivitasMahasiswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakAktivitasMahasiswas()
    {
        return $this->hasMany(SimakAktivitasMahasiswa::class, ['prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakBahanKajians]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakBahanKajians()
    {
        return $this->hasMany(SimakBahanKajian::class, ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakCapaianLulusanMasters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakCapaianLulusanMasters()
    {
        return $this->hasMany(SimakCapaianLulusanMaster::class, ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakCapaianLulusans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakCapaianLulusans()
    {
        return $this->hasMany(SimakCapaianLulusan::class, ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakCpmkMasters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakCpmkMasters()
    {
        return $this->hasMany(SimakCpmkMaster::class, ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakDatakrs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakDatakrs()
    {
        return $this->hasMany(SimakDatakrs::class, ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakDayaTampungs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakDayaTampungs()
    {
        return $this->hasMany(SimakDayaTampung::class, ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakJadwals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakJadwals()
    {
        return $this->hasMany(SimakJadwal::class, ['prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakKampusProdis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakKampusProdis()
    {
        return $this->hasMany(SimakKampusProdi::class, ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakKurikulumPetaMatkuls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakKurikulumPetaMatkuls()
    {
        return $this->hasMany(SimakKurikulumPetaMatkul::class, ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakKurikulums]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakKurikulums()
    {
        return $this->hasMany(SimakKurikulum::class, ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakMasterdosens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakMasterdosens()
    {
        return $this->hasMany(SimakMasterdosen::class, ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakMastermahasiswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakMastermahasiswas()
    {
        return $this->hasMany(SimakMastermahasiswa::class, ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakMastermatakuliahs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakMastermatakuliahs()
    {
        return $this->hasMany(SimakMastermatakuliah::class, ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakMatakuliahs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakMatakuliahs()
    {
        return $this->hasMany(SimakMatakuliah::class, ['prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakProdiCapems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakProdiCapems()
    {
        return $this->hasMany(SimakProdiCapem::class, ['prodi_id' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakProfilLulusans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakProfilLulusans()
    {
        return $this->hasMany(SimakProfilLulusan::class, ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakProposalSkripsiRubriks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakProposalSkripsiRubriks()
    {
        return $this->hasMany(SimakProposalSkripsiRubrik::class, ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakSkripsiRubriks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakSkripsiRubriks()
    {
        return $this->hasMany(SimakSkripsiRubrik::class, ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakSks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakSks()
    {
        return $this->hasMany(SimakSk::class, ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[SimakTahunakademikProdis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakTahunakademikProdis()
    {
        return $this->hasMany(SimakTahunakademikProdi::class, ['kode_prodi' => 'kode_prodi']);
    }
}
