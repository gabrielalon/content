<?php

namespace N3ttech\Content\Application\Translation\Command;

use N3ttech\Content\Infrastructure\Persist\Translation\TranslationRepository;

abstract class CommandHandler implements \N3ttech\Messaging\Command\CommandHandling\CommandHandler
{
    /** @var TranslationRepository */
    protected $repository;

    /**
     * @param TranslationRepository $repository
     */
    public function __construct(TranslationRepository $repository)
    {
        $this->repository = $repository;
    }
}
