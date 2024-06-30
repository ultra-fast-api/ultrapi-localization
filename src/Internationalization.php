<?php

declare(strict_types=1);

namespace UpiCore\Localization;

use Locale;
use UpiCore\Exception\UpiException;

final class Internationalization
{
    /**
     * Singleton instance
     *
     * @var self|null
     */
    protected static ?self $instance = null;

    /**
     * Accepted server language
     *
     * @var array
     */
    private static $acceptedLanguages = [];
    /**
     * Constructor
     *
     * @param string $languageCode
     * @param string $charset
     * @param string|null $timezone
     *
     * @throws UpiException
     */
    public function __construct(
        protected string $languageCode,
        protected string $charset,
        protected ?string $timezone = null
    ) {
        // Validate the language code
        if (!Locale::parseLocale($languageCode)) {
            throw new UpiException('LOCALIZATION_INVALID_LANGUAGE_CODE');
        }

        // Validate the charset
        if (empty($charset)) {
            throw new UpiException('LOCALIZATION_EMPTY_CHARSET_ERR');
        }

        // Set default locale for intl extension
        if (false === ini_set('intl.default_locale', $languageCode)) {
            throw new UpiException('LOCALIZATION_DEFAULT_LOCALE_FAILED');
        }

        // Set locale for all categories
        if (false === setlocale(LC_ALL, sprintf('%s.%s', $languageCode, $charset))) {
            throw new UpiException('LOCALIZATION_LOCALE_SET_FAILED');
        }

        // Set default timezone if provided
        if ($timezone !== null && false === date_default_timezone_set($timezone)) {
            throw new UpiException('LOCALIZATION_TIMEZONE_SET_FAILED');
        }

        // Set default locale for Intl extension
        Locale::setDefault($languageCode);

        self::$instance = $this;
    }

    /**
     * Singleton Instance for Internationalization
     *
     * @param string $languageCode
     * @param string $charset
     * @param string|null $timezone
     *
     * @return self
     * @throws UpiException
     */
    public static function instance(string $languageCode, string $charset, ?string $timezone = null): self
    {
        if (self::$instance === null) {
            self::$instance = new self($languageCode, $charset, $timezone);
        }
        return self::$instance;
    }

    /**
     * Get Language Code
     *
     * @return string
     */
    public static function getLanguageCode(): string
    {
        return self::$instance->languageCode;
    }

    /**
     * Get Charset
     *
     * @return string
     */
    public static function getCharset(): string
    {
        return self::$instance->charset;
    }

    /**
     * Get Timezone
     *
     * @return string|null
     */
    public static function getTimezone(): ?string
    {
        return self::$instance->timezone;
    }

    public static function setAcceptedLanguages(array $apiLanguages)
    {
        static::$acceptedLanguages = $apiLanguages;
    }

    public static function getAcceptedLanguages()
    {
        return static::$acceptedLanguages;
    }

    /**
     * Prevent instance from being cloned
     */
    public function __clone()
    {
    }

    /**
     * Prevent instance from being unserialized
     */
    public function __wakeup()
    {
    }
}
