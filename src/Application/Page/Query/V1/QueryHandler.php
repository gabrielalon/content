<?php

namespace N3ttech\Content\Application\Page\Query\V1;

abstract class QueryHandler implements \N3ttech\Messaging\Query\QueryHandling\QueryHandler
{
    /** @var PageQuery */
    protected $query;

    /**
     * @param PageQuery $query
     */
    public function __construct(PageQuery $query)
    {
        $this->query = $query;
    }
}
