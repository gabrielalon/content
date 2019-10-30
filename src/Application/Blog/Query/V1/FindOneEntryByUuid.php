<?php

namespace N3ttech\Content\Application\Blog\Query\V1;

class FindOneEntryByUuid extends EntryableQuery
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
