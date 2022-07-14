<?php

if (is_file($_SERVER["DOCUMENT_ROOT"] . "/local/modules/ds.migrate/admin/ds_migrate.php")) {
    /** @noinspection PhpIncludeInspection */
    require($_SERVER["DOCUMENT_ROOT"] . "/local/modules/ds.migrate/admin/ds_migrate.php");
} else {
    /** @noinspection PhpIncludeInspection */
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/ds.migrate/admin/ds_migrate.php");
}
