<?php

namespace N3ttech\Content\Infrastructure\Query\Translation;

use N3ttech\Content\Application\Translation\Query;

final class InMemoryTranslationQuery implements Query\V1\TranslationQuery
{
    /** @var Query\ReadModel\TranslationCollection */
    private $entities;

    /**
     * @param Query\ReadModel\TranslationCollection|null $entities
     */
    public function __construct(Query\ReadModel\TranslationCollection $entities = null)
    {
        if (null === $entities) {
            $entities = new Query\ReadModel\TranslationCollection([]);
        }

        $this->entities = $entities;
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByKey(Query\V1\FindOneByKey $query): void
    {
        $this->checkExistence($query->getKey());

        $query->addTranslation($this->entities->get($query->getKey()));
    }

    /**
     * @param string $key
     *
     * @throws \RuntimeException
     */
    private function checkExistence(string $key): void
    {
        if (false === $this->entities->has($key)) {
            throw new \RuntimeException(\sprintf('Translation does not exists on given key: %s', $key));
        }
    }
}
