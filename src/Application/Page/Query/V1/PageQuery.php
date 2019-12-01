<?php

namespace N3ttech\Content\Application\Page\Query\V1;

interface PageQuery
{
    /**
     * @param FindOneByKey $query
     */
    public function findOneByKey(FindOneByKey $query): void;
}
