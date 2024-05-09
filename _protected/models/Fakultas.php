<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_masterfakultas".
 *
 * @property int $id
 * @property string $kode_badan_hukum
 * @property string $kode_pt
 * @property string $kode_fakultas
 * @property string $nama_fakultas
 * @property string|null $nama_fakultas_en
 * @property string|null $tgl_pendirian
 * @property string|null $pejabat
 * @property string|null $jabatan
 * @property int|null $kode_nim
 *
 * @property BillBiayaFakultas[] $billBiayaFakultas
 * @property Events[] $events
 * @property SimakMasterdosen $pejabat0
 * @property SimakMasterprogramstudi[] $simakMasterprogramstudis
 */
class Fakultas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_masterfakultas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_badan_hukum', 'kode_pt', 'kode_fakultas', 'nama_fakultas'], 'required'],
            [['tgl_pendirian'], 'safe'],
            [['kode_nim'], 'integer'],
            [['kode_badan_hukum'], 'string', 'max' => 7],
            [['kode_pt'], 'string', 'max' => 6],
            [['kode_fakultas'], 'string', 'max' => 5],
            [['nama_fakultas', 'nama_fakultas_en'], 'string', 'max' => 100],
            [['pejabat'], 'string', 'max' => 30],
            [['jabatan'], 'string', 'max' => 1],
            [['kode_fakultas'], 'unique'],
            [['pejabat'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMasterdosen::class, 'targetAttribute' => ['pejabat' => 'nidn']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_badan_hukum' => 'Kode Badan Hukum',
            'kode_pt' => 'Kode Pt',
            'kode_fakultas' => 'Kode Fakultas',
            'nama_fakultas' => 'Nama Fakultas',
            'nama_fakultas_en' => 'Nama Fakultas En',
            'tgl_pendirian' => 'Tgl Pendirian',
            'pejabat' => 'Pejabat',
            'jabatan' => 'Jabatan',
            'kode_nim' => 'Kode Nim',
        ];
    }

    /**
     * Gets query for [[BillBiayaFakultas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBillBiayaFakultas()
    {
        return $this->hasMany(BillBiayaFakultas::class, ['fakultas_id' => 'id']);
    }

    /**
     * Gets query for [[Events]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Events::class, ['fakultas' => 'kode_fakultas']);
    }

    /**
     * Gets query for [[Pejabat0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPejabat0()
    {
        return $this->hasOne(SimakMasterdosen::class, ['nidn' => 'pejabat']);
    }

    /**
     * Gets query for [[SimakMasterprogramstudis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSimakMasterprogramstudis()
    {
        return $this->hasMany(SimakMasterprogramstudi::class, ['kode_fakultas' => 'kode_fakultas']);
    }
}
