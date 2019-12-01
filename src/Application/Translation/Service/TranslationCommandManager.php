<?php

namespace N3ttech\Content\Application\Translation\Service;

use N3ttech\Content\Application\Translation\Command;
use N3ttech\Messaging\Manager\CommandManager;

final class TranslationCommandManager extends CommandManager
{
    /**
     * @param string $key
     */
    public function create(string $key): void
    {
        $this->command(new Command\CreateTranslation($key));
    }

    /**
     * @param string   $key
     * @param string[] $values
     */
    public function update(string $key, array $values): void
    {
        $this->command(new Command\UpdateTranslation($key, $values));
    }

    /**
     * @param string   $key
     * @param string[] $sites
     */
    public function site(string $key, array $sites): void
    {
        $this->command(new Command\SiteTranslation($key, $sites));
    }

    /**
     * @param string $key
     */
    public function remove(string $key): void
    {
        $this->command(new Command\RemoveTranslation($key));
    }
}
