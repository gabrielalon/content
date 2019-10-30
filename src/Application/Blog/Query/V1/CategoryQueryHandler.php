<?php

namespace N3ttech\Content\Application\Blog\Query\V1;

use N3ttech\Messaging\Query\QueryHandling\QueryHandler;

abstract class CategoryQueryHandler implements QueryHandler
{
    /** @var CategoryQuery */
    protected $ask;

    /**
     * @param CategoryQuery $ask
     */
    public function __construct(CategoryQuery $ask)
    {
        $this->ask = $ask;
    }
}
