<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_kabupaten".
 *
 * @property int $kode
 * @property string $id
 * @property string $kab
 * @property string|null $keterangan
 * @property int $id_provinsi
 * @property int|null $created_by
 * @property string|null $date_created
 * @property int|null $updated_by
 * @property int|null $last_updated
 *
 * @property IzinMahasiswa[] $izinMahasiswas
 * @property SimakPropinsi $provinsi
 */
class SimakKabupaten extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_kabupaten';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kab', 'id_provinsi'], 'required'],
            [['id_provinsi', 'created_by', 'updated_by', 'last_updated'], 'integer'],
            [['date_created'], 'safe'],
            [['id'], 'string', 'max' => 11],
            [['kab', 'keterangan'], 'string', 'max' => 100],
            [['id'], 'unique'],
            [['id_provinsi'], 'exist', 'skipOnError' => true, 'targetClass' => SimakPropinsi::className(), 'targetAttribute' => ['id_provinsi' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kode' => 'Kode',
            'id' => 'Kode Wilayah',
            'kab' => 'Kab',
            'keterangan' => 'Keterangan',
            'id_provinsi' => 'Provinsi',
            'created_by' => 'Created By',
            'date_created' => 'Date Created',
            'updated_by' => 'Updated By',
            'last_updated' => 'Last Updated',
        ];
    }

    /**
     * Gets query for [[IzinMahasiswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIzinMahasiswas()
    {
        return $this->hasMany(IzinMahasiswa::className(), ['kota_id' => 'id']);
    }

    /**
     * Gets query for [[Provinsi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvinsi()
    {
        return $this->hasOne(SimakPropinsi::className(), ['id' => 'id_provinsi']);
    }
}
