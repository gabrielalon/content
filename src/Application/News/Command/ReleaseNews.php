<?php

namespace N3ttech\Content\Application\News\Command;

final class ReleaseNews extends Command
{
    /** @var int */
    private $releaseDate;

    /** @var bool */
    private $hidden;

    /**
     * @param string $uuid
     * @param int    $releaseDate
     * @param bool   $hidden
     */
    public function __construct(string $uuid, int $releaseDate, bool $hidden = false)
    {
        $this->setUuid($uuid);
        $this->releaseDate = $releaseDate;
        $this->hidden = $hidden;
    }

    /**
     * @return int
     */
    public function getReleaseDate(): int
    {
        return $this->releaseDate;
    }

    /**
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->hidden;
    }
}
