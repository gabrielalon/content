<?php

namespace N3ttech\Content\Application\Blog\Service;

use N3ttech\Content\Application\Blog\Query;
use N3ttech\Messaging\Manager\QueryManager;
use N3ttech\Messaging\Query\Exception;

class CategoryQueryManager extends QueryManager
{
    /**
     * @param string $uuid
     *
     * @throws Exception\ResourceNotFoundException
     *
     * @return Query\ReadModel\Category
     */
    public function findOneCategoryByUuid(string $uuid): Query\ReadModel\Category
    {
        $query = new Query\V1\FindOneCategoryByUuid($uuid);

        $this->ask($query);

        return $query->getCategory($uuid);
    }

    /**
     * @param string $site
     *
     * @return Query\ReadModel\CategoryCollection
     */
    public function findAllSitedCategories(string $site): Query\ReadModel\CategoryCollection
    {
        $query = new Query\V1\FindAllSitedCategories($site);

        $this->ask($query);

        return $query->getCollection();
    }
}
