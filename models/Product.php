<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $structure
 * @property string $expiration
 * @property int $category
 * @property string|null $image
 *
 * @property Category $category0
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'structure', 'expiration', 'category'], 'required'],
            [['expiration'], 'safe'],
            [['category'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'structure' => 'Состав',
            'expiration' => 'Срок годности',
            'category' => 'Категория',
            'image' => 'Изображение',
        ];
    }

    public $imageFile;

    public function upload()
    {
        if ($this->validate()){
            $path = 'images/' . $this->randomFileName($this->imageFile->extension);
            $this->imageFile->saveAs($path);
            $this->image = '/' . $path;
            return true;
        } else {
            return false;
        }
    }

    private function randomFileName($extension = false)
    {
        $extension = $extension ? '.' . $extension : '';
        do {
            $name = md5(microtime() . rand(0, 1000));

            $file = $name . $extension;
        } while (file_exists($file));
        return $file;
    }


    public function getFullTreeStructure(): array
    {

        $groupsForNav = Group::find()->all();
        $tree = [];
        foreach ($groupsForNav as $group){
            $tree [] = [
                'label' => $group->name,
                'url' => '..',
                'items' => $group->categoryformenu,
            ];
        }

        return $tree;
    }


    /**
     * Gets query for [[Category0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(Category::class, ['id' => 'category']);
    }
}
