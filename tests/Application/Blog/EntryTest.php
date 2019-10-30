<?php

namespace N3ttech\Content\Test\Application\Blog;

use N3ttech\Content\Application\Blog\Event;
use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Content\Test\Application\AggregateChangedTestCase;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 * @coversNothing
 */
class EntryTest extends AggregateChangedTestCase
{
    /** @var VO\Identity\Uuid */
    private $uuid;

    /** @var VO\Date\Time */
    private $publishDate;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->uuid = VO\Identity\Uuid::fromIdentity(Uuid::uuid4()->toString());
        $this->publishDate = VO\Date\Time::fromTimestamp(time());
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itCreatesNewEntryTest()
    {
        $entry = Entry::createNewEntry($this->uuid, $this->publishDate);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        $this->assertCount(1, $events);

        /** @var Event\NewEntryCreated $event */
        $event = $events[0];

        $this->assertSame(Event\NewEntryCreated::class, $event->messageName());
        $this->assertTrue($this->uuid->equals($event->entryUuid()));
        $this->assertTrue($this->publishDate->equals($event->entryPublishDate()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itUpdatesExistingEntryTest()
    {
        /** @var Entry $entry */
        $entry = $this->reconstituteReturnPackageFromHistory($this->newEntryCreated());

        $publishDate = VO\Date\Time::fromTimestamp(time());

        $entry->update($publishDate);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        $this->assertCount(1, $events);

        /** @var Event\ExistingEntryUpdated $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingEntryUpdated::class, $event->messageName());
        $this->assertTrue($publishDate->equals($event->entryPublishDate()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itTranslatesExistingEntryTest()
    {
        /** @var Entry $entry */
        $entry = $this->reconstituteReturnPackageFromHistory($this->newEntryCreated());

        $names = VO\Intl\Language\Texts::fromArray(['pl' => 'Name']);
        $contents = VO\Intl\Language\Contents::fromArray(['pl' => 'Content']);

        $entry->translate($names, $contents);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        $this->assertCount(1, $events);

        /** @var Event\ExistingEntryTranslated $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingEntryTranslated::class, $event->messageName());
        $this->assertTrue($names->equals($event->entryNames()));
        $this->assertTrue($contents->equals($event->entryContents()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itCategorizesExistingEntryTest()
    {
        /** @var Entry $entry */
        $entry = $this->reconstituteReturnPackageFromHistory($this->newEntryCreated());

        $categories = VO\Identity\Uuids::fromArray([Uuid::uuid4()->toString()]);

        $entry->categorize($categories);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        $this->assertCount(1, $events);

        /** @var Event\ExistingEntryCategorized $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingEntryCategorized::class, $event->messageName());
        $this->assertTrue($categories->equals($event->entryCategories()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itShowsExistingEntryTest()
    {
        /** @var Entry $entry */
        $entry = $this->reconstituteReturnPackageFromHistory($this->newEntryCreated());

        $entry->show();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        $this->assertCount(1, $events);

        /** @var Event\ExistingEntryShown $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingEntryShown::class, $event->messageName());
        $this->assertFalse($event->entryHide()->raw());
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itHidesExistingEntryTest()
    {
        /** @var Entry $entry */
        $entry = $this->reconstituteReturnPackageFromHistory($this->newEntryCreated());

        $entry->hide();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        $this->assertCount(1, $events);

        /** @var Event\ExistingEntryHidden $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingEntryHidden::class, $event->messageName());
        $this->assertTrue($event->entryHide()->raw());
    }

    /**
     * @test
     */
    public function itRemovesExistingEntryTest()
    {
        /** @var Entry $entry */
        $entry = $this->reconstituteReturnPackageFromHistory($this->newEntryCreated());
        $entry->remove();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        $this->assertCount(1, $events);

        /** @var Event\ExistingEntryRemoved $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingEntryRemoved::class, $event->messageName());
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return AggregateRoot
     */
    private function reconstituteReturnPackageFromHistory(AggregateChanged ...$events): AggregateRoot
    {
        return $this->reconstituteAggregateFromHistory(
            Entry::class,
            $events
        );
    }

    /**
     * @return AggregateChanged
     */
    private function newEntryCreated(): AggregateChanged
    {
        return Event\NewEntryCreated::occur($this->uuid->toString(), [
            'publish_date' => $this->publishDate->raw(),
        ]);
    }
}
