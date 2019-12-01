<?php

namespace N3ttech\Content\Infrastructure\Persist\Translation;

use N3ttech\Content\Domain\Model\Translation\Translation;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\Persist\AggregateRepository;

final class TranslationRepository extends AggregateRepository
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
     * @param string $key
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return AggregateRoot|Translation
     */
    public function find(string $key): AggregateRoot
    {
        return $this->findAggregateRoot(Translation\Key::fromString($key));
    }
}
