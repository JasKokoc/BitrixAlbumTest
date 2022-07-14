<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 * @global CUser $USER
 * @global CMain $APPLICATION
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

if ($arResult["SHOW_SMS_FIELD"] == true) {
    CJSCore::Init('phone_auth');
}
?>
<?php
$arResult["USE_CAPTCHA"] = COption::GetOptionString("main", "captcha_registration", "N") == "Y" ? "Y" : "N";
?>
<div class="form-signin">
    <form>
        <img class="mb-4" src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="72"
             height="57">
    </form>
    <?
    if ($USER->IsAuthorized()): ?>

        <?php
        LocalRedirect('/albums/'); ?>

    <?
    else: ?>
        <?
        if (count($arResult["ERRORS"]) > 0):
            foreach ($arResult["ERRORS"] as $key => $error) {
                if (intval($key) == 0 && $key !== 0) {
                    $arResult["ERRORS"][$key] = str_replace(
                        "#FIELD_NAME#",
                        "&quot;" . GetMessage("REGISTER_FIELD_" . $key) . "&quot;",
                        $error
                    );
                }
            } ?>


        <?php
        elseif ($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
            ?>
            <p><?
                echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT") ?></p>
        <?
        endif ?>

        <?
        if ($arResult["SHOW_SMS_FIELD"] == true): ?>

            <form method="post" action="<?= POST_FORM_ACTION_URI ?>" name="regform">
                <?
                if ($arResult["BACKURL"] <> ''):
                    ?>
                    <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
                <?
                endif;
                ?>

                <input type="hidden" name="SIGNED_DATA" value="<?= htmlspecialcharsbx($arResult["SIGNED_DATA"]) ?>"/>
                <table>
                    <tbody>
                    <tr>
                        <td><?
                            echo GetMessage("main_register_sms") ?><span class="starrequired">*</span></td>
                        <td><input size="30" type="text" name="SMS_CODE"
                                   value="<?= htmlspecialcharsbx($arResult["SMS_CODE"]) ?>" autocomplete="off"/></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="code_submit_button"
                                   value="<?
                                   echo GetMessage("main_register_sms_send") ?>"/></td>
                    </tr>
                    </tfoot>
                </table>
            </form>


            <div id="bx_register_error" style="display:none"><?
                ShowError("error") ?></div>

            <div id="bx_register_resend"></div>

        <?
        else: ?>

            <form method="post" action="<?= POST_FORM_ACTION_URI ?>" name="regform" enctype="multipart/form-data">
                <?
                if ($arResult["BACKURL"] <> ''):
                    ?>
                    <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
                <?
                endif;
                ?>


                <h3 class="bx-title"><?= GetMessage("AUTH_REGISTER") ?></h3>


                <?
                foreach ($arResult["SHOW_FIELDS"] as $FIELD): ?>
                    <?
//
                    ?>
                    <div class="form-floating">
                        <input type="<?= (($FIELD == "PASSWORD") || ($FIELD == "CONFIRM_PASSWORD")) ? "password" : "text" ?>"
                               name="REGISTER[<?= $FIELD ?>]" value="<?= $arResult["VALUES"][$FIELD] ?>"
                               autocomplete="off" class="form-control" placeholder="[<?= $FIELD ?>]"/>
                        <label for="floatingInput"><?= ($FIELD == "LOGIN" ? "EMAIL" : $FIELD) ?></label>
                    </div>
                <?
                endforeach ?>
                <?
                if ($arResult['ERRORS']): ?>
                    <div class="alert alert-danger">
                        <?
                        foreach ($arResult['ERRORS'] as $error) {
                            echo $error . "<br>";
                        }
                        ?>
                    </div>
                <?
                endif; ?>
                <div class="g-recaptcha" data-sitekey="<?= RE_SITE_KEY ?>"></div>
                <br>
                <input type="submit" class="w-100 btn btn-lg btn-primary" name="register_submit_button"
                       value="<?= GetMessage("AUTH_REGISTER") ?>"/>
            </form>
        <?
        endif //$arResult["SHOW_SMS_FIELD"] == true ?>

    <?
    endif ?>
</div>