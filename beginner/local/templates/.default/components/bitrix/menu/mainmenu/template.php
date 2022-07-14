<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<?php
if (!empty($arResult)): ?>

<ul class="list-unstyled">
    <?php
    foreach ($arResult as $arList):

        if ($arParams["MAX_LEVEL"] == 1 && $arList["DEPTH_LEVEL"] > 1) {
            continue;
        }
        ?>
        <?php
        if ($arList["SELECTED"]):
            ?>
            <li><a class="text-white" href="<?= $arList["LINK"] ?>
                               <?= $arList["TEXT"] ?>"</a></li>
        <?php
        else:
            ?>
            <li><a class="text-white" href="<?= $arList["LINK"] ?>"><?= $arList["TEXT"] ?></a></li>
        <?php
        endif ?>
    <?php
    endforeach ?>
    <?php
    endif ?>
</ul>

