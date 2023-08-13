<?php

use app\models\Category;
use app\models\Product;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'imageFile')->widget(FileInput::class, [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'language' => 'ru',
            'showCancel'=> false
        ]
    ]);  ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'structure')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'expiration')->widget(DatePicker::class, [
        'options' => [],
        'pluginOptions' => [
            'autoclose' => true,
            'language' => 'ru',
            'format' => 'yyyy-mm-dd'
        ]
    ]); ?>

    <?= $form->field($model, 'category')->widget(Select2::class, [
        'data' => ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'name')
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
