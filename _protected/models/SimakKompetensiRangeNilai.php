<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "simak_kompetensi_range_nilai".
 *
 * @property int $id
 * @property int $induk_kompetensi_id
 * @property float|null $nilai_minimal
 * @property float|null $nilai_maksimal
 * @property string|null $label
 * @property string|null $label_en
 * @property string|null $color
 *
 * @property SimakIndukKegiatanKompetensi $indukKompetensi
 */
class SimakKompetensiRangeNilai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simak_kompetensi_range_nilai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['induk_kompetensi_id'], 'required'],
            [['induk_kompetensi_id'], 'integer'],
            [['nilai_minimal', 'nilai_maksimal'], 'number'],
            [['label', 'label_en'], 'string', 'max' => 25],
            [['color'], 'string', 'max' => 10],
            [['induk_kompetensi_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakIndukKegiatanKompetensi::class, 'targetAttribute' => ['induk_kompetensi_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'induk_kompetensi_id' => 'Induk Kompetensi ID',
            'nilai_minimal' => 'Nilai Minimal',
            'nilai_maksimal' => 'Nilai Maksimal',
            'label' => 'Label',
            'label_en' => 'Label En',
            'color' => 'Color',
        ];
    }

    /**
     * Gets query for [[IndukKompetensi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIndukKompetensi()
    {
        return $this->hasOne(SimakIndukKegiatanKompetensi::class, ['id' => 'induk_kompetensi_id']);
    }

    public static function getMaxKompetensi($induk_kompetensi_id)
    {
        $query = SimakKompetensiRangeNilai::find()->select(['nilai_maksimal']);

        $query->where([
            'induk_kompetensi_id' => $induk_kompetensi_id
        ]);

        $query->orderBy(['nilai_maksimal'=>SORT_DESC]);
        return $query->one();
    }

    public static function getRangeNilai($value, $induk_kompetensi_id)
    {
        $query = SimakKompetensiRangeNilai::find();

        $query->where([
            'induk_kompetensi_id' => $induk_kompetensi_id
        ]);

        $query->andWhere($value. ' >= nilai_minimal AND '.$value.' <= nilai_maksimal');

        return $query->one();
    }
}
