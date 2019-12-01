<?php

namespace N3ttech\Content\Application\Translation\Service;

use N3ttech\Content\Application\Translation\Query;
use N3ttech\Messaging\Manager\QueryManager;
use N3ttech\Messaging\Query\Exception;

final class TranslationQueryManager extends QueryManager
{
    /**
     * @param string $key
     *
     * @throws Exception\ResourceNotFoundException
     *
     * @return Query\ReadModel\Translation
     */
    public function findOneTranslationByUuid(string $key): Query\ReadModel\Translation
    {
        $query = new Query\V1\FindOneByKey($key);

        $this->ask($query);

        return $query->getTranslation($key);
    }
}
