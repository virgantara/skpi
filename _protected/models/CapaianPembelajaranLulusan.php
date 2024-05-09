<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_capaian_lulusan".
 *
 * @property string $id
 * @property string $kode
 * @property string|null $jenis
 * @property string $kode_prodi
 * @property string|null $deskripsi
 * @property string|null $deskripsi_en
 * @property string|null $state
 * @property int|null $urutan
 *
 * @property SimakCpmkMaster[] $cpmks
 * @property SimakMasterprogramstudi $kodeProdi
 * @property SimakProfilLulusan[] $pls
 * @property SimakBahanKajianCpl[] $simakBahanKajianCpls
 * @property SimakCapaianLulusanCpmk[] $simakCapaianLulusanCpmks
 * @property SimakCapaianLulusanMk[] $simakCapaianLulusanMks
 * @property SimakCapaianLulusanPemetaan[] $simakCapaianLulusanPemetaans
 * @property SimakProfilLulusanCpl[] $simakProfilLulusanCpls
 */
class CapaianPembelajaranLulusan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_capaian_lulusan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kode', 'kode_prodi'], 'required'],
            [['deskripsi_en'], 'string'],
            [['urutan'], 'integer'],
            [['id', 'kode', 'jenis'], 'string', 'max' => 50],
            [['kode_prodi'], 'string', 'max' => 15],
            [['deskripsi'], 'string', 'max' => 500],
            [['state'], 'string', 'max' => 1],
            [['kode', 'kode_prodi'], 'unique', 'targetAttribute' => ['kode', 'kode_prodi']],
            [['id'], 'unique'],
            [['kode_prodi'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMasterprogramstudi::class, 'targetAttribute' => ['kode_prodi' => 'kode_prodi']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode' => 'Kode',
            'jenis' => 'Jenis',
            'kode_prodi' => 'Kode Prodi',
            'deskripsi' => 'Deskripsi',
            'deskripsi_en' => 'Deskripsi En',
            'state' => 'State',
            'urutan' => 'Urutan',
        ];
    }

    /**
     * Gets query for [[Cpmks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCpmks()
    {
        return $this->hasMany(SimakCpmkMaster::class, ['id' => 'cpmk_id'])->viaTable('simak_capaian_lulusan_cpmk', ['cpl_id' => 'id']);
    }

    /**
     * Gets query for [[KodeProdi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKodeProdi()
    {
        return $this->hasOne(SimakMasterprogramstudi::class, ['kode_prodi' => 'kode_prodi']);
    }

    /**
     * Gets query for [[Pls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPls()
    {
        return $this->hasMany(SimakProfilLulusan::class, ['id' => 'pl_id'])->viaTable('simak_profil_lulusan_cpl', ['cpl_id' => 'id']);
    }

    /**
     * Gets query for [[SimakBahanKajianCpls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakBahanKajianCpls()
    {
        return $this->hasMany(SimakBahanKajianCpl::class, ['cpl_id' => 'id']);
    }

    /**
     * Gets query for [[SimakCapaianLulusanCpmks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakCapaianLulusanCpmks()
    {
        return $this->hasMany(SimakCapaianLulusanCpmk::class, ['cpl_id' => 'id']);
    }

    /**
     * Gets query for [[SimakCapaianLulusanMks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakCapaianLulusanMks()
    {
        return $this->hasMany(SimakCapaianLulusanMk::class, ['cpl_id' => 'id']);
    }

    /**
     * Gets query for [[SimakCapaianLulusanPemetaans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakCapaianLulusanPemetaans()
    {
        return $this->hasMany(SimakCapaianLulusanPemetaan::class, ['cpl_id' => 'id']);
    }

    /**
     * Gets query for [[SimakProfilLulusanCpls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakProfilLulusanCpls()
    {
        return $this->hasMany(SimakProfilLulusanCpl::class, ['cpl_id' => 'id']);
    }
}
