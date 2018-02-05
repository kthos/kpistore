<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
<!--div class="nav-wrapper"-->
    <?php
    NavBar::begin([
        'brandLabel' => '<span class="glyphicon glyphicon-home"></span>  '. Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            //'class' => 'brand-logo',
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '<span class="glyphicon glyphicon-home"></span>  Home', 'url' => ['/site/index']],
        ['label' => '<span class="glyphicon glyphicon-phone-alt"></span>  About', 'url' => ['/site/about']],
        ['label' => '<span class="glyphicon glyphicon-envelope"></span>  Contact', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '<span class="glyphicon glyphicon-user"></span>  Signup', 'url' => ['/user/registration/register']];
        $menuItems[] = ['label' => '<span class="glyphicon glyphicon-user"></span>  Login', 'url' => ['/user/security/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/user/security/logout'], 'post')
            . Html::submitButton(
                '<span class="glyphicon glyphicon-off"></span>  Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
            /*['label' =>'<span class="glyphicon glyphicon-off"></span>  Logout (' . Yii::$app->user->identity->username . ')'
             ,'url' => ['/user/security/logout']
             ,'linkOptions' => ['data-method' => 'post']
             ,'class' => 'logout'
            ];*/
    }
    
    echo Nav::widget([
        'encodeLabels' => false, // 'encodeLabels' => false, for Appear icon in front of menu
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
