<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_asrama".
 *
 * @property int $id
 * @property string $nama
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Kamar[] $kamars
 */
class Asrama extends \yii\db\ActiveRecord
{

    public $dataKamar;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_asrama';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dataKamar'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx','on'=>'sce_upload_file'],
            [['kampus_id', 'nama'], 'required'],
            [['kampus_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nama'], 'string', 'max' => 255],
            [['kampus_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakKampus::className(), 'targetAttribute' => ['kampus_id' => 'kode_kampus']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
              'kampus_id' => 'Kelas',
            'nama' => 'Nama',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getNamaKampus()
    {
        return $this->kampus->nama_kampus;
    }

    public function getKampus()
    {
        return $this->hasOne(SimakKampus::className(), ['kode_kampus' => 'kampus_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKamars()
    {
        return $this->hasMany(Kamar::className(), ['asrama_id' => 'id']);
    }
}
