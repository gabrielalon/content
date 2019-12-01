<?php

namespace N3ttech\Content\Application\Page\Service;

use N3ttech\Content\Application\Page\Query;
use N3ttech\Messaging\Manager\QueryManager;
use N3ttech\Messaging\Query\Exception;

final class PageQueryManager extends QueryManager
{
    /**
     * @param string $key
     *
     * @throws Exception\ResourceNotFoundException
     *
     * @return Query\ReadModel\Page
     */
    public function findOnePageByUuid(string $key): Query\ReadModel\Page
    {
        $query = new Query\V1\FindOneByKey($key);

        $this->ask($query);

        return $query->getPage($key);
    }
}
