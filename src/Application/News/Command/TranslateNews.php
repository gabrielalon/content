<?php

namespace N3ttech\Content\Application\News\Command;

final class TranslateNews extends Command
{
    /** @var string[] */
    private $names;

    /** @var string[] */
    private $contents;

    /**
     * @param string   $uuid
     * @param string[] $names
     * @param string[] $contents
     */
    public function __construct(string $uuid, array $names, array $contents)
    {
        $this->setUuid($uuid);
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
