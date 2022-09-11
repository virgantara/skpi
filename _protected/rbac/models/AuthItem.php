<?php

namespace app\rbac\models;

use Yii;

/**
 * This is the model class for table "erp_auth_item".
 *
 * @property string $name
 * @property int $type
 * @property string|null $description
 * @property string|null $rule_name
 * @property string|null $data
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 * @property AuthRule $ruleName
 */
class AuthItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_auth_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['name'], 'unique'],
            // [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::className(), 'targetAttribute' => ['rule_name' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    // public function attributeLabels()
    // {
    //     return [
    //         'name' => 'Name',
    //         'type' => 'Type',
    //         'description' => 'Description',
    //         'rule_name' => 'Rule Name',
    //         'data' => 'Data',
    //         'created_at' => 'Created At',
    //         'updated_at' => 'Updated At',
    //     ];
    // }

    /**
     * Gets query for [[AuthAssignments]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getAuthAssignments()
    // {
    //     return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    // }

    /**
     * Gets query for [[AuthItemChildren]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getAuthItemChildren()
    // {
    //     return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
    // }

    /**
     * Gets query for [[AuthItemChildren0]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getAuthItemChildren0()
    // {
    //     return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    // }

    /**
     * Gets query for [[Children]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getChildren()
    // {
    //     return $this->hasMany(AuthItem::className(), ['name' => 'child'])->viaTable('erp_auth_item_child', ['parent' => 'name']);
    // }

    /**
     * Gets query for [[Parents]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getParents()
    // {
    //     return $this->hasMany(AuthItem::className(), ['name' => 'parent'])->viaTable('erp_auth_item_child', ['child' => 'name']);
    // }

    /**
     * Gets query for [[RuleName]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getRuleName()
    // {
    //     return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    // }

    public static function getRoles()
    {
        // if user is not 'theCreator' ( You ), we do not want to show him users with that role
        if (!Yii::$app->user->can('theCreator')) {
            return static::find()->select('name')->where(['type' => 1])->andWhere(['!=', 'name', 'theCreator'])->all();
        }

        // this is You or some other super admin, so show everything 
        return static::find()->select('name')->where(['type' => 1])->all();
    }
}
