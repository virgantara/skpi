<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bill_tagihan".
 *
 * @property int $id
 * @property int $urutan
 * @property int $semester
 * @property int $tahun
 * @property string|null $nim
 * @property int $komponen_id
 * @property float $nilai
 * @property float|null $nilai_minimal
 * @property float|null $terbayar
 * @property int $edit
 * @property int|null $status_bayar
 * @property int|null $is_tercekal
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property BillTransaksi[] $billTransaksis
 * @property BillKomponenBiaya $komponen
 * @property SimakMastermahasiswa $nim0
 * @property BillTahun $tahun0
 */
class BillTagihan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bill_tagihan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['urutan', 'semester', 'tahun', 'komponen_id', 'edit', 'status_bayar', 'is_tercekal'], 'integer'],
            [['semester', 'tahun', 'komponen_id', 'nilai'], 'required'],
            [['nilai', 'nilai_minimal', 'terbayar'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['nim'], 'string', 'max' => 25],
            [['komponen_id'], 'exist', 'skipOnError' => true, 'targetClass' => BillKomponenBiaya::className(), 'targetAttribute' => ['komponen_id' => 'id']],
            [['nim'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMastermahasiswa::className(), 'targetAttribute' => ['nim' => 'nim_mhs']],
            [['tahun'], 'exist', 'skipOnError' => true, 'targetClass' => BillTahun::className(), 'targetAttribute' => ['tahun' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'urutan' => 'Urutan',
            'semester' => 'Semester',
            'tahun' => 'Tahun',
            'nim' => 'Nim',
            'komponen_id' => 'Komponen ID',
            'nilai' => 'Nilai',
            'nilai_minimal' => 'Nilai Minimal',
            'terbayar' => 'Terbayar',
            'edit' => 'Edit',
            'status_bayar' => 'Status Bayar',
            'is_tercekal' => 'Is Tercekal',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[BillTransaksis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBillTransaksis()
    {
        return $this->hasMany(BillTransaksi::className(), ['tagihan_id' => 'id']);
    }

    /**
     * Gets query for [[Komponen]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKomponen()
    {
        return $this->hasOne(BillKomponenBiaya::className(), ['id' => 'komponen_id']);
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
     * Gets query for [[Tahun0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTahun0()
    {
        return $this->hasOne(BillTahun::className(), ['id' => 'tahun']);
    }
}
