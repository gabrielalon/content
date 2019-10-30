<?php

namespace N3ttech\Content\Infrastructure\Persist\Snippet;

use N3ttech\Content\Domain\Model\Snippet\Snippet;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\Persist\AggregateRepository;
use N3ttech\Valuing as VO;

class SnippetRepository extends AggregateRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAggregateRootClass(): string
    {
        return Snippet::class;
    }

    /**
     * @param Snippet $snippet
     *
     * @throws \Exception
     */
    public function save(Snippet $snippet): void
    {
        $this->saveAggregateRoot($snippet);
    }

    /**
     * @param string $uuid
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return AggregateRoot|Snippet
     */
    public function find(string $uuid): AggregateRoot
    {
        return $this->findAggregateRoot(VO\Identity\Uuid::fromIdentity($uuid));
    }
}
