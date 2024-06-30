<?php

declare(strict_types=1);

namespace UpiCore\Localization\Interfaces;

interface HTTPMessageInterface
{
    public function getStatus(): int;

    public function getMessage(): string;
}