<?php

declare(strict_types=1);

namespace UpiCore\Localization;

use UpiCore\Exception\UpiException;
use UpiCore\Localization\Language;

class Locale
{

    /**
     * Localization files destination
     *
     * @var string
     */
    protected static $localizationPath = null;

    public function __construct(string $localizationPath = null)
    {
        if (\is_null($localizationPath) && !$defaultPath = \UpiCore\Ceremony\Utils\Destination\PathResolver::localePath()) {
            throw new UpiException('LOCALIZATION_LOCALE_PATH_NOT_DEFINED');
        }

        self::$localizationPath = $localizationPath ?: $defaultPath;

        if (!\is_dir(self::$localizationPath)) {
            throw new UpiException('LOCALIZATION_LOCALE_PATH_NOT_EXISTS');
        }
    }

    /**
     * Gives current localization path
     *
     * @return string|null
     */
    public static function getLocalizationPath()
    {
        return self::$localizationPath;
    }

    /**
     * Gives current localization file
     *
     * @return array
     */
    public static function getLocalizationFile(): array
    {
        return require self::$localizationPath . DIRECTORY_SEPARATOR . Language::apiLanguage() . DIRECTORY_SEPARATOR . Language::apiLanguage() . '.php';
    }
}
