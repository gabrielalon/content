<?php

namespace N3ttech\Content\Infrastructure\Projection\Translation;

use N3ttech\Content\Application\Translation\Event;
use N3ttech\Content\Application\Translation\Query\ReadModel;
use N3ttech\Content\Domain\Model\Translation\Projection\TranslationProjection;

final class InMemoryTranslationProjector implements TranslationProjection
{
    /** @var ReadModel\TranslationCollection */
    private $entities;

    /**
     * @param ReadModel\TranslationCollection|null $entities
     */
    public function __construct(ReadModel\TranslationCollection $entities = null)
    {
        if (null === $entities) {
            $entities = new ReadModel\TranslationCollection([]);
        }

        $this->entities = $entities;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    public function onNewTranslationCreated(Event\NewTranslationCreated $event): void
    {
        $this->entities->add(ReadModel\Translation::fromKey($event->translationKey()));
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    public function onExistingTranslationUpdated(Event\ExistingTranslationUpdated $event): void
    {
        $this->checkExistence($event->aggregateId());

        $translation = $this->entities->get($event->aggregateId())
            ->setValues($event->translationValues())
        ;

        $this->entities->add($translation);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Assert\AssertionFailedException
     */
    public function onExistingTranslationSited(Event\ExistingTranslationSited $event): void
    {
        $this->checkExistence($event->aggregateId());

        $translation = $this->entities->get($event->aggregateId())
            ->setSites($event->translationSites())
        ;

        $this->entities->add($translation);
    }

    /**
     * {@inheritdoc}
     */
    public function onExistingTranslationRemoved(Event\ExistingTranslationRemoved $event): void
    {
        $this->checkExistence($event->aggregateId());

        $this->entities->remove($event->aggregateId());
    }

    /**
     * @param string $key
     *
     * @return ReadModel\Translation
     *
     * @throws \RuntimeException
     */
    public function get(string $key): ReadModel\Translation
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
            throw new \RuntimeException(\sprintf('Translation does not exists on given key: %s', $key));
        }
    }
}
