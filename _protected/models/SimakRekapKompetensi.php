<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_rekap_kompetensi".
 *
 * @property int $id
 * @property int $kompetensi_id
 * @property string|null $nim
 * @property int|null $tahun
 * @property float|null $nilai
 * @property float|null $nilai_dosen
 * @property float|null $nilai_akhir
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class SimakRekapKompetensi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_rekap_kompetensi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kompetensi_id'], 'required'],
            [['kompetensi_id', 'tahun'], 'integer'],
            [['nilai', 'nilai_dosen', 'nilai_akhir'], 'number'],
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
            'kompetensi_id' => 'Kompetensi ID',
            'nim' => 'Nim',
            'tahun' => 'Tahun',
            'nilai' => 'Nilai',
            'nilai_dosen' => 'Nilai Dosen',
            'nilai_akhir' => 'Nilai Akhir',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
