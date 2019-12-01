<?php

namespace N3ttech\Content\Application\Page\Command;

abstract class Command extends \N3ttech\Messaging\Command\Command\Command
{
    /** @var string */
    private $key;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    protected function setKey(string $key): void
    {
        $this->key = $key;
    }
}
