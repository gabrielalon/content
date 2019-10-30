<?php

namespace N3ttech\Content\Application\Blog\Command;

use N3ttech\Content\Infrastructure\Persist\Blog\EntryRepository;
use N3ttech\Messaging\Command\CommandHandling\CommandHandler;

abstract class EntryHandler implements CommandHandler
{
    /** @var EntryRepository */
    protected $repository;

    /**
     * @param EntryRepository $repository
     */
    public function __construct(EntryRepository $repository)
    {
        $this->repository = $repository;
    }
}
