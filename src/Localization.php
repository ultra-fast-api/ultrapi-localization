<?php

declare(strict_types=1);

namespace UpiCore\Localization;

class Localization
{

    /**
     * Separates and returns the language tag as a country and language code.
     *
     * @param string $tag The language tag to parse (e.g., "en-US").
     *
     * @return array An associative array containing the following keys:
     *               - 'languageCode': The two-letter language code (e.g., "en").
     *               - 'countryCode': The two-letter country code (e.g., "US").
     *               - 'tag': The original tag (unchanged).
     */
    public static function parseTag(string $tag): array
    {
        $languageCode = substr($tag, 0, 2);
        $countryCode = substr($tag, 3);

        return [
            'languageCode' => $languageCode,
            'countryCode' => $countryCode,
            'tag' => $tag,
        ];
    }

    /**
     * Returns the display value for a specific type of any tag.
     * Valid types are "name", "language", or "region".
     *
     * @param string $type The type of display value to retrieve ("name", "language", or "region").
     * @param string $locale The locale for which to get the display value (e.g., "en-US").
     * @param string $displayLocale The display locale to use for formatting (e.g., "en-US").
     *
     * @return string|null The display value for the specified type, or null if the type is invalid.
     */
    public static function getDisplay($type, $locale, $displayLocale)
    {
        if (in_array($type, ['name', 'language', 'region'])) {

            $parseTag = self::parseTag($locale);
            $fn = 'getDisplay' . ucfirst($type);

            return \Locale::{$fn}(
                $parseTag['languageCode'] . '-' . $parseTag['countryCode'],
                $displayLocale
            );
        } else
            return null;
    }

    /**
     * Returns an array containing display values for the given tag (e.g., "en-US").
     *
     * @param string $tag The language tag to get details for (e.g., "en-US").
     *
     * @return array An associative array containing the following keys:
     *               - 'name': The display name of the language and region combination.
     *               - 'language': The display name of the language.
     *               - 'region': The display name of the region.
     */
    public static function tagDetail(string $tag)
    {
        return [
            'name'      => self::getDisplay('name', $tag, Language::apiLanguage()),
            'language'  => self::getDisplay('language', $tag, Language::apiLanguage()),
            'region'    => self::getDisplay('region', $tag, Language::apiLanguage()),
        ];
    }


    /**
     * Checks if the provided language is a valid and actively used language within the system.
     *
     * @param string $lang The language code to check (e.g., "en").
     *
     * @return bool True if the language is valid and used, false otherwise.
     */
    public static function isLang(string $lang)
    {
        $apiLanguages = Internationalization::getAcceptedLanguages();

        return in_array($lang, $apiLanguages);
    }
}
