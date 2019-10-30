<?php

namespace N3ttech\Content\Application\Blog\Service;

use N3ttech\Content\Application\Blog\Query;
use N3ttech\Messaging\Manager\QueryManager;
use N3ttech\Messaging\Query\Exception;

class EntryQueryManager extends QueryManager
{
    /**
     * @param string $uuid
     *
     * @throws Exception\ResourceNotFoundException
     *
     * @return Query\ReadModel\Entry
     */
    public function findOneEntryByUuid(string $uuid): Query\ReadModel\Entry
    {
        $query = new Query\V1\FindOneEntryByUuid($uuid);

        $this->ask($query);

        return $query->getEntry($uuid);
    }

    /**
     * @return Query\ReadModel\EntryCollection
     */
    public function findAllActiveEntries(): Query\ReadModel\EntryCollection
    {
        $query = new Query\V1\FindAllActiveEntries();

        $this->ask($query);

        return $query->getCollection();
    }
}
