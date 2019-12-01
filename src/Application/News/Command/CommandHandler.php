<?php

namespace N3ttech\Content\Application\News\Command;

use N3ttech\Content\Infrastructure\Persist\News\NewsRepository;

abstract class CommandHandler implements \N3ttech\Messaging\Command\CommandHandling\CommandHandler
{
    /** @var NewsRepository */
    protected $repository;

    /**
     * @param NewsRepository $repository
     */
    public function __construct(NewsRepository $repository)
    {
        $this->repository = $repository;
    }
}
