<?php

namespace N3ttech\Content\Application\Page\Service;

use N3ttech\Content\Application\Page\Command;
use N3ttech\Messaging\Manager\CommandManager;

final class PageCommandManager extends CommandManager
{
    /**
     * @param string $key
     */
    public function create(string $key): void
    {
        $this->command(new Command\CreatePage($key));
    }

    /**
     * @param string   $key
     * @param string[] $names
     * @param string[] $contents
     */
    public function translate(string $key, array $names, array $contents): void
    {
        $this->command(new Command\TranslatePage($key, $names, $contents));
    }

    /**
     * @param string   $key
     * @param string[] $sites
     */
    public function site(string $key, array $sites): void
    {
        $this->command(new Command\SitePage($key, $sites));
    }

    /**
     * @param string $key
     */
    public function remove(string $key): void
    {
        $this->command(new Command\RemovePage($key));
    }
}
