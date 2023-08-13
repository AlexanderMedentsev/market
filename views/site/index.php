<?php

/** @var yii\web\View $this */

/** @var $items */

use yii\bootstrap5\Carousel;

$this->title = Yii::$app->name;
?>

<div class="site-index">
    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Свежие продукты всегда с вами!</h1>
        <p><a class="btn btn-lg btn-success" href="/product">Посмотреть все продукты</a></p>

        <?php echo Carousel::widget([
            'items' => $items,
            'options' => [
                'style' => 'width:100%;', // Задаем ширину контейнера
                'class' => 'carousel-dark slide',
            ]
        ]);
        ?>

    </div>


</div>
