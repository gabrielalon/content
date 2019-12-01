<?php

namespace N3ttech\Content\Domain\Model\Blog;

use N3ttech\Content\Application\Blog\Event;
use N3ttech\Content\Domain\Common;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class Entry extends AggregateRoot
{
    /** @var VO\Date\Time */
    private $creationDate;

    /** @var Common\Release */
    private $release;

    /** @var Common\Content */
    private $content;

    /** @var VO\Identity\Uuids */
    private $categories;

    /**
     * @param VO\Identity\Uuid $uuid
     *
     * @return Entry
     */
    public function setUuid(VO\Identity\Uuid $uuid): Entry
    {
        $this->setAggregateId($uuid);

        return $this;
    }

    /**
     * @param VO\Date\Time $creationDate
     *
     * @return Entry
     */
    public function setCreationDate(VO\Date\Time $creationDate): Entry
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @param Common\Release $release
     *
     * @return Entry
     */
    public function setRelease(Common\Release $release): Entry
    {
        $this->release = $release;

        return $this;
    }

    /**
     * @param Common\Content $content
     *
     * @return Entry
     */
    public function setContent(Common\Content $content): Entry
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param VO\Identity\Uuids $categories
     *
     * @return Entry
     */
    public function setCategories(VO\Identity\Uuids $categories): Entry
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @param VO\Identity\Uuid $uuid
     *
     * @return Entry
     *
     * @throws \Assert\AssertionFailedException
     */
    public static function createNewEntry(VO\Identity\Uuid $uuid): Entry
    {
        $category = new static();

        $category->recordThat(Event\NewEntryCreated::occur($uuid->toString(), [
            'creation_date' => time(),
        ]));

        return $category;
    }

    /**
     * @param Common\Release $release
     */
    public function release(Common\Release $release): void
    {
        $this->recordThat(Event\ExistingEntryReleased::occur($this->aggregateId(), [
            'release' => $release->raw(),
        ]));
    }

    /**
     * @param VO\Identity\Uuids $categories
     */
    public function categorize(VO\Identity\Uuids $categories): void
    {
        $this->recordThat(Event\ExistingEntryCategorized::occur($this->aggregateId(), [
            'categories' => $categories->toArray(),
        ]));
    }

    /**
     * @param Common\Content $content
     */
    public function translate(Common\Content $content): void
    {
        $this->recordThat(Event\ExistingEntryTranslated::occur($this->aggregateId(), [
            'content' => $content->raw(),
        ]));
    }

    /**
     * @throws \Assert\AssertionFailedException
     */
    public function hide(): void
    {
        $this->release(Common\Release::fromBoolean(true));
    }

    /**
     * @throws \Assert\AssertionFailedException
     */
    public function show(): void
    {
        $this->release(Common\Release::fromBoolean(false));
    }

    public function remove(): void
    {
        $this->recordThat(Event\ExistingEntryRemoved::occur($this->aggregateId()));
    }
}
