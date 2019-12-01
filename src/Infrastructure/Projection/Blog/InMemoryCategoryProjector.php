<?php

namespace N3ttech\Content\Infrastructure\Projection\Blog;

use N3ttech\Content\Application\Blog\Event;
use N3ttech\Content\Application\Blog\Query\ReadModel;
use N3ttech\Content\Domain\Model\Blog\Projection\CategoryProjection;

class InMemoryCategoryProjector implements CategoryProjection
{
    /** @var ReadModel\CategoryCollection */
    private $entities;

    /**
     * @param ReadModel\CategoryCollection|null $entities
     */
    public function __construct(ReadModel\CategoryCollection $entities = null)
    {
        if (null === $entities) {
            $entities = new ReadModel\CategoryCollection([]);
        }

        $this->entities = $entities;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    public function onNewCategoryCreated(Event\NewCategoryCreated $event): void
    {
        $this->entities->add(ReadModel\Category::fromUuid($event->categoryUuid()));
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingCategoryMoved(Event\ExistingCategoryMoved $event): void
    {
        $this->checkExistence($event->aggregateId());

        $category = $this->entities->get($event->aggregateId())
            ->setParental($event->categoryParental())
        ;

        $this->entities->add($category);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingCategorySited(Event\ExistingCategorySited $event): void
    {
        $this->checkExistence($event->aggregateId());

        $category = $this->entities->get($event->aggregateId())
            ->setSites($event->categorySites())
        ;

        $this->entities->add($category);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingCategoryTranslated(Event\ExistingCategoryTranslated $event): void
    {
        $this->checkExistence($event->aggregateId());

        $category = $this->entities->get($event->aggregateId())
            ->setNames($event->categoryNames())
        ;

        $this->entities->add($category);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     * @throws \RuntimeException
     */
    public function onExistingCategoryRemoved(Event\ExistingCategoryRemoved $event): void
    {
        $this->checkExistence($event->aggregateId());

        $this->entities->remove($event->aggregateId());
    }

    /**
     * @param string $uuid
     *
     * @throws \RuntimeException
     *
     * @return ReadModel\Category
     */
    public function get(string $uuid): ReadModel\Category
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
            throw new \RuntimeException(\sprintf('Category does not exists on given uuid: %s', $uuid));
        }
    }
}
