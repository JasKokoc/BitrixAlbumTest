<?php
/**
 * @global $APPLICATION
 */
const ERROR_404 = "Y";
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
CHTTP::SetStatus("404 Not Found");
$APPLICATION->SetTitle('404');
?>
    <div class="page-404">
        404 page    
     </div>
