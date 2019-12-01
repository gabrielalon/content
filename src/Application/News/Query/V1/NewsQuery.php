<?php

namespace N3ttech\Content\Application\News\Query\V1;

interface NewsQuery
{
    /**
     * @param FindAllActiveNews $event
     */
    public function findAllActiveNews(FindAllActiveNews $event): void;

    /**
     * @param FindAllSitedNews $event
     */
    public function findAllSitedNews(FindAllSitedNews $event): void;

    /**
     * @param FindOneNewsByUuid $event
     */
    public function findOneNewsByUuid(FindOneNewsByUuid $event): void;
}
