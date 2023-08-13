<?php

use app\models\Category;
use app\models\Group;
use app\models\Product;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/** @var yii\web\View $this */
/** @var app\models\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Продукты';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить продукт', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'image',
                'label' => false,
                'format' => ['image', ['width' => '200', 'height' => '200']],
                'value' => function ($dataProvider) {
                    return $dataProvider->image;
                },
            ],
            'name',
            'structure',

            [
                'attribute' => 'expiration',
                'value' => 'expiration',
                'format' => 'raw',
                'label' => "Срок годности",
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'name' => 'ProductSearch[expiration]',
                    'value' => ArrayHelper::getValue($_GET, "ProductSearch.expiration"),
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                    ]
                ])
            ],

            [
                'attribute' => 'group',
                'label' => 'Группы',
                'value' => function ($model) {
                    $groups = Group::find()->leftJoin('category_group', 'group.id = id_group')->andWhere(['category_group.id_category' => $model->category])->all();
                    $value = [];
                    foreach ($groups as $group) {
                        $value[] = " {$group->name}";
                    }

                    return implode(', ', $value);
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'group',
                    'data' => ArrayHelper::map(Group::find()->asArray()->all(), 'id', 'name'),
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Выберите значение'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ])
            ],
            [
                'attribute' => 'category',
                'value' => 'category0.name',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'category',
                    'data' => ArrayHelper::map(Category::find()->leftJoin('category_group', 'category.id = category_group.id_category')->filterWhere(['category_group.id_group' => $searchModel->group])->asArray()->all(), 'id', 'name'),
                    'value' => 'category.name',
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => 'Выберите значение'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ])
            ],

            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
