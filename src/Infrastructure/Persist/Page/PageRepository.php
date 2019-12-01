<?php

namespace N3ttech\Content\Infrastructure\Persist\Page;

use N3ttech\Content\Domain\Model\Page\Page;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\Persist\AggregateRepository;

final class PageRepository extends AggregateRepository
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
     * @param string $key
     *
     * @throws \Assert\AssertionFailedException
     *
     * @return AggregateRoot|Page
     */
    public function find(string $key): AggregateRoot
    {
        return $this->findAggregateRoot(Page\Key::fromString($key));
    }
}
