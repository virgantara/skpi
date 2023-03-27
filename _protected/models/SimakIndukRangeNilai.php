<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_induk_range_nilai".
 *
 * @property int $id
 * @property int $induk_id
 * @property float|null $nilai_minimal
 * @property float|null $nilai_maksimal
 * @property string|null $label
 * @property string|null $label_en
 * @property string|null $color
 *
 * @property SimakIndukKegiatan $induk
 */
class SimakIndukRangeNilai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_induk_range_nilai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['induk_id'], 'required'],
            [['induk_id'], 'integer'],
            [['nilai_minimal', 'nilai_maksimal'], 'number'],
            [['label', 'label_en'], 'string', 'max' => 25],
            [['color'], 'string', 'max' => 10],
            [['induk_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakIndukKegiatan::class, 'targetAttribute' => ['induk_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'induk_id' => 'Induk ID',
            'nilai_minimal' => 'Nilai Minimal',
            'nilai_maksimal' => 'Nilai Maksimal',
            'label' => 'Label',
            'label_en' => 'Label En',
            'color' => 'Color',
        ];
    }

    /**
     * Gets query for [[Induk]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInduk()
    {
        return $this->hasOne(SimakIndukKegiatan::class, ['id' => 'induk_id']);
    }
}
