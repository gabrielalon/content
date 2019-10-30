<?php

namespace N3ttech\Content\Domain\Model\Blog;

use N3ttech\Content\Application\Blog\Event;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class Category extends AggregateRoot
{
    /** @var VO\Intl\Language\Texts */
    private $names;

    /** @var VO\Identity\Uuids */
    private $sites;

    /** @var VO\Identity\Uuid */
    private $parental;

    /**
     * @param VO\Identity\Uuid $uuid
     *
     * @return Category
     */
    public function setUuid(VO\Identity\Uuid $uuid): Category
    {
        $this->setAggregateId($uuid);

        return $this;
    }

    /**
     * @param VO\Intl\Language\Texts $names
     *
     * @return Category
     */
    public function setNames(VO\Intl\Language\Texts $names): Category
    {
        $this->names = $names;

        return $this;
    }

    /**
     * @param VO\Identity\Uuids $sites
     *
     * @return Category
     */
    public function setSites(VO\Identity\Uuids $sites): Category
    {
        $this->sites = $sites;

        return $this;
    }

    /**
     * @param VO\Identity\Uuid $parental
     *
     * @return Category
     */
    public function setParental(VO\Identity\Uuid $parental): Category
    {
        $this->parental = $parental;

        return $this;
    }

    /**
     * @param VO\Identity\Uuid $uuid
     *
     * @return Category
     */
    public static function createNewCategory(VO\Identity\Uuid $uuid): Category
    {
        $category = new static();

        $category->recordThat(Event\NewCategoryCreated::occur($uuid->toString()));

        return $category;
    }

    /**
     * @param VO\Identity\Uuid $parental
     */
    public function move(VO\Identity\Uuid $parental): void
    {
        $this->recordThat(Event\ExistingCategoryMoved::occur($this->aggregateId(), [
            'parental' => $parental->toString(),
        ]));
    }

    /**
     * @param VO\Intl\Language\Texts $names
     */
    public function translate(VO\Intl\Language\Texts $names): void
    {
        $this->recordThat(Event\ExistingCategoryTranslated::occur($this->aggregateId(), [
            'names' => $names->raw(),
        ]));
    }

    /**
     * @param VO\Identity\Uuids $sites
     */
    public function sited(VO\Identity\Uuids $sites): void
    {
        $this->recordThat(Event\ExistingCategorySited::occur($this->aggregateId(), [
            'sites' => $sites->toArray(),
        ]));
    }

    public function remove(): void
    {
        $this->recordThat(Event\ExistingCategoryRemoved::occur($this->aggregateId()));
    }
}
