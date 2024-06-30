<?php

declare(strict_types=1);

namespace UpiCore\Localization\LanguageLocale;

class LocaleOption
{
    private $code;
    private $charset;
    private $timezone;
    private $languageName;
    private $country;
    private $dateFormat;
    private $timeFormat;
    private $currency;
    private $numberFormat;

    public function __construct(array $config)
    {
        $this->code         = $config['CODE'] ?? '';
        $this->charset      = $config['CHARSET'] ?? 'UTF-8';
        $this->timezone     = $config['TIMEZONE'] ?? 'UTC';
        $this->languageName = $config['LANGUAGE_NAME'] ?? '';
        $this->country      = $config['COUNTRY'] ?? '';
        $this->dateFormat   = $config['DATE_FORMAT'] ?? 'Y-m-d';
        $this->timeFormat   = $config['TIME_FORMAT'] ?? 'H:i:s';
        $this->currency     = $config['CURRENCY'] ?? '';
        $this->numberFormat = $config['NUMBER_FORMAT'] ?? [
            'DECIMAL_SEPARATOR' => '.',
            'THOUSAND_SEPARATOR' => ','
        ];
    }

    public function getLanguageCode()
    {
        return $this->code;
    }

    public function getCharset()
    {
        return $this->charset;
    }

    public function getTimezone()
    {
        return $this->timezone;
    }

    public function getLanguageName()
    {
        return $this->languageName;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    public function getTimeFormat()
    {
        return $this->timeFormat;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getNumberFormat()
    {
        return $this->numberFormat;
    }

    public function getItemAsArray(): array
    {
        return [
            'CODE'          => $this->code,
            'CHARSET'       => $this->charset,
            'TIMEZONE'      => $this->timezone,
            'LANGUAGE_NAME' => $this->languageName,
            'COUNTRY'       => $this->country,
            'DATE_FORMAT'   => $this->dateFormat,
            'TIME_FORMAT'   => $this->timeFormat,
            'CURRENCY'      => $this->currency,
            'NUMBER_FORMAT' => $this->numberFormat
        ];
    }
}
