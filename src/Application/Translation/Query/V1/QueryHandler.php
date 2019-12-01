<?php

namespace N3ttech\Content\Application\Translation\Query\V1;

abstract class QueryHandler implements \N3ttech\Messaging\Query\QueryHandling\QueryHandler
{
    /** @var TranslationQuery */
    protected $query;

    /**
     * @param TranslationQuery $query
     */
    public function __construct(TranslationQuery $query)
    {
        $this->query = $query;
    }
}
