<?php

namespace N3ttech\Content\Application\Blog\Command;

class UpdateEntry extends Command
{
    /** @var int */
    private $publishDate;

    /**
     * @param string $uuid
     * @param int    $publishDate
     */
    public function __construct(string $uuid, int $publishDate)
    {
        $this->setUuid($uuid);
        $this->publishDate = $publishDate;
    }

    /**
     * @return int
     */
    public function getPublishDate(): int
    {
        return $this->publishDate;
    }
}
