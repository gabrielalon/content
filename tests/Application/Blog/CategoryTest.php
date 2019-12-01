<?php

namespace N3ttech\Content\Test\Application\Blog;

use N3ttech\Content\Application\Blog\Event;
use N3ttech\Content\Domain\Model\Blog\Category;
use N3ttech\Content\Test\Application\AggregateChangedTestCase;
use N3ttech\Messaging\Aggregate\AggregateRoot;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 * @coversNothing
 */
class CategoryTest extends AggregateChangedTestCase
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
    public function itCreatesNewCategoryTest(): void
    {
        $category = Category::createNewCategory($this->uuid);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($category);

        $this->assertCount(1, $events);

        /** @var Event\NewCategoryCreated $event */
        $event = $events[0];

        $this->assertSame(Event\NewCategoryCreated::class, $event->messageName());
        $this->assertTrue($this->uuid->equals($event->categoryUuid()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itMovesExistingCategoryTest(): void
    {
        /** @var Category $category */
        $category = $this->reconstituteReturnPackageFromHistory($this->newCategoryCreated());

        $parental = VO\Identity\Uuid::fromIdentity(Uuid::uuid4()->toString());

        $category->move($parental);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($category);

        $this->assertCount(1, $events);

        /** @var Event\ExistingCategoryMoved $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingCategoryMoved::class, $event->messageName());
        $this->assertTrue($parental->equals($event->categoryParental()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itTranslatesExistingCategoryTest(): void
    {
        /** @var Category $category */
        $category = $this->reconstituteReturnPackageFromHistory($this->newCategoryCreated());

        $names = VO\Intl\Language\Texts::fromArray(['pl' => 'Name']);

        $category->translate($names);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($category);

        $this->assertCount(1, $events);

        /** @var Event\ExistingCategoryTranslated $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingCategoryTranslated::class, $event->messageName());
        $this->assertTrue($names->equals($event->categoryNames()));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itSitesExistingCategoryTest(): void
    {
        /** @var Category $category */
        $category = $this->reconstituteReturnPackageFromHistory($this->newCategoryCreated());

        $sites = VO\Identity\Uuids::fromArray([Uuid::uuid4()->toString()]);

        $category->sited($sites);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($category);

        $this->assertCount(1, $events);

        /** @var Event\ExistingCategorySited $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingCategorySited::class, $event->messageName());
        $this->assertTrue($sites->equals($event->categorySites()));
    }

    /**
     * @test
     */
    public function itRemovesExistingCategoryTest(): void
    {
        /** @var Category $category */
        $category = $this->reconstituteReturnPackageFromHistory($this->newCategoryCreated());
        $category->remove();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($category);

        $this->assertCount(1, $events);

        /** @var Event\ExistingCategoryRemoved $event */
        $event = $events[0];

        $this->assertSame(Event\ExistingCategoryRemoved::class, $event->messageName());
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return AggregateRoot
     */
    private function reconstituteReturnPackageFromHistory(AggregateChanged ...$events): AggregateRoot
    {
        return $this->reconstituteAggregateFromHistory(
            Category::class,
            $events
        );
    }

    /**
     * @return AggregateChanged
     */
    private function newCategoryCreated(): AggregateChanged
    {
        return Event\NewCategoryCreated::occur($this->uuid->toString(), [
            'publish_date' => $this->publishDate->raw(),
        ]);
    }
}
