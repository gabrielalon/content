<?php

namespace N3ttech\Content\Domain\Model\Blog;

use N3ttech\Content\Application\Blog\Event;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Valuing as VO;

class Entry extends AggregateRoot
{
    /** @var VO\Date\Time */
    private $publishDate;

    /** @var VO\Intl\Language\Texts */
    private $names;

    /** @var VO\Intl\Language\Contents */
    private $contents;

    /** @var VO\Identity\Uuids */
    private $categories;

    /** @var VO\Option\Check */
    private $hide;

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
     * @param VO\Date\Time $publishDate
     *
     * @return Entry
     */
    public function setPublishDate(VO\Date\Time $publishDate): Entry
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    /**
     * @param VO\Intl\Language\Texts $names
     *
     * @return Entry
     */
    public function setNames(VO\Intl\Language\Texts $names): Entry
    {
        $this->names = $names;

        return $this;
    }

    /**
     * @param VO\Intl\Language\Contents $contents
     *
     * @return Entry
     */
    public function setContents(VO\Intl\Language\Contents $contents): Entry
    {
        $this->contents = $contents;

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
     * @param VO\Option\Check $hide
     *
     * @return Entry
     */
    public function setHide(VO\Option\Check $hide): Entry
    {
        $this->hide = $hide;

        return $this;
    }

    /**
     * @param VO\Identity\Uuid $uuid
     * @param VO\Date\Time     $publishDate
     *
     * @return Entry
     */
    public static function createNewEntry(VO\Identity\Uuid $uuid, VO\Date\Time $publishDate): Entry
    {
        $category = new static();

        $category->recordThat(Event\NewEntryCreated::occur($uuid->toString(), [
            'publish_date' => $publishDate->raw(),
        ]));

        return $category;
    }

    /**
     * @param VO\Date\Time $publishDate
     */
    public function update(VO\Date\Time $publishDate): void
    {
        $this->recordThat(Event\ExistingEntryUpdated::occur($this->aggregateId(), [
            'publish_date' => $publishDate->raw(),
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
     * @param VO\Intl\Language\Texts    $names
     * @param VO\Intl\Language\Contents $contents
     */
    public function translate(VO\Intl\Language\Texts $names, VO\Intl\Language\Contents $contents): void
    {
        $this->recordThat(Event\ExistingEntryTranslated::occur($this->aggregateId(), [
            'names' => $names->raw(),
            'contents' => $contents->raw(),
        ]));
    }

    public function hide(): void
    {
        $this->recordThat(Event\ExistingEntryHidden::occur($this->aggregateId()));
    }

    public function show(): void
    {
        $this->recordThat(Event\ExistingEntryShown::occur($this->aggregateId()));
    }

    public function remove(): void
    {
        $this->recordThat(Event\ExistingEntryRemoved::occur($this->aggregateId()));
    }
}
