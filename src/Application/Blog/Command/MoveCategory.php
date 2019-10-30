<?php

namespace N3ttech\Content\Application\Blog\Command;

class MoveCategory extends Command
{
    /** @var string */
    private $parental;

    /**
     * @param string $uuid
     * @param string $parental
     */
    public function __construct(string $uuid, string $parental)
    {
        $this->setUuid($uuid);
        $this->parental = $parental;
    }

    /**
     * @return string
     */
    public function getParental(): string
    {
        return $this->parental;
    }
}
