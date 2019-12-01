<?php

namespace N3ttech\Content\Application\News\Service;

use N3ttech\Content\Application\News\Command;
use N3ttech\Messaging\Manager\CommandManager;

final class NewsCommandManager extends CommandManager
{
    /**
     * @param string $uuid
     */
    public function create(string $uuid): void
    {
        $this->command(new Command\CreateNews($uuid));
    }

    /**
     * @param string $uuid
     * @param int    $releaseDate
     */
    public function release(string $uuid, int $releaseDate): void
    {
        $this->command(new Command\ReleaseNews($uuid, $releaseDate));
    }

    /**
     * @param string   $uuid
     * @param string[] $sites
     */
    public function site(string $uuid, array $sites): void
    {
        $this->command(new Command\SiteNews($uuid, $sites));
    }

    /**
     * @param string   $uuid
     * @param string[] $names
     * @param string[] $contents
     */
    public function translate(string $uuid, array $names, array $contents): void
    {
        $this->command(new Command\TranslateNews($uuid, $names, $contents));
    }

    /**
     * @param string $uuid
     */
    public function show(string $uuid): void
    {
        $this->command(new Command\ShowNews($uuid));
    }

    /**
     * @param string $uuid
     */
    public function hide(string $uuid): void
    {
        $this->command(new Command\HideNews($uuid));
    }

    /**
     * @param string $uuid
     */
    public function remove(string $uuid): void
    {
        $this->command(new Command\RemoveNews($uuid));
    }
}
