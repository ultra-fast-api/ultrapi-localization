<?php

declare(strict_types=1);

namespace UpiCore\Localization;

use UpiCore\Exception\UpiException;
use UpiCore\Localization\Internationalization;

class Language
{

    protected static $languageFile = null;

    public function __construct()
    {
        if (!self::$languageFile)
            self::$languageFile = (new \UpiCore\Localization\Locale())->getLocalizationFile();

        if (null === $this->apiLanguage())
            $this->selfThrowException('LOCALIZATION_DEFAULT_LOCALE_NOT_SPECIFIED');
    }

    public static function instance(): self
    {
        return new self();
    }

    public static function apiLanguage(): string
    {
        return Internationalization::getLanguageCode();
    }

    public static function apiTimezone(): string
    {
        return Internationalization::getTimezone();
    }

    public static function getTextAll(string $key, string ...$args): string
    {
        try {
            $categoryAndText = \explode('_', $key);
            $getText = self::instance()::$languageFile[$categoryAndText[0]][$key] ?? null;

            if (null === $getText)
                self::selfThrowException('LOCALIZATION_TRANSLATION_NOT_FOUND');

            return [] === $args ? $getText : \sprintf($getText, ...$args);
        } catch (UpiException $e) {
            echo $e;
            exit;
        }
    }

    public static function getText(string $key, string ...$args): string
    {
        try {
            $pureText = self::getTextAll($key, ...$args);

            return \count($text = \explode('/', $pureText)) > 1 ? $text[1] : $text[0];
        } catch (UpiException $e) {
            echo $e;
            exit;
        }
    }

    public static function createHttpMessage(string $pureText): \UpiCore\Localization\Message\HTTPMessage
    {
        return new \UpiCore\Localization\Message\HTTPMessage(self::getTextAll($pureText));
    }

    protected static final function selfThrowException(string $key)
    {
        $selfException = new class extends UpiException
        {
            public function __construct($code = 0, $message = '')
            {
                $this->code = $code;
                $this->message = $message;
            }
        };

        try {
            $categoryAndText = \explode('_', $key);
            $message = self::instance()::$languageFile[$categoryAndText[0]][$key] ?? null;

            if ($message)
                list($status, $message) = \UpiCore\Localization\Message\HTTPMessage::parseTextMessage($message);
            else
                list($status, $message) = [500, null];

            throw new $selfException($status, $message);
        } catch (UpiException $e) {
            echo $e;
            exit;
        }
    }
}
