<?php

namespace N3ttech\Content\Application\Blog\Service;

use N3ttech\Content\Application\Blog\Command;
use N3ttech\Messaging\Manager\CommandManager;

final class EntryCommandManager extends CommandManager
{
    /**
     * @param string $uuid
     */
    public function create(string $uuid): void
    {
        $this->command(new Command\CreateEntry($uuid));
    }

    /**
     * @param string $uuid
     * @param int    $releaseDate
     */
    public function release(string $uuid, int $releaseDate): void
    {
        $this->command(new Command\ReleaseEntry($uuid, $releaseDate));
    }

    /**
     * @param string   $uuid
     * @param string[] $categories
     */
    public function categorize(string $uuid, array $categories): void
    {
        $this->command(new Command\CategorizeEntry($uuid, $categories));
    }

    /**
     * @param string   $uuid
     * @param string[] $names
     * @param string[] $contents
     */
    public function translate(string $uuid, array $names, array $contents): void
    {
        $this->command(new Command\TranslateEntry($uuid, $names, $contents));
    }

    /**
     * @param string $uuid
     */
    public function show(string $uuid): void
    {
        $this->command(new Command\ShowEntry($uuid));
    }

    /**
     * @param string $uuid
     */
    public function hide(string $uuid): void
    {
        $this->command(new Command\HideEntry($uuid));
    }

    /**
     * @param string $uuid
     */
    public function remove(string $uuid): void
    {
        $this->command(new Command\RemoveEntry($uuid));
    }
}
