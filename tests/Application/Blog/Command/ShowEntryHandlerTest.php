<?php

namespace N3ttech\Content\Test\Application\Blog\Command;

use N3ttech\Content\Application\Blog\Command;
use N3ttech\Content\Application\Blog\Event;
use N3ttech\Content\Application\Blog\Service;
use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Content\Domain\Model\Blog\Projection;
use N3ttech\Content\Infrastructure\Persist\Blog\EntryRepository;
use N3ttech\Content\Infrastructure\Projection\Blog\InMemoryEntryProjector;
use N3ttech\Content\Test\Application\HandlerTestCase;
use N3ttech\Messaging\Aggregate\AggregateType;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;

/**
 * @internal
 * @coversNothing
 */
class ShowEntryHandlerTest extends HandlerTestCase
{
    /** @var Service\EntryCommandManager */
    private $command;

    public function setUp(): void
    {
        $repository = new EntryRepository($this->getEventStorage(), $this->getSnapshotStorage());

        $this->register(Projection\EntryProjection::class, new InMemoryEntryProjector());
        $this->register(Command\CreateEntryHandler::class, new Command\CreateEntryHandler($repository));
        $this->register(Command\ShowEntryHandler::class, new Command\ShowEntryHandler($repository));

        $this->command = new Service\EntryCommandManager($this->getCommandBus());
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itShowsExistingBlogEntryTest(): void
    {
        //given
        $uuid = \Ramsey\Uuid\Uuid::uuid4();
        $this->command->create($uuid->toString());

        //when
        $this->command->show($uuid->toString());

        //then
        /** @var InMemoryEntryProjector $projector */
        $projector = $this->container->get(Projection\EntryProjection::class);
        $entity = $projector->get($uuid->toString());

        $this->assertEquals($entity->identifier(), $uuid->toString());
        $this->assertFalse($entity->isHidden());

        $aggregateId = VO\Identity\Uuid::fromIdentity($uuid->toString());
        $collection = $this->getStreamRepository()->load($aggregateId, 2);

        foreach ($collection->getArrayCopy() as $eventStream) {
            $event = $eventStream->getEventName();
            /** @var AggregateChanged $event */

            /** @var Event\ExistingEntryReleased $event */
            $event = $event::fromEventStream($eventStream);

            $this->assertTrue($entity->getUuid()->equals($event->entryUuid()));
            $this->assertTrue($entity->getHidden()->equals($event->entryRelease()->hidden()));
        }

        $snapshot = $this->getSnapshotRepository()->get(AggregateType::fromAggregateRootClass(Entry::class), $aggregateId);
        $this->assertEquals($snapshot->getLastVersion(), 2);
    }
}
