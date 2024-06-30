<?php

declare(strict_types=1);

namespace UpiCore\Localization\LanguageLocale;

use UpiCore\Localization\LanguageLocale\LocaleOption;

class LocaleCollection implements \Iterator
{
    private $languages = [];
    private $position = 0;

    public function __construct($configs)
    {
        foreach ($configs as $config) {
            $this->languages[] = new LocaleOption((array) $config);
        }
        $this->position = 0;
    }

    public function current(): mixed
    {
        return $this->languages[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return isset($this->languages[$this->position]);
    }

    public function getCurrentAsArray(): array
    {
        return $this->languages[$this->position]->getItemAsArray();
    }
}
