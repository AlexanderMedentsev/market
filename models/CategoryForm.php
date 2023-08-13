<?php

namespace app\models;


use yii\base\Model;

class CategoryForm extends Model
{
    public int|null $id = null;
    public string|null $name = null;
    public array $groups = [];


    public function attributeLabels(): array
    {
        return [
            'id' => 'id',
            'name' => 'Имя',
            'groups' => 'Группы'
        ];
    }

    public function rules(): array
    {
        return [
            [
                ['id', 'name', 'groups'],
                'required'
            ],

        ];
    }
}
