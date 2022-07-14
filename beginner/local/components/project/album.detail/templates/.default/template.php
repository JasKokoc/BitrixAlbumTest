<?php
/**
 * @global $USER
 * @var array $arParams
 * @var array $arResult
 * @var \CBitrixComponentTemplate $this
 * @var \ProjectAlbumDetailComponent $component
 */

?>

    <section class="py-5 text-center container">
        <h1 class="fw-light"><?= $arResult['ALBUMS_DETAIL'][0]['PREVIEW_TEXT']; ?></h1>
        <?
        if ($arResult['ALBUMS_DETAIL'][0]['CREATED_BY'] == $USER->getID()) { ?>
            <a href="uploads/" class="btn btn-primary my-2">Добавить изображения</a> <?
        } ?>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?
                foreach ($arResult['ALBUMS_DETAIL'] as $photo):
                    if (empty($photo['PICTURES_SRC'])) {
                        echo "<a>В альбоме нет изображений</a>";
                        die();
                    } else
                        ?>
                        <div class="col">
                        <div class="card shadow-sm">
                        <div class="card-body" >
                        <a href="<?= $photo['PICTURES_SRC'] ?>" data-fancybox="gallery"
                                                                data-caption="<?= $photo['TEXT'] ?>">
                    <img width="100%" height="225" src="<?= $photo['PICTURES_SRC'] ?>"/>
                    </a>
                    <p class="card-text">
                        <?= $photo['TEXT'] ?>
                    </p>
                    <div class="btn-group">

                        <button class="btn btn-sm btn-outline-secondary deletePicBtn"
                                data-source="<?= $photo['PROPERTY_FOR_DELETE'] ?>" data-info="<?= $photo['AlbID'] ?>"
                                type="button">Удалить
                        </button>

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Обновлёно: <?= $photo['TIMESTAMP'] ?></small>
                        </div>
                    </div>
                    </div>
                    </div>
                    </div>
                <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>
<?
