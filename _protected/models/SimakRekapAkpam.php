<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_rekap_akpam".
 *
 * @property int $id
 * @property string|null $nim
 * @property int $semester
 * @property int|null $tahun_akademik
 * @property int $id_jenis_kegiatan
 * @property float $akpam
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class SimakRekapAkpam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_rekap_akpam';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['semester', 'id_jenis_kegiatan', 'akpam'], 'required'],
            [['semester', 'tahun_akademik', 'id_jenis_kegiatan'], 'integer'],
            [['akpam'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['nim'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nim' => 'Nim',
            'semester' => 'Semester',
            'tahun_akademik' => 'Tahun Akademik',
            'id_jenis_kegiatan' => 'Id Jenis Kegiatan',
            'akpam' => 'Akpam',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
