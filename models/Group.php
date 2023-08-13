<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "group".
 *
 * @property int $id
 * @property string $name
 *
 * @property CategoryGroup[] $categoryGroups
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
        ];
    }

    /**
     * Gets query for [[CategoryGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryForMenu()
    {
        return $this->hasMany(Category::class, ['id' => 'id_category'])->viaTable('category_group', ['id_group' => 'id']);
    }

    public function getCategoryGroups()
    {
        return $this->hasMany(CategoryGroup::class, ['id_group' => 'id']);
    }
}
