<?php

/**
 * @global $APPLICATION
 */
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Авторизация");
?>
    <main class="form-signin">
        <?
        $APPLICATION->IncludeComponent(
            "bitrix:main.auth.form",
            "auth",
            array(
                "AUTH_FORGOT_PASSWORD_URL" => "",
                "AUTH_REGISTER_URL" => "/register/",
                "AUTH_SUCCESS_URL" => "/"
            )
        ); ?>
    </main>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>