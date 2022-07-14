<?php
/**
 * @var array $arParams
 * @var array $arResult
 * @var \CBitrixComponentTemplate $this
 * @var \ProjectAlbumsListComponent $component
 */

?>
<form id="albumsForm" method="post" action="">
<div class="album py-5 bg-light">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
            if ($USER->isAuthorized()) {
                foreach ($arResult['ALBUMS'] as $album):

                    if ($USER->GetID() == $album['CREATED_BY']) {
                        ?>
                        <div class="col">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <input type="hidden" name="elId" value="<?=$album['IDFORDELETE']?>">
                                    <img width="100%" height="225" src="<?= $album['PREVIEW_PICTURE_SRC'] ?>"/>
                                    <p class="card-text">
                                        <?= $album['TEXT'] ?>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">

                                        <div class="btn-group">
                                            <a href="/albums/<?= $album['ID'] ?>/" class="btn btn-sm btn-outline-secondary">Просмотр</a>
                                            <button class="btn btn-sm btn-outline-secondary deleteAlbumBtn" data-source="<?=$album['IDFORDELETE']?>" type="button">Удалить</button>
                                        </div>
                                        </form>
                                        <small class="text-muted">Обновлён: <?= $album['TIMESTAMP'] ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?
                    }
                endforeach;
            }
            ?>
        </div>
    </div>
</div>

