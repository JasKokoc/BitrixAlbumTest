<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

/**
 * @global $APPLICATION
 */
$assets = Asset::getInstance();

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<!doctype html>
<html lang="en">
<head>

    <?php
    $APPLICATION->ShowHead() ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php
        $APPLICATION->ShowTitle() ?></title>
    <?

    $assets->addCss(SITE_TEMPLATE_PATH . '/css/styles.css');
    $assets->addCss('/css/album.css');
    $assets->addString("<script src='https://www.google.com/recaptcha/api.js'></script>");
    $assets->addString('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>');
    $assets->addString(
        '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>'
    );
    $assets->addString(
        '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">'
    );
    $assets->addString('<link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">');
    $assets->addString(
        '<link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">'
    );
    $assets->addString(
        '<link rel="apple-touch-icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">'
    );
    $assets->addString(
        '<link rel="icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">'
    );
    $assets->addString(
        '<link rel="icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">'
    );
    $assets->addString(
        '<link rel="manifest" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/manifest.json">'
    );
    $assets->addString(
        '<link rel="mask-icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">'
    );
    $assets->addString('<link rel="icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/favicon.ico">');

    ?>
    <meta name="theme-color" content="#7952b3">

</head>
<body class="text-center">
<?php
$APPLICATION->ShowPanel() ?>

