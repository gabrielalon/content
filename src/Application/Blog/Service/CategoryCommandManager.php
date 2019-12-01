<?php

namespace N3ttech\Content\Application\Blog\Service;

use N3ttech\Content\Application\Blog\Command;
use N3ttech\Messaging\Manager\CommandManager;

final class CategoryCommandManager extends CommandManager
{
    /**
     * @param string $uuid
     */
    public function create(string $uuid): void
    {
        $this->command(new Command\CreateCategory($uuid));
    }

    /**
     * @param string $uuid
     * @param string $parental
     */
    public function move(string $uuid, string $parental): void
    {
        $this->command(new Command\MoveCategory($uuid, $parental));
    }

    /**
     * @param string   $uuid
     * @param string[] $names
     */
    public function translate(string $uuid, array $names): void
    {
        $this->command(new Command\TranslateCategory($uuid, $names));
    }

    /**
     * @param string   $uuid
     * @param string[] $sites
     */
    public function site(string $uuid, array $sites): void
    {
        $this->command(new Command\SiteCategory($uuid, $sites));
    }

    /**
     * @param string $uuid
     */
    public function remove(string $uuid): void
    {
        $this->command(new Command\RemoveCategory($uuid));
    }
}
