<?php

namespace N3ttech\Content\Application\News\Command;

final class SiteNews extends Command
{
    /** @var string[] */
    private $sites;

    /**
     * @param string   $uuid
     * @param string[] $sites
     */
    public function __construct(string $uuid, array $sites)
    {
        $this->setUuid($uuid);
        $this->sites = $sites;
    }

    /**
     * @return string[]
     */
    public function getSites(): array
    {
        return $this->sites;
    }
}
