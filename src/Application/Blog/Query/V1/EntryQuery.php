<?php

namespace N3ttech\Content\Application\Blog\Query\V1;

interface EntryQuery
{
    /**
     * @param FindOneEntryByUuid $query
     */
    public function findOneEntryByUuid(FindOneEntryByUuid $query): void;

    /**
     * @param FindAllActiveEntries $query
     */
    public function findAllActiveEntries(FindAllActiveEntries $query): void;
}
