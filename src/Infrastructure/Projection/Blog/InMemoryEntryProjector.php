<?php

namespace N3ttech\Content\Infrastructure\Projection\Blog;

use N3ttech\Content\Application\Blog\Event;
use N3ttech\Content\Application\Blog\Query\ReadModel;
use N3ttech\Content\Domain\Model\Blog\Projection\EntryProjection;

class InMemoryEntryProjector implements EntryProjection
{
    /** @var ReadModel\EntryCollection */
    private $entities;

    /**
     * @param null|ReadModel\EntryCollection $entities
     */
    public function __construct(ReadModel\EntryCollection $entities = null)
    {
        if (null === $entities) {
            $entities = new ReadModel\EntryCollection([]);
        }

        $this->entities = $entities;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    public function onNewEntryCreated(Event\NewEntryCreated $event): void
    {
        $this->entities->add(
            ReadModel\Entry::fromUuid($event->entryUuid())
                ->setPublishDate($event->entryPublishDate())
        );
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingEntryCategorized(Event\ExistingEntryCategorized $event): void
    {
        $this->checkExistence($event->aggregateId());

        $entry = $this->entities->get($event->aggregateId())
            ->setCategories($event->entryCategories())
        ;

        $this->entities->add($entry);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingEntryHidden(Event\ExistingEntryHidden $event): void
    {
        $this->checkExistence($event->aggregateId());

        $entry = $this->entities->get($event->aggregateId())
            ->setHide($event->entryHide())
        ;

        $this->entities->add($entry);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingEntryShown(Event\ExistingEntryShown $event): void
    {
        $this->checkExistence($event->aggregateId());

        $entry = $this->entities->get($event->aggregateId())
            ->setHide($event->entryHide())
        ;

        $this->entities->add($entry);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingEntryTranslated(Event\ExistingEntryTranslated $event): void
    {
        $this->checkExistence($event->aggregateId());

        $entry = $this->entities->get($event->aggregateId())
            ->setNames($event->entryNames())
            ->setContents($event->entryContents())
        ;

        $this->entities->add($entry);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingEntryUpdated(Event\ExistingEntryUpdated $event): void
    {
        $this->checkExistence($event->aggregateId());

        $entry = $this->entities->get($event->aggregateId())
            ->setPublishDate($event->entryPublishDate())
        ;

        $this->entities->add($entry);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingEntryRemoved(Event\ExistingEntryRemoved $event): void
    {
        $this->checkExistence($event->aggregateId());

        $this->entities->remove($event->aggregateId());
    }

    /**
     * @param string $uuid
     *
     * @throws \RuntimeException
     *
     * @return ReadModel\Entry
     */
    public function get(string $uuid): ReadModel\Entry
    {
        $this->checkExistence($uuid);

        return $this->entities->get($uuid);
    }

    /**
     * @param string $uuid
     *
     * @throws \RuntimeException
     */
    private function checkExistence(string $uuid): void
    {
        if (false === $this->entities->has($uuid)) {
            throw new \RuntimeException(\sprintf(
                'Entry does not exists on given uuid: %s',
                $uuid
            ));
        }
    }
}
