<?php

namespace N3ttech\Content\Infrastructure\Query\Page;

use N3ttech\Content\Application\Page\Query;

final class InMemoryPageQuery implements Query\V1\PageQuery
{
    /** @var Query\ReadModel\PageCollection */
    private $entities;

    /**
     * @param Query\ReadModel\PageCollection|null $entities
     */
    public function __construct(Query\ReadModel\PageCollection $entities = null)
    {
        if (null === $entities) {
            $entities = new Query\ReadModel\PageCollection([]);
        }

        $this->entities = $entities;
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByKey(Query\V1\FindOneByKey $query): void
    {
        $this->checkExistence($query->getKey());

        $query->addPage($this->entities->get($query->getKey()));
    }

    /**
     * @param string $key
     *
     * @throws \RuntimeException
     */
    private function checkExistence(string $key): void
    {
        if (false === $this->entities->has($key)) {
            throw new \RuntimeException(\sprintf('Page does not exists on given key: %s', $key));
        }
    }
}
