<?php

namespace N3ttech\Content\Application\Blog\Query\V1;

use N3ttech\Messaging\Query\QueryHandling\QueryHandler;

abstract class EntryQueryHandler implements QueryHandler
{
    /** @var EntryQuery */
    protected $query;

    /**
     * @param EntryQuery $query
     */
    public function __construct(EntryQuery $query)
    {
        $this->query = $query;
    }
}
