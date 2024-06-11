<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\assets\SobakaAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\web\User;

AppAsset::register($this);
SobakaAsset::register($this);

/* @var User $comUser */
$comUser = \yii::$app->user;

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/svg+xml', 'href' => Yii::getAlias('@web/sobaka.svg')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
                      'brandLabel' => $this->render('brand-label'),
                      'brandUrl'   => Yii::$app->homeUrl,
                      'options'    => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top'],
                  ]);
    echo Nav::widget(
        [
            'options' => ['class' => 'navbar-nav'],
            'items'   => [
                $comUser->can('super') ? ['label' => \yii::t('app', 'Users'),
                                                        'url'   => ['/user/list']] : '',
                $comUser->can('postList') ? ['label' => \yii::t('app', 'Posts'), 'url' => ['/article/list']] : '',
                Yii::$app->user->isGuest
                    ? ['label' => \yii::t('app', 'Login'), 'url' => ['/default/login']]
                    : '<li class="nav-item">'
                      . Html::beginForm(['/default/logout'])
                      . Html::submitButton(
                        \yii::t('app', 'Logout ({username})',
                                ['username' => Yii::$app->user->identity->username]),
                        ['class' => 'nav-link btn btn-link logout']
                    )
                      . Html::endForm()
                      . '</li>'
            ]
        ]
    );
    echo $this->render('lang_choose');
    NavBar::end();

    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; Sergey Siunov <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
