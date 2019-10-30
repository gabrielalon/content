<?php

namespace N3ttech\Content\Application\Blog\Query\V1;

use N3ttech\Messaging\Query\QueryHandling\QueryHandler;

abstract class EntryQueryHandler implements QueryHandler
{
    /** @var EntryQuery */
    protected $ask;

    /**
     * @param EntryQuery $ask
     */
    public function __construct(EntryQuery $ask)
    {
        $this->ask = $ask;
    }
}
