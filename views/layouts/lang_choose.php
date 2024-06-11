<?php

$currentRU = $currentUS = '';
switch (\yii::$app->language) {
    case 'ru-RU':
        $currentRU = ' current';
        break;
    case 'en-US':
        $currentUS = ' current';
        break;
}
?>

<section class="lang-choose">
    <div class="flag flag-ru<?= $currentRU ?>" data-lang="ru-RU"></div>
    <div class="flag flag-us<?= $currentUS ?>" data-lang="en-US"></div>
</section>
