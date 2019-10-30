<?php

namespace N3ttech\Content\Infrastructure\Persist\Page;

use N3ttech\Content\Domain\Model\Page\Page;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\Persist\AggregateRepository;
use N3ttech\Valuing as VO;

class PageRepository extends AggregateRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAggregateRootClass(): string
    {
        return Page::class;
    }

    /**
     * @param Page $page
     *
     * @throws \Exception
     */
    public function save(Page $page): void
    {
        $this->saveAggregateRoot($page);
    }

    /**
     * @param string $uuid
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return AggregateRoot|Page
     */
    public function find(string $uuid): AggregateRoot
    {
        return $this->findAggregateRoot(VO\Identity\Uuid::fromIdentity($uuid));
    }
}
