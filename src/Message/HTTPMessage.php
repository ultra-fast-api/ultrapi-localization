<?php

declare(strict_types=1);

namespace UpiCore\Localization\Message;

use UpiCore\Localization\Interfaces\HTTPMessageInterface;

class HTTPMessage implements HTTPMessageInterface
{
    protected int $status = 0;

    protected ?string $message = null;

    public function __construct(string $textMessage)
    {
        list($status, $message) = self::parseTextMessage($textMessage);

        $this->status = $status;
        $this->message = $message;
    }

    public static function parseTextMessage(string $pureText)
    {
        $text = \preg_replace('/\s/', '', $pureText);
        $pureText = \trim($pureText);

        if (\strpos($text, '/') === 3) {
            if (is_numeric(
                $status = \substr($pureText, 0, \strpos($text, '/'))
            ));
            $message = \substr($pureText, \strpos($pureText, '/') + 1);
        }

        return [(int) ($status ?? 0), $message ?? $pureText];
    }

    public function getStatus(): int
    {
        return (int) $this->status;
    }

    public function getMessage(): string
    {
        return (string) $this->message;
    }
}
