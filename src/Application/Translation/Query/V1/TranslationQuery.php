<?php

namespace N3ttech\Content\Application\Translation\Query\V1;

interface TranslationQuery
{
    /**
     * @param FindOneByKey $query
     */
    public function findOneByKey(FindOneByKey $query): void;
}
