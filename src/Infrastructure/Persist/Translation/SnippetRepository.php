<?php

namespace N3ttech\Content\Infrastructure\Persist\Translation;

use N3ttech\Content\Domain\Model\Translation\Translation;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\Persist\AggregateRepository;
use N3ttech\Valuing as VO;

class TranslationRepository extends AggregateRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAggregateRootClass(): string
    {
        return Translation::class;
    }

    /**
     * @param Translation $snippet
     *
     * @throws \Exception
     */
    public function save(Translation $snippet): void
    {
        $this->saveAggregateRoot($snippet);
    }

    /**
     * @param string $uuid
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return AggregateRoot|Translation
     */
    public function find(string $uuid): AggregateRoot
    {
        return $this->findAggregateRoot(VO\Identity\Uuid::fromIdentity($uuid));
    }
}
