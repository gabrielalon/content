<?php

namespace N3ttech\Content\Application\Translation\Command;

final class SiteTranslation extends Command
{
    /** @var string[] */
    private $sites;

    /**
     * @param string   $key
     * @param string[] $sites
     */
    public function __construct(string $key, array $sites)
    {
        $this->setKey($key);
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
