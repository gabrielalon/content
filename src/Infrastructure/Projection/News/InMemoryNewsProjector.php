<?php

namespace N3ttech\Content\Infrastructure\Projection\News;

use N3ttech\Content\Application\News\Event;
use N3ttech\Content\Application\News\Query\ReadModel;
use N3ttech\Content\Domain\Model\News\Projection\NewsProjection;

final class InMemoryNewsProjector implements NewsProjection
{
    /** @var ReadModel\NewsCollection */
    private $entities;

    /**
     * @param ReadModel\NewsCollection|null $entities
     */
    public function __construct(ReadModel\NewsCollection $entities = null)
    {
        if (null === $entities) {
            $entities = new ReadModel\NewsCollection([]);
        }

        $this->entities = $entities;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    public function onNewNewsCreated(Event\NewNewsCreated $event): void
    {
        $this->entities->add(ReadModel\News::fromUuid($event->newsUuid())
            ->setCreationDate($event->newsCreationDate())
        );
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    public function onExistingNewsTranslated(Event\ExistingNewsTranslated $event): void
    {
        $this->checkExistence($event->aggregateId());

        $news = $this->entities->get($event->aggregateId())
            ->setNames($event->newsContent()->names())
            ->setContents($event->newsContent()->texts())
        ;

        $this->entities->add($news);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    public function onExistingNewsReleased(Event\ExistingNewsReleased $event): void
    {
        $this->checkExistence($event->aggregateId());

        $news = $this->entities->get($event->aggregateId())
            ->setReleaseDate($event->newsRelease()->releaseDate())
            ->setHidden($event->newsRelease()->hidden())
        ;

        $this->entities->add($news);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    public function onExistingNewsSited(Event\ExistingNewsSited $event): void
    {
        $this->checkExistence($event->aggregateId());

        $news = $this->entities->get($event->aggregateId())
            ->setSites($event->newsSites())
        ;

        $this->entities->add($news);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
     */
    public function onExistingNewsRemoved(Event\ExistingNewsRemoved $event): void
    {
        $this->checkExistence($event->aggregateId());

        $this->entities->remove($event->aggregateId());
    }

    /**
     * @param string $uuid
     *
     * @throws \RuntimeException
     *
     * @return ReadModel\News
     */
    public function get(string $uuid): ReadModel\News
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
            throw new \RuntimeException(\sprintf('News does not exists on given uuid: %s', $uuid));
        }
    }
}
