<?php

namespace N3ttech\Content\Application\News\Query\V1;

abstract class QueryHandler implements \N3ttech\Messaging\Query\QueryHandling\QueryHandler
{
    /** @var NewsQuery */
    protected $query;

    /**
     * @param NewsQuery $query
     */
    public function __construct(NewsQuery $query)
    {
        $this->query = $query;
    }
}
