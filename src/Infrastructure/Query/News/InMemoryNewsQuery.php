<?php

namespace N3ttech\Content\Infrastructure\Query\News;

use N3ttech\Content\Application\News\Query;

final class InMemoryNewsQuery implements Query\V1\NewsQuery
{
    /** @var Query\ReadModel\NewsCollection */
    private $entities;

    /**
     * @param Query\ReadModel\NewsCollection|null $entities
     */
    public function __construct(Query\ReadModel\NewsCollection $entities = null)
    {
        if (null === $entities) {
            $entities = new Query\ReadModel\NewsCollection([]);
        }

        $this->entities = $entities;
    }

    /**
     * {@inheritdoc}
     */
    public function findAllActiveNews(Query\V1\FindAllActiveNews $event): void
    {
        foreach ($this->entities->getArrayCopy() as $news) {
            $event->addNews($news);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findAllSitedNews(Query\V1\FindAllSitedNews $event): void
    {
        foreach ($this->entities->getArrayCopy() as $news) {
            $event->addNews($news);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findOneNewsByUuid(Query\V1\FindOneNewsByUuid $event): void
    {
        $this->checkExistence($event->getUuid());

        $event->addNews($this->entities->get($event->getUuid()));
    }

    /**
     * @param string $uuid
     *
     * @throws \RuntimeException
     */
    private function checkExistence(string $uuid): void
    {
        if (false === $this->entities->has($uuid)) {
            throw new \RuntimeException(\sprintf('News does not exists on given uuid: %s', $uuid));
        }
    }
}
