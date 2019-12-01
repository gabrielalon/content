<?php

namespace N3ttech\Content\Application\News\Service;

use N3ttech\Content\Application\News\Query;
use N3ttech\Messaging\Manager\QueryManager;
use N3ttech\Messaging\Query\Exception;

final class NewsQueryManager extends QueryManager
{
    /**
     * @param string $uuid
     *
     * @throws Exception\ResourceNotFoundException
     *
     * @return Query\ReadModel\News
     */
    public function findOneNewsByUuid(string $uuid): Query\ReadModel\News
    {
        $query = new Query\V1\FindOneNewsByUuid($uuid);

        $this->ask($query);

        return $query->getNews($uuid);
    }

    /**
     * @return Query\ReadModel\NewsCollection
     */
    public function findAllActiveNews(): Query\ReadModel\NewsCollection
    {
        $query = new Query\V1\FindAllActiveNews();

        $this->ask($query);

        return $query->getCollection();
    }

    /**
     * @param string $site
     *
     * @return Query\ReadModel\NewsCollection
     */
    public function findAllSitedNews(string $site): Query\ReadModel\NewsCollection
    {
        $query = new Query\V1\FindAllSitedNews($site);

        $this->ask($query);

        return $query->getCollection();
    }
}
