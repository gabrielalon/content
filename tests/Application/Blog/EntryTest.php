<?php

namespace N3ttech\Content\Test\Application\Blog;

use N3ttech\Content\Application\Blog\Event;
use N3ttech\Content\Domain\Common;
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

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->uuid = VO\Identity\Uuid::fromIdentity(Uuid::uuid4()->toString());
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     */
    public function itCreatesNewEntryTest(): void
    {
        $entry = Entry::createNewEntry($this->uuid);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        $this->assertCount(1, $events);

        /** @var Event\NewEntryCreated $event */
        $event = $events[0];

        $this->assertSame(Event\NewEntryCreated::class, $event->messageName());
        $this->assertTrue($this->uuid->equals($event->entryUuid()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itReleasesExistingEntryTest(): void
    {
        /** @var Entry $entry */
        $entry = $this->reconstituteReturnPackageFromHistory($this->newEntryCreated());

        $release = Common\Release::fromData(time(), true);

        $entry->release($release);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        $this->assertCount(1, $events);

        /** @var Event\ExistingEntryReleased $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingEntryReleased::class, $event->messageName());
        $this->assertTrue($release->equals($event->entryRelease()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itTranslatesExistingEntryTest(): void
    {
        /** @var Entry $entry */
        $entry = $this->reconstituteReturnPackageFromHistory($this->newEntryCreated());

        $content = Common\Content::fromData(['pl' => 'Name'], ['pl' => 'Content']);

        $entry->translate($content);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        $this->assertCount(1, $events);

        /** @var Event\ExistingEntryTranslated $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingEntryTranslated::class, $event->messageName());
        $this->assertTrue($content->equals($event->entryContent()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itCategorizesExistingEntryTest(): void
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
    public function itShowsExistingEntryTest(): void
    {
        /** @var Entry $entry */
        $entry = $this->reconstituteReturnPackageFromHistory($this->newEntryCreated());

        $entry->show();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        $this->assertCount(1, $events);

        /** @var Event\ExistingEntryReleased $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingEntryReleased::class, $event->messageName());
        $this->assertFalse($event->entryRelease()->hidden()->raw());
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itHidesExistingEntryTest(): void
    {
        /** @var Entry $entry */
        $entry = $this->reconstituteReturnPackageFromHistory($this->newEntryCreated());

        $entry->hide();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        $this->assertCount(1, $events);

        /** @var Event\ExistingEntryReleased $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingEntryReleased::class, $event->messageName());
        $this->assertTrue($event->entryRelease()->hidden()->raw());
    }

    /**
     * @test
     */
    public function itRemovesExistingEntryTest(): void
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
            'creation_date' => time(),
        ]);
    }
}
