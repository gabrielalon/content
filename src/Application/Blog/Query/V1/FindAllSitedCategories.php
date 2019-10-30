<?php

namespace N3ttech\Content\Application\Blog\Query\V1;

class FindAllSitedCategories extends CategorizableQuery
{
    /** @var string */
    private $site;

    /**
     * @param string $site
     */
    public function __construct(string $site)
    {
        $this->site = $site;
    }

    /**
     * @return string
     */
    public function getSite(): string
    {
        return $this->site;
    }
}
