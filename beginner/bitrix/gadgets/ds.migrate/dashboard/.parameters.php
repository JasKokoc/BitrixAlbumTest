<?

use Bitrix\Main\Loader;
use Ds\Migrate\Locale;
use Ds\Migrate\SchemaManager;
use Ds\Migrate\VersionConfig;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!Loader::includeModule('ds.migrate')) {
    return false;
}

$configs = (new VersionConfig())->getList();

$schemaValues = [];
$configValues = [];

foreach ($configs as $config) {
    $configValues[$config['name']] = $config['title'];

    $schemas = (new SchemaManager($config['name']))->getEnabledSchemas();
    foreach ($schemas as $schema) {
        $schemaValues[$schema->getName()] = $schema->getTitle();
    }
}

$arParameters = [
    'USER_PARAMETERS' => [
        'SELECT_CONFIGS' => [
            'NAME' => Locale::getMessage('GD_SELECT_CONFIGS'),
            'TYPE' => 'LIST',
            'SIZE' => 10,
            'VALUES' => $configValues,
            'MULTIPLE' => 'Y',
            'DEFAULT' => [],
        ],
        'CHECK_SCHEMAS' => [
            'NAME' => Locale::getMessage('GD_CHECK_SCHEMAS'),
            'TYPE' => 'LIST',
            'SIZE' => 10,
            'VALUES' => $schemaValues,
            'MULTIPLE' => 'Y',
            'DEFAULT' => [],
        ],
    ],
];
