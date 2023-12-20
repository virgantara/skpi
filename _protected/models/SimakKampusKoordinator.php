<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_kampus_koordinator".
 *
 * @property int $id
 * @property int|null $kampus_id
 * @property string $nama_cabang
 * @property string $nama_koordinator
 *
 * @property SimakKampus $kampus
 */
class SimakKampusKoordinator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_kampus_koordinator';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kampus_id'], 'integer'],
            [['nama_cabang', 'nama_koordinator','niy'], 'required'],
            [['niy'], 'string', 'max' => 10,'min' => 6],
            [['ttd_path'], 'safe'],
            [['nama_cabang', 'nama_koordinator'], 'string', 'max' => 200],
            [['kampus_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakKampus::class, 'targetAttribute' => ['kampus_id' => 'id']],
            [['ttd_path'], 'file', 'skipOnEmpty' => true, 'extensions' => ['jpg','png','jpeg'], 'maxSize' => 1024 * 1024 * 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kampus_id' => 'Kampus ID',
            'nama_cabang' => 'Nama Cabang',
            'niy' => 'NIY',
            'ttd_path' => 'Tanda Tangan',
            'nama_koordinator' => 'Nama Koordinator',
        ];
    }

    /**
     * Gets query for [[Kampus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKampus()
    {
        return $this->hasOne(SimakKampus::class, ['id' => 'kampus_id']);
    }
}
