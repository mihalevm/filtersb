<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap <?=(Yii::$app->user->isGuest ? 'wrap-black':'')?>">
    <div class="company-pre-nav"></div>
    <?php
    $brandUrl = Yii::$app->homeUrl;

    if (!Yii::$app->user->isGuest) {
        $brandUrl = Yii::$app->user->identity->utype =='D'?'/driver-dashboard':'/company-dashboard';
    }

    NavBar::begin([
        'brandLabel' => '<div class="company-logo"></div><div class="company-label">'.Yii::$app->name.'</div>',
        'brandUrl'   => $brandUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top company-nav-position',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            Yii::$app->user->isGuest ? (
            ['label' => 'Водителям', 'url' => ['/register?t=D']]):(''),
            Yii::$app->user->isGuest ? (
            ['label' => 'Бизнесу', 'url' => ['/register?t=C']]):(''),
            Yii::$app->user->isGuest ? (
                    ['label' => 'Вход', 'url' => ['/signin']]
            ) : (
                '<li><a href="'.(Yii::$app->user->identity->utype =='D'?'/driver-profile':'/company-profile').'">Профиль</a></li>'.
                '<li>'
                . Html::beginForm(['/signin/logout'], 'post')
                . Html::submitButton(
                    'Выход (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container <?=(Yii::$app->user->isGuest ? 'company-landing-container-fullscreen':'')?>">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer company-footer">
    <div class="container">
        <p class="pull-right">&copy; <?=Yii::$app->name ?> <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
