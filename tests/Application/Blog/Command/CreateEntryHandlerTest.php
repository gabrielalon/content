<?php

namespace N3ttech\Content\Test\Application\Blog\Command;

use N3ttech\Content\Application\Blog\Command;
use N3ttech\Content\Application\Blog\Event;
use N3ttech\Content\Domain\Model\Blog\Entry;
use N3ttech\Content\Domain\Model\Blog\Projection;
use N3ttech\Content\Infrastructure\Persist\Blog\EntryRepository;
use N3ttech\Content\Infrastructure\Projection\Blog\InMemoryEntryProjector;
use N3ttech\Content\Test\Application\HandlerTestCase;
use N3ttech\Messaging\Aggregate\AggregateType;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 * @coversNothing
 */
class CreateEntryHandlerTest extends HandlerTestCase
{
    public function setUp(): void
    {
        $repository = new EntryRepository($this->getEventStorage(), $this->getSnapshotStorage());

        $this->register(Projection\EntryProjection::class, new InMemoryEntryProjector());
        $this->register(Command\CreateEntryHandler::class, new Command\CreateEntryHandler($repository));
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itCreatesNewBlogTest()
    {
        //given
        $command = new Command\CreateEntry(Uuid::uuid4()->toString(), time());

        //when
        $this->getCommandBus()->dispatch($command);

        //then
        /** @var InMemoryEntryProjector $projector */
        $projector = $this->container->get(Projection\EntryProjection::class);
        $entity = $projector->get($command->getUuid());

        $this->assertEquals($entity->identifier(), $command->getUuid());
        $this->assertEquals($entity->publishDate(), $command->getPublishDate());

        $aggregateId = VO\Identity\Uuid::fromIdentity($command->getUuid());
        $collection = $this->getStreamRepository()->load($aggregateId, 1);

        foreach ($collection->getArrayCopy() as $eventStream) {
            $event = $eventStream->getEventName();
            /** @var AggregateChanged $event */

            /** @var Event\NewEntryCreated $event */
            $event = $event::fromEventStream($eventStream);

            $this->assertTrue($entity->getUuid()->equals($event->entryUuid()));
            $this->assertTrue($entity->getPublishDate()->equals($event->entryPublishDate()));
        }

        $snapshot = $this->getSnapshotRepository()->get(AggregateType::fromAggregateRootClass(Entry::class), $aggregateId);

        $this->assertEquals($snapshot->getLastVersion(), 1);
    }
}
