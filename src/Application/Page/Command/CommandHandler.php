<?php

namespace N3ttech\Content\Application\Page\Command;

use N3ttech\Content\Infrastructure\Persist\Page\PageRepository;

abstract class CommandHandler implements \N3ttech\Messaging\Command\CommandHandling\CommandHandler
{
    /** @var PageRepository */
    protected $repository;

    /**
     * @param PageRepository $repository
     */
    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }
}
