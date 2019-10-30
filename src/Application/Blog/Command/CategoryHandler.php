<?php

namespace N3ttech\Content\Application\Blog\Command;

use N3ttech\Content\Infrastructure\Persist\Blog\CategoryRepository;
use N3ttech\Messaging\Command\CommandHandling\CommandHandler;

abstract class CategoryHandler implements CommandHandler
{
    /** @var CategoryRepository */
    protected $repository;

    /**
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }
}
