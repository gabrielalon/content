<?php

namespace N3ttech\Content\Application\Blog\Command;

final class TranslateCategory extends Command
{
    /** @var string[] */
    private $names;

    /**
     * @param string   $uuid
     * @param string[] $names
     */
    public function __construct(string $uuid, array $names)
    {
        $this->setUuid($uuid);
        $this->names = $names;
    }

    /**
     * @return string[]
     */
    public function getNames(): array
    {
        return $this->names;
    }
}
