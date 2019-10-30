<?php

namespace N3ttech\Content\Infrastructure\Persist\News;

use N3ttech\Content\Domain\Model\News\News;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\Persist\AggregateRepository;
use N3ttech\Valuing as VO;

class NewsRepository extends AggregateRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAggregateRootClass(): string
    {
        return News::class;
    }

    /**
     * @param News $news
     *
     * @throws \Exception
     */
    public function save(News $news): void
    {
        $this->saveAggregateRoot($news);
    }

    /**
     * @param string $uuid
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return AggregateRoot|News
     */
    public function find(string $uuid): AggregateRoot
    {
        return $this->findAggregateRoot(VO\Identity\Uuid::fromIdentity($uuid));
    }
}
