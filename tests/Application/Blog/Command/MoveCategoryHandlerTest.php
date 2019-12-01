<?php

namespace N3ttech\Content\Test\Application\Blog\Command;

use N3ttech\Content\Application\Blog\Command;
use N3ttech\Content\Application\Blog\Event;
use N3ttech\Content\Application\Blog\Service;
use N3ttech\Content\Domain\Model\Blog\Category;
use N3ttech\Content\Domain\Model\Blog\Projection;
use N3ttech\Content\Infrastructure\Persist\Blog\CategoryRepository;
use N3ttech\Content\Infrastructure\Projection\Blog\InMemoryCategoryProjector;
use N3ttech\Content\Test\Application\HandlerTestCase;
use N3ttech\Messaging\Aggregate\AggregateType;
use N3ttech\Messaging\Aggregate\EventBridge\AggregateChanged;
use N3ttech\Valuing as VO;

/**
 * @internal
 * @coversNothing
 */
class MoveCategoryHandlerTest extends HandlerTestCase
{
    /** @var Service\CategoryCommandManager */
    private $command;

    public function setUp(): void
    {
        $repository = new CategoryRepository($this->getEventStorage(), $this->getSnapshotStorage());

        $this->register(Projection\CategoryProjection::class, new InMemoryCategoryProjector());
        $this->register(Command\CreateCategoryHandler::class, new Command\CreateCategoryHandler($repository));
        $this->register(Command\MoveCategoryHandler::class, new Command\MoveCategoryHandler($repository));

        $this->command = new Service\CategoryCommandManager($this->getCommandBus());
    }

    /**
     * @test
     *
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function itMovesExistingBlogCategoryTest(): void
    {
        //given
        $uuid = \Ramsey\Uuid\Uuid::uuid4();
        $parental = \Ramsey\Uuid\Uuid::uuid4();
        $this->command->create($uuid->toString());

        //when
        $this->command->move($uuid->toString(), $parental->toString());

        //then
        /** @var InMemoryCategoryProjector $projector */
        $projector = $this->container->get(Projection\CategoryProjection::class);
        $entity = $projector->get($uuid->toString());

        $this->assertEquals($entity->identifier(), $uuid->toString());
        $this->assertEquals($entity->parental(), $parental->toString());

        $aggregateId = VO\Identity\Uuid::fromIdentity($uuid->toString());
        $collection = $this->getStreamRepository()->load($aggregateId, 2);

        foreach ($collection->getArrayCopy() as $eventStream) {
            $event = $eventStream->getEventName();
            /** @var AggregateChanged $event */

            /** @var Event\ExistingCategoryMoved $event */
            $event = $event::fromEventStream($eventStream);

            $this->assertTrue($entity->getUuid()->equals($event->categoryUuid()));
            $this->assertTrue($entity->getParental()->equals($event->categoryParental()));
        }

        $snapshot = $this->getSnapshotRepository()->get(AggregateType::fromAggregateRootClass(Category::class), $aggregateId);
        $this->assertEquals($snapshot->getLastVersion(), 2);
    }
}
