<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_user_prodi".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $prodi_id
 *
 * @property SimakMasterprogramstudi $prodi
 * @property User $user
 */
class UserProdi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_user_prodi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'prodi_id'], 'integer'],
            [['prodi_id'], 'exist', 'skipOnError' => true, 'targetClass' => SimakMasterprogramstudi::class, 'targetAttribute' => ['prodi_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'prodi_id' => 'Prodi ID',
        ];
    }

    /**
     * Gets query for [[Prodi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdi()
    {
        return $this->hasOne(SimakMasterprogramstudi::class, ['id' => 'prodi_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
