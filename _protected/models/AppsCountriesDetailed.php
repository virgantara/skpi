<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "apps_countries_detailed".
 *
 * @property int $id
 * @property string $countryCode
 * @property string $countryName
 * @property string|null $currencyCode
 * @property string|null $fipsCode
 * @property string|null $isoNumeric
 * @property string|null $north
 * @property string|null $south
 * @property string|null $east
 * @property string|null $west
 * @property string|null $capital
 * @property string|null $continentName
 * @property string|null $continent
 * @property string|null $languages
 * @property string|null $isoAlpha3
 * @property int|null $geonameId
 *
 * @property IzinMahasiswa[] $izinMahasiswas
 */
class AppsCountriesDetailed extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apps_countries_detailed';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['geonameId'], 'integer'],
            [['countryCode', 'fipsCode', 'continent'], 'string', 'max' => 2],
            [['countryName', 'continentName', 'languages'], 'string', 'max' => 100],
            [['currencyCode', 'isoAlpha3'], 'string', 'max' => 3],
            [['isoNumeric'], 'string', 'max' => 4],
            [['north', 'south', 'east', 'west', 'capital'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'countryCode' => 'Country Code',
            'countryName' => 'Country Name',
            'currencyCode' => 'Currency Code',
            'fipsCode' => 'Fips Code',
            'isoNumeric' => 'Iso Numeric',
            'north' => 'North',
            'south' => 'South',
            'east' => 'East',
            'west' => 'West',
            'capital' => 'Capital',
            'continentName' => 'Continent Name',
            'continent' => 'Continent',
            'languages' => 'Languages',
            'isoAlpha3' => 'Iso Alpha3',
            'geonameId' => 'Geoname ID',
        ];
    }

    /**
     * Gets query for [[IzinMahasiswas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIzinMahasiswas()
    {
        return $this->hasMany(IzinMahasiswa::className(), ['negara_id' => 'id']);
    }
}
