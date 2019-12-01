<?php

namespace N3ttech\Content\Application\News\Query\V1;

final class FindOneNewsByUuid extends Query
{
    /** @var string */
    private $uuid;

    /**
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }
}
