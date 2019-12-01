<?php

namespace N3ttech\Content\Domain\Model\Translation;

use N3ttech\Content\Application\Translation\Event;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class Translation extends AggregateRoot
{
    /** @var VO\Intl\Language\Contents */
    private $values;

    /** @var VO\Identity\Uuids */
    private $sites;

    /**
     * @param Translation\Key $key
     *
     * @return Translation
     */
    public function setKey(Translation\Key $key): Translation
    {
        $this->setAggregateId($key);

        return $this;
    }

    /**
     * @param VO\Intl\Language\Contents $values
     *
     * @return Translation
     */
    public function setValues(VO\Intl\Language\Contents $values): Translation
    {
        $this->values = $values;

        return $this;
    }

    /**
     * @param VO\Identity\Uuids $sites
     *
     * @return Translation
     */
    public function setSites(VO\Identity\Uuids $sites): Translation
    {
        $this->sites = $sites;

        return $this;
    }

    /**
     * @param Translation\Key $key
     *
     * @return Translation
     *
     * @throws \Assert\AssertionFailedException
     */
    public static function createNewTranslation(Translation\Key $key): Translation
    {
        $category = new static();

        $category->recordThat(Event\NewTranslationCreated::occur($key->toString()));

        return $category;
    }

    /**
     * @param VO\Intl\Language\Contents $values
     */
    public function update(VO\Intl\Language\Contents $values): void
    {
        $this->recordThat(Event\ExistingTranslationUpdated::occur($this->aggregateId(), [
            'values' => $values->raw(),
        ]));
    }

    /**
     * @param VO\Identity\Uuids $sites
     */
    public function sited(VO\Identity\Uuids $sites): void
    {
        $this->recordThat(Event\ExistingTranslationSited::occur($this->aggregateId(), [
            'sites' => $sites->toArray(),
        ]));
    }

    public function remove(): void
    {
        $this->recordThat(Event\ExistingTranslationRemoved::occur($this->aggregateId()));
    }
}
