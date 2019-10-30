<?php

namespace N3ttech\Content\Application\Blog\Query\V1;

interface CategoryQuery
{
    /**
     * @param FindAllSitedCategories $query
     */
    public function findAllSitedCategories(FindAllSitedCategories $query): void;

    /**
     * @param FindOneCategoryByUuid $query
     */
    public function findOneCategoryByUuid(FindOneCategoryByUuid $query): void;
}
