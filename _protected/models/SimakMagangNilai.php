<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_magang_nilai".
 *
 * @property int $id
 * @property string $kriteria
 * @property float|null $nilai_angka
 * @property float|null $bobot
 * @property string|null $magang_id
 * @property string|null $updated_at
 * @property string|null $created_at
 *
 * @property SimakMagang $magang
 */
class SimakMagangNilai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_magang_nilai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kriteria'], 'required'],
            [['nilai_angka', 'bobot'], 'number'],
            [['updated_at', 'created_at'], 'safe'],
            [['kriteria'], 'string', 'max' => 255],
            [['magang_id'], 'string', 'max' => 50],
            [['magang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMagang::class, 'targetAttribute' => ['magang_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kriteria' => 'Kriteria',
            'nilai_angka' => 'Nilai Angka',
            'bobot' => 'Bobot',
            'magang_id' => 'Magang ID',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Magang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMagang()
    {
        return $this->hasOne(SimakMagang::class, ['id' => 'magang_id']);
    }
}
