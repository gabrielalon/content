<?php

namespace N3ttech\Content\Application\Page\Command;

final class TranslatePage extends Command
{
    /** @var string[] */
    private $names;

    /** @var string[] */
    private $contents;

    /**
     * @param string   $key
     * @param string[] $names
     * @param string[] $contents
     */
    public function __construct(string $key, array $names, array $contents)
    {
        $this->setKey($key);
        $this->names = $names;
        $this->contents = $contents;
    }

    /**
     * @return string[]
     */
    public function getNames(): array
    {
        return $this->names;
    }

    /**
     * @return string[]
     */
    public function getContents(): array
    {
        return $this->contents;
    }
}
