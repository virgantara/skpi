<?php
namespace app\models;

use yii\base\Model;
use Yii;

/**
 * ContactForm is the model behind the contact form.
 */
class LulusanForm extends Model
{

    public $dataLulusan;

    /**
     * Returns the validation rules for attributes.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['dataLulusan'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, xlsx,csv'],
        ];
    }

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'dataLulusan'=> Yii::t('app', 'Data Lulusan'),
        ];
    }


}
