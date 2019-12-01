<?php

namespace N3ttech\Content\Test\Application\News\Command;

use N3ttech\Content\Application\News\Command;
use N3ttech\Content\Application\News\Event;
use N3ttech\Content\Application\News\Service;
use N3ttech\Content\Domain\Model\News\News;
use N3ttech\Content\Domain\Model\News\Projection;
use N3ttech\Content\Infrastructure\Persist\News\NewsRepository;
use N3ttech\Content\Infrastructure\Projection\News\InMemoryNewsProjector;
use N3ttech\Content\Test\Application\HandlerTestCase;
use N3ttech\Messaging\Aggregate\AggregateType;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;

/**
 * @internal
 * @coversNothing
 */
class ReleaseNewsHandlerTest extends HandlerTestCase
{
    /** @var Service\NewsCommandManager */
    private $command;

    public function setUp(): void
    {
        $repository = new NewsRepository($this->getEventStorage(), $this->getSnapshotStorage());

        $this->register(Projection\NewsProjection::class, new InMemoryNewsProjector());
        $this->register(Command\CreateNewsHandler::class, new Command\CreateNewsHandler($repository));
        $this->register(Command\ReleaseNewsHandler::class, new Command\ReleaseNewsHandler($repository));

        $this->command = new Service\NewsCommandManager($this->getCommandBus());
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itReleasesExistingNewsTest(): void
    {
        //given
        $uuid = \Ramsey\Uuid\Uuid::uuid4();
        $releaseDate = time();
        $this->command->create($uuid->toString());

        //when
        $this->command->release($uuid->toString(), $releaseDate);

        //then
        /** @var InMemoryNewsProjector $projector */
        $projector = $this->container->get(Projection\NewsProjection::class);
        $entity = $projector->get($uuid->toString());

        $this->assertEquals($entity->identifier(), $uuid->toString());
        $this->assertEquals($entity->getReleaseDate()->raw(), $releaseDate);

        $aggregateId = VO\Identity\Uuid::fromIdentity($uuid->toString());
        $collection = $this->getStreamRepository()->load($aggregateId, 2);

        foreach ($collection->getArrayCopy() as $eventStream) {
            $event = $eventStream->getEventName();
            /** @var AggregateChanged $event */

            /** @var Event\ExistingNewsReleased $event */
            $event = $event::fromEventStream($eventStream);

            $this->assertTrue($entity->getUuid()->equals($event->newsUuid()));
            $this->assertTrue($entity->getReleaseDate()->equals($event->newsRelease()->releaseDate()));
        }

        $snapshot = $this->getSnapshotRepository()->get(AggregateType::fromAggregateRootClass(News::class), $aggregateId);
        $this->assertEquals($snapshot->getLastVersion(), 2);
    }
}
