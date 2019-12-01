<?php

namespace N3ttech\Content\Application\Blog\Command;

final class SiteCategory extends Command
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
