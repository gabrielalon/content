<?php

namespace N3ttech\Content\Application\News\Query\V1;

final class FindAllSitedNews extends Query
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
