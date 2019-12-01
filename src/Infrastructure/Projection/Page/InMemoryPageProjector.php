<?php

namespace N3ttech\Content\Infrastructure\Projection\Page;

use N3ttech\Content\Application\Page\Event;
use N3ttech\Content\Application\Page\Query\ReadModel;
use N3ttech\Content\Domain\Model\Page\Projection\PageProjection;

final class InMemoryPageProjector implements PageProjection
{
    /** @var ReadModel\PageCollection */
    private $entities;

    /**
     * @param ReadModel\PageCollection|null $entities
     */
    public function __construct(ReadModel\PageCollection $entities = null)
    {
        if (null === $entities) {
            $entities = new ReadModel\PageCollection([]);
        }

        $this->entities = $entities;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    public function onNewPageCreated(Event\NewPageCreated $event): void
    {
        $this->entities->add(ReadModel\Page::fromKey($event->pageKey()));
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    public function onExistingPageTranslated(Event\ExistingPageTranslated $event): void
    {
        $this->checkExistence($event->aggregateId());

        $page = $this->entities->get($event->aggregateId())
            ->setNames($event->pageContent()->names())
            ->setContents($event->pageContent()->texts())
        ;

        $this->entities->add($page);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    public function onExistingPageSited(Event\ExistingPageSited $event): void
    {
        $this->checkExistence($event->aggregateId());

        $page = $this->entities->get($event->aggregateId())
            ->setSites($event->pageSites())
        ;

        $this->entities->add($page);
    }

    /**
     * {@inheritdoc}
     */
    public function onExistingPageRemoved(Event\ExistingPageRemoved $event): void
    {
        $this->checkExistence($event->aggregateId());

        $this->entities->remove($event->aggregateId());
    }

    /**
     * @param string $key
     *
     * @return ReadModel\Page
     *
     * @throws \RuntimeException
     */
    public function get(string $key): ReadModel\Page
    {
        $this->checkExistence($key);

        return $this->entities->get($key);
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
